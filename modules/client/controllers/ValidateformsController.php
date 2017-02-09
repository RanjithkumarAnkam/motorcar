<?php

namespace app\modules\client\controllers;

use yii\web\Controller;
use yii;
use app\components\EncryptDecryptComponent;
use app\models\TblAcaCompanies;
use yii\web\HttpException;
use app\models\TblAcaElementMaster;
use app\components\ValidateElementComponent;
use app\models\TblAcaCompanyValidationStatus;
use app\models\TblAcaValidationLog;
use app\models\TblAcaPlanClassValidationLog;
use app\models\TblAcaPayrollValidationLog;
use app\models\TblAcaMedicalValidationLog;
use yii\helpers\ArrayHelper;
use app\models\TblAcaMecCoverage;
use app\components\CommonValidationsComponent;
use app\models\TblAcaGeneralPlanInfo;
use app\models\TblAcaGeneralPlanMonths;
use app\models\TblAcaValidationRules;
use app\models\TblAcaPlanCriteria;
use app\models\TblAcaEmpStatusTrack;
use app\models\TblAcaAggregatedGroup;
use app\models\TblAcaAggregatedGroupList;
use app\models\TblAcaBasicInformation;
use app\models\TblAcaDesignatedGovtEntity;
use app\models\TblAcaPlanCoverageType;
use app\models\TblAcaPlanOfferTypeYears;
use app\models\TblAcaPlanCoverageTypeOffered;
use app\models\TblAcaEmpContributions;
use app\models\TblAcaEmpContributionsPremium;
use yii\caching\Cache;
use app\models\TblAcaPayrollData;
use app\models\TblAcaPayrollEmploymentPeriod;
use app\models\TblAcaPayrollEmploymentPeriodValidationLog;
use app\models\TblAcaMedicalData;
use app\models\TblAcaMedicalEnrollmentPeriodValidationLog;
use app\models\TblAcaMedicalEnrollmentPeriod;
use app\models\TblAcaLookupOptions;
use app\models\TblPayrollErrorSearch;
use app\models\TblAcaMedicalErrorSearch;
use app\models\TblCityStatesUnitedStates;
use app\models\TblAcaCron;
use app\components\ValidateCheckErrorsComponent;

class ValidateformsController extends Controller {
	
	
	public $arrinvalid_ssn = [ 
			'000000000',
			'111111111',
			'222222222',
			'333333333',
			'444444444',
			'555555555',
			'666666666',
			'777777777',
			'888888888',
			'999999999' 
	];
	/**
	 * *This action function helps to display index **
	 */
	public function actionIndex() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			
			if (isset ( $_GET ['c_id'] ) && $_GET ['c_id'] != '') {
				
				$session = \Yii::$app->session;
				$logged_user_id = $session ['client_user_id'];
				$client_ids = $session ['client_ids']; // all related clients to the logged user
				$company_ids = $session ['company_ids']; // all related companies to the logged user
				$mapped_company_ids = array_map ( function ($piece) {
					return ( string ) $piece;
				}, $company_ids );
				$month_list = array ();
				$arrsection_months = array ();
				
				$arr_validations = array ();
				$plan_class_validation = '';
				$payroll_validation = '';
				$medical_validation = '';
				$is_all_validated = 0;
				$arr_plan_class_individual_issues = array ();
				// rendering the layout
				$this->layout = 'main';
				
				// collecting the company id from the url and decoding it
				$encrypt_component = new EncryptDecryptComponent ();
				$validate_check_errors = new ValidateCheckErrorsComponent ();
				$model_companies = new TblAcaCompanies ();
				
				/**
				 * Get from URL*
				 */
				$get_company_id = \Yii::$app->request->get ();
				
				/**
				 * Encrypted company ID*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
					if (! empty ( $check_company_details )) {
						$client_id = $check_company_details->client_id; // Company clien Id
					}
				}
				
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$arruserpermissions = \Yii::$app->Permission->Checkclientallpermission ( $logged_user_id, $company_id );
					
					if (in_array ( 'editmedical', $arruserpermissions, TRUE ) && in_array ( 'editpayroll', $arruserpermissions, TRUE ) || in_array ( 'all', $arruserpermissions, TRUE )) {
						
						$arruserpermission = array ();
						// / get the company details
						$company_detals = $check_company_details;
						
						// checking if the validation starts for this company
						
						$company_validation = TblAcaCompanyValidationStatus::find ()->where ( [ 
								'company_id' => $company_id 
						] )->andWhere ( [ 
								'is_initialized' => 1 
						] )->andWhere ( [ 
								'is_completed' => 0 
						] )->One ();
						
						/**
						 * ****Get validation results***********
						 */
						$validation_results = TblAcaValidationLog::find ()->select ( 'validation_rule_id, is_validated' )->where ( [ 
								'company_id' => $company_id 
						] )->All ();
						/**
						 * Validation status*
						 */
						$validation_status = TblAcaCompanyValidationStatus::find ()->where ( [ 
								'company_id' => $company_id 
						] )->One ();
						$new_validation_status = TblAcaCompanyValidationStatus::find ()->where ( [ 
								'company_id' => $company_id 
						] )->andWhere ( [ 
								'is_initialized' => 1 
						] )->andWhere ( [ 
								'is_completed' => 0 
						] )->One ();
						
						// Checking if validations results are empty
						if (! empty ( $validation_results )) {
							
							$arr_validations = $validate_check_errors->CheckErrors ( $validation_results, $company_id );
							
							$arr_plan_class_individual_issues = $arr_validations ['arr_plan_class_individual_issues'];
						}
				
						// check if all values are validated
						if (empty ( $arr_validations ['basic_info'] ) && empty ( $arr_validations ['benefit_plan'] ) && empty ( $arr_validations ['plan_class_validation'] ) && empty ( $arr_validations ['payroll_data_validation'] ) && empty ( $arr_validations ['medical_data_validation'] )) {
							$is_all_validated = 1;
						}
						
						if (! empty ( $validation_results ) && ! empty ( $validation_status )) {
							if ($is_all_validated == 1 && $validation_status->is_completed == 1 && $validation_status->is_basic_info == 1 && $validation_status->is_benefit_info == 1 && $validation_status->is_plan_class == 1 && $validation_status->is_payroll_data == 1 && $validation_status->is_medical_data == 1) {
								
								$company_detals->reporting_status = 31;
								
								$company_detals->save ();
							} else {
								$company_detals->reporting_status = 29;
								$company_detals->save ();
							}
						}
						// check for doc signed
						$arruserpermission = \Yii::$app->Permission->Checkclientallpermission ( $logged_user_id, $company_id );
						
						return $this->render ( 'index', array (
								'company_id' => $company_id,
								'encoded_company_id' => $_GET ['c_id'],
								'arr_validations' => $arr_validations,
								'validation_results' => $validation_results,
								'validation_status' => $validation_status,
								'is_all_validated' => $is_all_validated,
								'arr_plan_class_individual_issues' => $arr_plan_class_individual_issues,
								'company_detals' => $company_detals,
								'company_validation' => $company_validation,
								'new_validation_status' => $new_validation_status,
								'arruserpermission' => $arruserpermission 
						) );
					} else {
						\Yii::$app->session->setFlash ( 'error', 'Permission Denied' );
						return $this->redirect ( array (
								'/client/dashboard?c_id=' . $_GET ['c_id'] 
						) );
					}
				} else {
					return $this->redirect ( array (
							'/client/companies' 
					) );
				}
			} else {
				return $this->redirect ( array (
						'/client/companies' 
				) );
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
	}
	
	/**
	 * ****This function checks validation .
	 *
	 *
	 * It selects the company to be validated depending upon the validation status
	 * Below function is triggered by CRON
	 * ********
	 */
	public function actionCheckvalidation() {		
		// get records new tble
		$model_cron = TblAcaCron::find()->all();

		if (empty($model_cron))
		{
			
				
			// record insert in new table
			
			// Getting all companies to be validates
			$get_all_validation = TblAcaCompanyValidationStatus::find ()->select ( 'company_id, validation_id' )->where ( [ 
					'is_initialized' => 1,
					'is_executed' => 0 
			] )->All ();			
			
			$count = count($get_all_validation);
			$i=0;
			if (! empty ( $get_all_validation )) {
				
				
				$model_cron_insert = new TblAcaCron();
				$model_cron_insert->is_cron_started=1;
				$model_cron_insert->save();
				
				foreach ( $get_all_validation as $companies_validations ) {
					// Calling validation functions for all i
					$check_validation = $this->runvalidation ( $companies_validations->company_id, $companies_validations->validation_id );
					if(!empty($check_validation)){$i++;}
				}	
				//if($count == $i){
					// record delete in new table
					TblAcaCron::deleteAll ();
				//}
			}
			
		}
		/*else{
			echo 'hi';
		}*/
		
	}
	public function actionSetvalidationcron() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			if (isset ( $_POST ['company_id'] ) && $_POST ['company_id'] != '') {
				
				$encrypt_component = new EncryptDecryptComponent ();
				$model_validation_status = new TblAcaCompanyValidationStatus ();
				$result = array ();
				$check_status = array();
				$encrypt_company_id = $_POST ['company_id'];
				$company_id = $encrypt_component->decryptUser ( $encrypt_company_id );
				// begin transaction
				$transaction = \Yii::$app->db->beginTransaction ();
				try {
					// delete old validation
					/*
					TblAcaCompanyValidationStatus::deleteAll ( 'company_id = :company_id', [ 
							':company_id' => $company_id 
					] );
					*/
					$check_status = TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->One();
					if(!empty($check_status))
					{
					$model_validation_status = 	$check_status;
					}
					
					
					$model_validation_status->company_id = $company_id;
					$model_validation_status->is_initialized = 1;
					$model_validation_status->is_executed = 0;
					$model_validation_status->is_completed = 0;
					
					$model_validation_status->start_date_time = date ( 'Y-m-d H:i:s' );
					
					if (($model_validation_status->save ()) && $model_validation_status->validate ()) {
						
							$model_companies = new TblAcaCompanies();
							$model_status=$model_companies->Companyuniquedetails($company_id);
							$model_status->reporting_status = 30;
							$model_status->save ();
			
			
						$result ['success'] = 'success';
						
						$transaction->commit ();
					} else {
						
						$arrerrors = $model_validation_status->getFirstErrors ();
						$errorstring = '';
						/**
						 * *****Converting error into string*******
						 */
						foreach ( $arrerrors as $key => $value ) {
							$errorstring .= $value . '<br>';
						}
						
						throw new \Exception ( $errorstring );
					}
				} catch ( \Exception $e ) { // catching the exception
					
					$msg = $e->getMessage ();
					$result ['error'] = $msg;
					
					$transaction->rollback ();
				}
				
				return json_encode ( $result );
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
	}
	public function Runvalidation($company_id, $validation_id) {
		if (isset ( $company_id ) && $company_id != '') {
			
			ini_set ( 'memory_limit', '2048M' );
			ini_set ( 'max_execution_time', 3600 );
			ini_set ( 'max_input_time', 3600 );
			$result = array ();
			$arr_validations = array ();
			
			$encrypt_component = new EncryptDecryptComponent ();
			$validate_element_component = new ValidateElementComponent ();
			$validate_check_errors = new ValidateCheckErrorsComponent();
			
			// start validation
			$start_validation_result = $this->StartValidation ( $company_id, $validation_id );
			
			if (! empty ( $start_validation_result ['success'] )) {
				
				try {
					
					/**
					 * ****Get validation results***********
					 */
					/*$validation_results = TblAcaValidationLog::find ()->select ( 'validation_rule_id, is_validated' )->where ( [ 
							'company_id' => $company_id 
					] )->All ();
					*/
					$validation_status = TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->One();
					
					if(!empty($validation_status))
					{
						
					//$arr_validations = $validate_check_errors->CheckErrors($validation_results, $company_id);
					
					if( $validation_status->is_basic_info == 0 || $validation_status->is_benefit_info == 0 )
					{
						$validate_result = $validate_element_component->Validateelement ( $company_id );
						
						if (! empty ( $validate_result ['error'] )) {
							throw new \Exception ( 'Element-' . $validate_result ['error'] );
						}
						else
						{
							$this->EndValidation ( $validation_id ,$company_id, 'basic_info');
							$this->EndValidation ( $validation_id ,$company_id, 'benefit_plan');
						}
					}
					else
						{
							$this->EndValidation ( $validation_id ,$company_id, 'basic_info');
							$this->EndValidation ( $validation_id ,$company_id, 'benefit_plan');
						}
					
					if($validation_status->is_plan_class == 0 )
					{
						$validate_plan_class = $validate_element_component->ValidatePlanclass ( $company_id );
						if (! empty ( $validate_plan_class ['error'] )) {
							throw new \Exception ( 'Plan-' . $validate_plan_class ['error'] );
						}
						else
						{
							$this->EndValidation ( $validation_id ,$company_id, 'plan_class');
						}
					}else
						{
							$this->EndValidation ( $validation_id ,$company_id, 'plan_class');
						}
					
					if($validation_status->is_medical_data == 0)
					{
						$validate_medical = $validate_element_component->ValidateMedical ( $company_id );
						if (! empty ( $validate_medical ['error'] )) {
							throw new \Exception ( 'Medical-' . $validate_medical ['error'] );
						}
						else
						{
							$this->EndValidation ( $validation_id ,$company_id, 'medical_data');
						}
					}else
						{
							$this->EndValidation ( $validation_id ,$company_id, 'medical_data');
						}
					
					if($validation_status->is_payroll_data == 0)
					{
						$validate_payroll = $validate_element_component->ValidatePayroll ( $company_id );
					
						if (! empty ( $validate_payroll ['error'] )) {
							throw new \Exception ( 'Payroll-' . $validate_payroll ['error'] );
						}
						else
						{
							$this->EndValidation ( $validation_id ,$company_id, 'payroll_data');
						}
					}else
						{
							$this->EndValidation ( $validation_id ,$company_id, 'payroll_data');
						}
					
				}else
				{
					
					
					$validate_result = $validate_element_component->Validateelement ( $company_id );
					
					if (! empty ( $validate_result ['error'] )) {
						throw new \Exception ( 'Element-' . $validate_result ['error'] );
					}
					else
					{
						$this->EndValidation ( $validation_id ,$company_id, 'basic_info');
						$this->EndValidation ( $validation_id ,$company_id, 'benefit_plan');
					}
					
					
					$validate_plan_class = $validate_element_component->ValidatePlanclass ( $company_id );
					if (! empty ( $validate_plan_class ['error'] )) {
						throw new \Exception ( 'Plan-' . $validate_plan_class ['error'] );
					}
					else
					{
						$this->EndValidation ( $validation_id ,$company_id, 'plan_class');
					}
					
					$validate_medical = $validate_element_component->ValidateMedical ( $company_id );
					if (! empty ( $validate_medical ['error'] )) {
						throw new \Exception ( 'Medical-' . $validate_medical ['error'] );
					}
					else
					{
						$this->EndValidation ( $validation_id ,$company_id, 'medical_data');
					}
					
					$validate_payroll = $validate_element_component->ValidatePayroll ( $company_id );
				
					if (! empty ( $validate_payroll ['error'] )) {
						throw new \Exception ( 'Payroll-' . $validate_payroll ['error'] );
					}
					else
					{
						$this->EndValidation ( $validation_id ,$company_id, 'payroll_data');
					}
					
					
					
					
				}
					// end validation
					$end_validation_result = $this->EndValidation ( $validation_id ,$company_id, 'all');
					
					if (! empty ( $end_validation_result ['success'] )) {
						$result ['success'] = 'success';
					}
				} catch ( \Exception $e ) { // catching the exception
					
					$msg = $e->getMessage ();
					$result ['error'] = $msg;
					// exception validation
					$exception_validation_result = $this->ValidationException ( $validation_id, $msg );
				}
			}
			
			return $result;
		}
	}
	protected function StartValidation($company_id, $validation_id) {
		$result = array ();
		
		$validation_details = TblAcaCompanyValidationStatus::find ()->where ( [ 
				'validation_id' => $validation_id 
		] )->One ();
		
		$validation_details->is_executed = 1;
		$validation_details->start_date_time = date ( 'Y-m-d H:i:s' );
		
		if (($validation_details->save ()) && $validation_details->validate ()) {
			
		
			
			$result ['success'] = 'success';
			$result ['validation_id'] = $validation_details->validation_id;
		} else {
			
			$arrerrors = $validation_details->getFirstErrors ();
			$errorstring = '';
			/**
			 * *****Converting error into string*******
			 */
			foreach ( $arrerrors as $key => $value ) {
				$errorstring .= $value . '<br>';
			}
			$result ['error'] = $errorstring;
		}
		
		return $result;
	}
	protected function EndValidation($validation_id , $company_id, $validation_end_type) {
		$result = array ();
		$arr_validations =  array();
		$is_all_validated = 0;
		$model_companies = new TblAcaCompanies();
		$validate_check_errors = new ValidateCheckErrorsComponent();
		
		$validation_details = TblAcaCompanyValidationStatus::find ()->where ( [ 
				'validation_id' => $validation_id 
		] )->One ();
		if (! empty ( $validation_details )) {
			
			if($validation_end_type == 'all')
			{
			$validation_details->is_completed = 1;
			$validation_details->end_date_time = date ( 'Y-m-d H:i:s' );
			
			/**
			 * ****Get validation results***********
			 */
			$validation_results = TblAcaValidationLog::find ()->select ( 'validation_rule_id, is_validated' )->where ( [ 
					'company_id' => $company_id 
			] )->All ();
				
			
			// Checking if validations results are empty
				if (! empty ( $validation_results )) { 
					
					$arr_validations = $validate_check_errors->CheckErrors($validation_results, $company_id);
				}
				
				// check if all values are validated
				if (empty ( $arr_validations ['basic_info'] ) && empty ( $arr_validations ['benefit_plan'] ) && empty ( $arr_validations ['plan_class_validation'] ) && empty ( $arr_validations ['payroll_data_validation'] ) && empty ( $arr_validations ['medical_data_validation'] )) {
					$is_all_validated = 1;
				}
				
			}
			else if($validation_end_type == 'basic_info')
			{
			$validation_details->is_basic_info = 1;
			$validation_details->basic_info_date = date ( 'Y-m-d H:i:s' );
			}
			else if($validation_end_type == 'benefit_plan')
			{
			$validation_details->is_benefit_info = 1;
			$validation_details->benefit_info_date = date ( 'Y-m-d H:i:s' );
			}
			else if($validation_end_type == 'plan_class')
			{
			$validation_details->is_plan_class = 1;
			
			}
			else if($validation_end_type == 'payroll_data')
			{
			$validation_details->is_payroll_data = 1;
			$validation_details->payroll_info_date = date ( 'Y-m-d H:i:s' );
			}
			else if($validation_end_type == 'medical_data')
			{
			$validation_details->is_medical_data = 1;
			$validation_details->medical_info_date = date ( 'Y-m-d H:i:s' );
			}
			
			
			
			
			if (($validation_details->save ()) && $validation_details->validate ()) {
				
				$model_status=$model_companies->Companyuniquedetails($company_id);
				
				if($is_all_validated == 1)
				{
					$model_status->reporting_status = 31;
				}
				else
				{
					$model_status->reporting_status = 29;
				}
				
				$model_status->save ();
				$result ['success'] = 'success';
				$result ['validation_id'] = $validation_details->validation_id;
			} else {
				$arrerrors = $validation_details->getFirstErrors ();
				$errorstring = '';
				/**
				 * *****Converting error into string*******
				 */
				foreach ( $arrerrors as $key => $value ) {
					$errorstring .= $value . '<br>';
				}
				$result ['error'] = $errorstring;
			}
		}
		return $result;
	}
	protected function ValidationException($validation_id, $exception) {
		$result = array ();
		$validation_details = TblAcaCompanyValidationStatus::find ()->where ( [ 
				'validation_id' => $validation_id 
		] )->One ();
		if (! empty ( $validation_details )) {
			$validation_details->exception = $exception;
			
			if (($validation_details->save ()) && $validation_details->validate ()) {
				$result ['success'] = 'success';
				$result ['validation_id'] = $validation_details->validation_id;
			} else {
				$arrerrors = $validation_details->getFirstErrors ();
				$errorstring = '';
				/**
				 * *****Converting error into string*******
				 */
				foreach ( $arrerrors as $key => $value ) {
					$errorstring .= $value . '<br>';
				}
				$result ['error'] = $errorstring;
			}
		}
	}
	public function actionMeccoverage() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			/**
			 * Declaring Session Variables**
			 */
			 
			
			$this->layout = 'main';
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			$encrypt_component = new EncryptDecryptComponent ();
			$common_validation_component = new CommonValidationsComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_element_master = new TblAcaElementMaster ();
			$model_mec_coverage = new TblAcaMecCoverage ();
			
			$get_company_id = \Yii::$app->request->get ();
			
			$mec_months = '';
			$validation_rule_ids = array ();
			$update_validations = array ();
			$element_ids = array ();
			
			if (! empty ( $get_company_id )) {
				/**
				 * Encrypted company ID*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
					$client_id = $check_company_details->client_id; // Company clien Id
					                                                
					// / get the company details
					$company_detals = TblAcaCompanies::find ()->select ( 'company_client_number,company_name' )->where ( 'company_id = :company_id', [ 
							'company_id' => $company_id 
					] )->one ();
					
					// checking if the validation starts for this company
					// print_r($company_id);die();
					$company_validation = TblAcaCompanyValidationStatus::find ()->where ( [ 
							'company_id' => $company_id 
					] )->andWhere ( [ 
							'is_initialized' => 1 
					] )->andWhere ( [ 
							'is_completed' => 0 
					] )->One ();
				}
				
				/**
				 * *Checking if company details exists for the company_id and company and client is present in session**
				 */
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$period_details = $model_companies->getcompanyperiod ( $company_id );
					$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
					
					/**
					 * *Check for validation errors***
					 */
					$validation_results = TblAcaValidationLog::find ()->select ( 'validation_rule_id, is_validated' )->where ( [ 
							'company_id' => $company_id,
							'validation_rule_id' => 62,
							'is_validated' => 0 
					] )->One ();
					
					if (! empty ( $validation_results )) {
						$validation_rule_ids [] = $validation_results->validation_rule_id;
						
						$section_ids = [ 
								'8' 
						];
						$element_ids = [ 
								'73' 
						];
						$all_elements = $model_element_master->FindallbysectionIds ( $section_ids );
						
						$arrsection_elements = ArrayHelper::map ( $all_elements, 'element_id', 'element_label' );
						
						$check_mec_coverage = TblAcaMecCoverage::find ()->where ( [ 
								'company_id' => $company_id,
								'period_id' => $period_id 
						] )->One ();
						
						if (! empty ( $check_mec_coverage )) {
							$model_mec_coverage = $check_mec_coverage;
						}
						if (\Yii::$app->request->post ()) {
							$mec_coverage_info = \Yii::$app->request->post ();
							
							if (! empty ( $mec_coverage_info ['TblAcaMecCoverage'] ['mec_months'] )) {
								$mec_months = $mec_coverage_info ['TblAcaMecCoverage'] ['mec_months'];
								$mec_months = implode ( ",", $mec_months );
							}
							
							$model_mec_coverage->company_id = $company_id;
							$model_mec_coverage->period_id = $period_id;
							$model_mec_coverage->mec_months = $mec_months;
							
							if ($model_mec_coverage->isNewRecord) {
								$model_mec_coverage->created_date = date ( 'Y-m-d H:i:s' );
								$model_mec_coverage->created_by = $logged_user_id;
							} else {
								$model_mec_coverage->modified_date = date ( 'Y-m-d H:i:s' );
								$model_mec_coverage->modified_by = $logged_user_id;
							}
							
							// begin transaction
							$transaction = \Yii::$app->db->beginTransaction ();
							
							try {
								
								if ($model_mec_coverage->save () && $model_mec_coverage->validate ()) {
									
									// validate general plan info
									$validate_results = $common_validation_component->ValidateGeneralplaninfo ( $company_id, $element_ids );
									
									if (! empty ( $validate_results ['error'] )) {
										throw new \Exception ( $validate_results ['error'] );
									} else {
										
										TblAcaValidationLog::deleteAll ( [ 
												'and',
												'company_id  = :company_id',
												[ 
														'in',
														'validation_rule_id',
														$validation_rule_ids 
												] 
										], [ 
												':company_id' => $company_id 
										] );
										
										$update_validations = $this->Updategeneralvalidation ( $company_id, $validate_results ['success'] );
										
										$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();
											
										if(!empty($model_company_validation_log))		{
											$model_company_validation_log->created_by = $logged_user_id;
											$model_company_validation_log->modified_by = $logged_user_id;
											$model_company_validation_log->benefit_info_date = date('Y-m-d H:i:s');
												
											$model_company_validation_log->save();
										}
										
										if (! empty ( $update_validations ['error'] )) {
											throw new \Exception ( $update_validations ['error'] );
										}
									}
									
									$transaction->commit (); // commit the transaction
									
									\Yii::$app->session->setFlash ( 'success', 'Mec Coverage is saved successfully' );
									return $this->redirect ( array (
											'/client/validateforms?c_id=' . $encrypt_company_id 
									) );
								} else {
									
									throw new \Exception ( 'Error occurred while saving' ); // throws a exception
								}
							} catch ( \Exception $e ) {
								
								$msg = $e->getMessage ();
								\Yii::$app->session->setFlash ( 'error', $msg );
								
								// rollback transaction
								$transaction->rollback ();
								
								return $this->redirect ( array (
										'/client/validateforms/meccoverage?c_id=' . $encrypt_company_id 
								) );
							}
						}
						
						return $this->render ( 'meccoverage', array (
								'company_id' => $company_id,
								'encoded_company_id' => $_GET ['c_id'],
								'model_mec_coverage' => $model_mec_coverage,
								'arrsection_elements' => $arrsection_elements,
								'validation_results' => $validation_results,
								'company_detals' => $company_detals,
								'company_validation' => $company_validation 
						) );
					} else {
						
						\Yii::$app->session->setFlash ( 'success', 'Mec Coverage is already validated' );
						return $this->redirect ( array (
								'/client/validateforms?c_id=' . $encrypt_company_id 
						) );
					}
				} else {
					return $this->redirect ( array (
							'/client/companies' 
					) );
				}
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
	}
	public function actionGeneralplaninfo() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			/**
			 * Declaring Session Variables**
			 */
			$this->layout = 'main';
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			$encrypt_component = new EncryptDecryptComponent ();
			$common_validation_component = new CommonValidationsComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_element_master = new TblAcaElementMaster ();
			$model_general_plan_info = new TblAcaGeneralPlanInfo ();
			$model_general_plan_months = new TblAcaGeneralPlanMonths ();
			
			$get_company_id = \Yii::$app->request->get ();
			
			$validation_rule_ids = array ();
			$update_validations = array ();
			$arrvalidations = array ();
			$offer_type = '';
			$renewal_month = '';
			$plan_type_description = '';
			$is_multiple_waiting_periods = '';
			$multiple_description = '';
			$is_employees_hra = '';
			$is_first_year = '';
			$month_list = '';
			$arrsection_elements = array ();
			$arrsection_months = array ();
			$validated_rule_ids = array ();
			$arrvalidation_errors = array ();
			$post_validation_errors = array ();
			
			if (! empty ( $get_company_id )) {
				/**
				 * Encrypted company ID*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
					$client_id = $check_company_details->client_id; // Company clien Id
					                                                
					// / get the company details
					$company_detals = TblAcaCompanies::find ()->select ( 'company_client_number,company_name' )->where ( 'company_id = :company_id', [ 
							'company_id' => $company_id 
					] )->one ();
					
					// checking if the validation starts for this company
					
					$company_validation = TblAcaCompanyValidationStatus::find ()->where ( [ 
							'company_id' => $company_id 
					] )->andWhere ( [ 
							'is_initialized' => 1 
					] )->andWhere ( [ 
							'is_completed' => 0 
					] )->One ();
				}
				
				/**
				 * *Checking if company details exists for the company_id and company and client is present in session**
				 */
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$period_details = $model_companies->getcompanyperiod ( $company_id );
					$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
					
					$validation_rule_ids = [ 
							'55',
							'56',
							'57',
							'58',
							'59',
							'60',
							'61' 
					];
					$element_ids = [ 
							'64',
							'65',
							'68',
							'69',
							'70',
							'72' 
					];
					/**
					 * *Check for validation errors***
					 */
					$validation_results = TblAcaValidationLog::find ()->select ( 'validation_rule_id, is_validated' )->where ( [ 
							'company_id' => $company_id,
							'validation_rule_id' => $validation_rule_ids,
							'is_validated' => 0 
					] )->All ();
					
					if (! empty ( $validation_results )) {
						
						foreach ( $validation_results as $validations ) {
							
							$arrvalidations [] = $validations->validation_rule_id;
							$arrvalidation_errors [$validations->validation_rule_id] ['error_message'] = $validations->validationRule->error_message;
							$arrvalidation_errors [$validations->validation_rule_id] ['error_code'] = $validations->validationRule->error_code;
						}
						
						/**
						 * Get all errors for general info *
						 */
						$get_post_validation_errors = TblAcaValidationRules::find ()->select ( 'rule_id, error_code, error_message' )->where ( [ 
								'rule_id' => $validation_rule_ids 
						] )->All ();
						
						if (! empty ( $get_post_validation_errors )) {
							
							foreach ( $get_post_validation_errors as $errors ) {
								$post_validation_errors [$errors->rule_id] ['error_message'] = $errors->error_message;
								$post_validation_errors [$errors->rule_id] ['error_code'] = $errors->error_code;
							}
						}
						
						$section_ids = [ 
								'7' 
						];
						$all_elements = $model_element_master->FindallbysectionIds ( $section_ids );
						
						$arrsection_elements = ArrayHelper::map ( $all_elements, 'element_id', 'element_label' );
						
						/**
						 * ********Check General Plan info***************
						 */
						$general_plan_info = TblAcaGeneralPlanInfo::find ()->where ( [ 
								'company_id' => $company_id,
								'period_id' => $period_id 
						] )->One ();
						if (! empty ( $general_plan_info )) {
							$model_general_plan_info = $general_plan_info;
							
							$general_plan_id = $general_plan_info->general_plan_id;
							
							/**
							 * ********Check month group list***************
							 */
							
							$month_list = $model_general_plan_months->FindbygeneralId ( $general_plan_id );
							
							$all_months = $model_general_plan_months->FindallbymonthIds ( $general_plan_id );
							
							$arrsection_months = ArrayHelper::map ( $all_months, 'month_id', 'plan_value' );
						}
						
						if ($model_general_plan_info->load ( \Yii::$app->request->post () )) {
							
							$general_plan_info = \Yii::$app->request->post ();
							
							if (! empty ( $general_plan_info ['TblAcaGeneralPlanInfo'] ['renewal_month'] )) {
								$renewal_month = $general_plan_info ['TblAcaGeneralPlanInfo'] ['renewal_month'];
							}
							
							if (! empty ( $general_plan_info ['TblAcaGeneralPlanInfo'] ['is_first_year'] )) {
								$is_first_year = $general_plan_info ['TblAcaGeneralPlanInfo'] ['is_first_year'];
							}
							
							if (! empty ( $general_plan_info ['TblAcaGeneralPlanInfo'] ['plan_type_description'] )) {
								$plan_type_description = $general_plan_info ['TblAcaGeneralPlanInfo'] ['plan_type_description'];
							}
							if (! empty ( $general_plan_info ['TblAcaGeneralPlanInfo'] ['offer_type'] )) {
								$offer_type = $general_plan_info ['TblAcaGeneralPlanInfo'] ['offer_type'];
							}
							
							if (! empty ( $general_plan_info ['TblAcaGeneralPlanInfo'] ['is_multiple_waiting_periods'] )) {
								$is_multiple_waiting_periods = $general_plan_info ['TblAcaGeneralPlanInfo'] ['is_multiple_waiting_periods'];
							}
							if (! empty ( $general_plan_info ['TblAcaGeneralPlanInfo'] ['multiple_description'] )) {
								
								if (! empty ( $is_multiple_waiting_periods ) && $is_multiple_waiting_periods == 1) {
									$multiple_description = $general_plan_info ['TblAcaGeneralPlanInfo'] ['multiple_description'];
								} else {
									$multiple_description = '';
								}
							}
							
							if (! empty ( $general_plan_info ['TblAcaGeneralPlanInfo'] ['is_employees_hra'] )) {
								$is_employees_hra = $general_plan_info ['TblAcaGeneralPlanInfo'] ['is_employees_hra'];
							}
							$model_general_plan_info->company_id = $company_id;
							$model_general_plan_info->period_id = $period_id;
							
							if (in_array ( 60, $arrvalidations, TRUE )) {
								$model_general_plan_info->offer_type = $offer_type;
							}
							
							if (in_array ( 55, $arrvalidations, TRUE )) {
								$model_general_plan_info->is_first_year = $is_first_year;
							}
							
							if (in_array ( 56, $arrvalidations, TRUE )) {
								$model_general_plan_info->renewal_month = $renewal_month;
							}
							
							if (in_array ( 57, $arrvalidations, TRUE )) {
								$model_general_plan_info->is_multiple_waiting_periods = $is_multiple_waiting_periods;
							}
							
							if (in_array ( 58, $arrvalidations, TRUE )) {
								$model_general_plan_info->multiple_description = $multiple_description;
							}
							
							if (in_array ( 59, $arrvalidations, TRUE )) {
								$model_general_plan_info->is_employees_hra = $is_employees_hra;
							}
							
							if ($model_general_plan_info->isNewRecord) {
								$model_general_plan_info->created_date = date ( 'Y-m-d H:i:s' );
								$model_general_plan_info->created_by = $logged_user_id;
							} else {
								$model_general_plan_info->modified_date = date ( 'Y-m-d H:i:s' );
								$model_general_plan_info->modified_by = $logged_user_id;
							}
							
							// begin transaction
							$transaction = \Yii::$app->db->beginTransaction ();
							
							try {
								
								if ($model_general_plan_info->save () && $model_general_plan_info->validate ()) {
									
									$general_plan_id = $model_general_plan_info->general_plan_id;
									
									if ($model_general_plan_months->load ( \Yii::$app->request->post () )) {
										$month_list = \Yii::$app->request->post ();
										$month_list_array = $month_list ['TblAcaGeneralPlanMonths'] ['plan_value'];
										
										if (! empty ( $general_plan_id )) {
											
											TblAcaGeneralPlanMonths::deleteAll ( [ 
													'general_plan_id' => $general_plan_id 
											] );
										}
										
										$i = 0;
										foreach ( $month_list_array as $key => $value ) {
											
											$model_general_plan_months->general_plan_id = $general_plan_id;
											// $model_general_plan_months->both_self_fully=$yes_value;
											$model_general_plan_months->month_id = $key;
											
											if (! empty ( $offer_type ) && $offer_type == 1) {
												$model_general_plan_months->plan_value = $value;
											} else {
												$model_general_plan_months->plan_value = 0;
											}
											
											$model_general_plan_months->created_by = $logged_user_id;
											$model_general_plan_months->created_date = date ( 'Y-m-d H:i:s' );
											$model_general_plan_months->plan_month_id = NULL;
											$model_general_plan_months->isNewRecord = TRUE;
											if ($model_general_plan_months->save () && $model_general_plan_months->validate ()) {
												$i ++;
											}
										}
									}
									// validate general plan info
									$validate_results = $common_validation_component->ValidateGeneralplaninfo ( $company_id, $element_ids );

									$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();
									
									if(!empty($model_company_validation_log))		{
										$model_company_validation_log->created_by = $logged_user_id;
										$model_company_validation_log->modified_by = $logged_user_id;
										$model_company_validation_log->benefit_info_date = date('Y-m-d H:i:s');
									
										$model_company_validation_log->save();
									}
									
									if (! empty ( $validate_results ['error'] )) {
										throw new \Exception ( $validate_results ['error'] );
									} else {
										$validation_success = $validate_results ['success'];
										if (! in_array ( 0, $validation_success, TRUE )) {
											
											TblAcaValidationLog::deleteAll ( [ 
													'and',
													'company_id  = :company_id',
													[ 
															'in',
															'validation_rule_id',
															$validation_rule_ids 
													] 
											], [ 
													':company_id' => $company_id 
											] );
											
											$update_validations = $this->Updategeneralvalidation ( $company_id, $validation_success );
											if (! empty ( $update_validations ['error'] )) {
												throw new \Exception ( $update_validations ['error'] );
											}
											
											$transaction->commit (); // commit the transaction
											
											\Yii::$app->session->setFlash ( 'success', 'General Plan Info is saved successfully' );
											return $this->redirect ( array (
													'/client/validateforms?c_id=' . $encrypt_company_id 
											) );
										} else {
											foreach ( $validation_success as $key => $value ) {
												if ($value == 0) {
													$arrvalidation_errors [$key] ['error_message'] = $post_validation_errors [$key] ['error_message'];
													$arrvalidation_errors [$key] ['error_code'] = $post_validation_errors [$key] ['error_code'];
												} else {
													$arrvalidation_errors [$key] ['error_message'] = '';
													$arrvalidation_errors [$key] ['error_code'] = '';
												}
											}
											
											$transaction->rollBack ();
										}
									}
								} else {
									
									throw new \Exception ( 'Something error occured while saving' ); // throws a exception
								}
							} catch ( \Exception $e ) {
								
								$msg = $e->getMessage ();
								\Yii::$app->session->setFlash ( 'error', $msg );
								
								// rollback transaction
								$transaction->rollback ();
								
								return $this->redirect ( array (
										'/client/validateforms/generalplaninfo?c_id=' . $encrypt_company_id 
								) );
							}
						}
						
						return $this->render ( 'generalplaninfo', array (
								'company_id' => $company_id,
								'encoded_company_id' => $_GET ['c_id'],
								'model_general_plan_info' => $model_general_plan_info,
								'model_general_plan_info_months' => $model_general_plan_months,
								'month_list' => $month_list,
								'arrsection_elements' => $arrsection_elements,
								'arrsection_months' => $arrsection_months,
								'arrvalidations' => $arrvalidations,
								'arrvalidation_errors' => $arrvalidation_errors,
								'company_detals' => $company_detals,
								'company_validation' => $company_validation 
						) );
					} else {
						
						\Yii::$app->session->setFlash ( 'success', 'General Plan Info is already validated' );
						return $this->redirect ( array (
								'/client/validateforms?c_id=' . $encrypt_company_id 
						) );
					}
				} else {
					return $this->redirect ( array (
							'/client/companies' 
					) );
				}
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
	}
	public function actionPlanofferingcriteria() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			/**
			 * Declaring Session Variables**
			 */
			$this->layout = 'main';
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			$encrypt_component = new EncryptDecryptComponent ();
			$common_validation_component = new CommonValidationsComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_element_master = new TblAcaElementMaster ();
			$model_plan_offering_criteria = new TblAcaPlanCriteria ();
			
			$get_company_id = \Yii::$app->request->get ();
			
			$plan_offering_criteria_type = '';
			$initial_measurment_period_begin = '';
			$validation_rule_ids = array ();
			$update_validations = array ();
			$arrvalidations = array ();
			$arrsection_elements = array ();
			$arrsection_months = array ();
			$validated_rule_ids = array ();
			$arrvalidation_errors = array ();
			$post_validation_errors = array ();
			
			if (! empty ( $get_company_id )) {
				/**
				 * Encrypted company ID*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
					$client_id = $check_company_details->client_id; // Company clien Id
					                                                
					// / get the company details
					$company_detals = TblAcaCompanies::find ()->select ( 'company_client_number,company_name' )->where ( 'company_id = :company_id', [ 
							'company_id' => $company_id 
					] )->one ();
					
					// checking if the validation starts for this company
					
					$company_validation = TblAcaCompanyValidationStatus::find ()->where ( [ 
							'company_id' => $company_id 
					] )->andWhere ( [ 
							'is_initialized' => 1 
					] )->andWhere ( [ 
							'is_completed' => 0 
					] )->One ();
				}
				
				/**
				 * *Checking if company details exists for the company_id and company and client is present in session**
				 */
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$period_details = $model_companies->getcompanyperiod ( $company_id );
					$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
					
					$validation_rule_ids = [ 
							'27',
							'28',
							'29',
							'30' 
					];
					$element_ids = [ 
							'25',
							'26',
							'27',
							'38' 
					];
					/**
					 * *Check for validation errors***
					 */
					$validation_results = TblAcaValidationLog::find ()->select ( 'validation_rule_id, is_validated' )->where ( [ 
							'company_id' => $company_id,
							'validation_rule_id' => $validation_rule_ids,
							'is_validated' => 0 
					] )->All ();
					
					if (! empty ( $validation_results )) {
						
						foreach ( $validation_results as $validations ) {
							
							$arrvalidations [] = $validations->validation_rule_id;
							$arrvalidation_errors [$validations->validation_rule_id] ['error_message'] = $validations->validationRule->error_message;
							$arrvalidation_errors [$validations->validation_rule_id] ['error_code'] = $validations->validationRule->error_code;
						}
						
						/**
						 * Get all errors for general info *
						 */
						$get_post_validation_errors = TblAcaValidationRules::find ()->select ( 'rule_id, error_code, error_message' )->where ( [ 
								'rule_id' => $validation_rule_ids 
						] )->All ();
						
						if (! empty ( $get_post_validation_errors )) {
							
							foreach ( $get_post_validation_errors as $errors ) {
								$post_validation_errors [$errors->rule_id] ['error_message'] = $errors->error_message;
								$post_validation_errors [$errors->rule_id] ['error_code'] = $errors->error_code;
							}
						}
						
						$section_ids = [ 
								'3' 
						];
						$all_elements = $model_element_master->FindallbysectionIds ( $section_ids );
						
						$arrsection_elements = ArrayHelper::map ( $all_elements, 'element_id', 'element_label' );
						
						/**
						 * ********Check General Plan info***************
						 */
						$check_plan_criteria = TblAcaPlanCriteria::find ()->where ( [ 
								'company_id' => $company_id,
								'period_id' => $period_id 
						] )->One ();
						
						if (! empty ( $check_plan_criteria )) {
							$model_plan_offering_criteria = $check_plan_criteria;
						}
						
						/**
						 * Check for any post of data*
						 */
						if ($model_plan_offering_criteria->load ( \Yii::$app->request->post () )) {
							
							/**
							 * Check for the type of button clicked i.e (Save and continue) or (Save and Exit)*
							 */
							$postplancriteria = \Yii::$app->request->post ( 'TblAcaPlanCriteria' );
							if (! empty ( $postplancriteria ['plan_offering_criteria_type'] )) {
								
								$criteria_type = $postplancriteria ['plan_offering_criteria_type'];
								foreach ( $criteria_type as $key => $value ) {
									$plan_offering_criteria_type .= $value . ',';
								}
							}
							
							if (! empty ( $postplancriteria ['initial_measurment_period_begin'] )) {
								
								$initial_measurment_period_begin = $postplancriteria ['initial_measurment_period_begin'];
							}
							
							// begin transaction
							$transaction = \Yii::$app->db->beginTransaction ();
							
							try {
								$model_plan_offering_criteria->attributes = $postplancriteria;
								$model_plan_offering_criteria->company_id = $company_id;
								$model_plan_offering_criteria->period_id = $period_id;
								$model_plan_offering_criteria->plan_offering_criteria_type = $plan_offering_criteria_type;
								$model_plan_offering_criteria->initial_measurment_period_begin = $initial_measurment_period_begin;
								
								if ($model_plan_offering_criteria->isNewRecord) {
									$model_plan_offering_criteria->created_date = date ( 'Y-m-d H:i:s' );
									$model_plan_offering_criteria->created_by = $logged_user_id;
								} else {
									$model_plan_offering_criteria->modified_date = date ( 'Y-m-d H:i:s' );
									$model_plan_offering_criteria->modified_by = $logged_user_id;
								}
								
								if ($model_plan_offering_criteria->save () && $model_plan_offering_criteria->validate ()) {
									
									// validate general plan info
									$validate_results = $common_validation_component->ValidatePlanofferingcriteria ( $company_id, $element_ids );
									
									if (! empty ( $validate_results ['error'] )) {
										throw new \Exception ( $validate_results ['error'] );
									} else {
										$validation_success = $validate_results ['success'];
										
										if (! in_array ( 0, $validation_success, TRUE )) {
											
											TblAcaValidationLog::deleteAll ( [ 
													'and',
													'company_id  = :company_id',
													[ 
															'in',
															'validation_rule_id',
															$validation_rule_ids 
													] 
											], [ 
													':company_id' => $company_id 
											] );
											
											$update_validations = $this->Updategeneralvalidation ( $company_id, $validation_success );

											$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();
											
											if(!empty($model_company_validation_log))		{
												$model_company_validation_log->created_by = $logged_user_id;
												$model_company_validation_log->modified_by = $logged_user_id;
												$model_company_validation_log->basic_info_date = date('Y-m-d H:i:s');
											
												$model_company_validation_log->save();
											}
												
											if (! empty ( $update_validations ['error'] )) {
												throw new \Exception ( $update_validations ['error'] );
											}
											
											$transaction->commit (); // commit the transaction
											
											\Yii::$app->session->setFlash ( 'success', 'Plan offering criteria saved successfully' );
											return $this->redirect ( array (
													'/client/validateforms?c_id=' . $encrypt_company_id 
											) );
										} else {
											foreach ( $validation_success as $key => $value ) {
												if ($value == 0) {
													$arrvalidation_errors [$key] ['error_message'] = $post_validation_errors [$key] ['error_message'];
													$arrvalidation_errors [$key] ['error_code'] = $post_validation_errors [$key] ['error_code'];
												} else {
													$arrvalidation_errors [$key] ['error_message'] = '';
													$arrvalidation_errors [$key] ['error_code'] = '';
												}
											}
											
											$transaction->rollBack ();
										}
									}
								} else {
									$arrerrors = $model_plan_offering_criteria->getFirstErrors ();
									$errorstring = '';
									
									foreach ( $arrerrors as $key => $value ) {
										$errorstring .= $value . '<br>';
									}
									
									throw new \Exception ( $errorstring );
								}
							} catch ( \Exception $e ) {
								
								$msg = $e->getMessage ();
								\Yii::$app->session->setFlash ( 'error', $msg );
								// rollback transaction
								$transaction->rollback ();
								/**
								 * Redirect to Index (Company dashboard)*
								 */
								return $this->redirect ( array (
										'/client/validateforms/planofferingcriteria?c_id=' . $encrypt_company_id 
								) );
							}
						}
						
						return $this->render ( 'planofferingcriteria', array (
								'company_id' => $company_id,
								'encoded_company_id' => $_GET ['c_id'],
								'model_plan_offering_criteria' => $model_plan_offering_criteria,
								'arrvalidations' => $arrvalidations,
								'arrvalidation_errors' => $arrvalidation_errors,
								'arrsection_elements' => $arrsection_elements,
								'company_detals' => $company_detals,
								'company_validation' => $company_validation 
						) );
					} else {
						
						\Yii::$app->session->setFlash ( 'success', 'Plan offering criteria is already validated' );
						return $this->redirect ( array (
								'/client/validateforms?c_id=' . $encrypt_company_id 
						) );
					}
				} else {
					return $this->redirect ( array (
							'/client/companies' 
					) );
				}
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
	}
	public function actionLargeempstatustrack() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			/**
			 * Declaring Session Variables**
			 */
			$this->layout = 'main';
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			$encrypt_component = new EncryptDecryptComponent ();
			$common_validation_component = new CommonValidationsComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_element_master = new TblAcaElementMaster ();
			$model_large_emp_status = new TblAcaEmpStatusTrack ();
			
			$get_company_id = \Yii::$app->request->get ();
			
			$validation_rule_ids = array ();
			$update_validations = array ();
			$arrvalidations = array ();
			$arrsection_elements = array ();
			$arrsection_months = array ();
			$validated_rule_ids = array ();
			$arrvalidation_errors = array ();
			$post_validation_errors = array ();
			
			if (! empty ( $get_company_id )) {
				/**
				 * Encrypted company ID*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
					$client_id = $check_company_details->client_id; // Company clien Id
					                                                
					// / get the company details
					$company_detals = TblAcaCompanies::find ()->select ( 'company_client_number,company_name' )->where ( 'company_id = :company_id', [ 
							'company_id' => $company_id 
					] )->one ();
					
					// checking if the validation starts for this company
					
					$company_validation = TblAcaCompanyValidationStatus::find ()->where ( [ 
							'company_id' => $company_id 
					] )->andWhere ( [ 
							'is_initialized' => 1 
					] )->andWhere ( [ 
							'is_completed' => 0 
					] )->One ();
				}
				
				/**
				 * *Checking if company details exists for the company_id and company and client is present in session**
				 */
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$period_details = $model_companies->getcompanyperiod ( $company_id );
					$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
					
					$validation_rule_ids = [ 
							'24',
							'25',
							'26' 
					];
					$element_ids = [ 
							'22',
							'23',
							'24' 
					];
					/**
					 * *Check for validation errors***
					 */
					$validation_results = TblAcaValidationLog::find ()->select ( 'validation_rule_id, is_validated' )->where ( [ 
							'company_id' => $company_id,
							'validation_rule_id' => $validation_rule_ids,
							'is_validated' => 0 
					] )->All ();
					
					if (! empty ( $validation_results )) {
						
						foreach ( $validation_results as $validations ) {
							
							$arrvalidations [] = $validations->validation_rule_id;
							$arrvalidation_errors [$validations->validation_rule_id] ['error_message'] = $validations->validationRule->error_message;
							$arrvalidation_errors [$validations->validation_rule_id] ['error_code'] = $validations->validationRule->error_code;
						}
						
						/**
						 * Get all errors for general info *
						 */
						$get_post_validation_errors = TblAcaValidationRules::find ()->select ( 'rule_id, error_code, error_message' )->where ( [ 
								'rule_id' => $validation_rule_ids 
						] )->All ();
						
						if (! empty ( $get_post_validation_errors )) {
							
							foreach ( $get_post_validation_errors as $errors ) {
								$post_validation_errors [$errors->rule_id] ['error_message'] = $errors->error_message;
								$post_validation_errors [$errors->rule_id] ['error_code'] = $errors->error_code;
							}
						}
						
						$section_ids = [ 
								'2' 
						];
						$all_elements = $model_element_master->FindallbysectionIds ( $section_ids );
						
						$arrsection_elements = ArrayHelper::map ( $all_elements, 'element_id', 'element_label' );
						
						/**
						 * ********Check Large emp status***************
						 */
						$check_emp_status = TblAcaEmpStatusTrack::find ()->where ( [ 
								'company_id' => $company_id,
								'period_id' => $period_id 
						] )->One ();
						
						if (! empty ( $check_emp_status )) {
							$model_large_emp_status = $check_emp_status;
						}
						
						/**
						 * Check for any post of data*
						 */
						if ($model_large_emp_status->load ( \Yii::$app->request->post () )) {
							
							/**
							 * Check for the type of button clicked i.e (Save and continue) or (Save and Exit)*
							 */
							$redirect_button = \Yii::$app->request->post ( 'button' );
							$postempstatus = \Yii::$app->request->post ( 'TblAcaEmpStatusTrack' );
							
							// begin transaction
							$transaction = \Yii::$app->db->beginTransaction ();
							
							try {
								$model_large_emp_status->attributes = $postempstatus;
								$model_large_emp_status->company_id = $company_id;
								$model_large_emp_status->period_id = $period_id;
								
								if ($model_large_emp_status->isNewRecord) {
									$model_large_emp_status->created_date = date ( 'Y-m-d H:i:s' );
									$model_large_emp_status->created_by = $logged_user_id;
								} else {
									$model_large_emp_status->modified_date = date ( 'Y-m-d H:i:s' );
									$model_large_emp_status->modified_by = $logged_user_id;
								}
								
								if ($model_large_emp_status->save () && $model_large_emp_status->validate ()) {
									
									// validate general plan info
									$validate_results = $common_validation_component->Validateale ( $company_id, $element_ids );
									
									$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();
									
									if(!empty($model_company_validation_log))		{
										$model_company_validation_log->created_by = $logged_user_id;
										$model_company_validation_log->modified_by = $logged_user_id;
										$model_company_validation_log->basic_info_date = date('Y-m-d H:i:s');
									
										$model_company_validation_log->save();
									}
									
									if (! empty ( $validate_results ['error'] )) {
										throw new \Exception ( $validate_results ['error'] );
									} else {
										$validation_success = $validate_results ['success'];
										
										if (! in_array ( 0, $validation_success, TRUE )) {
											
											TblAcaValidationLog::deleteAll ( [ 
													'and',
													'company_id  = :company_id',
													[ 
															'in',
															'validation_rule_id',
															$validation_rule_ids 
													] 
											], [ 
													':company_id' => $company_id 
											] );
											
											$update_validations = $this->Updategeneralvalidation ( $company_id, $validation_success );
											if (! empty ( $update_validations ['error'] )) {
												throw new \Exception ( $update_validations ['error'] );
											}
											
											$transaction->commit (); // commit the transaction
											
											\Yii::$app->session->setFlash ( 'success', 'Large emp status and tracking saved successfully' );
											return $this->redirect ( array (
													'/client/validateforms?c_id=' . $encrypt_company_id 
											) );
										} else {
											foreach ( $validation_success as $key => $value ) {
												if ($value == 0) {
													$arrvalidation_errors [$key] ['error_message'] = $post_validation_errors [$key] ['error_message'];
													$arrvalidation_errors [$key] ['error_code'] = $post_validation_errors [$key] ['error_code'];
												} else {
													$arrvalidation_errors [$key] ['error_message'] = '';
													$arrvalidation_errors [$key] ['error_code'] = '';
												}
											}
											
											$transaction->rollBack ();
										}
									}
								} else {
									$arrerrors = $model_large_emp_status->getFirstErrors ();
									$errorstring = '';
									
									foreach ( $arrerrors as $key => $value ) {
										$errorstring .= $value . '<br>';
									}
									
									throw new \Exception ( $errorstring );
								}
							} catch ( \Exception $e ) {
								
								$msg = $e->getMessage ();
								\Yii::$app->session->setFlash ( 'error', $msg );
								// rollback transaction
								$transaction->rollback ();
								/**
								 * Redirect to Index (Company dashboard)*
								 */
								return $this->redirect ( array (
										'/client/validateforms/?c_id=' . $encrypt_company_id 
								) );
							}
						}
						
						return $this->render ( 'largeempstatus', array (
								'company_id' => $company_id,
								'encoded_company_id' => $_GET ['c_id'],
								'model_large_emp_status' => $model_large_emp_status,
								'arrvalidations' => $arrvalidations,
								'arrvalidation_errors' => $arrvalidation_errors,
								'arrsection_elements' => $arrsection_elements,
								'company_detals' => $company_detals,
								'company_validation' => $company_validation 
						) );
					} else {
						
						\Yii::$app->session->setFlash ( 'success', 'Plan offering criteria is already validated' );
						return $this->redirect ( array (
								'/client/validateforms/largeempstatustrack?c_id=' . $encrypt_company_id 
						) );
					}
				} else {
					return $this->redirect ( array (
							'/client/companies' 
					) );
				}
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
	}
	public function actionSaveaggregatedgroup() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			/**
			 * Declaring Session Variables**
			 */
			$this->layout = 'main';
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			$encrypt_component = new EncryptDecryptComponent ();
			$common_validation_component = new CommonValidationsComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_element_master = new TblAcaElementMaster ();
			$model_aggragated_group = new TblAcaAggregatedGroup ();
			$model_aggragated_group_list = new TblAcaAggregatedGroupList ();
			
			$get_company_id = \Yii::$app->request->get ();
			
			$client_id = '';
			$hear_about_us = '';
			$others = '';
			$total_aggregated_grp_months = '';
			$total_1095_forms = '';
			$authoritative_transmittal = '';
			$is_ale_member = '';
			$is_other_entity = '';
			$aggregated_list = '';
			$validation_rule_ids = array ();
			$update_validations = array ();
			$arrvalidations = array ();
			$arrsection_elements = array ();
			$validated_rule_ids = array ();
			$arrvalidation_errors = array ();
			$post_validation_errors = array ();
			
			if (! empty ( $get_company_id )) {
				/**
				 * Encrypted company ID*
				 */
				 
				
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
					$client_id = $check_company_details->client_id; // Company clien Id
					                                                
					// / get the company details
					$company_detals = TblAcaCompanies::find ()->select ( 'company_client_number,company_name' )->where ( 'company_id = :company_id', [ 
							'company_id' => $company_id 
					] )->one ();
					
					// checking if the validation starts for this company
					
					$company_validation = TblAcaCompanyValidationStatus::find ()->where ( [ 
							'company_id' => $company_id 
					] )->andWhere ( [ 
							'is_initialized' => 1 
					] )->andWhere ( [ 
							'is_completed' => 0 
					] )->One ();
				}
				
				/**
				 * *Checking if company details exists for the company_id and company and client is present in session**
				 */
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$period_details = $model_companies->getcompanyperiod ( $company_id );
					$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
					
					$validation_rule_ids = [ 
							'49',
							'50',
							'51',
							'52',
							'53',
							'54' 
					];
					$element_ids = [ 
							'56',
							'57',
							'58',
							'59',
							'60',
							'61' 
					];
					/**
					 * *Check for validation errors***
					 */
					$validation_results = TblAcaValidationLog::find ()->select ( 'validation_rule_id, is_validated' )->where ( [ 
							'company_id' => $company_id,
							'validation_rule_id' => $validation_rule_ids,
							'is_validated' => 0 
					] )->All ();
					
					
					if (! empty ( $validation_results )) {
						
						foreach ( $validation_results as $validations ) {
							
							$arrvalidations [] = $validations->validation_rule_id;
							$arrvalidation_errors [$validations->validation_rule_id] ['error_message'] = $validations->validationRule->error_message;
							$arrvalidation_errors [$validations->validation_rule_id] ['error_code'] = $validations->validationRule->error_code;
						}
						
						/**
						 * Get all errors for general info *
						 */
						$get_post_validation_errors = TblAcaValidationRules::find ()->select ( 'rule_id, error_code, error_message' )->where ( [ 
								'rule_id' => $validation_rule_ids 
						] )->All ();
						
						if (! empty ( $get_post_validation_errors )) {
							
							foreach ( $get_post_validation_errors as $errors ) {
								$post_validation_errors [$errors->rule_id] ['error_message'] = $errors->error_message;
								$post_validation_errors [$errors->rule_id] ['error_code'] = $errors->error_code;
							}
						}
						
						$section_ids = [ 
								'5' 
						];
						$all_elements = $model_element_master->FindallbysectionIds ( $section_ids );
						
						$arrsection_elements = ArrayHelper::map ( $all_elements, 'element_id', 'element_label' );
						
						/**
						 * ********Check Large emp status***************
						 */
						$check_emp_status = TblAcaAggregatedGroup::find ()->where ( [ 
								'company_id' => $company_id,
								'period_id' => $period_id 
						] )->One ();
						
						$check_aggregated_group = $model_aggragated_group->FindbycompanyIdperiodId ( $company_id, $period_id );
						
						if (! empty ( $check_aggregated_group )) {
							$model_aggragated_group = $check_aggregated_group;
							$aggregated_list = $model_aggragated_group_list->FindbyaggregateId ( $check_aggregated_group->aggregated_grp_id );
						}
						
						/**
						 * Check for any post of data*
						 */
						if ($model_aggragated_group->load ( \Yii::$app->request->post () )) {
							
							$aggragate_group_post = \Yii::$app->request->post ();
							
							if (! empty ( $aggragate_group_post ['TblAcaAggregatedGroup'] ['total_aggregated_grp_months'] )) {
								$total_aggregated_grp_months_array = $aggragate_group_post ['TblAcaAggregatedGroup'] ['total_aggregated_grp_months'];
								
								if ($total_aggregated_grp_months_array) {
									foreach ( $total_aggregated_grp_months_array as $key => $value ) {
										$total_aggregated_grp_months .= $value . ',';
									}
								}
							}
							
							if (! empty ( $aggragate_group_post ['TblAcaAggregatedGroup'] ['is_authoritative_transmittal'] )) {
								$authoritative_transmittal = $aggragate_group_post ['TblAcaAggregatedGroup'] ['is_authoritative_transmittal'];
							}
							
							if (! empty ( $aggragate_group_post ['TblAcaAggregatedGroup'] ['is_ale_member'] )) {
								$is_ale_member = $aggragate_group_post ['TblAcaAggregatedGroup'] ['is_ale_member'];
							}
							
							if (! empty ( $aggragate_group_post ['TblAcaAggregatedGroup'] ['is_other_entity'] )) {
								$is_other_entity = $aggragate_group_post ['TblAcaAggregatedGroup'] ['is_other_entity'];
							}
							
							if (! empty ( $aggragate_group_post ['TblAcaAggregatedGroup'] ['total_1095_forms'] )) {
								$total_1095_forms = $aggragate_group_post ['TblAcaAggregatedGroup'] ['total_1095_forms'];
							}
							
							$model_aggragated_group->company_id = $company_id;
							$model_aggragated_group->period_id = $period_id;
							$model_aggragated_group->is_authoritative_transmittal = $authoritative_transmittal;
							$model_aggragated_group->is_ale_member = $is_ale_member;
							$model_aggragated_group->is_other_entity = $is_other_entity;
							$model_aggragated_group->total_1095_forms = $total_1095_forms;
							$model_aggragated_group->total_aggregated_grp_months = $total_aggregated_grp_months;
							
							if ($model_aggragated_group->isNewRecord) {
								$model_aggragated_group->created_date = date ( 'Y-m-d H:i:s' );
								$model_aggragated_group->created_by = $logged_user_id;
							} else {
								$model_aggragated_group->modified_date = date ( 'Y-m-d H:i:s' );
								$model_aggragated_group->modified_by = $logged_user_id;
							}
							
							// begin transaction
							$transaction = \Yii::$app->db->beginTransaction ();
							
							try {
								
								if ($model_aggragated_group->save () && $model_aggragated_group->validate ()) {
									
									$aggregated_grp_id = $model_aggragated_group->aggregated_grp_id;
									
									if ($model_aggragated_group_list->load ( \Yii::$app->request->post () )) {
										$group_list = \Yii::$app->request->post ();
										$group_list_array = $group_list ['TblAcaAggregatedGroupList'];
										
										if (! empty ( $aggregated_list )) {
											
											TblAcaAggregatedGroupList::deleteAll ( [ 
													'aggregated_grp_id' => $aggregated_grp_id 
											] );
										}
										
										foreach ( $group_list_array as $list ) {
											
											if (! empty ( $list ['group_name'] ) || ! empty ( $list ['group_ein'] )) {
												$model_aggragated_group_list->aggregated_grp_id = $aggregated_grp_id;
												$model_aggragated_group_list->group_name = $list ['group_name'];
												$model_aggragated_group_list->group_ein = $list ['group_ein'];
												$model_aggragated_group_list->created_by = $logged_user_id;
												$model_aggragated_group_list->created_date = date ( 'Y-m-d H:i:s' );
												$model_aggragated_group_list->aggregated_ein_list_id = NULL;
												$model_aggragated_group_list->isNewRecord = TRUE;
												$model_aggragated_group_list->save ();
											}
										}
									}
									
									// validate general plan info
									$validate_results = $common_validation_component->Validateaggreagate ( $company_id, $element_ids );

									$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();
									
									if(!empty($model_company_validation_log))		{
										$model_company_validation_log->created_by = $logged_user_id;
										$model_company_validation_log->modified_by = $logged_user_id;
										$model_company_validation_log->basic_info_date = date('Y-m-d H:i:s');
									
										$model_company_validation_log->save();
									}
									if (! empty ( $validate_results ['error'] )) {
										
										throw new \Exception ( $validate_results ['error'] );
									} else {
										
										$validation_success = $validate_results ['success'];
										
										if (! in_array ( 0, $validation_success, TRUE )) {
											
											TblAcaValidationLog::deleteAll ( [ 
													'and',
													'company_id  = :company_id',
													[ 
															'in',
															'validation_rule_id',
															$validation_rule_ids 
													] 
											], [ 
													':company_id' => $company_id 
											] );
											
											$update_validations = $this->Updategeneralvalidation ( $company_id, $validation_success );
											if (! empty ( $update_validations ['error'] )) {
												throw new \Exception ( $update_validations ['error'] );
											}
											
											$transaction->commit (); // commit the transaction
											
											\Yii::$app->session->setFlash ( 'success', 'Aggregated group saved successfully' );
											return $this->redirect ( array (
													'/client/validateforms?c_id=' . $encrypt_company_id 
											) );
										} else {
											foreach ( $validation_success as $key => $value ) {
												if ($value == 0) {
													$arrvalidation_errors [$key] ['error_message'] = $post_validation_errors [$key] ['error_message'];
													$arrvalidation_errors [$key] ['error_code'] = $post_validation_errors [$key] ['error_code'];
												} else {
													$arrvalidation_errors [$key] ['error_message'] = '';
													$arrvalidation_errors [$key] ['error_code'] = '';
												}
											}
										
											$transaction->rollBack ();
											// \Yii::$app->session->setFlash ( 'error', 'Error occurred while saving.' );
										}
									}
								} else {
									
									\Yii::$app->session->setFlash ( 'error', 'Error occurred while saving.' );
									
									return $this->redirect ( array (
											'/client/validateforms/saveaggregatedgroup?c_id=' . $encrypt_company_id 
									) );
								}
							} catch ( \Exception $e ) {
								
								$msg = $e->getMessage ();
								\Yii::$app->session->setFlash ( 'error', $msg );
								
								// rollback transaction
								$transaction->rollback ();
							}
						}
						
						return $this->render ( 'aggregatedgroup', array (
								'company_id' => $company_id,
								'encoded_company_id' => $_GET ['c_id'],
								'arrvalidations' => $arrvalidations,
								'arrvalidation_errors' => $arrvalidation_errors,
								'arrsection_elements' => $arrsection_elements,
								'model_aggregated_group_list' => $model_aggragated_group_list,
								'model_aggregated_group' => $model_aggragated_group,
								'aggregated_list' => $aggregated_list,
								'company_detals' => $company_detals,
								'company_validation' => $company_validation 
						) );
					} else {
						
						\Yii::$app->session->setFlash ( 'success', 'Aggregated group is already validated' );
						return $this->redirect ( array (
								'/client/validateforms/saveaggregatedgroup?c_id=' . $encrypt_company_id 
						) );
					}
				} else {
					return $this->redirect ( array (
							'/client/companies' 
					) );
				}
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
	}
	protected function Updategeneralvalidation($company_id, $validation_rule_ids) {
		$result = array ();
		$model_validation_log = new TblAcaValidationLog ();
		
		if (! empty ( $validation_rule_ids )) {
			
			try {
				
				$count = 0;
				$arrvalidation_count = count ( $validation_rule_ids );
				
				foreach ( $validation_rule_ids as $key => $value ) {
					
					$model_validation_log->company_id = $company_id;
					$model_validation_log->validation_rule_id = $key;
					$model_validation_log->modified_date = date ( 'Y-m-d' );
					$model_validation_log->is_validated = $value;
					$model_validation_log->isNewRecord = True;
					$model_validation_log->log_id = NULL;
					
					if ($model_validation_log->validate () && $model_validation_log->save ()) {
						
						$count ++;
					} else {
						$arrerrors = $model_validation_log->getFirstErrors ();
						$errorstring = '';
						/**
						 * *****Converting error into string*******
						 */
						foreach ( $arrerrors as $key => $value ) {
							$errorstring .= $value . '<br>';
						}
						
						throw new \Exception ( $errorstring );
					}
				}
				
				if ($arrvalidation_count == $count) {
					$result ['success'] = 'success';
				}
			} catch ( \Exception $e ) { // catching the exception
				
				$result ['error'] = $e->getMessage ();
				// rollback transaction
			}
		}
		
		return $result;
	}
	public function actionSavebasicinfo() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			/**
			 * Declaring Session Variables**
			 */
			$this->layout = 'main';
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			$encrypt_component = new EncryptDecryptComponent ();
			$common_validation_component = new CommonValidationsComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_element_master = new TblAcaElementMaster ();
			$model_basic_info = new TblAcaBasicInformation ();
			
			$get_company_id = \Yii::$app->request->get ();
			
			$client_id = '';
			$contact_phone_number = '';
			$emp_benefit_phone_number = '';
			$validation_rule_ids = array ();
			$update_validations = array ();
			$arrvalidations = array ();
			$arrsection_elements = array ();
			$validated_rule_ids = array ();
			$arrvalidation_errors = array ();
			$post_validation_errors = array ();
			
			if (! empty ( $get_company_id )) {
				/**
				 * Encrypted company ID*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
					$client_id = $check_company_details->client_id; // Company clien Id
				}
				
				// / get the company details
				$company_detals = TblAcaCompanies::find ()->select ( 'company_client_number,company_name' )->where ( 'company_id = :company_id', [ 
						'company_id' => $company_id 
				] )->one ();
				
				// checking if the validation starts for this company
				
				$company_validation = TblAcaCompanyValidationStatus::find ()->where ( [ 
						'company_id' => $company_id 
				] )->andWhere ( [ 
						'is_initialized' => 1 
				] )->andWhere ( [ 
						'is_completed' => 0 
				] )->One ();
				
				/**
				 * *Checking if company details exists for the company_id and company and client is present in session**
				 */
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$period_details = $model_companies->getcompanyperiod ( $company_id );
					$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
					
					$validation_rule_ids = [ 
							'1',
							'2',
							'3',
							'4',
							'5',
							'6',
							'7',
							'8',
							'9',
							'10',
							'11',
							'12',
							'13',
							'14',
							'15',
							'16',
							'17',
							'18',
							'19',
							'20',
							'21',
							'22',
							'23' 
					];
					
					$element_ids = [ 
							'1',
							'2',
							'4',
							'6',
							'8',
							'9',
							'10',
							'11',
							'15',
							'16',
							'17',
							'18' 
					];
					/**
					 * *Check for validation errors***
					 */
					$validation_results = TblAcaValidationLog::find ()->select ( 'validation_rule_id, is_validated' )->where ( [ 
							'company_id' => $company_id,
							'validation_rule_id' => $validation_rule_ids,
							'is_validated' => 0 
					] )->All ();
					
					if (! empty ( $validation_results )) {
						
						foreach ( $validation_results as $validations ) {
							
							$arrvalidations [] = $validations->validation_rule_id;
							$arrvalidation_errors [$validations->validation_rule_id] ['error_message'] = $validations->validationRule->error_message;
							$arrvalidation_errors [$validations->validation_rule_id] ['error_code'] = $validations->validationRule->error_code;
						}
						
						/**
						 * Get all errors for general info *
						 */
						$get_post_validation_errors = TblAcaValidationRules::find ()->select ( 'rule_id, error_code, error_message' )->where ( [ 
								'rule_id' => $validation_rule_ids 
						] )->All ();
						
						if (! empty ( $get_post_validation_errors )) {
							
							foreach ( $get_post_validation_errors as $errors ) {
								$post_validation_errors [$errors->rule_id] ['error_message'] = $errors->error_message;
								$post_validation_errors [$errors->rule_id] ['error_code'] = $errors->error_code;
							}
						}
						
						$section_ids = [ 
								'1' 
						];
						
						$all_elements = $model_element_master->FindallbysectionIds ( $section_ids );
						
						$arrsection_elements = ArrayHelper::map ( $all_elements, 'element_id', 'element_label' );
						
						$check_basic_info = $model_basic_info->FindbycompanyIdperiodId ( $company_id, $period_id );
						if (! empty ( $check_basic_info )) {
							$model_basic_info = $check_basic_info;
						}
						
						/**
						 * Check for any post of data*
						 */
						
						if ($model_basic_info->load ( \Yii::$app->request->post () )) {
							
							$postbasicinformation = \Yii::$app->request->post ( 'TblAcaBasicInformation' );
							$companyinformation = \Yii::$app->request->post ( 'TblAcaCompanies' );
							
							if (! empty ( $postbasicinformation ['contact_phone_number'] )) {
								$contact_phone_number = preg_replace ( '/[^A-Za-z0-9\']/', '', $postbasicinformation ['contact_phone_number'] ); // escape apostraphe
							}
							if (! empty ( $postbasicinformation ['emp_benefit_phone_number'] )) {
								$emp_benefit_phone_number = preg_replace ( '/[^A-Za-z0-9\']/', '', $postbasicinformation ['emp_benefit_phone_number'] ); // escape apostraphe
							}
							
							// begin transaction
							$transaction = \Yii::$app->db->beginTransaction ();
							
							try {
								$model_basic_info->attributes = $postbasicinformation;
								$model_basic_info->company_id = $company_id;
								$model_basic_info->period_id = $period_id;
								$model_basic_info->contact_phone_number = $contact_phone_number;
								$model_basic_info->emp_benefit_phone_number = $emp_benefit_phone_number;
								
								if ($model_basic_info->isNewRecord) {
									$model_basic_info->created_date = date ( 'Y-m-d H:i:s' );
									$model_basic_info->created_by = $logged_user_id;
								} else {
									$model_basic_info->modified_date = date ( 'Y-m-d H:i:s' );
									$model_basic_info->modified_by = $logged_user_id;
								}
								
								$check_company_details->attributes = $companyinformation;
								
								if ($check_company_details->save () && $check_company_details->validate ()) {
									
									if ($model_basic_info->save () && $model_basic_info->validate ()) {

										$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();
										
										if(!empty($model_company_validation_log))		{
											$model_company_validation_log->created_by = $logged_user_id;
											$model_company_validation_log->modified_by = $logged_user_id;
											$model_company_validation_log->basic_info_date = date('Y-m-d H:i:s');
										
											$model_company_validation_log->save();
										}
										
										
										// validate general plan info
										$validate_results = $common_validation_component->Validatebasicinfo ( $company_id, $element_ids );
										
										if (! empty ( $validate_results ['error'] )) {
											throw new \Exception ( $validate_results ['error'] );
										} else {
											$validation_success = $validate_results ['success'];
											
											if (! in_array ( 0, $validation_success, TRUE )) {
												
												TblAcaValidationLog::deleteAll ( [ 
														'and',
														'company_id  = :company_id',
														[ 
																'in',
																'validation_rule_id',
																$validation_rule_ids 
														] 
												], [ 
														':company_id' => $company_id 
												] );
												
												$update_validations = $this->Updategeneralvalidation ( $company_id, $validation_success );
												if (! empty ( $update_validations ['error'] )) {
													throw new \Exception ( $update_validations ['error'] );
												}
												
												$transaction->commit (); // commit the transaction
												
												\Yii::$app->session->setFlash ( 'success', 'Basic info saved successfully' );
												return $this->redirect ( array (
														'/client/validateforms?c_id=' . $encrypt_company_id 
												) );
											} else {
												foreach ( $validation_success as $key => $value ) {
													if ($value == 0) {
														$arrvalidation_errors [$key] ['error_message'] = $post_validation_errors [$key] ['error_message'];
														$arrvalidation_errors [$key] ['error_code'] = $post_validation_errors [$key] ['error_code'];
													} else {
														$arrvalidation_errors [$key] ['error_message'] = '';
														$arrvalidation_errors [$key] ['error_code'] = '';
													}
												}
												
												$transaction->rollBack ();
											}
										}
									} else {
										$arrerrors = $model_basic_info->getFirstErrors ();
										$errorstring = '';
										/**
										 * *****Converting error into string*******
										 */
										foreach ( $arrerrors as $key => $value ) {
											$errorstring .= $value . '<br>';
										}
										
										throw new \Exception ( $errorstring );
									}
								} else {
									$arrerrors = $check_company_details->getFirstErrors ();
									$errorstring = '';
									/**
									 * *****Converting error into string*******
									 */
									foreach ( $arrerrors as $key => $value ) {
										$errorstring .= $value . '<br>';
									}
									
									throw new \Exception ( $errorstring );
								}
							} catch ( \Exception $e ) {
								
								$msg = $e->getMessage ();
								\Yii::$app->session->setFlash ( 'error', $msg );
								// rollback transaction
								$transaction->rollback ();
								/**
								 * Redirect to Index (Company dashboard)*
								 */
								return $this->redirect ( array (
										'/client/validateforms/savebasicinfo?c_id=' . $encrypt_company_id 
								) );
							}
						}
						return $this->render ( 'basicinfo', array (
								'company_id' => $company_id,
								'encoded_company_id' => $_GET ['c_id'],
								'arrvalidations' => $arrvalidations,
								'arrvalidation_errors' => $arrvalidation_errors,
								'arrsection_elements' => $arrsection_elements,
								'model_basic_info' => $model_basic_info,
								'company_details' => $check_company_details,
								'c_details' => $company_detals,
								'company_validation' => $company_validation 
						) );
					} else {
						
						\Yii::$app->session->setFlash ( 'success', 'Basic Information already validated' );
						return $this->redirect ( array (
								'/client/validateforms/savebasicinfo?c_id=' . $encrypt_company_id 
						) );
					}
				} else {
					return $this->redirect ( array (
							'/client/companies' 
					) );
				}
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
	}
	public function actionDesignatedgovtentity() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			/**
			 * Declaring Session Variables**
			 */
			$this->layout = 'main';
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			$encrypt_component = new EncryptDecryptComponent ();
			$common_validation_component = new CommonValidationsComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_element_master = new TblAcaElementMaster ();
			$model_designated_govt_entity = new TblAcaDesignatedGovtEntity ();
			
			$get_company_id = \Yii::$app->request->get ();
			
			$client_id = '';
			$plan_offering_criteria_type = '';
			$dge_reporting = '';
			$dge_contact_phone_number = '';
			$validation_rule_ids = array ();
			$update_validations = array ();
			$arrvalidations = array ();
			$arrsection_elements = array ();
			$validated_rule_ids = array ();
			$arrvalidation_errors = array ();
			$post_validation_errors = array ();
			
			if (! empty ( $get_company_id )) {
				/**
				 * Encrypted company ID*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
					$client_id = $check_company_details->client_id; // Company clien Id
					                                                
					// / get the company details
					$company_detals = TblAcaCompanies::find ()->select ( 'company_client_number,company_name' )->where ( 'company_id = :company_id', [ 
							'company_id' => $company_id 
					] )->one ();
					
					// checking if the validation starts for this company
					
					$company_validation = TblAcaCompanyValidationStatus::find ()->where ( [ 
							'company_id' => $company_id 
					] )->andWhere ( [ 
							'is_initialized' => 1 
					] )->andWhere ( [ 
							'is_completed' => 0 
					] )->One ();
				}
				
				/**
				 * *Checking if company details exists for the company_id and company and client is present in session**
				 */
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$period_details = $model_companies->getcompanyperiod ( $company_id );
					$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
					
					$validation_rule_ids = [ 
							'31',
							'32',
							'33',
							'34',
							'35',
							'36',
							'37',
							'38',
							'39',
							'40',
							'41',
							'42',
							'43',
							'44',
							'45',
							'46',
							'47',
							'48',
							'143',
							'144',
							'145' 
					];
					
					$element_ids = [ 
							'42',
							'43',
							'44',
							'45',
							'47',
							'48',
							'49',
							'50',
							'52',
							'54',
							'55' 
					];
					/**
					 * *Check for validation errors***
					 */
					$validation_results = TblAcaValidationLog::find ()->select ( 'validation_rule_id, is_validated' )->where ( [ 
							'company_id' => $company_id,
							'validation_rule_id' => $validation_rule_ids,
							'is_validated' => 0 
					] )->All ();
					
					if (! empty ( $validation_results )) {
						
						foreach ( $validation_results as $validations ) {
							
							$arrvalidations [] = $validations->validation_rule_id;
							$arrvalidation_errors [$validations->validation_rule_id] ['error_message'] = $validations->validationRule->error_message;
							$arrvalidation_errors [$validations->validation_rule_id] ['error_code'] = $validations->validationRule->error_code;
						}
						
						/**
						 * Get all errors for general info *
						 */
						$get_post_validation_errors = TblAcaValidationRules::find ()->select ( 'rule_id, error_code, error_message' )->where ( [ 
								'rule_id' => $validation_rule_ids 
						] )->All ();
						
						if (! empty ( $get_post_validation_errors )) {
							
							foreach ( $get_post_validation_errors as $errors ) {
								$post_validation_errors [$errors->rule_id] ['error_message'] = $errors->error_message;
								$post_validation_errors [$errors->rule_id] ['error_code'] = $errors->error_code;
							}
						}
						
						$section_ids = [ 
								'4' 
						];
						
						$all_elements = $model_element_master->FindallbysectionIds ( $section_ids );
						
						$arrsection_elements = ArrayHelper::map ( $all_elements, 'element_id', 'element_label' );
						
						/**
						 * ********Check Designated Government Entity***************
						 */
						$check_designated_govt_entity = $model_designated_govt_entity->FindbycompanyIdperiodId ( $company_id, $period_id );
						if (! empty ( $check_designated_govt_entity )) {
							$model_designated_govt_entity = $check_designated_govt_entity;
						}
						
						/**
						 * Check for any post of data*
						 */
						if ($model_designated_govt_entity->load ( \Yii::$app->request->post () )) {
							
							$postdesignated = \Yii::$app->request->post ( 'TblAcaDesignatedGovtEntity' );
							if (! empty ( $postdesignated ['dge_reporting'] )) {
								
								$dge_reporting = $postdesignated ['dge_reporting'];
							}
							
							if (! empty ( $postdesignated ['dge_contact_phone_number'] )) {
								$dge_contact_phone_number = preg_replace ( '/[^A-Za-z0-9\']/', '', $postdesignated ['dge_contact_phone_number'] ); // escape apostraphe
							}
							
							// begin transaction
							$transaction = \Yii::$app->db->beginTransaction ();
							
							try {
								$model_designated_govt_entity->attributes = $postdesignated;
								$model_designated_govt_entity->company_id = $company_id;
								$model_designated_govt_entity->period_id = $period_id;
								$model_designated_govt_entity->dge_reporting = $dge_reporting;
								$model_designated_govt_entity->dge_contact_phone_number = $dge_contact_phone_number;
								
								if ($model_designated_govt_entity->isNewRecord) {
									$model_designated_govt_entity->created_date = date ( 'Y-m-d H:i:s' );
									$model_designated_govt_entity->created_by = $logged_user_id;
								} else {
									$model_designated_govt_entity->modified_date = date ( 'Y-m-d H:i:s' );
									$model_designated_govt_entity->modified_by = $logged_user_id;
								}
								
								if ($model_designated_govt_entity->save () && $model_designated_govt_entity->validate ()) {
									
									// validate dge
									$validate_results = $common_validation_component->Validatedge ( $company_id, $element_ids );
									
									$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();
									
									if(!empty($model_company_validation_log))		{
										$model_company_validation_log->created_by = $logged_user_id;
										$model_company_validation_log->modified_by = $logged_user_id;
										$model_company_validation_log->basic_info_date = date('Y-m-d H:i:s');
									
										$model_company_validation_log->save();
									}
									
									if (! empty ( $validate_results ['error'] )) {
										throw new \Exception ( $validate_results ['error'] );
									} else {
										$validation_success = $validate_results ['success'];
										
										if (! in_array ( 0, $validation_success, TRUE )) {
											
											TblAcaValidationLog::deleteAll ( [ 
													'and',
													'company_id  = :company_id',
													[ 
															'in',
															'validation_rule_id',
															$validation_rule_ids 
													] 
											], [ 
													':company_id' => $company_id 
											] );
											
											$update_validations = $this->Updategeneralvalidation ( $company_id, $validation_success );
											if (! empty ( $update_validations ['error'] )) {
												throw new \Exception ( $update_validations ['error'] );
											}
											
											$transaction->commit (); // commit the transaction
											
											\Yii::$app->session->setFlash ( 'success', 'Designated Govt Entity saved successfully' );
											return $this->redirect ( array (
													'/client/validateforms?c_id=' . $encrypt_company_id 
											) );
										} else {
											$arrvalidation_errors = array ();
											foreach ( $validation_success as $key => $value ) {
												if ($value == 0) {
													$arrvalidation_errors [$key] ['error_message'] = $post_validation_errors [$key] ['error_message'];
													$arrvalidation_errors [$key] ['error_code'] = $post_validation_errors [$key] ['error_code'];
												}
											}
											
											$transaction->rollBack ();
										}
									}
								} else {
									$arrerrors = $model_designated_govt_entity->getFirstErrors ();
									$errorstring = '';
									
									foreach ( $arrerrors as $key => $value ) {
										$errorstring .= $value . '<br>';
									}
									
									throw new \Exception ( $errorstring );
								}
							} catch ( \Exception $e ) {
								
								$msg = $e->getMessage ();
								\Yii::$app->session->setFlash ( 'error', $msg );
								// rollback transaction
								$transaction->rollback ();
								/**
								 * Redirect to Index (Company dashboard)*
								 */
								return $this->redirect ( array (
										'/client/validateforms/designatedgovtentity?c_id=' . $encrypt_company_id 
								) );
							}
						}
						
						return $this->render ( 'designatedgovtentity', array (
								'company_id' => $company_id,
								'encoded_company_id' => $_GET ['c_id'],
								'arrvalidations' => $arrvalidations,
								'arrvalidation_errors' => $arrvalidation_errors,
								'arrsection_elements' => $arrsection_elements,
								'model_designated_govt_entity' => $model_designated_govt_entity,
								'company_details' => $check_company_details,
								'c_detals' => $company_detals,
								'company_validation' => $company_validation 
						) );
					} else {
						
						\Yii::$app->session->setFlash ( 'success', 'Basic Information already validated' );
						return $this->redirect ( array (
								'/client/validateforms/designatedgovtentity?c_id=' . $encrypt_company_id 
						) );
					}
				} else {
					return $this->redirect ( array (
							'/client/companies' 
					) );
				}
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
	}
	public function actionErrors() {
		return $this->render ( 'errors' );
	}
	
	/**
	 * ********* function to update plan classes validation issues ********
	 */
	public function actionPlanclassesvalidation() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
		/**
		 * Declaring Session Variables**
		 */
		$this->layout = 'main';
		$session = \Yii::$app->session;
		$logged_user_id = $session ['client_user_id'];
		$arr_offer_types = array ();
		$validation_rule_ids = array ();
		$update_validations = array ();
		$arrvalidations = array ();
		$arrsection_elements = array ();
		$validated_rule_ids = array ();
		$arrvalidation_errors = array ();
		$post_validation_errors = array ();
		$old_plan_type = '';
		
		$encrypt_component = new EncryptDecryptComponent ();
		$common_validation_component = new CommonValidationsComponent ();
		$model_element_master = new TblAcaElementMaster ();
		$model_plan_coverage_type = new TblAcaPlanCoverageType ();
		$model_plan_offer_type_years = new TblAcaPlanOfferTypeYears ();
		$model_plan_coverage_type_offered = new TblAcaPlanCoverageTypeOffered ();
		$model_plan_emp_contributions = new TblAcaEmpContributions ();
		$model_plan_emp_contributions_premium = new TblAcaEmpContributionsPremium ();
		
		$get_company_id = \Yii::$app->request->get ();
		
		if (! empty ( $get_company_id )) {
			
			
			/**
			 * Encrypted company ID*
			 */
			$encrypt_company_id = $get_company_id ['c_id'];
			$encrypt_plan_class_id = $get_company_id ['plan_class_id'];
			
			if (! empty ( $encrypt_company_id ) && ! empty ( $encrypt_plan_class_id )) {
				$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
				$plan_class_id = $encrypt_component->decryptUser ( $encrypt_plan_class_id ); // Decrypted plan class Id
				                                                                             
				// getting company details
				$company_details = TblAcaCompanies::find ()->select ( 'company_client_number,company_name' )->where ( 'company_id = :company_id', [ 
						'company_id' => $company_id 
				] )->one ();
				
				// checking if the validation starts for this company
				
				$company_validation = TblAcaCompanyValidationStatus::find ()->where ( [ 
						'company_id' => $company_id 
				] )->andWhere ( [ 
						'is_initialized' => 1 
				] )->andWhere ( [ 
						'is_completed' => 0 
				] )->One ();
				
				// / getting plan class name
				
				$plan_class_details = TblAcaPlanCoverageType::find ()->where ( [ 
						'plan_class_id' => $plan_class_id 
				] )->One ();
				// / getting data from plan class validation log
				if (! empty ( $plan_class_details )) {
					
					$validation_rule_ids = [ 
							'63',
							'64',
							'65',
							'66',
							'67',
							'68',
							'69',
							'70',
							'71',
							'72',
							'73',
							'74',
							'148'
					];
					
					$element_ids = [ 
							'76',
							'77',
							'78',
							'79',
							'80',
							'81',
							'82',
							'83',
							'84',
							'85',
							'86',
							'87' 
					];
					
					/**
					 * *Check for validation errors***
					 */
					$validation_results = TblAcaPlanClassValidationLog::find ()->select ( 'validation_rule_id, is_validated' )->where ( [ 
							'company_id' => $company_id,
							'validation_rule_id' => $validation_rule_ids,
							'is_validated' => 0 
					] )->All ();
					
					if (! empty ( $validation_results )) {
						
						foreach ( $validation_results as $validations ) {
							
							$arrvalidations [] = $validations->validation_rule_id;
							$arrvalidation_errors [$validations->validation_rule_id] ['error_message'] = $validations->validationRule->error_message;
							$arrvalidation_errors [$validations->validation_rule_id] ['error_code'] = $validations->validationRule->error_code;
						}
						
						/**
						 * Get all errors for general info *
						 */
						$get_post_validation_errors = TblAcaValidationRules::find ()->select ( 'rule_id, error_code, error_message' )->where ( [ 
								'rule_id' => $validation_rule_ids 
						] )->All ();
						
						if (! empty ( $get_post_validation_errors )) {
							
							foreach ( $get_post_validation_errors as $errors ) {
								$post_validation_errors [$errors->rule_id] ['error_message'] = $errors->error_message;
								$post_validation_errors [$errors->rule_id] ['error_code'] = $errors->error_code;
							}
						}
						
						/**
						 * *************get section elements*********************
						 */
						$section_ids = [ 
								'9',
								'10',
								'11' 
						];
						$all_elements = $model_element_master->FindallbysectionIds ( $section_ids );
						
						$arrsection_elements = ArrayHelper::map ( $all_elements, 'element_id', 'element_label' );
						
						/**
						 * ****************Get plan offer type years**************************
						 */
						
						$all_offer_types = $model_plan_offer_type_years->FindbyplanclassId ( $plan_class_id );
						if (! empty ( $all_offer_types )) {
							$arr_offer_types = ArrayHelper::map ( $all_offer_types, 'plan_year', 'plan_year_value', 'plan_year_type' );
						}
						
						$model_plan_coverage_type = $plan_class_details;
						$old_plan_type = $model_plan_coverage_type->plan_offer_type;
						/**
						 * *Get plan class coverage type*
						 */
						$plan_coverage_type_offered = $model_plan_coverage_type_offered->FindplanbyId ( $plan_class_id );
						
						if (! empty ( $plan_coverage_type_offered )) {
							$model_plan_coverage_type_offered = $plan_coverage_type_offered;
							
							/**
							 * Get Emp contribution*
							 */
							$emp_contribution_details = $model_plan_emp_contributions->FindbycoveragetypeId ( $plan_coverage_type_offered->coverage_type_id );
							if (! empty ( $emp_contribution_details )) {
								$model_plan_emp_contributions = $emp_contribution_details;
								
								/**
								 * Get Emp contribution premium*
								 */
								$emp_contribution_premium_details = $model_plan_emp_contributions_premium->FindbyempcontributionId ( $emp_contribution_details->emp_contribution_id );
								
								if (! empty ( $emp_contribution_premium_details )) {
									$model_plan_emp_contributions_premium = $emp_contribution_premium_details;
								}
							}
						}
						
						$plan_class_post_details = \Yii::$app->request->post ();
						if (! empty ( $plan_class_post_details )) {
							
							// begin transaction
							$transaction = \Yii::$app->db->beginTransaction ();
							try {
								
								if (! empty ( $plan_class_post_details ['TblAcaPlanCoverageType'] )) {
									$plan_coverage_type = $this->PlanCoverageType ( $company_id, $plan_class_id, $plan_class_post_details );
									
									if (! empty ( $plan_coverage_type ['success'] ) && ! empty ( $plan_coverage_type ['plan_class_id'] )) {
										
										$model_plan_coverage_type = TblAcaPlanCoverageType::find ()->where ( [ 
												'plan_class_id' => $plan_class_id 
										] )->One ();
										/**
										 * ****************Get plan offer type years**************************
										 */
										
										$all_offer_types = $model_plan_offer_type_years->FindbyplanclassId ( $plan_class_id );
										if (! empty ( $all_offer_types )) {
											$arr_offer_types = ArrayHelper::map ( $all_offer_types, 'plan_year', 'plan_year_value', 'plan_year_type' );
										}
									}
								}
								
								if (! empty ( $plan_class_post_details ['TblAcaPlanCoverageType'] )) {
									$plantype = $plan_class_post_details ['TblAcaPlanCoverageType']['plantype'];
									$plan_coverage_type_offered_result = $this->Coveragetypeoffered ( $company_id, $plan_class_id, $plan_class_post_details );
									
									if (! empty ( $plan_coverage_type_offered_result ['success'] ) && ! empty ( $plan_coverage_type_offered_result ['coverage_type_id'] )) {
										
										$post_coverage_type_id = $plan_coverage_type_offered_result ['coverage_type_id'];
										/**
										 * *Get plan class coverage type*
										 */
										$model_plan_coverage_type_offered = $model_plan_coverage_type_offered->FindplanbyId ( $plan_class_id );
										
										if (! empty ( $plan_class_post_details ['TblAcaEmpContributions'] )) {
											
											$plan_emp_contribution_result = $this->Empcontribution ( $company_id, $plan_class_id, $plan_class_post_details );
											
											if (! empty ( $plan_emp_contribution_result ['success'] ) && ! empty ( $plan_emp_contribution_result ['emp_contribution_id'] )) {
												
												$post_emp_contribution_id = $plan_emp_contribution_result ['emp_contribution_id'];
												
												/**
												 * *Get plan class coverage type*
												 */
												$model_plan_emp_contributions = TblAcaEmpContributions::find ()->where ( [ 
														'emp_contribution_id' => $post_emp_contribution_id 
												] )->One ();
											}
										}
									}
								}
								
								// validate general plan info
								$validate_results = $common_validation_component->ValidateindividualPlanclass ( $company_id, $plan_class_id, $element_ids );
								
								if (! empty ( $validate_results ['error'] )) {
									throw new \Exception ( $validate_results ['error'] );
								} else {
									$validation_success = $validate_results ['success'];
									
									if (! in_array ( 0, $validation_success, TRUE )) {
										
										TblAcaPlanClassValidationLog::deleteAll ( [ 
												'and',
												'company_id  = :company_id',
												'plan_class_id  = :plan_class_id',
												[ 
														'in',
														'validation_rule_id',
														$validation_rule_ids 
												] 
										], [ 
												':company_id' => $company_id,
												':plan_class_id' => $plan_class_id 
										] );
										
										
										
										
										

                                   
										if($plantype != $old_plan_type )
										{
											$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();		
											$model_company_validation_log->is_medical_data = 0;
											$model_company_validation_log->is_initialized = 0;
											$model_company_validation_log->is_executed = 0;		
											$model_company_validation_log->save();
											
											TblAcaMedicalValidationLog::deleteAll ( 'company_id = :company_id', [ 
												':company_id' => $company_id
													
											] );
											
											TblAcaMedicalEnrollmentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
													':company_id' => $company_id
																				
											] );
											
											if($plantype == 1)
											{
												
											TblAcaValidationLog::deleteAll ( [ 
																'and',
																'company_id  = :company_id',
																[ 
																		'in',
																		'validation_rule_id',
																		142 
																] 
														], [ 
																':company_id' => $company_id 
														] );
														
											$model_validation_log_m = 	new TblAcaValidationLog();
											$model_validation_log_m->company_id = $company_id;
											$model_validation_log_m->validation_rule_id = 142;
											$model_validation_log_m->modified_date = date ( 'Y-m-d H:i:s' );
											$model_validation_log_m->is_validated = 1;
											$model_validation_log_m->save();
									
								
											}
										}
										$transaction->commit (); // commit the transaction
										
										\Yii::$app->session->setFlash ( 'success', 'Plan Class saved successfully' );
										return $this->redirect ( array (
												'/client/validateforms?c_id=' . $encrypt_company_id 
										) );
									} else {
										foreach ( $validation_success as $key => $value ) {
											if ($value == 0) {
												$arrvalidation_errors [$key] ['error_message'] = $post_validation_errors [$key] ['error_message'];
												$arrvalidation_errors [$key] ['error_code'] = $post_validation_errors [$key] ['error_code'];
											} else {
												$arrvalidation_errors [$key] ['error_message'] = '';
												$arrvalidation_errors [$key] ['error_code'] = '';
											}
										}
										
										$transaction->rollBack ();
									}
								}
							} catch ( \Exception $e ) {
								
								$msg = $e->getMessage ();
								$result ['error'] = $msg;
								
								$transaction->rollBack ();
								\Yii::$app->session->setFlash ( 'error', $msg );
								return $this->redirect ( array (
										'/client/validateforms/planclassesvalidation?c_id=' . $encrypt_company_id.'&plan_class_id='.$encrypt_plan_class_id 
								) );
							}
						}
						
						return $this->render ( 'planclassesvalidation', array (
								'company_detals' => $company_details,
								'plan_class_details' => $plan_class_details,
								'model_plan_coverage_type' => $model_plan_coverage_type,
								'model_plan_offer_type_years' => $model_plan_offer_type_years,
								'model_plan_coverage_type_offered' => $model_plan_coverage_type_offered,
								'model_plan_emp_contributions' => $model_plan_emp_contributions,
								'model_plan_emp_contributions_premium' => $model_plan_emp_contributions_premium,
								'arrsection_elements' => $arrsection_elements,
								'arr_offer_types' => $arr_offer_types,
								'arrvalidations' => $arrvalidations,
								'arrvalidation_errors' => $arrvalidation_errors,
								'encoded_company_id' => $_GET ['c_id'],
								'encrypt_plan_class_id' => $encrypt_plan_class_id,
								'company_validation' => $company_validation 
						) );
					} else {
						
						\Yii::$app->session->setFlash ( 'success', 'Plan Class already validated' );
						return $this->redirect ( array (
								'/client/validateforms?c_id=' . $encrypt_company_id 
						) );
					}
				}
			} else {
				return $this->redirect ( array (
						'/client/companies' 
				) );
			}
		}
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
	}
	
	/**
	 * *Action is used to add or update plan coverage type**
	 */
	protected function PlanCoverageType($company_id, $plan_id, $plan_coverage_type_details) {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			// declaring models
			$model_plan_coverage_type = new TblAcaPlanCoverageType ();
			$model_plan_offer_years = new TblAcaPlanOfferTypeYears ();
			
			// declaring variables
			$Planoffertypeyears = array ();
			$result = array ();
			
			$planname = '';
			$plantype = '';
			$employeemedicalplan = '';
			$doh = '';
			$period_id = '';
			$redirect_action = '';
			
			/**
			 * Declaring session variables***
			 */
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			
			if (! empty ( $plan_coverage_type_details )) {
				
				$plan_details = $model_plan_coverage_type->FindplanbyId ( $plan_id, $company_id );
				
				if (! empty ( $plan_details )) {
					$model_plan_coverage_type = $plan_details;
				}
				
				/**
				 * Assigning post data to variables*
				 */
				if (! empty ( $plan_coverage_type_details ['TblAcaPlanCoverageType'] ['plan_class_name'] )) {
					$planname = $plan_coverage_type_details ['TblAcaPlanCoverageType'] ['plan_class_name'];
				}
				
				if (! empty ( $plan_coverage_type_details ['TblAcaPlanCoverageType'] ['plantype'] )) {
					$plantype = $plan_coverage_type_details ['TblAcaPlanCoverageType'] ['plantype'];
				}
				
				if (! empty ( $plan_coverage_type_details ['TblAcaPlanCoverageType'] ['employeemedicalplan'] )) {
					$employeemedicalplan = $plan_coverage_type_details ['TblAcaPlanCoverageType'] ['employeemedicalplan'];
				}
				
				if (! empty ( $plan_coverage_type_details ['TblAcaPlanCoverageType'] ['doh'] )) {
					$doh = $plan_coverage_type_details ['TblAcaPlanCoverageType'] ['doh'];
				}
				
				$Planoffertypeyears = $plan_coverage_type_details ['Planoffertypeyears'];
				
				if (! empty ( $planname )) {
					$model_plan_coverage_type->plan_class_name = $planname;
				}
				
				if (! empty ( $plantype )) {
					$model_plan_coverage_type->plan_offer_type = $plantype;
				}
				
				
				$model_plan_coverage_type->plan_type_doh = $doh;
				
				
				
				$model_plan_coverage_type->employee_medical_plan = $employeemedicalplan;
				
				
				$model_plan_coverage_type->modified_date = date ( 'Y-m-d H:i:s' );
				$model_plan_coverage_type->modified_by = $logged_user_id;
				
				try {
					
					if ($model_plan_coverage_type->update () && $model_plan_coverage_type->validate ()) {
						$plan_class_id = $model_plan_coverage_type->plan_class_id;
						
						if (! empty ( $Planoffertypeyears )) {
							
							$model_plan_offer_years = new TblAcaPlanOfferTypeYears ();
							
							$check_all_offertype_years = $model_plan_offer_years->FindbyplanclassId ( $plan_class_id );
							if (! empty ( $check_all_offertype_years )) {
								TblAcaPlanOfferTypeYears::deleteAll ( [ 
										'plan_class_id' => $plan_class_id 
								] );
							}
							
							foreach ( $Planoffertypeyears as $type => $years ) {
								
								foreach ( $years as $key => $value ) {
									
									$model_plan_offer_years->plan_class_id = $plan_class_id;
									$model_plan_offer_years->plan_year_type = $type;
									$model_plan_offer_years->plan_year = $key;
									$model_plan_offer_years->plan_year_value = $value;
									
									$model_plan_offer_years->created_date = date ( 'Y-m-d H:i:s' );
									$model_plan_offer_years->created_by = $logged_user_id;
									
									$model_plan_offer_years->modified_date = date ( 'Y-m-d H:i:s' );
									$model_plan_offer_years->modified_by = $logged_user_id;
									$model_plan_offer_years->isNewRecord = true;
									$model_plan_offer_years->plan_years_id = null;
									
									if ($model_plan_offer_years->save () && $model_plan_offer_years->validate ()) {
										$result ['success'] = 'success';
									} else {
										
										$arrerrors = $model_plan_offer_years->getFirstErrors ();
										$errorstring = '';
										/**
										 * *****Converting error into string*******
										 */
										foreach ( $arrerrors as $key => $value ) {
											$errorstring .= $value . '<br>';
										}
										
										throw new \Exception ( $errorstring );
									}
								}
							}
						}
						$result ['success'] = 'success';
						$result ['plan_class_id'] = $model_plan_coverage_type->plan_class_id;
					} else {
						$arrerrors = $model_plan_coverage_type->getFirstErrors ();
						$errorstring = '';
						/**
						 * *****Converting error into string*******
						 */
						foreach ( $arrerrors as $key => $value ) {
							$errorstring .= $value . '<br>';
						}
						
						throw new \Exception ( $errorstring );
					}
				} catch ( \Exception $e ) {
					
					$result ['error'] = $e->getMessage ();
				}
				
				return $result;
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	protected function Coveragetypeoffered($company_id, $plan_id, $coverage_offer_type_post) {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			$model_plan_coverage_type = new TblAcaPlanCoverageType ();
			$model_plan_offer_type_years = new TblAcaPlanOfferTypeYears ();
			$model_plan_coverage_type_offered = new TblAcaPlanCoverageTypeOffered ();
			
			$result = array ();
			$mv_coverage_months_array = array ();
			$essential_coverage_months_array = array ();
			$employee_mv_coverage = '';
			$mv_coverage_months = '';
			$employee_essential_coverage = '';
			$essential_coverage_months = '';
			$spouse_essential_coverage = '';
			$spouse_conditional_coverage = '';
			$dependent_essential_coverage = '';
			
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			
			if (! empty ( $company_id ) && $plan_id) {
				
				/**
				 * Get plan class
				 */
				$plan_details = $model_plan_coverage_type->FindplanbyId ( $plan_id, $company_id );
				
				/**
				 * *Get plan class coverage type*
				 */
				$plan_coverage_type_offered = $model_plan_coverage_type_offered->FindplanbyId ( $plan_id );
				if (! empty ( $plan_details )) {
					
					if (! empty ( $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] )) {
						
						if (! empty ( $plan_coverage_type_offered )) {
							$model_plan_coverage_type_offered = $plan_coverage_type_offered;
						}
						
						/**
						 * assigning post variables*
						 */
						if (! empty ( $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['employee_mv_coverage'] )) {
							$employee_mv_coverage = $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['employee_mv_coverage'];
						}
						
						if (! empty ( $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['mv_coverage_months'] )) {
							$mv_coverage_months_array = $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['mv_coverage_months'];
							
							if ($mv_coverage_months_array) {
								foreach ( $mv_coverage_months_array as $key => $value ) {
									$mv_coverage_months .= $value . ',';
								}
							}
						}
						
						if (! empty ( $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['employee_essential_coverage'] )) {
							$employee_essential_coverage = $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['employee_essential_coverage'];
						}
						
						if (! empty ( $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['essential_coverage_months'] )) {
							$essential_coverage_months_array = $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['essential_coverage_months'];
							
							if ($essential_coverage_months_array) {
								foreach ( $essential_coverage_months_array as $key => $value ) {
									$essential_coverage_months .= $value . ',';
								}
							}
						}
						
						if (! empty ( $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['spouse_essential_coverage'] )) {
							$spouse_essential_coverage = $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['spouse_essential_coverage'];
						}
						if (! empty ( $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['spouse_conditional_coverage'] )) {
							$spouse_conditional_coverage = $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['spouse_conditional_coverage'];
						}
						if (! empty ( $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['dependent_essential_coverage'] )) {
							$dependent_essential_coverage = $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['dependent_essential_coverage'];
						}
						// ***Assigning variables in model***//
						$model_plan_coverage_type_offered->plan_class_id = $plan_id;
						
						if (! empty ( $employee_mv_coverage )) {
							$model_plan_coverage_type_offered->employee_mv_coverage = $employee_mv_coverage;
						}
						
						if (! empty ( $mv_coverage_months )) {
							$model_plan_coverage_type_offered->mv_coverage_months = $mv_coverage_months;
						}
						
						if (! empty ( $employee_essential_coverage )) {
							$model_plan_coverage_type_offered->employee_essential_coverage = $employee_essential_coverage;
						}
						
						if (! empty ( $essential_coverage_months )) {
							$model_plan_coverage_type_offered->essential_coverage_months = $essential_coverage_months;
						}
						
						if (! empty ( $spouse_essential_coverage )) {
							$model_plan_coverage_type_offered->spouse_essential_coverage = $spouse_essential_coverage;
						}
						
						if (! empty ( $spouse_conditional_coverage )) {
							$model_plan_coverage_type_offered->spouse_conditional_coverage = $spouse_conditional_coverage;
						}
						
						if (! empty ( $dependent_essential_coverage )) {
							$model_plan_coverage_type_offered->dependent_essential_coverage = $dependent_essential_coverage;
						}
						
						if ($model_plan_coverage_type_offered->isNewRecord) {
							$model_plan_coverage_type_offered->created_date = date ( 'Y-m-d H:i:s' );
							$model_plan_coverage_type_offered->created_by = $logged_user_id;
						} else {
							$model_plan_coverage_type_offered->modified_date = date ( 'Y-m-d H:i:s' );
							$model_plan_coverage_type_offered->modified_by = $logged_user_id;
						}
						
						try {
							
							if ($model_plan_coverage_type_offered->save () && $model_plan_coverage_type_offered->validate ()) {
								
								$result ['success'] = 'success';
								$result ['coverage_type_id'] = $model_plan_coverage_type_offered->coverage_type_id;
							} else {
								
								$arrerrors = $model_plan_coverage_type_offered->getFirstErrors ();
								$errorstring = '';
								/**
								 * *****Converting error into string*******
								 */
								foreach ( $arrerrors as $key => $value ) {
									$errorstring .= $value . '<br>';
								}
								
								throw new \Exception ( $errorstring );
							}
						} catch ( \Exception $e ) {
							
							$msg = $e->getMessage ();
							$result ['error'] = $msg;
						}
					}
				}
				
				return $result;
			} else {
				return $this->redirect ( array (
						'/client/companies' 
				) );
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	protected function Empcontribution($company_id, $plan_id, $emp_contribution_post) {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			$encrypt_component = new EncryptDecryptComponent ();
			$model_plan_coverage_type = new TblAcaPlanCoverageType ();
			$model_plan_coverage_type_offered = new TblAcaPlanCoverageTypeOffered ();
			$model_plan_emp_contributions = new TblAcaEmpContributions ();
			$model_plan_emp_contributions_premium = new TblAcaEmpContributionsPremium ();
			
			$result = array ();
			$contribution_result = array ();
			$safe_harbor = '';
			$employee_plan_contribution = '';
			
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			
			if (! empty ( $company_id ) && ! empty ( $plan_id )) {
				
				/**
				 * Get plan class
				 */
				$plan_details = $model_plan_coverage_type->FindplanbyId ( $plan_id, $company_id );
				
				/**
				 * *Get plan class coverage type*
				 */
				$plan_coverage_type_offered = $model_plan_coverage_type_offered->FindplanbyId ( $plan_id );
				if (! empty ( $plan_coverage_type_offered )) {
					
					/**
					 * *Get emp contribution*
					 */
					$plan_emp_contributions = $model_plan_emp_contributions->FindbycoveragetypeId ( $plan_coverage_type_offered->coverage_type_id );
					;
					
					if (! empty ( $plan_emp_contributions )) {
						$model_plan_emp_contributions = $plan_emp_contributions;
						
						/**
						 * Get Emp contribution premium*
						 */
						$emp_contribution_premium_details = $model_plan_emp_contributions_premium->FindbyempcontributionId ( $plan_emp_contributions->emp_contribution_id );
						
						if (! empty ( $emp_contribution_premium_details )) {
							$model_plan_emp_contributions_premium = $emp_contribution_premium_details;
						}
					}
					
					if (! empty ( $emp_contribution_post ['TblAcaEmpContributionsPremium'] )) {
						
						$premium_contribution = $emp_contribution_post ['TblAcaEmpContributionsPremium'] ['premium_value'];
						
						if (! empty ( $emp_contribution_post ['TblAcaEmpContributions'] ['safe_harbor'] )) {
							$safe_harbor = $emp_contribution_post ['TblAcaEmpContributions'] ['safe_harbor'];
						}
						
						if (! empty ( $emp_contribution_post ['TblAcaEmpContributions'] ['employee_plan_contribution'] )) {
							$employee_plan_contribution = $emp_contribution_post ['TblAcaEmpContributions'] ['employee_plan_contribution'];
						}
						
						$model_plan_emp_contributions->safe_harbor = $safe_harbor;
						$model_plan_emp_contributions->employee_plan_contribution = $employee_plan_contribution;
						$model_plan_emp_contributions->coverage_type_id = $plan_coverage_type_offered->coverage_type_id;
						if ($model_plan_emp_contributions->isNewRecord) {
							$model_plan_emp_contributions->created_date = date ( 'Y-m-d H:i:s' );
							$model_plan_emp_contributions->created_by = $logged_user_id;
						} else {
							$model_plan_emp_contributions->modified_date = date ( 'Y-m-d H:i:s' );
							$model_plan_emp_contributions->modified_by = $logged_user_id;
						}
						
						try {
							if ($model_plan_emp_contributions->save () && $model_plan_emp_contributions->validate ()) {
								
								$emp_contribution_id = $model_plan_emp_contributions->emp_contribution_id;
								
								foreach ( $premium_contribution as $key => $value ) {
									$model_plan_emp_contributions_premium = new TblAcaEmpContributionsPremium ();
									
									// check for old offer years
									if (! empty ( $emp_contribution_premium_details )) {
										$model_plan_emp_contributions_premium_details = $model_plan_emp_contributions_premium->getPremiumvalueall ( $emp_contribution_premium_details->emp_contribution_id, $key );
										if (! empty ( $model_plan_emp_contributions_premium_details )) {
											$model_plan_emp_contributions_premium = $model_plan_emp_contributions_premium_details;
										}
									}
									
									$model_plan_emp_contributions_premium->emp_contribution_id = $emp_contribution_id;
									$model_plan_emp_contributions_premium->premium_year = $key;
									$model_plan_emp_contributions_premium->premium_value = $value;
									
									if ($model_plan_emp_contributions_premium->isNewRecord) {
										$model_plan_emp_contributions_premium->created_date = date ( 'Y-m-d H:i:s' );
										$model_plan_emp_contributions_premium->created_by = $logged_user_id;
									} else {
										$model_plan_emp_contributions_premium->modified_date = date ( 'Y-m-d H:i:s' );
										$model_plan_emp_contributions_premium->modified_by = $logged_user_id;
									}
									
									if ($model_plan_emp_contributions_premium->save () && $model_plan_emp_contributions_premium->validate ()) {
										$contribution_result ['success'] = 'success';
									} else {
										$contribution_result ['error'] = $model_plan_emp_contributions_premium->errors;
									}
								}
								
								if ($contribution_result ['success'] == 'success') {
									
									$result ['success'] = 'success';
									$result ['emp_contribution_id'] = $model_plan_emp_contributions->emp_contribution_id;
								}
							} else {
								
								$arrerrors = $model_plan_emp_contributions->getFirstErrors ();
								$errorstring = '';
								/**
								 * *****Converting error into string*******
								 */
								foreach ( $arrerrors as $key => $value ) {
									$errorstring .= $value . '<br>';
								}
								
								throw new \Exception ( $errorstring );
							}
						} catch ( \Exception $e ) {
							
							$msg = $e->getMessage ();
							$result ['error'] = $msg;
						}
					}
				}
				
				return $result;
			} else {
				return $this->redirect ( array (
						'/client/companies' 
				) );
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	public function actionPayrollvalidation() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			// rendering the layout
			$this->layout = 'main';
			
			$encrypt_component = new EncryptDecryptComponent ();
			$company_detals = array ();
			$company_validation = array ();
			$error_payroll_classes = array ();
			$arr_payroll_individual_issues = array ();
			$payroll_period_issues = array();
			$payroll_validation_issues = array();
			$top_ten_employee_id = array();
			
			$get_company_id = \Yii::$app->request->get ();
			
			if (! empty ( $get_company_id )) {
				/**
				 * Encrypted company ID*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					                                                                       
					// / get the company details
					$company_detals = TblAcaCompanies::find ()->select ( 'company_client_number,company_name' )->where ( 'company_id = :company_id', [ 
							'company_id' => $company_id 
					] )->one ();
					
					// checking if the validation starts for this company
					
					$company_validation = TblAcaCompanyValidationStatus::find ()->where ( [ 
							'company_id' => $company_id 
					] )->andWhere ( [ 
							'is_initialized' => 1 
					] )->andWhere ( [ 
							'is_completed' => 0 
					] )->One ();
					
					
					
					/**
					 * *** getting individual payroll employee validation *******
					 */
					/**************** pagination ***********************/	
					$num_rec_per_page=10;
				
					if (isset($get_company_id['page_id'])) {
						$page  = $get_company_id['page_id'];
					 } else {
					 	$page=1; 
					 }
		
					$start_from = ($page-1) * $num_rec_per_page;
				
					/**
						now getting the count of total issues 
					**/					
					$sql = 'SELECT `employee_id` FROM `tbl_aca_payroll_validation_log` WHERE `company_id`=' . $company_id . ' GROUP BY employee_id';
					$payroll_validation = \Yii::$app->db->createCommand ( $sql )->queryAll ();
					$i=0;
					foreach($payroll_validation as $payroll_validation){
						$payroll_validation_issues[$i] = $payroll_validation['employee_id'];
						$i++;
					}					
					
					$sql = 'SELECT `employee_id` FROM `tbl_aca_payroll_employment_period_validation_log` WHERE `company_id`=' . $company_id . ' GROUP BY employee_id';
					$payroll_period = \Yii::$app->db->createCommand ( $sql )->queryAll ();
					$j=0;
					foreach($payroll_period as $payroll_period){
						$payroll_period_issues[$j] = $payroll_period['employee_id'];
						$j++;
					}
						
										
					// combining both the issue arrays to combine all the employee ids					
					$issues_array = array_merge($payroll_validation_issues,$payroll_period_issues);
					
					// get the unique employee ids
					$final_employee_ids_array = array_unique($issues_array);
					$final_employee_ids_array = array_values($final_employee_ids_array);
					//print_r($start_from);die();
					if(count($final_employee_ids_array)> 10){

						//pagination						
						for($i=$start_from;$i<($start_from+10);$i++){	
							
							if($i<count($final_employee_ids_array)){
								$top_ten_employee_id[] = $final_employee_ids_array[$i];
							}else
							{
								break;
							}
						}
					}else
					{
						for($i=0;$i<count($final_employee_ids_array);$i++){
							$top_ten_employee_id[] = $final_employee_ids_array[$i];
						}
						
					}

					$payroll_details = ArrayHelper::index(TblAcaPayrollData::find ()->where ( [ 
								'employee_id' => $top_ten_employee_id
						] )->groupBy ( [ 
								'employee_id' 
						] )->asArray()->All (),'employee_id');
						//ArrayHelper::map($array, 'id', 'name')
						
						
					// get the number of issues for individual payroll data
					$error_individual_payroll = ArrayHelper::index(TblAcaPayrollValidationLog::find ()->select(['COUNT(*) AS cnt,employee_id'])->where ( [ 
								'company_id' => $company_id 
						] )->andWhere ( [ 
								'<>',
								'is_validated',
								1 
						] )->andWhere ( [ 
								'employee_id' => $top_ten_employee_id 
						] )->groupBy ( [ 
								'employee_id' 
						] )->asArray()->All (),'employee_id');
						
						
						
					// get the number of issues for period payroll data
					$error_individual_payroll_period = ArrayHelper::index(TblAcaPayrollEmploymentPeriodValidationLog::find ()->select(['COUNT(*) AS cnt,employee_id'])->where ( [ 
								'company_id' => $company_id 
						] )->andWhere ( [ 
								'<>',
								'is_validated',
								1 
						] )->andWhere ( [ 
								'employee_id' => $top_ten_employee_id 
						] )->groupBy ( [ 
								'employee_id' 
						] )->asArray()->All (),'employee_id');
						
						
					if(!empty($payroll_details))		
					{						
					foreach($payroll_details as $key=>$value)
					{
						$employee_id = 	$key;
						$payroll_issue = '';
						$payroll_period_issue = '';
						if(!empty($error_individual_payroll[$employee_id]['cnt'])){
							
							$payroll_issue = $error_individual_payroll[$employee_id]['cnt'];
						}
						if(!empty($error_individual_payroll_period[$employee_id]['cnt'])){
							
							$payroll_period_issue = $error_individual_payroll_period[$employee_id]['cnt'];
						}
						
						
						$issue_count = $payroll_issue+ $payroll_period_issue;
						
						if ($issue_count != 0) {
							$hased_payroll_employee_id = $encrypt_component->encrytedUser ( $employee_id );
							
							$arr_payroll_individual_issues [] = array (
									'payroll_firstname' => $value['first_name'],
									'payroll_lastname' => $value['last_name'],
									'payroll_middlename' => $value['middle_name'],
									'payroll_ssn' => $value['ssn'],
									'issue_count' => $issue_count,
									'payroll_id' => $hased_payroll_employee_id ,
									'company_id'=>$encrypt_company_id
									);
						}
					}
					}	
						//print_r($arr_payroll_individual_issues);die();	
						
					
					
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
					/**
						now getting the count of total issues 
					
					$payroll_validation = TblAcaPayrollValidationLog::find ()->select ( 'employee_id' )->where ( [ 
								'company_id' => $company_id 
					] )->groupBy ( [ 
								'employee_id' 
						] )->All ();
						
					//$arr_validations ['payroll_data_validation'] = count($payroll_validation);
						
					$payroll_period = TblAcaPayrollEmploymentPeriodValidationLog::find ()->select ( 'employee_id' )->where ( [ 
								'company_id' => $company_id 
					] )->groupBy ( [ 
								'employee_id' 
						] )->All ();
						
					$arr_validations ['payroll_data_validation'] = count($payroll_validation) + count($payroll_period);
					
					
					/**
					 * *** getting individual payroll employee validation *******
					 
					if($arr_validations ['payroll_data_validation']>10){
											
						$error_payroll_classes = TblAcaPayrollData::find ()->where ( [ 
								'employee_id' => $payroll_validation 
						] )->orWhere ( [ 
								'employee_id' => $payroll_period 
						] )->andWhere ( [ 
								'company_id' => $company_id 
						] )->groupBy ( [ 
								'employee_id' 
						] )
						  ->offset($start_from)
						  ->limit($num_rec_per_page)
							
						->All ();
					}
					else{
						$error_payroll_classes = TblAcaPayrollData::find ()->where ( [ 
								'employee_id' => $payroll_validation 
						] )->orWhere ( [ 
								'employee_id' => $payroll_period 
						] )->andWhere ( [ 
								'company_id' => $company_id 
						] )->groupBy ( [ 
								'employee_id' 
						] )->All ();
					}
					
					//////// using for pagination
					$error_payroll_classes_count = TblAcaPayrollData::find ()->where ( [ 
								'employee_id' => $payroll_validation 
						] )->orWhere ( [ 
								'employee_id' => $payroll_period 
						] )->andWhere ( [ 
								'company_id' => $company_id 
						] )->groupBy ( [ 
								'employee_id' 
						] )->count ();
					
					//$searchModel = new TblPayrollErrorSearch();
					// get the individual payroll employee details
					foreach ( $error_payroll_classes as $error_payroll_class ) {
						
						$payroll_details = TblAcaPayrollData::find ()->where ( [ 
								'employee_id' => $error_payroll_class->employee_id 
						] )->One ();
						
						// get the number of issues for individual payroll data
						$error_individual_payroll = TblAcaPayrollValidationLog::find ()->where ( [ 
								'company_id' => $company_id 
						] )->andWhere ( [ 
								'<>',
								'is_validated',
								1 
						] )->andWhere ( [ 
								'employee_id' => $error_payroll_class->employee_id 
						] )->All ();
						
						// get the number of issues for period payroll data
						$error_individual_payroll_period = TblAcaPayrollEmploymentPeriodValidationLog::find ()->where ( [ 
								'company_id' => $company_id 
						] )->andWhere ( [ 
								'<>',
								'is_validated',
								1 
						] )->andWhere ( [ 
								'employee_id' => $error_payroll_class->employee_id 
						] )->Count ();
						
						$issue_count = count ( $error_individual_payroll );
						$issue_count += $error_individual_payroll_period;
						
						if ($issue_count != 0) {
							$hased_payroll_employee_id = $encrypt_component->encrytedUser ( $error_payroll_class->employee_id );
							
							$arr_payroll_individual_issues [] = array (
									'payroll_firstname' => $payroll_details->first_name,
									'payroll_lastname' => $payroll_details->last_name,
									'payroll_middlename' => $payroll_details->middle_name,
									'payroll_ssn' => $payroll_details->ssn,
									'issue_count' => $issue_count,
									'payroll_id' => $hased_payroll_employee_id ,
									'company_id'=>$encrypt_company_id
									);
						}
					}
					//$dataProvider = $searchModel->search($arr_payroll_individual_issues); //dataProvider for grid 
					*/
				}
				
			}
			
			if(!empty($arr_payroll_individual_issues)){
				
				return $this->render ( 'payrollvalidation', array (
						'company_detals' => $company_detals,
						//'dataProvider'=>$dataProvider,
						//'searchModel'=>$searchModel,
						'company_validation' => $company_validation,
						'encoded_company_id' => $_GET ['c_id'],
						'arr_payroll_individual_issues' => $arr_payroll_individual_issues,
						//'total_issue_count' => $arr_validations ['payroll_data_validation'],
						'total_issue_count' => count($final_employee_ids_array),
						'error_payroll_classes_count' => count($final_employee_ids_array)
				) );
			}else{
			return $this->redirect ( array (
								'/client/validateforms?c_id=' . $encrypt_company_id 
						) );
			}
			
		} else {
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	
	/**
	 * ******** action to update the payroll validation issues ******
	 */
	public function actionPayrollindividualvalidation() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			/**
			 * Declaring Session Variables**
			 */
			$this->layout = 'main';
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			
			$encrypt_component = new EncryptDecryptComponent ();
			$common_validation_component = new CommonValidationsComponent ();
			$validation_rule_ids = array ();
			$element_ids = array ();
			$arrvalidation_errors = array ();
			$arrvalidations = array ();
			$arrperiodvalidation_errors = array ();
			$get_company_id = \Yii::$app->request->get ();
			
			if (! empty ( $get_company_id )) {
				
				/**
				 * Encrypted company ID*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				$encrypt_payroll_id = $get_company_id ['payroll_id'];
				
				if (! empty ( $encrypt_company_id ) && ! empty ( $encrypt_payroll_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					$payroll_id = $encrypt_component->decryptUser ( $encrypt_payroll_id ); // Decrypted payroll Id
					// die($company_id);                                                                      
					// / getting company details
					$company_details = TblAcaCompanies::find ()->select ( 'company_client_number,company_name' )->where ( 'company_id = :company_id', [ 
							'company_id' => $company_id 
					] )->one ();
					
					// / getting payroll details
					
					$payroll_details = TblAcaPayrollData::find ()->where ( [ 
							'employee_id' => $payroll_id 
					] )->One ();
					 // $payroll_details->scenario = 'validateMedical';
					  
					if (! empty ( $payroll_details )) {
						
						// check for payroll employee period
						
						$employee_periods = TblAcaPayrollEmploymentPeriod::find ()->where ( [ 
								'employee_id' => $payroll_id 
						] )->All ();
						
						/*for($i = 75; $i <= 103; $i ++) {
							
							$validation_rule_ids [] = $i;
						}*/
							$validation_rule_ids = [ 
							'75',
							'76',
							'77',
							'78',
							'79',
							'80',
							'81',
							'82',
							'83',
							'84',
							'85',
							'86',
							'87',
							'88',
							'89',
							'90',
							'91',
							'92',
							'93',
							'94',
							'95',
							'96',
							'97',
							'98',
							'99',
							'100',
							'101',
							'102',
							'103',
							'146',
							'147',
							'149',
							'150',
							'151',
							'152'
					];
						for($i = 1; $i <= 13; $i ++) {
							$element_ids [] = $i;
						}
						
						/**
						 * *Check for validation errors***
						 */
						$validation_results = TblAcaPayrollValidationLog::find ()->select ( 'validation_rule_id, is_validated' )->where ( [ 
								'company_id' => $company_id,
								'employee_id' => $payroll_id,
								'validation_rule_id' => $validation_rule_ids,
								'is_validated' => 0 
						] )->All ();
						
						$validation_period_results = TblAcaPayrollEmploymentPeriodValidationLog::find ()->select ( 'period_id, validation_rule_id, is_validated' )->where ( [ 
								'company_id' => $company_id,
								'employee_id' => $payroll_id,
								'validation_rule_id' => $validation_rule_ids,
								'is_validated' => 0 
						] )->All ();
						
						
						if (! empty ( $validation_results ) || ! empty ( $validation_period_results )) {
							if (! empty ( $validation_results )) {
								foreach ( $validation_results as $validations ) {
									
									$arrvalidations [] = $validations->validation_rule_id;
									$arrvalidation_errors [$validations->validation_rule_id] ['error_message'] = $validations->validationRule->error_message;
									$arrvalidation_errors [$validations->validation_rule_id] ['error_code'] = $validations->validationRule->error_code;
								}
							}
							
							if (! empty ( $validation_period_results )) {
								foreach ( $validation_period_results as $period_validations ) {
									
									$arrperiodvalidation_errors [$period_validations->period_id] [$period_validations->validation_rule_id] ['error_message'] = $period_validations->validationRule->error_message;
									$arrperiodvalidation_errors [$period_validations->period_id] [$period_validations->validation_rule_id] ['error_code'] = $period_validations->validationRule->error_code;
								}
							}
							
							$plan_classes = TblAcaPlanCoverageType::find ()->select ( 'plan_class_id, plan_class_number' )->where ( [ 
									'company_id' => $company_id 
							] )->all ();
							
							/**
							 * Get all errors for general info *
							 */
							$get_post_validation_errors = TblAcaValidationRules::find ()->select ( 'rule_id, error_code, error_message' )->where ( [ 
									'rule_id' => $validation_rule_ids 
							] )->All ();
							
							if (! empty ( $get_post_validation_errors )) {
								
								foreach ( $get_post_validation_errors as $errors ) {
									$post_validation_errors [$errors->rule_id] ['error_message'] = $errors->error_message;
									$post_validation_errors [$errors->rule_id] ['error_code'] = $errors->error_code;
								}
							}
							
							$employee_post_details = \Yii::$app->request->post ();
							
							if (! empty ( $employee_post_details )) {
								// begin transaction
								$transaction = \Yii::$app->db->beginTransaction ();
								
								try {
									
									$payroll_details->attributes = $employee_post_details ['TblAcaPayrollData'];
									
									if(!empty($employee_post_details ['TblAcaPayrollData']['ssn']))
									{
										
										$payroll_details->ssn = preg_replace ( '/[^0-9\']/', '',  $employee_post_details ['TblAcaPayrollData']['ssn'] ); 
										
										// checking for duplicate SSN
										
										$duplicate_ssn = TblAcaPayrollData::find ()->select ( 'ssn' )->where ('ssn='.$payroll_details->ssn )->andWhere ( 'employee_id <> ' . $payroll_id )->andWhere ( 'company_id='.$company_id  )->All ();
										if(!empty($duplicate_ssn)){
											throw new \Exception ( 'SSN already exists' );
										}
									
									}
									$payroll_details->state = strtoupper($employee_post_details ['TblAcaPayrollData']['state']);
									if ($payroll_details->save () && $payroll_details->validate ()) {
										if (! empty ( $employee_post_details ['TblAcaPayrollEmploymentPeriod'] )) {
											$period_details = $employee_post_details ['TblAcaPayrollEmploymentPeriod'];
											
											foreach ( $period_details as $key => $details ) {
												
												$hire_date = '';
												$termination_date = '';
												$plan_class = '';
												$status = '';
												
												if (! empty ( $details ['hire_date'] )) {
													$hire_date = $details ['hire_date'];
												}
												
												if (! empty ( $details ['termination_date'] )) {
													$termination_date = $details ['termination_date'];
												}
												
												if (! empty ( $details ['plan_class'] )) {
													$plan_class = $details ['plan_class'];
												}
												
												if (! empty ( $details ['status'] )) {
													$status = $details ['status'];
												}
												
												
												$encrypted_period_id = $key;
												
												$decrypted_period_id = $encrypt_component->decryptUser ( $encrypted_period_id );
												
												$individual_period_details = TblAcaPayrollEmploymentPeriod::find ()->where ( [ 
														'period_id' => $decrypted_period_id 
												] )->One ();
												
												
												
												if (! empty ( $individual_period_details )) {
													$individual_period_details->hire_date = $details ['hire_date'];
													$individual_period_details->termination_date = $details ['termination_date'];
													$individual_period_details->plan_class = $details ['plan_class'];
													$individual_period_details->status = $details ['status'];
													
													if ($individual_period_details->save () && $individual_period_details->validate ()) {
														$period_result ['success'] = 'success';
														
														
													} else {
														
														$arrerrors = $individual_period_details->getFirstErrors ();
														$errorstring = '';
														/**
														 * *****Converting error into string*******
														 */
														foreach ( $arrerrors as $key => $value ) {
															$errorstring .= $value . '<br>';
														}
														
														throw new \Exception ( $errorstring );
													}
												}
											}
										}
										
										// validate general plan info
										$validate_results = $common_validation_component->ValidatePayroll ( $company_id, $payroll_id, $element_ids );
										
										if (! empty ( $validate_results ['error'] )) {
											throw new \Exception ( $validate_results ['error'] );
										} else {
											$validation_success = $validate_results ['success'];
											$validation_period_success = $validate_results ['period_success'];
											
											if (empty ( $validation_success ) && empty ( $validation_period_success )) {
												
												TblAcaPayrollValidationLog::deleteAll ( 'company_id = :company_id AND employee_id = :employee_id', [ 
														':company_id' => $company_id,
														':employee_id' => $payroll_id 
												] );
												
												TblAcaPayrollEmploymentPeriodValidationLog::deleteAll ( 'company_id = :company_id AND employee_id = :employee_id', [ 
														':company_id' => $company_id,
														':employee_id' => $payroll_id 
												] );
												
												
												$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();
													
												if(!empty($model_company_validation_log))		{
													$model_company_validation_log->created_by = $logged_user_id;
													$model_company_validation_log->modified_by = $logged_user_id;
													$model_company_validation_log->payroll_info_date = date('Y-m-d H:i:s');
														
													$model_company_validation_log->save();
												}
												
												
												$transaction->commit (); // commit the transaction
												
												\Yii::$app->session->setFlash ( 'success', 'Value updated successfully' );
												return $this->redirect ( array (
														'/client/validateforms/payrollvalidation?c_id=' . $encrypt_company_id 
												) );
											} else {
												$arrperiodvalidation_errors = array ();
												$arrvalidation_errors = array ();
												
												if (! empty ( $validation_success )) {
													foreach ( $validation_success as $key => $value ) {
														
														if ($value == 0) {
															$arrvalidation_errors [$key] ['error_message'] = $post_validation_errors [$key] ['error_message'];
															$arrvalidation_errors [$key] ['error_code'] = $post_validation_errors [$key] ['error_code'];
														}
													}
													
												}
												
												if (! empty ( $validation_period_success )) {
													foreach ( $validation_period_success as $key => $validations ) {
														
														foreach ( $validations as $validation_rule_id => $is_validated ) {
															
															if ($is_validated == 0) {
																$arrperiodvalidation_errors [$key] [$validation_rule_id] ['error_message'] = $post_validation_errors [$validation_rule_id] ['error_message'];
																$arrperiodvalidation_errors [$key] [$validation_rule_id] ['error_code'] = $post_validation_errors [$validation_rule_id] ['error_code'];
															}
														}
													}
												}
												
												// check for payroll employee period
												
												$employee_periods = TblAcaPayrollEmploymentPeriod::find ()->where ( [ 
														'employee_id' => $payroll_id 
												] )->All ();
												
												//$transaction->rollBack ();
											}
										}
									} else {
										
										$arrerrors = $payroll_details->getFirstErrors ();
										$errorstring = '';
										/**
										 * *****Converting error into string*******
										 */
										foreach ( $arrerrors as $key => $value ) {
											$errorstring .= $value . '<br>';
										}
										
										throw new \Exception ( $errorstring );
									}
								} catch ( \Exception $e ) {
									
									$msg = $e->getMessage ();
									
									//print_r($e);die();
									\Yii::$app->session->setFlash ( 'error', $msg );
									
									// rollback transaction
									$transaction->rollback ();
									
									return $this->redirect ( array (
											'/client/validateforms/payrollindividualvalidation?c_id=' . $encrypt_company_id . '&payroll_id=' . $encrypt_payroll_id 
									) );
								}
							}
							
							return $this->render ( 'payrollindividualvalidation', array (
									'company_detals' => $company_details,
									'payroll_details' => $payroll_details,
									'encrypt_company_id' => $encrypt_company_id,
									'arrvalidations' => $arrvalidations,
									'arrvalidation_errors' => $arrvalidation_errors,
									'employee_periods' => $employee_periods,
									'arrperiodvalidation_errors' => $arrperiodvalidation_errors,
									'plan_classes' => $plan_classes,
									'encoded_company_id' => $encrypt_company_id,
									'encrypt_payroll_id' => $encrypt_payroll_id 
							) );
						}else
						{
							\Yii::$app->session->setFlash ( 'success', 'No issues in the employee.' );
							return $this->redirect ( array (
							'/client/validateforms?c_id='.$encrypt_company_id 
								) );
							
						}
					}
				} else {
					return $this->redirect ( array (
							'/client/companies' 
					) );
				}
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
	}
	
	/**
	 * ******* action for medical validations *****
	 */
	public function actionMedicalvalidation() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			// rendering the layout
			$this->layout = 'main';
			
			$encrypt_component = new EncryptDecryptComponent ();
			$company_detals = array ();
			$company_validation = array ();
			$error_medical_classes = array ();
			$arr_medical_individual_issues = array ();
			$medical_period_issues = array();
			$medical_validation_issues = array();
			$top_ten_employee_id = array();
			
			$get_company_id = \Yii::$app->request->get ();
			
			if (! empty ( $get_company_id )) {
				/**
				 * Encrypted company ID*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					                                                                       
					// / get the company details
					$company_detals = TblAcaCompanies::find ()->select ( 'company_client_number,company_name' )->where ( 'company_id = :company_id', [ 
							'company_id' => $company_id 
					] )->one ();
					
					// checking if the validation starts for this company
					
					$company_validation = TblAcaCompanyValidationStatus::find ()->where ( [ 
							'company_id' => $company_id 
					] )->andWhere ( [ 
							'is_initialized' => 1 
					] )->andWhere ( [ 
							'is_completed' => 0 
					] )->One ();
					
					
					
					
					
					/**
					 * *** getting individual payroll employee validation *******
					 */
					/**************** pagination ***********************/	
					$num_rec_per_page=10;
				
					if (isset($get_company_id['page_id'])) {
						$page  = $get_company_id['page_id'];
					 } else {
					 	$page=1; 
					 }
		
					$start_from = ($page-1) * $num_rec_per_page;
				
					/**
						now getting the count of total issues 
					**/					
					$sql = 'SELECT `employee_id` FROM `tbl_aca_medical_validation_log` WHERE `company_id`=' . $company_id . ' GROUP BY employee_id';
					$medical_validation = \Yii::$app->db->createCommand ( $sql )->queryAll ();
					$i=0;
					foreach($medical_validation as $medical_validation){
						$medical_validation_issues[$i] = $medical_validation['employee_id'];
						$i++;
					}					
					
					$sql = 'SELECT `employee_id` FROM `tbl_aca_medical_enrollment_period_validation_log` WHERE `company_id`=' . $company_id . ' GROUP BY employee_id';
					$medical_period = \Yii::$app->db->createCommand ( $sql )->queryAll ();
					$j=0;
					foreach($medical_period as $medical_period){
						$medical_period_issues[$j] = $medical_period['employee_id'];
						$j++;
					}
						
										
					// combining both the issue arrays to combine all the employee ids					
					$issues_array = array_merge($medical_validation_issues,$medical_period_issues);
				
					// get the unique employee ids
					$final_employee_ids_array = array_unique($issues_array);
					$final_employee_ids_array = array_values($final_employee_ids_array);
						
					
					if(count($final_employee_ids_array)> 10){

						//pagination						
						for($i=$start_from;$i<($start_from+10);$i++){	
							
							if($i<count($final_employee_ids_array)){
								
							//	if(!empty($final_employee_ids_array[$i])){
								$top_ten_employee_id[] = $final_employee_ids_array[$i];
							//	}
							}else
							{
								break;
							}
						}
					}else
					{
						
						for($i=0;$i<count($final_employee_ids_array);$i++){
							//if(!empty($final_employee_ids_array[$i])){
							$top_ten_employee_id[] = $final_employee_ids_array[$i];
							//}
						}
						
					}

					$medical_details = ArrayHelper::index(TblAcaMedicalData::find ()->where ( [ 
								'employee_id' => $top_ten_employee_id
						] )->groupBy ( [ 
								'employee_id' 
						] )->asArray()->All (),'employee_id');
						//ArrayHelper::map($array, 'id', 'name')
						
						
					// get the number of issues for individual payroll data
					$error_individual_medical = ArrayHelper::index(TblAcaMedicalValidationLog::find ()->select(['COUNT(*) AS cnt,employee_id'])->where ( [ 
								'company_id' => $company_id 
						] )->andWhere ( [ 
								'<>',
								'is_validated',
								1 
						] )->andWhere ( [ 
								'employee_id' => $top_ten_employee_id 
						] )->groupBy ( [ 
								'employee_id' 
						] )->asArray()->All (),'employee_id');
						
					
						
					// get the number of issues for period payroll data
					$error_individual_medical_period = ArrayHelper::index(TblAcaMedicalEnrollmentPeriodValidationLog::find ()->select(['COUNT(*) AS cnt,employee_id'])->where ( [ 
								'company_id' => $company_id 
						] )->andWhere ( [ 
								'<>',
								'is_validated',
								1 
						] )->andWhere ( [ 
								'employee_id' => $top_ten_employee_id 
						] )->groupBy ( [ 
								'employee_id' 
						] )->asArray()->All (),'employee_id');
						
					if(!empty($medical_details))		
					{		//print_r($issue_count);			
					foreach($medical_details as $key=>$value)
					{
						$employee_id = 	$key;
						$medical_issue = '';
						$medical_period_issue = '';
						if(!empty($error_individual_medical[$employee_id]['cnt'])){
							
							$medical_issue = $error_individual_medical[$employee_id]['cnt'];
						}
						if(!empty($error_individual_medical_period[$employee_id]['cnt'])){
							
							$medical_period_issue = $error_individual_medical_period[$employee_id]['cnt'];
						}
						
						
						$issue_count = $medical_issue+ $medical_period_issue;
							
						if ($issue_count != 0) {
							$hased_medical_employee_id = $encrypt_component->encrytedUser ( $employee_id );
							
							
								$arr_medical_individual_issues [] = array (
								//'medical_firstname' => $medical_details->first_name,
								'medical_firstname' => $value['first_name'],
								'medical_lastname' => $value['last_name'],
								'medical_middlename' => $value['middle_name'],
								'medical_ssn' => $value['ssn'],
								'issue_count' => $issue_count,
								'medical_id' => $hased_medical_employee_id ,
								'company_id' =>$encrypt_company_id
							);
						}
					}
					
						
					
				}
				
				
				
				
				
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					/**
					 * *** getting individual payroll employee validation *******
					 */
					/**************** pagination **********************
					$num_rec_per_page=10;
					
					if (isset($get_company_id['page_id'])) {
						$page  = $get_company_id['page_id'];
					} else {
						$page=1;
					}
					
					$start_from = ($page-1) * $num_rec_per_page;
					
					/**
						now getting the count of total issues 
					*
					$medical_validation = TblAcaMedicalValidationLog::find ()->select ( 'employee_id' )->where ( [ 
								'company_id' => $company_id 
					] )->All ();
						
					$arr_validations ['medical_data_validation'] = count($medical_validation);
					
					$medical_period = TblAcaMedicalEnrollmentPeriodValidationLog::find ()->select ( 'employee_id' )->where ( [ 
								'company_id' => $company_id 
					] )->All ();
						
					$arr_validations ['medical_data_validation'] += count($medical_period);
					//print_r($arr_validations ['medical_data_validation']);die();
					/**
					 * *** getting individual payroll employee validation *******
					 
					if($arr_validations ['medical_data_validation']>10){
						$error_medical_classes = TblAcaMedicalData::find ()->where ( [ 
								'employee_id' => $medical_validation 
						] )->orWhere ( [ 
								'employee_id' => $medical_period 
						] )->andWhere ( [ 
								'company_id' => $company_id 
						] )->groupBy ( [ 
								'employee_id' 
						] )
						->offset($start_from)
						->limit($num_rec_per_page)
						
						->All ();
					}
					else{
						$error_medical_classes = TblAcaMedicalData::find ()->where ( [ 
								'employee_id' => $medical_validation 
						] )->orWhere ( [ 
								'employee_id' => $medical_period 
						] )->andWhere ( [ 
								'company_id' => $company_id 
						] )->groupBy ( [ 
								'employee_id' 
						] )->All ();
					}
					
					//////// using for pagination
					$error_medical_classes_count = TblAcaMedicalData::find ()->where ( [ 
								'employee_id' => $medical_validation 
						] )->orWhere ( [ 
								'employee_id' => $medical_period 
						] )->andWhere ( [ 
								'company_id' => $company_id 
						] )->groupBy ( [ 
								'employee_id' 
						] )->count ();
					//$searchModel = new TblAcaMedicalErrorSearch();
					
					// get the individual payroll employee details
					foreach ( $error_medical_classes as $error_medical_class ) {
						
						$medical_details = TblAcaMedicalData::find ()->where ( [ 
								'employee_id' => $error_medical_class->employee_id 
						] )->One ();
						
						// get the number of issues for individual medical data
						$error_individual_medical = TblAcaMedicalValidationLog::find ()->where ( [ 
								'company_id' => $company_id 
						] )->andWhere ( [ 
								'<>',
								'is_validated',
								1 
						] )->andWhere ( [ 
								'employee_id' => $error_medical_class->employee_id 
						] )->All ();
						
						// get the number of issues for period medical data
						$error_individual_medical_period = TblAcaMedicalEnrollmentPeriodValidationLog::find ()->where ( [ 
								'company_id' => $company_id 
						] )->andWhere ( [ 
								'<>',
								'is_validated',
								1 
						] )->andWhere ( [ 
								'employee_id' => $error_medical_class->employee_id 
						] )->Count ();
						
						$issue_count = count ( $error_individual_medical );
						$issue_count += $error_individual_medical_period;
						
						if ($issue_count > 0) {
							$hased_medical_employee_id = $encrypt_component->encrytedUser ( $error_medical_class->employee_id );
							$arr_medical_individual_issues [] = array (
									//'medical_firstname' => $medical_details->first_name,
									'medical_firstname' => $medical_details->first_name,
									'medical_lastname' => $medical_details->last_name,
									'medical_middlename' => $medical_details->middle_name,
									'medical_ssn' => $medical_details->ssn,
									'issue_count' => $issue_count,
									'medical_id' => $hased_medical_employee_id ,
									'company_id' =>$encrypt_company_id
							);
						}
					}
					
					*/
					//print_r($arr_medical_individual_issues);die();
						//$dataProvider = $searchModel->search($arr_medical_individual_issues); //dataProvider for grid 
				}
			}
			
			if(!empty($arr_medical_individual_issues)){
			return $this->render ( 'medicalvalidation', array (
					'company_detals' => $company_detals,
					//'dataProvider'=>$dataProvider,
					//'searchModel'=>$searchModel,
					'company_validation' => $company_validation,
					'encoded_company_id' => $_GET ['c_id'],
					'arr_medical_individual_issues' => $arr_medical_individual_issues,
					'total_issue_count' =>  count($final_employee_ids_array),
					'error_medical_classes_count' =>  count($final_employee_ids_array)
			) );
			
			}else{
			return $this->redirect ( array (
								'/client/validateforms?c_id=' . $encrypt_company_id 
						) );
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
	}
	
	/**
	 * ******** action to update the payroll validation issues ******
	 */
	public function actionMedicalindividualvalidation() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			/**
			 * Declaring Session Variables**
			 */
			$this->layout = 'main';
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			
			$encrypt_component = new EncryptDecryptComponent ();
			$common_validation_component = new CommonValidationsComponent ();
			$validation_rule_ids = array ();
			$element_ids = array ();
			$arrvalidation_errors = array ();
			$arrvalidations = array ();
			$arrperiodvalidation_errors = array ();
			$get_company_id = \Yii::$app->request->get ();
			
			if (! empty ( $get_company_id )) {
				
				/**
				 * Encrypted company ID*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				$encrypt_medical_id = $get_company_id ['medical_id'];
				
				if (! empty ( $encrypt_company_id ) && ! empty ( $encrypt_medical_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					$medical_id = $encrypt_component->decryptUser ( $encrypt_medical_id ); // Decrypted payroll Id
					                                                                       
					// / getting company details
					$company_details = TblAcaCompanies::find ()->select ( 'company_client_number,company_name' )->where ( 'company_id = :company_id', [ 
							'company_id' => $company_id 
					] )->one ();
					
					// / getting payroll details
					
					$medical_details = TblAcaMedicalData::find ()->where ( [ 
							'employee_id' => $medical_id 
					] )->One ();
					
					if (! empty ( $medical_details )) {
						
						// check for medical employee period
						
						$enrollment_periods = TblAcaMedicalEnrollmentPeriod::find ()->where ( [ 
								'employee_id' => $medical_id 
						] )->All ();
						
						/*for($i = 104; $i <= 139; $i ++) {
							
							$validation_rule_ids [] = $i;
						}*/
						
						$validation_rule_ids = [ 
							'104',
							'105',
							'106',
							'107',
							'108',
							'109',
							'110',
							'111',
							'112',
							'113',
							'114',
							'115',
							'116',
							'117',
							'118',
							'119',
							'120',
							'121',
							'122',
							'123',
							'124',
							'125',
							'126',
							'127',
							'128',
							'129',
							'130',
							'131',
							'132',
							'133',
							'134',
							'135',
							'136',
							'137',
							'138',
							'139',
							'153',
							'154',
							'155',
							'156'
						];
						
						for($i = 1; $i <= 15; $i ++) {
							$element_ids [] = $i;
						}
						
						/**
						 * *Check for validation errors***
						 */
						$validation_results = TblAcaMedicalValidationLog::find ()->select ( 'validation_rule_id, is_validated' )->where ( [ 
								'company_id' => $company_id,
								'employee_id' => $medical_id,
								'validation_rule_id' => $validation_rule_ids,
								'is_validated' => 0 
						] )->All ();
						
						$validation_period_results = TblAcaMedicalEnrollmentPeriodValidationLog::find ()->select ( 'period_id, validation_rule_id, is_validated' )->where ( [ 
								'company_id' => $company_id,
								'employee_id' => $medical_id,
								'validation_rule_id' => $validation_rule_ids,
								'is_validated' => 0 
						] )->All ();
						
						if (! empty ( $validation_results ) || ! empty ( $validation_period_results )) {
							if (! empty ( $validation_results )) {
								foreach ( $validation_results as $validations ) {
									
									$arrvalidations [] = $validations->validation_rule_id;
									$arrvalidation_errors [$validations->validation_rule_id] ['error_message'] = $validations->validationRule->error_message;
									$arrvalidation_errors [$validations->validation_rule_id] ['error_code'] = $validations->validationRule->error_code;
								}
							}
							
							if (! empty ( $validation_period_results )) {
								foreach ( $validation_period_results as $period_validations ) {
									
									$arrperiodvalidation_errors [$period_validations->period_id] [$period_validations->validation_rule_id] ['error_message'] = $period_validations->validationRule->error_message;
									$arrperiodvalidation_errors [$period_validations->period_id] [$period_validations->validation_rule_id] ['error_code'] = $period_validations->validationRule->error_code;
								}
							}
							
							$plan_classes = TblAcaPlanCoverageType::find ()->select ( 'plan_class_id, plan_class_number' )->where ( [ 
									'company_id' => $company_id 
							] )->all ();
							
							/**
							 * Get all errors for general info *
							 */
							$get_post_validation_errors = TblAcaValidationRules::find ()->select ( 'rule_id, error_code, error_message' )->where ( [ 
									'rule_id' => $validation_rule_ids 
							] )->All ();
						
							if (! empty ( $get_post_validation_errors )) {
								
								foreach ( $get_post_validation_errors as $errors ) {
									$post_validation_errors [$errors->rule_id] ['error_message'] = $errors->error_message;
									$post_validation_errors [$errors->rule_id] ['error_code'] = $errors->error_code;
								}
							}
							
							$person_type_Data = ArrayHelper::map ( TblAcaLookupOptions::find ()->where ( [ 
									'=',
									'code_id',
									10 
							] )->andwhere ( [ 
									'<>',
									'lookup_status',
									2 
							] )->all (), 'lookup_id', 'lookup_value' );
							
							$employee_post_details = \Yii::$app->request->post ();
							
							if (! empty ( $employee_post_details )) {
								
								// begin transaction
								$transaction = \Yii::$app->db->beginTransaction ();
								
								try {
									
									$medical_details->attributes = $employee_post_details ['TblAcaMedicalData'];
									//$medical_details->dob =date('Y-m-d',strtotime($employee_post_details ['TblAcaMedicalData']['dob']));
									if(!empty($employee_post_details ['TblAcaMedicalData']['ssn']))
									{
										
										$medical_details->ssn = preg_replace ( '/[^0-9\']/', '',  $employee_post_details ['TblAcaMedicalData']['ssn'] ); 
										
										// checking for duplicate SSN
										
										$duplicate_ssn = TblAcaMedicalData::find ()->select ( 'ssn' )->where ('ssn='.$medical_details->ssn )->andWhere ( 'employee_id <> ' . $medical_id )->andWhere ( 'company_id='.$company_id  )->All ();
										if(!empty($duplicate_ssn)){
											throw new \Exception ( 'SSN already exists' );
										}
									}
									
									//print_r($medical_details->attributes);die();
									
									if ($medical_details->save () && $medical_details->validate ()) {
										if (! empty ( $employee_post_details ['TblAcaMedicalEnrollmentPeriod'] )) {
											$period_details = $employee_post_details ['TblAcaMedicalEnrollmentPeriod'];
											
											foreach ( $period_details as $key => $details ) {
												
												$coverage_start_date = '';
												$coverage_end_date = '';
												$person_type = '';
												$ssn = '';
												$dob = '';
												$dependent_dob = '';
												
												if (! empty ( $details ['coverage_start_date'] )) {
													$coverage_start_date = $details ['coverage_start_date'];
												}
												
												if (! empty ( $details ['coverage_end_date'] )) {
													$coverage_end_date = $details ['coverage_end_date'];
												}
												
												if (! empty ( $details ['person_type'] )) {
													$person_type = $details ['person_type'];
												}
												
												if (! empty ( $details ['ssn'] )) {
													$ssn = preg_replace ( '/[^0-9\']/', '',$details ['ssn']);
												}
												
												if (! empty ( $details ['dependent_dob'] )) {
													$dependent_dob = $details ['dependent_dob'];
												}
												
												if (! empty ( $details ['dob'] )) {
													$dob = date('Y-m-d',strtotime($details ['dob']));
												}
												
												$encrypted_period_id = $key;
												$decrypted_period_id = $encrypt_component->decryptUser ( $encrypted_period_id );
												
												$individual_period_details = TblAcaMedicalEnrollmentPeriod::find ()->where ( [ 
														'period_id' => $decrypted_period_id 
												] )->One ();
												
												if (! empty ( $individual_period_details )) {
													$individual_period_details->coverage_start_date = $coverage_start_date;
													$individual_period_details->coverage_end_date = $coverage_end_date;
													$individual_period_details->person_type = $person_type;
													$individual_period_details->ssn = $ssn;
													$individual_period_details->dependent_dob = $dependent_dob;
													$individual_period_details->dob = $dob;
													
													if ($individual_period_details->save () && $individual_period_details->validate ()) {
														$period_result ['success'] = 'success';
													} else {
														
														$arrerrors = $individual_period_details->getFirstErrors ();
														$errorstring = '';
														/**
														 * *****Converting error into string*******
														 */
														foreach ( $arrerrors as $key => $value ) {
															$errorstring .= $value . '<br>';
														}
														
														throw new \Exception ( $errorstring );
													}
												}
											}
										}
										
										// validate general plan info
										$validate_results = $common_validation_component->ValidateMedical ( $company_id, $medical_id, $element_ids );
										
										
										if (! empty ( $validate_results ['error'] )) {
											
											throw new \Exception ( $validate_results ['error'] );
										} else {
											$validation_success = $validate_results ['success'];
											$validation_period_success = $validate_results ['period_success'];
											
											if (empty ( $validation_success ) && empty ( $validation_period_success )) {
												
												
												
												TblAcaMedicalValidationLog::deleteAll ( 'company_id = :company_id AND employee_id = :employee_id', [ 
														':company_id' => $company_id,
														':employee_id' => $medical_id 
												] );
												
												TblAcaMedicalEnrollmentPeriodValidationLog::deleteAll ( 'company_id = :company_id AND employee_id = :employee_id', [ 
														':company_id' => $company_id,
														':employee_id' => $medical_id 
												] );
												
												$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();
													
												if(!empty($model_company_validation_log))		{
													$model_company_validation_log->created_by = $logged_user_id;
													$model_company_validation_log->modified_by = $logged_user_id;
													$model_company_validation_log->medical_info_date = date('Y-m-d H:i:s');
												
													$model_company_validation_log->save();
												}
												
												$transaction->commit (); // commit the transaction
												
												\Yii::$app->session->setFlash ( 'success', 'Value updated successfully' );
												return $this->redirect ( array (
														'/client/validateforms/medicalvalidation?c_id=' . $encrypt_company_id 
												) );
											
											
											} else {
												$arrvalidation_errors = array ();
												$arrperiodvalidation_errors = array ();
												
												if (! empty ( $validation_success )) {
													foreach ( $validation_success as $key => $value ) {
														
														if ($value == 0) {
															$arrvalidation_errors [$key] ['error_message'] = $post_validation_errors [$key] ['error_message'];
															$arrvalidation_errors [$key] ['error_code'] = $post_validation_errors [$key] ['error_code'];
														}
													}
												}
												
												if (! empty ( $validation_period_success )) {
													foreach ( $validation_period_success as $key => $validations ) {
														
														foreach ( $validations as $validation_rule_id => $is_validated ) {
															
															if ($is_validated == 0) {
																$arrperiodvalidation_errors [$key] [$validation_rule_id] ['error_message'] = $post_validation_errors [$validation_rule_id] ['error_message'];
																$arrperiodvalidation_errors [$key] [$validation_rule_id] ['error_code'] = $post_validation_errors [$validation_rule_id] ['error_code'];
															}
														}
													}
												}
												
												// check for payroll employee period
												
												$enrollment_periods = TblAcaMedicalEnrollmentPeriod::find ()->where ( [ 
														'employee_id' => $medical_id 
												] )->All ();
												
												$transaction->rollBack ();
											}
										}
									} else {
										
										$arrerrors = $medical_details->getFirstErrors ();
										$errorstring = '';
										/**
										 * *****Converting error into string*******
										 */
										foreach ( $arrerrors as $key => $value ) {
											$errorstring .= $value . '<br>';
										}
										
										throw new \Exception ( $errorstring );
									}
								} catch ( \Exception $e ) {
									
									$msg = $e->getMessage ();
									\Yii::$app->session->setFlash ( 'error', $msg );
									
									// rollback transaction
									$transaction->rollback ();
									
									return $this->redirect ( array (
											'/client/validateforms/medicalindividualvalidation?c_id=' . $encrypt_company_id . '&medical_id=' . $encrypt_medical_id 
									) );
								}
							}
							
							return $this->render ( 'medicalindividualvalidation', array (
									'company_detals' => $company_details,
									'medical_details' => $medical_details,
									'encrypt_company_id' => $encrypt_company_id,
									'arrvalidations' => $arrvalidations,
									'arrvalidation_errors' => $arrvalidation_errors,
									'enrollment_periods' => $enrollment_periods,
									'arrperiodvalidation_errors' => $arrperiodvalidation_errors,
									'plan_classes' => $plan_classes,
									'encoded_company_id' => $encrypt_company_id,
									'encrypt_medical_id' => $encrypt_medical_id,
									'person_type_Data' => $person_type_Data 
							) );
						}else
						{
							\Yii::$app->session->setFlash ( 'success', 'No issues in the employee.' );
							return $this->redirect ( array (
							'/client/validateforms/medicalvalidation?c_id='.$encrypt_company_id 
								) );
							
						}
					}
				} else {
					return $this->redirect ( array (
							'/client/companies' 
					) );
				}
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
	}
	
	
	public function actionSaveemploymentperiod()
	{
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			$hire_date= '';
			$termination_date = '';
			$plan_class = '';
			$status = '';
			$encrypt_payroll_id = '';
			$arrperiodinsertvalidation =  array();
			$validation_rule_ids =  array();
			$post_validation_errors = array();
			$arrperiodvalidation_errors = array();
			$result = array();

			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			
			$validation_rule_ids = [ 
							'99',
							'100',
							'101',
							'102',
							'103',
							'147'];
					
					
			
			$get_details = \Yii::$app->request->post ();
			
			if(!empty($get_details['payroll_id']))
			{
				$encrypt_payroll_id =$get_details['payroll_id'];
				$encrypt_company_id = $get_details['c_id'];
				
				$encrypt_component = new EncryptDecryptComponent ();
								
				$decrypt_payroll_id = $encrypt_component->decryptUser ( $encrypt_payroll_id );
				$decrypt_company_id = $encrypt_component->decryptUser ( $encrypt_company_id );
				
			}
			
			if(!empty($get_details['hire_date']))
			{
				$hire_date =$get_details['hire_date'];
				
			}
			
			if(!empty($get_details['termination_date']))
			{
				$termination_date =$get_details['termination_date'];
				
			}
			
			if(!empty($get_details['plan_class']))
			{
				$plan_class =$get_details['plan_class'];
				
			}
			
			if(!empty($get_details['status']))
			{
				$status =$get_details['status'];
				
			}
			
			if(!empty($encrypt_payroll_id))
			{
				$individual_period_details = new TblAcaPayrollEmploymentPeriod();
				
				
				/**
				 * ********Can not be empty value***********
				 */
				
				if (empty ( $hire_date ) || $hire_date == '0000-00-00') {
					
					$arrperiodinsertvalidation ['99'] = 0;
					
				} else {
					
					/**
					 * ********Coverage start date can not be
					 * greater than 31st dec of the current year***********
					 */
					
					$year_end = date ( 'Y-m-d', strtotime ( 'Dec 31' ) );
					
					if ($hire_date > $year_end) {
						
						$arrperiodinsertvalidation ['100'] = 0;
						
					}
				}
				
				
				
				
				if (empty ( $termination_date ) || $termination_date == '0000-00-00') {
					
				
					
				} else {
					
					/**
					 * *Cannot be lesser than HireDate
					 * *
					 */
					if (empty ( $hire_date ) || $hire_date == '0000-00-00') {
						
					} else {
						
						if ($termination_date < $hire_date) {
							
							$arrperiodinsertvalidation ['101'] = 0;
							
						}
					}
				}
				
				
				if (empty ( $plan_class )) {
					
					$arrperiodinsertvalidation ['102'] = 0;
					
				}
				
				
				if (empty ( $status )) {
						$arrperiodinsertvalidation['103'] = 0;
						
				}
				
				
				$get_post_validation_errors = TblAcaValidationRules::find ()->select ( 'rule_id, error_message' )->where ( [ 
									'rule_id' => $validation_rule_ids 
				] )->All ();
				
				if (! empty ( $get_post_validation_errors )) {
					
					foreach ( $get_post_validation_errors as $errors ) {
						
						$post_validation_errors [$errors->rule_id] ['error_message'] = $errors->error_message;
						
					}
				}
				
				if (empty ( $arrperiodinsertvalidation ))
				{				
				// begin transaction
				$transaction = \Yii::$app->db->beginTransaction ();
				
				try {
					
				$individual_period_details->hire_date = $hire_date;
				$individual_period_details->termination_date = $termination_date;
				$individual_period_details->plan_class = $plan_class;
				$individual_period_details->status = $status;
				$individual_period_details->created_by = $logged_user_id;
				$individual_period_details->employee_id = $decrypt_payroll_id;
				
				
				if ($individual_period_details->save () && $individual_period_details->validate ()) 
				{

					TblAcaPayrollValidationLog::deleteAll ( 'company_id = :company_id AND employee_id = :employee_id AND validation_rule_id = :validation_rule_id', [ 
														':company_id' => $decrypt_company_id,
														':employee_id' => $decrypt_payroll_id,
														':validation_rule_id'=>147
												] );
					
					$transaction->commit();
					$result['success'] = 'Saved Successfully';

			
				} else {
						
						$arrerrors = $individual_period_details->getFirstErrors ();
						$errorstring = '';
						
						/**
						 * *****Converting error into string*******
						 */
						foreach ( $arrerrors as $key => $value ) {
							$errorstring .= $value . '<br>';
						}
						
						throw new \Exception ( $errorstring );
					}
				
				
				} 
				catch ( \Exception $e ) {
									
					$msg = $e->getMessage ();
					
					$result['exception'] = $msg;				
											
					// rollback transaction
					$transaction->rollback ();
									
									
								}
			}else{
				
				foreach ( $arrperiodinsertvalidation as $validation_rule_id => $is_validated ) {
															
					
						$arrperiodvalidation_errors[$validation_rule_id] ['error_message'] = $post_validation_errors [$validation_rule_id] ['error_message'];
				
					
				}
				
				$result['error'] = $arrperiodvalidation_errors;
				
			} 
				
				
				
				
				
			}

			
			return json_encode($result);
		
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
		
	}
	
	
		public function actionSaveenrollmentperiod()
	{
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			$coverage_start_date = '';
			$coverage_end_date = '';
			$person_type = '';
			$ssn = '';
			$dependent_dob = '';
			$dob = '';
			$encrypt_medical_id = '';
			$enrollment_period_clean_ssn= '';
			$arrperiodinsertvalidation =  array();
			$validation_rule_ids =  array();
			$post_validation_errors = array();
			$arrperiodvalidation_errors = array();
			$result = array();

			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			
			$validation_rule_ids = [ '127', '128', '129', '130', '131', '132', '133', '134', '135', '136', '137', '138', '139'];
					
					
			
			$get_details = \Yii::$app->request->post ();
		
			if(!empty($get_details['medical_id']))
			{
				$encrypt_medical_id =$get_details['medical_id'];
				$encrypt_company_id = $get_details['c_id'];
				
				$encrypt_component = new EncryptDecryptComponent ();
								
				$decrypt_medical_id = $encrypt_component->decryptUser ( $encrypt_medical_id );
				$decrypt_company_id = $encrypt_component->decryptUser ( $encrypt_company_id );
				
			}
			
			if(!empty($get_details['coverage_start_date']))
			{
				$coverage_start_date =$get_details['coverage_start_date'];
				
			}
			
			if(!empty($get_details['coverage_end_date']))
			{
				$coverage_end_date =$get_details['coverage_end_date'];
				
			}
			
			if(!empty($get_details['person_type']))
			{
				$person_type =$get_details['person_type'];
				
			}
			
			if(!empty($get_details['ssn']))
			{
				$ssn =$get_details['ssn'];
				
			}
			
			if(!empty($get_details['dependent_dob']))
			{
				$dependent_dob =$get_details['dependent_dob'];
				
			}
			
			if(!empty($get_details['dob']))
			{
				$dob =$get_details['dob'];
				
			}
			
			if(!empty($encrypt_medical_id))
			{
				$individual_period_details = new TblAcaMedicalEnrollmentPeriod();
				
				
				/**
				 * ********Can not be empty value***********
				 */
				
				if (empty ( $coverage_start_date ) || $coverage_start_date == '0000-00-00') {
					
					$arrperiodinsertvalidation ['127'] = 0;
				} else {
					
					/**
					 * ********Coverage start date can not be
					 * greater than 31st dec of the current year***********
					 */
					
					$year_end = date ( 'Y-m-d', strtotime ( 'Dec 31' ) );
					
					if ($coverage_start_date > $year_end) {
						
						$arrperiodinsertvalidation ['128'] = 0;
					}
					
					/**
					 * ********can not be greater than coverage end date***********
					 */
					
					if (! empty ( $coverage_end_date )) {
						if ($coverage_start_date > $coverage_end_date) {
							$arrperiodinsertvalidation ['129'] = 0;
						}
					}
				
				}
				
				
				
				
				
				
				/**
				 * *Need to be one of "Employee" or
				 * "Dependent of Employee" or
				 * "Non Employee enrolled", or
				 * "Dependent of non employee enrolled"
				 * *
				 */
				
				if (empty ( $person_type )) {
					$arrperiodinsertvalidation ['132'] = 0;
				}
				
				
				if (! empty ( $person_type ) && $person_type != 84 && $person_type != 87) {
				/**
				 * ********Can not be empty value***********
				 */
				if (empty ( $dependent_dob ))
				{
				if (empty ( $ssn )) {
					
					
					$arrperiodinsertvalidation ['134'] = 0;
					
					
				} else {
					
					/**
					 * ***SSN has to be a 9 digit number****
					 */
					// Replacing special characters from EIN
					
					$enrollment_period_clean_ssn = preg_replace ( '/[^0-9]/s', '', $ssn );
					if (strlen ( $enrollment_period_clean_ssn ) == 9) {
						
						/**
						 * ***SSN can not have all numbers same
						 * ( eg.
						 * 000-00-0000, 111-11-1111 etc)
						 * ****
						 */
						
						if (in_array ( $enrollment_period_clean_ssn, $this->arrinvalid_ssn )) {
							
							$arrperiodinsertvalidation['136'] = 0;
						}
					} else {
						
						$arrperiodinsertvalidation['135'] = 0;
					}
				}
				
				}
				}
				
				
				if (! empty ( $person_type ) && $person_type != 84 && $person_type != 87) {
					/**
					 * ********If person type is not
					 * employee and social
					 * is not entered
					 * this is required***********
					 */
					if (empty ( $ssn )) {
						
						if (empty ( $dependent_dob )) {
							
							$arrperiodinsertvalidation['137'] = 0;
						}
					}
				}
				
				
				/**
				 * *If use dependent dob
				 * is selected then DOB
				 * cannot be blank, can not
				 * give a future date
				 * *
				 */
				
				if (! empty ( $dependent_dob ) && $dependent_dob == 1 && (! empty ( $person_type )) && $person_type != 84 && $person_type != 87) {
					if (empty ( $dob )) {
						
						$arrperiodinsertvalidation ['138'] = 0;
					} else {
						
						/**
						 * ********Cannot be a future date***********
						 */
						if (date ( 'Y-m-d', strtotime ( $dob) ) > date ( 'Y-m-d' )) {
							
							$arrperiodinsertvalidation  ['139'] = 0;
						} else {
						}
					}
				}
				
				
				$get_post_validation_errors = TblAcaValidationRules::find ()->select ( 'rule_id, error_message' )->where ( [ 
									'rule_id' => $validation_rule_ids 
				] )->All ();
				
				if (! empty ( $get_post_validation_errors )) {
					
					foreach ( $get_post_validation_errors as $errors ) {
						
						$post_validation_errors [$errors->rule_id] ['error_message'] = $errors->error_message;
						
					}
				}
				
				
				if (empty ( $arrperiodinsertvalidation ))
				{				
				// begin transaction
				$transaction = \Yii::$app->db->beginTransaction ();
				
				try {
					
				$individual_period_details->coverage_start_date = $coverage_start_date;
				$individual_period_details->coverage_end_date = $coverage_end_date;
				$individual_period_details->person_type = $person_type;
				$individual_period_details->ssn = $enrollment_period_clean_ssn;
				$individual_period_details->dependent_dob = $dependent_dob;
				$individual_period_details->dob = $dob;
				
				$individual_period_details->created_by = $logged_user_id;
				$individual_period_details->employee_id = $decrypt_medical_id;
				
				
				if ($individual_period_details->save () && $individual_period_details->validate ()) 
				{

					TblAcaMedicalValidationLog::deleteAll ( 'company_id = :company_id AND employee_id = :employee_id AND validation_rule_id = :validation_rule_id', [ 
														':company_id' => $decrypt_company_id,
														':employee_id' => $decrypt_medical_id,
														':validation_rule_id'=>156
												] );
					
					$transaction->commit();
					$result['success'] = 'Saved Successfully';

			
				} else {
						
						$arrerrors = $individual_period_details->getFirstErrors ();
						$errorstring = '';
						
						/**
						 * *****Converting error into string*******
						 */
						foreach ( $arrerrors as $key => $value ) {
							$errorstring .= $value . '<br>';
						}
						
						throw new \Exception ( $errorstring );
					}
				
				
				} 
				catch ( \Exception $e ) {
									
					$msg = $e->getMessage ();
					
					$result['exception'] = $msg;				
											
					// rollback transaction
					$transaction->rollback ();
									
									
								}
			}else{
				
				foreach ( $arrperiodinsertvalidation as $validation_rule_id => $is_validated ) {
															
					
						$arrperiodvalidation_errors[$validation_rule_id] ['error_message'] = $post_validation_errors [$validation_rule_id] ['error_message'];
				
					
				}
				
				$result['error'] = $arrperiodvalidation_errors;
				
			} 
				
				
				
				
				
			}

			
			return json_encode($result);
		
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
		
	}
}