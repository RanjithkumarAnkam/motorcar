<?php

namespace app\modules\client\controllers;

use app\components\EncryptDecryptComponent;
use app\models\TblAcaLookupOptions;
use app\models\TblAcaPlanCoverageType;
use app\models\TblAcaCompanies;
use app\models\TblAcaMedicalData;
use app\models\TblAcaPayrollData;
use app\models\TblAcaMedicalEmploymentPeriod;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\TblAcaSharefileFolders;
use app\models\TblAcaSharefileEmployees;
use app\models\TblAcaMedicalEnrollmentPeriod;
use app\models\TblAcaCompareMedicalData;
use app\models\TblAcaGlobalSettings;
use app\models\TblAcaCompanyValidationStatus;
use app\models\TblAcaMedicalEnrollmentPeriodValidationLog;
use app\models\TblAcaMedicalValidationLog;
use app\models\TblAcaValidationLog;
use app\models\TblAcaBrands;
use app\models\TblAcaUsers;
use app\models\TblAcaStaffUsers;
use app\models\TblAcaCompanyUsers;
use app\models\TblAcaClients;

class MedicalController extends Controller {
	// public variables
	public $encoded_company_id = NULL;
	public $company_id = NULL;
	
	/*
	 * this is the default function which is use to render the payroll data to the view
	 */
	public function actionIndex() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
			
			/**
			 * Declaring session variables***
			 */
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			/**
			 * Get data from url*
			 */
			$get_company_id = \Yii::$app->request->get ();
			
			if (! empty ( $get_company_id )) {
				/**
				 * Get encrypted company id from URL*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = (new EncryptDecryptComponent ())->decryptUser ( $encrypt_company_id ); // decrypted company id
					$check_company_details = (new TblAcaCompanies ())->Companyuniquedetails ( $company_id ); // Checking if company exists with that company id
					if (! empty ( $check_company_details )) {
						$client_id = $check_company_details->client_id; // Company clien Id
					}
				}
				
				/**
				 * Security check if the company related to the particular
				 * user by checking if company and client is present in session array *
				 */
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$this->encoded_company_id = $_GET ['c_id'];
					
					// rendering the layout
					$this->layout = 'main';
					
					// collecting the company id from the url and decoding it
					$encrypt_component = new EncryptDecryptComponent ();
					$company_id = $encrypt_component->decryptUser ( $_GET ['c_id'] );
					
					$company_detals = TblAcaCompanies::find ()->select ( 'company_client_number,company_name' )->where ( [ 
							'company_id' => $company_id 
					] )->one ();
					
					return $this->render ( 'index', array (
							'company_id' => $company_id,
							'encoded_company_id' => $_GET ['c_id'],
							'company_detals' => $company_detals 
					) );
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
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	
	/**
	 * This function is used to return the payroll data based on the company id
	 */
	public function actionMedicaldata() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
		                                                           
			// check for the company id post
			if (! empty ( $_POST ['c_id'] )) {
				$this->encoded_company_id = $_POST ['c_id'];
				// collecting the company id from the post and decoding it
				$company_id = EncryptDecryptComponent::decryptUser ( $_POST ['c_id'] );
				
				$objMedicalData = new TblAcaMedicalEnrollmentPeriod ();
				// calling the model function to collect all the employess specific to company id
				$employees = $objMedicalData->medicaldata ( $company_id );
				
				// initialising
				$employee_data = array ();
				
				// creating an array of employees as required for dx data grid
				foreach ( $employees as $employee ) {
					
					$data = array ();
					$emp_period_data = array ();
					
					$data = $objMedicalData->medicalenrollmentdata ( $employee ['employee_id'] );
					
					/**
					 * this loop is used to change the format of the date*
					 */
					foreach ( $data as $value ) {
						
						// change the date format for coverage_start_date column
						if ($value ['coverage_start_date'] && $value ['coverage_start_date']!='0000-00-00'){
							$value ['coverage_start_date'] = date ( "m/d/Y", strtotime ( $value ['coverage_start_date'] ) );
						}else{
							$value ['coverage_start_date']='';
						}
							// change the date format for coverage_end_date column
						if ($value ['coverage_end_date'] && $value ['coverage_end_date']!='0000-00-00'){
							$value ['coverage_end_date'] = date ( "m/d/Y", strtotime ( $value ['coverage_end_date'] ) );
						}else{
							$value ['coverage_end_date']='';
						}	
							// change the date format for dob column
						if ($value ['dob'] && $value ['dob']!='0000-00-00'){
							$value ['dob'] = date ( "m/d/Y", strtotime ( $value ['dob'] ) );
						}else{
							$value ['dob']='';
						}	
							// push that array into $emp_period_data array
						array_push ( $emp_period_data, $value );
					}
					
					// change the date format for dob column
					if ($employee ['dob'] && $employee ['dob']!='0000-00-00'){
						$employee ['dob'] = date ( "m/d/Y", strtotime ( $employee ['dob'] ) );
					}else{
							$employee ['dob']='';
						}
					$employee ['employmentperiods'] = $emp_period_data;
					
					array_push ( $employee_data, $employee );
				}
				
				// convering the array to json
				$employees_data = Json::encode ( $employee_data );
				
				$arrempployes = array ();
				$arrempployes ['employ'] = $employees_data;
				
				// collecting the suffixes
				$encoded_suffix = Json::encode ( (new TblAcaPayrollData ())->Suffixes () );
				$arrempployes ['suffix'] = $encoded_suffix;
				
				// collecting the plan classes
				$arrempployes ['planclass'] = Json::encode ( (new TblAcaMedicalEnrollmentPeriod ())->persontype () );
				
				// returning the response
				return Json::encode ( $arrempployes );
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	
	/**
	 * This function is used to commit the new employee details in the database
	 */
	public static function actionNewemployee() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
		                                                           
			// check for the data post
			if (! empty ( $_POST ['newdata'] )) {
				
				// assiging Posted values to the variables
				$data = $_POST ['newdata'];
				
				$company_id = EncryptDecryptComponent::decryptUser ( $_POST ['company_id'] );
				$check_company_details = TblAcaCompanies::find ()->where ( [ 
						'company_id' => $company_id 
				] )->One ();
				// collecting the loged user id from the session
				$logged_user = \Yii::$app->session->get ( 'client_user_id' );
				
				$response = array ();
				
				$first_name = $data ['first_name'];
				$last_name = $data ['last_name'];
				$ssn = $data ['ssn'];
				
				// $sql = "SELECT employee_id FROM tbl_aca_medical_data WHERE ssn = '" . $ssn . "' AND company_id='".$company_id."'";
				// $record_exist = TblAcaMedicalData::findBySql ( $sql )->one ();
				
				$record_exist = TblAcaMedicalData::find ()->select ( 'employee_id' )->where ( [ 
						'ssn' => $ssn,
						'company_id' => $company_id 
				] )->one ();
				
				// check for duplicate entry
				if (empty ( $record_exist ['employee_id'] )) {
					
					// initialising the model
					$model = new TblAcaMedicalData ();
					$model_validation_log = new TblAcaValidationLog ();
					
					$model->company_id = $company_id;
					
					// assiging the values to the model based on the condition
					if (isset ( $data ['first_name'] ) && $data ['first_name'] != '')
						$model->first_name = strip_tags ( $data ['first_name'] );
					
					if (isset ( $data ['middle_name'] ) && $data ['middle_name'] != '')
						$model->middle_name = strip_tags ( $data ['middle_name'] );
					
					if (isset ( $data ['last_name'] ) && $data ['last_name'] != '')
						$model->last_name = strip_tags ( $data ['last_name'] );
					
					if (isset ( $data ['suffix'] ) && $data ['suffix'] != '')
						$model->suffix = $data ['suffix'];
					
					if (isset ( $data ['ssn'] ) && $data ['ssn'] != '')
						$model->ssn = $data ['ssn'];
					
					if (isset ( $data ['address1'] ) && $data ['address1'] != '')
						$model->address1 = strip_tags ( $data ['address1'] );
					
					if (isset ( $data ['apt_suite'] ) && $data ['apt_suite'] != '')
						$model->apt_suite = strip_tags ( $data ['apt_suite'] );
					
					if (isset ( $data ['city'] ) && $data ['city'] != '')
						$model->city = $data ['city'];
					
					if (isset ( $data ['state'] ) && $data ['state'] != '')
						$model->state = $data ['state'];
					
					if (isset ( $data ['zip'] ) && $data ['zip'] != '')
						$model->zip = $data ['zip'];
					
					if (isset ( $data ['dob'] ) && $data ['dob'] != '') {
						$model->dob = $data ['dob'];
					} else {
						$model->dob = '';
					}
					
					if (isset ( $data ['notes'] ) && $data ['notes'] != '')
						$model->notes = strip_tags ( $data ['notes'] );
					
					$model->created_by = $logged_user;
					
					/**
					 * transaction block for the sql transactions to the database
					 */
					
					$connection = \yii::$app->db;
					
					// starting the transaction
					$transaction = $connection->beginTransaction ();
					
					// try block
					try {
						// validating the model and saving the model
						if ($model->validate () && $model->save ()) {
							
							/**
							 * *Delete all previous validations from DB**
							 */
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
							
							TblAcaMedicalValidationLog::deleteAll ( 'company_id = :company_id', [ 
									':company_id' => $company_id 
							] );
							
							TblAcaMedicalEnrollmentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
									':company_id' => $company_id 
							] );
							
							$model_company_validation_log = TblAcaCompanyValidationStatus::find ()->where ( [ 
									'company_id' => $company_id 
							] )->one ();
							
							if (! empty ( $model_company_validation_log )) {
								$model_company_validation_log->is_initialized = 0;
								$model_company_validation_log->is_executed = 0;
								$model_company_validation_log->is_completed = 0;
								
								$model_company_validation_log->is_medical_data = 0;
								$model_company_validation_log->save ();
								
								// update company status
								$check_company_details->reporting_status = 29;
								$check_company_details->save ();
							}
							
							$model_validation_log->company_id = $company_id;
							$model_validation_log->validation_rule_id = 142;
							$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
							$model_validation_log->is_validated = 1;
							$model_validation_log->save ();
							
							// commiting the model
							$transaction->commit ();
							
							$response ['status'] = 1;
							$response ['message'] = 'success';
						}
					} catch ( Exception $e ) {
						$msg = $e->getMessage ();
						$response ['status'] = 0;
						$response ['message'] = $msg;
						// rollbacking the transaction
						$transaction->rollback ();
					}
				} else {
					$response ['status'] = 2;
					$response ['message'] = 'Record already exist with the same SSN';
				}
				
				// returning the response
				echo json_encode ( $response );
			}
		} else {
			
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	
	/**
	 * This function is used to update the particula employee details and commit in the database
	 */
	public function actionUpdateemployee() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
		                                                           
			// check for the data post
			if (! empty ( $_POST ['newdata'] )) {
				
				// assiging Posted values to the variables
				$newdata = $_POST ['newdata'];
				
				$olddata = $_POST ['olddata'];
				// print_r($_POST); die();
				$company_id = EncryptDecryptComponent::decryptUser ( $_POST ['company_id'] );
				$check_company_details = TblAcaCompanies::find ()->where ( [ 
						'company_id' => $company_id 
				] )->One ();
				// collecting the loged user id from the session
				$logged_user = \Yii::$app->session->get ( 'client_user_id' );
				
				// initialising the model
				$model = TblAcaMedicalData::findOne ( [ 
						'employee_id' => $olddata ['employee_id'],
						'company_id' => $company_id 
				] );
				
				$existing_ssn = false;
				
				if (! empty ( $newdata ['ssn'] )) {
					// print_r($model); die();
					$ssn = $newdata ['ssn'];
					
					$ssn_exist = TblAcaMedicalData::find ()->select ( 'first_name' )->where ( 'ssn = :ssn AND company_id = :company_id AND employee_id !=:employee_id', [ 
							'ssn' => $ssn,
							'company_id' => $company_id,
							'employee_id' => $model->employee_id 
					] )->one ();
					
					// print_r($sql); die();
					if (! empty ( $ssn_exist->first_name )) {
						$existing_ssn = true;
					}
				}
				
				if (! $existing_ssn) {
					
					$model_validation_log = new TblAcaValidationLog ();
					// $model->company_id = $comapny_id;
					
					// assiging the values to the model based on the condition
					if (isset ( $newdata ['first_name'] ) && $newdata ['first_name'] != '')
						$model->first_name = $newdata ['first_name'];
					
					if (isset ( $newdata ['middle_name'] ))
						$model->middle_name = $newdata ['middle_name'];
					
					if (isset ( $newdata ['last_name'] ) && $newdata ['last_name'] != '')
						$model->last_name = $newdata ['last_name'];
					
					if (isset ( $newdata ['suffix'] ))
						$model->suffix = $newdata ['suffix'];
					
					if (isset ( $newdata ['ssn'] ) && $newdata ['ssn'] != '')
						$model->ssn = $newdata ['ssn'];
					
					if (isset ( $newdata ['address1'] ))
						$model->address1 = $newdata ['address1'];
					
					if (isset ( $newdata ['apt_suite'] ))
						$model->apt_suite = $newdata ['apt_suite'];
					
					if (isset ( $newdata ['city'] ))
						$model->city = $newdata ['city'];
					
					if (isset ( $newdata ['state'] ))
						$model->state = $newdata ['state'];
					
					if (isset ( $newdata ['zip'] ))
						$model->zip = $newdata ['zip'];
					
					if (isset ( $newdata ['dob'] ))
						$model->dob = $newdata ['dob'];
					
					if (isset ( $newdata ['notes'] ))
						$model->notes = $newdata ['notes'];
					
					$model->created_by = $logged_user;
					
					/**
					 * transaction block for the sql transactions to the database
					 */
					
					$connection = \yii::$app->db;
					
					// starting the transaction
					$transaction = $connection->beginTransaction ();
					
					// initialising
					$response = array ();
					// print_r($model); die();
					// try block
					try {
						// validating the model and saving the model
						if ($model->validate () && $model->save ()) {
							
							/**
							 * *Delete all previous validations from DB**
							 */
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
							
							TblAcaMedicalValidationLog::deleteAll ( 'company_id = :company_id', [ 
									':company_id' => $company_id 
							] );
							
							TblAcaMedicalEnrollmentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
									':company_id' => $company_id 
							] );
							
							$model_company_validation_log = TblAcaCompanyValidationStatus::find ()->where ( [ 
									'company_id' => $company_id 
							] )->one ();
							
							if (! empty ( $model_company_validation_log )) {
								$model_company_validation_log->is_initialized = 0;
								$model_company_validation_log->is_executed = 0;
								$model_company_validation_log->is_completed = 0;
								
								$model_company_validation_log->is_medical_data = 0;
								$model_company_validation_log->save ();
								
								// update company status
								$check_company_details->reporting_status = 29;
								$check_company_details->save ();
							}
							
							$model_validation_log->company_id = $company_id;
							$model_validation_log->validation_rule_id = 142;
							$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
							$model_validation_log->is_validated = 1;
							$model_validation_log->save ();
							
							// commiting the model
							$transaction->commit ();
							
							$response ['status'] = 1;
							$response ['message'] = 'Updated successfully';
						}
					} catch ( Exception $e ) {
						$msg = $e->getMessage ();
						$response ['status'] = 0;
						$response ['message'] = $msg;
						// rollbacking the transaction
						$transaction->rollback ();
					}
				} else {
					$response ['status'] = 2;
					$response ['message'] = 'Record already exists with the same ssn';
				}
				
				// returning the response
				echo json_encode ( $response );
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	
	/**
	 * This function is used to delete the particular employee details from the database
	 */
	public function actionDeletepayrollemployee() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
		                                                           
			// check for the data post
			if (! empty ( $_POST ['record'] )) {
				
				// assiging Posted values to the variables
				$data = $_POST ['record'];
				
				// initialising the model
				
				$model = TblAcaMedicalData::findOne ( [ 
						'employee_id' => $data ['employee_id'] 
				] );
				$model_validation_log = new TblAcaValidationLog ();
				
				$employment_model = TblAcaMedicalEnrollmentPeriod::deleteAll ( [ 
						'employee_id' => $data ['employee_id'] 
				] );
				
				// print_r($employment_model); die();
				
				/**
				 * transaction block for the sql transactions to the database
				 */
				
				$connection = \yii::$app->db;
				
				// starting the transaction
				$transaction = $connection->beginTransaction ();
				
				// initialising
				$response = array ();
				
				// try block
				try {
					
					// validating the model and saving the model
					if ($model->delete ()) {
						
						TblAcaMedicalValidationLog::deleteAll ( 'company_id = :company_id AND employee_id = :employee_id', [ 
								':company_id' => $model->company_id,
								':employee_id' => $data ['employee_id'] 
						] );
						
						TblAcaMedicalEnrollmentPeriodValidationLog::deleteAll ( 'company_id = :company_id AND employee_id = :employee_id', [ 
								':company_id' => $model->company_id,
								'employee_id' => $data ['employee_id'] 
						] );
						
						$medical_data = TblAcaMedicalData::find ()->select ( 'employee_id' )->where ( [ 
								'company_id' => $model->company_id 
						] )->Count ();
						
						$plan_class_data = TblAcaPlanCoverageType::find ()->select ( 'plan_class_id' )->where ( [ 
								'company_id' => $model->company_id,
								'plan_offer_type' => 1 
						] )->One ();
						
						if ($medical_data == 0) {
							TblAcaValidationLog::deleteAll ( [ 
									'and',
									'company_id  = :company_id',
									[ 
											'in',
											'validation_rule_id',
											142 
									] 
							], [ 
									':company_id' => $model->company_id 
							] );
							
							$model_validation_log->company_id = $model->company_id;
							$model_validation_log->validation_rule_id = 142;
							$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
							
							if (! empty ( $plan_class_data )) {
								$model_validation_log->is_validated = 0;
							} else {
								$model_validation_log->is_validated = 1;
							}
							
							$model_validation_log->save ();
						}
						
						// commiting the model
						$transaction->commit ();
						
						$response ['status'] = 1;
						$response ['message'] = 'Deleted successfully';
					}
				} catch ( Exception $e ) {
					$msg = $e->getMessage ();
					$response ['status'] = 0;
					$response ['message'] = $msg;
					// rollbacking the transaction
					$transaction->rollback ();
				}
				
				// returning the response
				echo json_encode ( $response );
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	
	/**
	 * This function is used to add the employment period of the particular employee details
	 * and commit in the database
	 */
	public function actionAddemploymentperiod() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
		                                                           // check for the data post
			if (! empty ( $_POST ['employee_details'] )) {
				
				// assiging Posted values to the variables
				$employee_details = $_POST ['employee_details'];
				
				$data = $_POST ['record'];
				
				// collecting the loged user id from the session
				$logged_user = \Yii::$app->session->get ( 'client_user_id' );
				
				// initialising the model
				$model = new TblAcaMedicalEnrollmentPeriod ();
				
				$model_validation_log = new TblAcaValidationLog ();
				
				$check_payroll = TblAcaMedicalData::findOne ( [ 
						'employee_id' => $employee_details ['employee_id'] 
				]
				 );
				$company_id = $check_payroll->company_id;
				$check_company_details = TblAcaCompanies::find ()->where ( [ 
						'company_id' => $company_id 
				] )->One ();
				
				$model->employee_id = $employee_details ['employee_id'];
				
				// assiging the values to the model based on the condition
				if (isset ( $data ['coverage_start_date'] ) && $data ['coverage_start_date'] != '')
					$model->coverage_start_date = date ( 'Y-m-d', strtotime ( $data ['coverage_start_date'] ) );
				
				if (isset ( $data ['coverage_end_date'] ) && $data ['coverage_end_date'] != '')
					$model->coverage_end_date = date ( 'Y-m-d', strtotime ( $data ['coverage_end_date'] ) );
				
				if (isset ( $data ['person_type'] ) && $data ['person_type'] != '')
					$model->person_type = $data ['person_type'];
				
				if (isset ( $data ['ssn'] ) && $data ['ssn'] != '')
					$model->ssn = $data ['ssn'];
				
				if (isset ( $data ['dob'] ) && $data ['dob'] != '')
					$model->dob = date ( 'Y-m-d', strtotime ( $data ['dob'] ) );
				
				if (isset ( $data ['notes'] ) && $data ['notes'] != '')
					$model->notes = $data ['notes'];
				
				if (isset ( $data ['dependent_dob'] ) && $data ['dependent_dob'] != '')
					$model->dependent_dob = $data ['dependent_dob'] == "true" ? 1 : null;
				
				$model->created_by = $logged_user;
				
				/**
				 * transaction block for the sql transactions to the database
				 */
				
				$connection = \yii::$app->db;
				
				// starting the transaction
				$transaction = $connection->beginTransaction ();
				
				$response = array ();
				
				// try block
				try {
					// validating the model and saving the model
					if ($model->validate () && $model->save ()) {
						
						/**
						 * *Delete all previous validations from DB**
						 */
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
						
						TblAcaMedicalValidationLog::deleteAll ( 'company_id = :company_id', [ 
								':company_id' => $company_id 
						] );
						
						TblAcaMedicalEnrollmentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
								':company_id' => $company_id 
						] );
						
						$model_company_validation_log = TblAcaCompanyValidationStatus::find ()->where ( [ 
								'company_id' => $company_id 
						] )->one ();
						
						if (! empty ( $model_company_validation_log )) {
							$model_company_validation_log->is_initialized = 0;
							$model_company_validation_log->is_executed = 0;
							$model_company_validation_log->is_completed = 0;
							
							$model_company_validation_log->is_medical_data = 0;
							$model_company_validation_log->save ();
							
							// update company status
							$check_company_details->reporting_status = 29;
							$check_company_details->save ();
						}
						
						$model_validation_log->company_id = $company_id;
						$model_validation_log->validation_rule_id = 142;
						$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
						$model_validation_log->is_validated = 1;
						$model_validation_log->save ();
						
						// commiting the model
						$transaction->commit ();
						
						$response ['status'] = 1;
						$response ['message'] = 'New enrollment record added successfully';
					}
				} catch ( Exception $e ) {
					$msg = $e->getMessage ();
					$response ['status'] = 0;
					$response ['message'] = $msg;
					// rollbacking the transaction
					$transaction->rollback ();
				}
				
				// returning the response
				echo json_encode ( $response );
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	
	/**
	 * This function is used to update the employment period of the particular employee details
	 * and commit in the database
	 */
	public function actionUpdateemploymentperiod() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
		                                                           // check for the data post
			if (! empty ( $_POST ['oldrecord'] )) {
				
				// assiging Posted values to the variables
				$olddata = $_POST ['oldrecord'];
				
				$data = $_POST ['newrecord'];
				
				// collecting the loged user id from the session
				$logged_user = \Yii::$app->session->get ( 'client_user_id' );
				
				// initialising the model
				$model = TblAcaMedicalEnrollmentPeriod::findOne ( [ 
						'period_id' => $olddata ['period_id'] 
				] );
				
				$model_validation_log = new TblAcaValidationLog ();
				
				$check_payroll = TblAcaMedicalData::findOne ( [ 
						'employee_id' => $model->employee_id 
				]
				 );
				$company_id = $check_payroll->company_id;
				$check_company_details = TblAcaCompanies::find ()->where ( [ 
						'company_id' => $company_id 
				] )->One ();
				
				// assiging the values to the model based on the condition
				if (isset ( $data ['coverage_start_date'] ) && $data ['coverage_start_date'] != '')
					$model->coverage_start_date = date ( 'Y-m-d', strtotime ( $data ['coverage_start_date'] ) );
				
				if (isset ( $data ['coverage_end_date'] ))
					$model->coverage_end_date = date ( 'Y-m-d', strtotime ( $data ['coverage_end_date'] ) );
				
				if (isset ( $data ['person_type'] ))
					$model->person_type = $data ['person_type'];
				
				if (isset ( $data ['ssn'] ))
					$model->ssn = $data ['ssn'];
				
				if (isset ( $data ['dob'] ))
					$model->dob = date ( 'Y-m-d', strtotime ( $data ['dob'] ) );
				
				if (isset ( $data ['notes'] ))
					$model->notes = $data ['notes'];
				
				if (isset ( $data ['dependent_dob'] ))
					$model->dependent_dob = $data ['dependent_dob'] == "true" ? 1 : null;
				
				$model->modified_by = $logged_user;
				
				$model->modified_date = date ( 'Y-m-d H:i:s' );
				
				/**
				 * transaction block for the sql transactions to the database
				 */
				
				$connection = \yii::$app->db;
				
				// starting the transaction
				$transaction = $connection->beginTransaction ();
				
				$response = array ();
				
				// try block
				try {
					// validating the model and saving the model
					if ($model->validate () && $model->save ()) {
						
						/**
						 * *Delete all previous validations from DB**
						 */
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
						
						TblAcaMedicalValidationLog::deleteAll ( 'company_id = :company_id', [ 
								':company_id' => $company_id 
						] );
						
						TblAcaMedicalEnrollmentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
								':company_id' => $company_id 
						] );
						
						$model_company_validation_log = TblAcaCompanyValidationStatus::find ()->where ( [ 
								'company_id' => $company_id 
						] )->one ();
						
						if (! empty ( $model_company_validation_log )) {
							$model_company_validation_log->is_initialized = 0;
							$model_company_validation_log->is_executed = 0;
							$model_company_validation_log->is_completed = 0;
							
							$model_company_validation_log->is_medical_data = 0;
							$model_company_validation_log->save ();
							
							// update company status
							$check_company_details->reporting_status = 29;
							$check_company_details->save ();
						}
						
						$model_validation_log->company_id = $company_id;
						$model_validation_log->validation_rule_id = 142;
						$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
						$model_validation_log->is_validated = 1;
						$model_validation_log->save ();
						
						// commiting the model
						$transaction->commit ();
						$response ['status'] = 1;
						$response ['message'] = 'Enrollment record updated successfully';
					}
				} catch ( Exception $e ) {
					$msg = $e->getMessage ();
					$response ['status'] = 0;
					$response ['message'] = $msg;
					// rollbacking the transaction
					$transaction->rollback ();
				}
				
				// returning the response
				echo json_encode ( $response );
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	
	/**
	 * This function is used to delete the employment period of the particular employee details
	 * and commit in the database
	 */
	public function actionDeleteemploymentperiod() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
		                                                           // check for the data post
			if (! empty ( $_POST ['record'] )) {
				
				// assiging Posted values to the variables
				$data = $_POST ['record'];
				
				// collecting the loged user id from the session
				$logged_user = \Yii::$app->session->get ( 'client_user_id' );
				
				// initialising the model
				$model = TblAcaMedicalEnrollmentPeriod::findOne ( [ 
						'period_id' => $data ['period_id'] 
				] );
				
				$check_payroll = TblAcaMedicalData::findOne ( [ 
						'employee_id' => $model->employee_id 
				]
				 );
				$company_id = $check_payroll->company_id;
				$check_company_details = TblAcaCompanies::find ()->where ( [ 
						'company_id' => $company_id 
				] )->One ();
				/**
				 * transaction block for the sql transactions to the database
				 */
				
				$connection = \yii::$app->db;
				
				// starting the transaction
				$transaction = $connection->beginTransaction ();
				
				$response = array ();
				
				// try block
				try {
					// validating the model and saving the model
					if ($model->delete ()) {
						
						
						TblAcaMedicalValidationLog::deleteAll ( 'company_id = :company_id', [ 
								':company_id' => $company_id 
						] );
						
						TblAcaMedicalEnrollmentPeriodValidationLog::deleteAll ( 'company_id = :company_id AND employee_id = :employee_id AND period_id = :period_id', [ 
								':company_id' => $company_id,
								'employee_id' => $data ['employee_id'],
								'period_id' => $data ['period_id'] 
						] );
						
						
						$model_company_validation_log = TblAcaCompanyValidationStatus::find ()->where ( [ 
								'company_id' => $company_id 
						] )->one ();
						
						if (! empty ( $model_company_validation_log )) {
							$model_company_validation_log->is_initialized = 0;
							$model_company_validation_log->is_executed = 0;
							$model_company_validation_log->is_completed = 0;
							
							$model_company_validation_log->is_medical_data = 0;
							$model_company_validation_log->save ();
							
							// update company status
							$check_company_details->reporting_status = 29;
							$check_company_details->save ();
						}
						
						
						
						// commiting the model
						$transaction->commit ();
						$response ['status'] = 1;
						$response ['message'] = 'Employment record deleted successfully';
					}
				} catch ( Exception $e ) {
					
					$msg = $e->getMessage ();
					$response ['status'] = 0;
					$response ['message'] = $msg;
					// rollbacking the transaction
					$transaction->rollback ();
				}
				
				// returning the response
				echo json_encode ( $response );
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	
	/*
	 * this function is used to upload the employee details into the payroll table
	 */
	public function actionUploademployees() {
		$session = \Yii::$app->session;
		
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
			
			/**
			 * Declaring session variables***
			 */
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			/**
			 * Get data from url*
			 */
			$get_company_id = \Yii::$app->request->get ();
			
			if (! empty ( $get_company_id )) {
				/**
				 * Get encrypted company id from URL*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = (new EncryptDecryptComponent ())->decryptUser ( $encrypt_company_id ); // decrypted company id
					$check_company_details = (new TblAcaCompanies ())->Companyuniquedetails ( $company_id ); // Checking if company exists with that company id
					if (! empty ( $check_company_details )) {
						$client_id = $check_company_details->client_id; // Company clien Id
						$company_client_number = $check_company_details->company_client_number;
					}
				}
				
				/**
				 * Security check if the company related to the particular
				 * user by checking if company and client is present in session array *
				 */
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$this->encoded_company_id = $_GET ['c_id'];
					
					$company_id = EncryptDecryptComponent::decryptUser ( $_GET ['c_id'] );
					
					// rendering the main
					$this->layout = 'main';
					
					// initialsing the model
					$model_employee = new TblAcaMedicalData ();
					$model_enrollment_period = new TblAcaMedicalEnrollmentPeriod ();
					$model_compare_medicaldata = new TblAcaCompareMedicalData ();
					$model_validation_log = new TblAcaValidationLog ();
					
					// check for file post
					if (! empty ( $_FILES ['TblAcaMedicalData'] ['tmp_name'] ['employee_id'] )) {
						
						$info = pathinfo ( $_FILES ['TblAcaMedicalData'] ['name'] ['employee_id'] );
						$date_time = '';
						if (isset ( $_POST ['new_file_name'] )) {
							$date_time = $_POST ['new_file_name'];
						}
						
						$file_extension = strtolower ( strrchr ( $_FILES ['TblAcaMedicalData'] ['name'] ['employee_id'], '.' ) );
						
						// $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
						
						// check for csv file
						$no_file_size_error = false;
						if (! empty ( $_FILES ['TblAcaMedicalData'] ['size'] ['employee_id'] )) {
							$file_size = ($_FILES ['TblAcaMedicalData'] ['size'] ['employee_id'] / (1024 * 1024));
							// echo $_FILES['TblAcaPayrollData']['size']['employee_id'].'-------'.$file_size; die();
							
							if ($file_size > 6) {
								$session->setFlash ( 'error', "Please select a file size which is below 5mb" );
							} else {
								$no_file_size_error = true;
							}
						}
						
						if ($file_extension == '.csv' && $no_file_size_error == true) {
							
							$file = UploadedFile::getInstance ( $model_employee, 'employee_id' );
							
							if ($file != '') {
								
								// genrating random file name
								// $file_name=rand(5,20).'.csv';
								// $fileName1 = $info['filename'].'_'.$date_time. '.csv';
								$fileName1 = $info ['filename'] . '_' . date ( 'd' ) . '-' . date ( 'M' ) . '-' . date ( 'Y' ) . '_' . date ( 'H' ) . 'h ' . date ( 'i' ) . 'm ' . date ( 's' ) . 's.csv';
								
								// file name
								// $fileName1 = "{$file_name}";
								
								$folder_name = 'csv_upload';
								
								if (empty ( $session ['csv_file_name'] )) {
									
									$session ['csv_file_name'] = $fileName1;
								} else {
									$webroot = getcwd ();
									
									$file_delete = $webroot . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'csv' . DIRECTORY_SEPARATOR . $folder_name . DIRECTORY_SEPARATOR . $session ['csv_file_name'];
									
									if (file_exists ( $file_delete )) {
										// deleting the file
										unlink ( $file_delete );
									}
								}
								
								TblAcaCompareMedicalData::deleteAll ( [ 
										'session_id' => $_COOKIE ["PHPSESSID"] 
								] );
								
								$session ['csv_file_name'] = $fileName1;
								
								// saving files in files/csv/csv_upload/..
								if (! is_dir ( getcwd () . '/files/csv/' . $folder_name )) {
									$old = umask ( 0 );
									mkdir ( getcwd () . '/files/csv/' . $folder_name, 0777, true );
									umask ( $old );
								}
								if ($fileName1)
									$file->saveAs ( getcwd () . '/files/csv/' . $folder_name . '/' . $fileName1 );
							}
							
							// $session["file-name"] = $fileName1;
							
							$webroot = getcwd ();
							
							$file = $webroot . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'csv' . DIRECTORY_SEPARATOR . $folder_name . DIRECTORY_SEPARATOR . $fileName1;
							
							$fp = fopen ( $file, 'r' );
							
							if ($fp) {
								$line = array ();
								$line = fgetcsv ( $fp, 1000, "," );
								
								// initialising the variables
								$CLEAN_GET = array ();
								
								$first_time = true;
								$x = 0; // this is for employee record
								$y = 0; // this is for employement record
								$r = 0;
								$v = 0;
								$result_count = $count = $InsertedCount = 0;
								$m = 1;
								$f = 1;
								$record_count = '';
								$record_count_first = '';
								$NotInsertedRecord = '';
								$existingRecords = 0;
								$linenumber = 0;
								$Total_records = 0;
								$or_info = 0;
								
								$model_user = '';
								$model_agents = '';
								$model_agent_alloc = '';
								
								$search = array (
										"\\",
										"\x00",
										"\n",
										"\r",
										"'",
										'"',
										"\x1a",
										"-" 
								);
								$replace = array (
										"\\\\",
										"\\0",
										"\\n",
										"\\r",
										"\'",
										'\"',
										"\\Z",
										"" 
								);
								
								echo 'Upload in process please wait.';
								
								$values = [ 
										"first_name",
										"middle_name",
										"last_name",
										"suffix",
										"ssn",
										"address1",
										"apt_suite",
										"city",
										"state",
										"zip",
										"dob",
										"notes",
										"hire_date",
										"temination_date",
										"plan_class",
										"status",
										"waiting_period" 
								];
								
								try {
									
									$connection = \Yii::$app->db;
									// begining the transaction
									$transaction = $connection->beginTransaction ();
									
									do {
										if (! empty ( $line )) {
											
											$count ++;
											
											// used to check for skipping first and second line
											if ($first_time == true || $count == 2) {
												$first_time = false;
												continue;
											}
											/*
											 * if ($count > 2500) { sleep ( 1 ); $count = 0; echo "."; flush (); }
											 */
											$linenumber ++;
											
											$first_name = '';
												$last_name = '';
												$ssn = '';
												$record_exist = array ();
												
												$first_name = strip_tags ( preg_replace ( '/[^a-z]/i', '', $line [0] ) );
												$last_name = strip_tags ( preg_replace ( '/[^a-z]/i', '', $line [2] ) );
												$ssn = strip_tags ( preg_replace ( '/\D/', '', $line [4] ) );
												$ssn_length = strlen ( $ssn );
												
											// check for first name and last name of the employee
											if (! (empty ( $first_name ) || empty ( $last_name ) || empty ( $ssn ))) {
												
												
												if ($ssn_length > 1 && $ssn_length < 10) {
													$record_exist = TblAcaMedicalData::find ()->select ( 'employee_id' )->where ( 'ssn = :ssn AND company_id = :company_id', [ 
															'ssn' => $ssn,
															'company_id' => $company_id 
													] )->one ();
												} else {
													$ssn = '';
												}
												
												// echo "<pre/>";
												
												// check for duplicate entry
												if (empty ( $record_exist ['employee_id'] ) && $ssn != '') {
													// from session
													
													$logged_id = $session->get ( 'client_user_id' );
													
													$model_employee->created_by = $logged_id;
													$model_employee->company_id = $company_id;
													
													$model_employee->employee_id = NULL; // primary key(auto increment id) id
													$model_employee->isNewRecord = true;
													
													if (! empty ( $line [0] )) {
														$model_employee->first_name = substr ( $first_name, 0, 25 );
													}
													
													if (! empty ( $line [1] )) {
														$model_employee->middle_name = substr ( strip_tags ( preg_replace ( '/[^a-z]/i', '', $line [1] ) ), 0, 2 );
													}
													
													if (! empty ( $line [2] )) {
														$model_employee->last_name = substr ( $last_name, 0, 25 );
													}
													
													if (! empty ( $line [3] )) {
														$suffix = strtolower ( preg_replace ( '/[^A-Za-z0-9\-]/', '', $line [3] ) );
														if ($suffix != '') {
															// query to get he suffix id from look up options table
															// $sql = "SELECT lookup_id FROM tbl_aca_lookup_options WHERE LCASE(lookup_value) LIKE '%" . $suffix . "%' AND code_id=7 ";
															// $resp = TblAcaLookupOptions::findBySql ( $sql )->one ();
															// echo $suffix;
															$resp = TblAcaLookupOptions::find ()->select ( 'lookup_id' )->where ( 'LCASE(lookup_value) LIKE :suffix AND code_id = :code_id', [ 
																	'suffix' => '%' . $suffix,
																	'code_id' => 7 
															] )
												//->andFilterWhere(['LCASE(lookup_value) LIKE "%:suffix%"'])
												->one();
															
															if (! empty ( $resp->lookup_id )) {
																$model_employee->suffix = $resp->lookup_id;
															}
														}
													}
													
													if (! empty ( $line [4] )) {
														
														if ($ssn_length > 1 && $ssn_length < 10) {
															$model_employee->ssn = $ssn;
														}
													}
													
													if (! empty ( $line [5] )) {
														$model_employee->address1 = substr ( strip_tags ( preg_replace ( '/[^A-Za-z0-9 \-]/', '', $line [5] ) ), 0, 100 );
													}
													
													if (! empty ( $line [6] )) {
														$model_employee->apt_suite = substr ( strip_tags ( preg_replace ( '/[^A-Za-z0-9 \-]/', '', $line [6] ) ), 0, 100 );
													}
													
													if (! empty ( $line [7] )) {
														$model_employee->city = substr ( strip_tags ( strtoupper ( preg_replace ( '/[^a-z ]/i', '', $line [7] ) ) ), 0, 25 );
													}
													
													if (! empty ( $line [8] )) {
														
														$model_employee->state = substr ( strip_tags ( strtoupper ( preg_replace ( '/[^a-z]/i', '', $line [8] ) ) ), 0, 2 );
													}
													
													if (! empty ( $line [9] )) {
														$zip = strip_tags ( preg_replace ( '/\D/', '', $line [9] ) );
														$zip_length = strlen ( $zip );
														if ($zip_length > 1 && $zip_length < 6) {
															$model_employee->zip = $zip;
														}
													}
													
													$model_employee->dob = '';
													if (! empty ( $line [10] )) {
														$employee_dob = $this->dateFormat ( $line [10] );
														if (! empty ( $employee_dob )) {
															$model_employee->dob = date ( "Y-m-d", strtotime ( $employee_dob ) );
														}
													}
													
													if (! empty ( $line [11] )) {
														
														$notes = strip_tags ( preg_replace ( '/[^A-Za-z0-9 \-]/', '', $line [11] ) );
														
														$model_employee->notes = substr ( $notes, 0, 150 );
													}
													
													// check for model validate and then saving
													if ($model_employee->validate () && $model_employee->save ()) {
														
														// declaring model to null
														$model_employee->first_name = NULL;
														$model_employee->last_name = NULL;
														$model_employee->middle_name = NULL;
														$model_employee->address1 = NULL;
														$model_employee->apt_suite = NULL;
														$model_employee->city = NULL;
														$model_employee->state = NULL;
														$model_employee->zip = NULL;
														$model_employee->ssn = NULL;
														$model_employee->dob = NULL;
														$model_employee->notes = NULL;
														$model_employee->suffix = NULL;
														
														$x ++;
														$last_id = $model_employee->employee_id;
														
														for($i = 0, $j = 12; $i < 12; $i ++, $j += 7) {
															if (! empty ( $line [$j] )) {
																// echo '<pre>';
																// print_r($line[$j+2]);
																// this block is for employment period
																$model_enrollment_period->period_id = NULL;
																$model_enrollment_period->isNewRecord = true;
																$model_enrollment_period->employee_id = $last_id;
																
																
																if (! empty ( trim ( $line [$j], " " ) )) {
																	$start_date = $this->dateFormat ( $line [$j] );
																	if (! empty ( $start_date )) {
																		$model_enrollment_period->coverage_start_date = date ( "Y-m-d", strtotime ( $start_date ) );
																	}
																}
																
																$model_enrollment_period->coverage_end_date = '';
																if (! empty ( trim ( $line [$j + 1], " " ) )) {
																	$end_date = $this->dateFormat ( $line [$j + 1] );
																	if (! empty ( $end_date )) {
																		$model_enrollment_period->coverage_end_date = date ( "Y-m-d", strtotime ( $end_date ) );
																	}
																}
																
																$person_type = '';
																$resp = array ();
																if (! empty ( $line [$j + 2] )) {
																	$person_type = strtolower ( preg_replace ( '/[^A-Za-z0-9 \-]/', '', $line [$j + 2] ) );
																	
																	// print_r($person_type); die();
																	if ($person_type != '') {
																		// query to get he plan class id from tbl_aca_plan_coverage_type table
																		$resp = TblAcaLookupOptions::find ()->select ( 'lookup_id' )->where ( 'LCASE(lookup_value) LIKE :person_type AND code_id = :code_id', [ 
																				'person_type' => '%' . $person_type,
																				'code_id' => 10 
																		] )->one ();
																		
																		if (! empty ( $resp->lookup_id )) {
																			$model_enrollment_period->person_type = $resp->lookup_id;
																		}
																	}
																}
																
																if (! empty ( $line [$j + 3] )) {
																	
																	$ssn = '';
																	$ssn = strip_tags ( preg_replace ( '/\D/', '', $line [$j + 3] ) );
																	
																	if (strlen ( $ssn ) > 1 && strlen ( $ssn ) < 10) {
																		$model_enrollment_period->ssn = $ssn;
																	}
																}
																
																if (! empty ( trim ( $line [$j + 4], " " ) )) {
																	
																	$dependent_dob = '';
																	$dependent_dob = strtolower ( preg_replace ( '/[^A-Za-z0-9\-]/', '', $line [$j + 4] ) );
																	$model_enrollment_period->dependent_dob = $dependent_dob == 'yes' ? 1 : null;
																}
																
																$model_enrollment_period->dob = '';
																if (! empty ( trim ( $line [$j + 5], ' ' ) )) {
																	$enrolled_period = $this->dateFormat ( $line [$j + 5] );
																	if (! empty ( $enrolled_period )) {
																		$model_enrollment_period->dob = date ( "Y-m-d", strtotime ( $enrolled_period ) );
																	}
																}
																
																if (! empty ( $line [$j + 6] )) {
																	
																	$notes = strip_tags ( preg_replace ( '/[^A-Za-z0-9 \-]/', '', $line [$j + 6] ) );
																	
																	$model_enrollment_period->notes = substr ( $notes, 0, 150 );
																}
																
																$model_enrollment_period->created_by = $logged_id;
																
																
																if ($model_enrollment_period->save ()) {
																	$y ++;
																	
																	// initialising model to null
																	$model_enrollment_period->coverage_start_date = NULL;
																	$model_enrollment_period->coverage_end_date = NULL;
																	$model_enrollment_period->person_type = NULL;
																	$model_enrollment_period->ssn = NULL;
																	$model_enrollment_period->dependent_dob = NULL;
																	$model_enrollment_period->dob = NULL;
																	$model_enrollment_period->notes = NULL;
																}
															}
														}
													} else {
														
														$NotInsertedRecord .= $Total_records . ',';
													}
													$Total_records ++;
												} else {
													$existingRecords ++;
													$Total_records ++;
													
													$model_compare_medicaldata->session_id = $_COOKIE ["PHPSESSID"];
													$model_compare_medicaldata->company_id = $company_id;
													$model_compare_medicaldata->employee_id = $record_exist ['employee_id'];
													$model_compare_medicaldata->line_number = $linenumber + 1;
													$model_compare_medicaldata->file_name = $fileName1;
													$model_compare_medicaldata->compare_medical_id = NULL;
													$model_compare_medicaldata->isNewRecord = TRUE;
													
													if ($model_compare_medicaldata->save () && $model_compare_medicaldata->validate ()) {
														
														$r ++;
													} else {
														// print_r($model_compare_medicaldata);die();
													}
												}
											} else {
												$newCsvData [] = $line;
												$v ++;
											}
										}
									} while ( ($line = fgetcsv ( $fp, 1000, ",", "'" )) != FALSE );
									
									
									if ($v > 0) {
										
										$this->prepareerrorcsv ( $newCsvData, $company_client_number, $company_id );
									}
									
									if ($x > 0 || $y > 0) {
										
										/**
										 * *Delete all previous validations from DB**
										 */
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
										
										TblAcaMedicalValidationLog::deleteAll ( 'company_id = :company_id', [ 
												':company_id' => $company_id 
										] );
										
										TblAcaMedicalEnrollmentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
												':company_id' => $company_id 
										] );
										
										$model_company_validation_log = TblAcaCompanyValidationStatus::find ()->where ( [ 
												'company_id' => $company_id 
										] )->one ();
										
										if (! empty ( $model_company_validation_log )) {
											$model_company_validation_log->is_initialized = 0;
											$model_company_validation_log->is_executed = 0;
											$model_company_validation_log->is_completed = 0;
											
											$model_company_validation_log->is_medical_data = 0;
											$model_company_validation_log->save ();
											
											// update company status
											$check_company_details->reporting_status = 29;
											$check_company_details->save ();
										}
										
										$model_validation_log->company_id = $company_id;
										$model_validation_log->validation_rule_id = 142;
										$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
										$model_validation_log->is_validated = 1;
										$model_validation_log->save ();
									}
									
									if ($x > 0 || $y > 0 || $r > 0) {
										
										/**
										 * **** upload the document into sharefile *******
										 */
										
										/**
										 * ***** getting the sharefile credentials *****
										 */
										$share_file = json_decode ( file_get_contents ( getcwd () . '/config/sharefile-credentials.json' ) );
										
										/*
										 * $hostname = \Yii::$app->params['shareFileHostname']; $client_api_id = \Yii::$app->params['shareFileClientApiId']; $client_secret = \Yii::$app->params['shareFileClientSecret']; //$username = \Yii::$app->params['shareFileUsername']; //$password = \Yii::$app->params['shareFilePassword'];
										 */
										
										$hostname = $share_file->hostname;
										$client_api_id = $share_file->client_api_id;
										$client_secret = $share_file->client_secret;
										
										/**
										 * ***** getting the sharefile folder details based on comapny id *****
										 */
										$folder_details = TblAcaSharefileFolders::find ()->where ( [ 
												'company_id' => $company_id 
										] )->One ();
										if (! empty ( $folder_details )) {
											$sharefile_folder_id = $folder_details->sharefile_folder_id;
										}
										
										/**
										 * ***** getting the sharefile login details based on logged id *****
										 */
										$sharefile_details = TblAcaSharefileEmployees::find ()->where ( [ 
												'user_id' => $logged_user_id 
										] )->One ();
										if (! empty ( $sharefile_details )) {
											$new_username = $sharefile_details->username;
											$enc_password = $sharefile_details->password;
											$new_password = \Yii::$app->EncryptDecrypt->decryptUser ( $enc_password );
											$client_logged_id = $sharefile_details->user_id;
											
											$local_path = getcwd () . '/files/csv/' . $folder_name . '/' . $fileName1;
											$result = \Yii::$app->Sharefile->upload_file ( $hostname, $client_api_id, $client_secret, $new_username, $new_password, $sharefile_folder_id, $local_path );
										}
										
										$transaction->commit ();
									} else {
										$transaction->rollBack ();
									}
								} catch ( \Exception $e ) {
									
									$msg = $e->getMessage ();
									
									$session = \Yii::$app->session;
									// assign the message for flash variable
									$session->setFlash ( 'error', $msg );
									$transaction->rollBack ();
								}
								
								// file closing
								fclose ( $fp );
								// deleting the file
								if ($r == 0) {
									// deleting the file
									if (file_exists ( $file ))
										unlink ( $file );
								}
								
								$error_count = $Total_records - $x;
								
								$actual_error_count = $error_count - $existingRecords;
								
								// echo $error_count; die();
								if ($error_count > 0) {
									
									// message to the user for missing record rows
									$session->setFlash ( 'error', "$x Record(s) uploaded. <br> <span > Total Records: $Total_records <br> Imported: $x   </span><br> <span > Some errors encounterd.</span><br><span > Total number of records found with same ssn: $existingRecords .</span><br><span style='float: left;word-break: break-all;'>Errors: $actual_error_count - this is because the data in mandatory fields such as first name, last name, ssn is missing.</span> <br>" );
								} else {
									$session->setFlash ( 'success', "$Total_records Record(s) uploaded. <br><span > Total Records: $Total_records <br> Imported : $Total_records </span>" );
								}
								
								if ($existingRecords > 0) {
									return $this->redirect ( \Yii::$app->getUrlManager ()->getBaseUrl () . '/client/medical/comparision?c_id=' . $_GET ['c_id'] );
								} else {
									return $this->redirect ( \Yii::$app->getUrlManager ()->getBaseUrl () . '/client/medical?c_id=' . $_GET ['c_id'] );
								}
							}
						} else {
							// echo 'test'; die();
						}
					} else {
						$msg = '';
						if (! empty ( $_FILES ['TblAcaMedicalData'] ['error'] ['employee_id'] )) {
							switch ($_FILES ['TblAcaMedicalData'] ['error'] ['employee_id']) {
								
								case 1 :
									$msg = "Please select a file size which is below 5mb";
									break;
								
								case 2 :
									$msg = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
									break;
								
								case 4 :
									$msg = "No file was uploaded";
									break;
								
								default :
									$msg = "Something went wrong please try again";
									break;
							}
							$session->setFlash ( 'error', $msg );
						}
					}
					
					return $this->render ( 'uploademployees', [ 
							'model_import' => $model_employee 
					] );
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
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	
	/*
	 * action for prepare error csv
	 */
	private function prepareerrorcsv($newCsvData, $company_client_number, $company_id) {
		$session = \Yii::$app->session;
		
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
			
			/**
			 * Declaring session variables***
			 */
			$logged_user_id = $session ['client_user_id'];
			$logged_email = $session ['client_email'];
			$model_companies = new TblAcaCompanies ();
			
			$webroot = getcwd ();
			$time = time ();
			
			// create folder
			if (! file_exists ( getcwd () . '/files/csv/error_csv/' . $company_client_number )) {
				mkdir ( getcwd () . '/files/csv/error_csv/' . $company_client_number, 0777, true );
			}
			
			$name = 'medical_csv_' . $time . '.csv';
			$file_error_medicaldata = $webroot . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'csv' . DIRECTORY_SEPARATOR . 'error_csv' . DIRECTORY_SEPARATOR . $company_client_number . DIRECTORY_SEPARATOR . $name;
			
			$fp1 = fopen ( $file_error_medicaldata, 'w' );
			
			$header = array (
					'Legal First Name',
					'M.I',
					'Legal Last Name',
					'Suffix',
					'SSN',
					'Address 1',
					'Apt#, Suite',
					'City or Town',
					'State',
					'Zip',
					'Date of Birth',
					'Notes',
					'Coverage Start Date 1',
					'Coverage End Date 1',
					'Person Type 1',
					'Connected Employee SSN 1',
					'Use Dependent DOB 1',
					'DOB 1',
					'Notes 1',
					'Coverage Start Date 2',
					'Coverage End Date 2',
					'Person Type 2',
					'Connected Employee SSN 2',
					'Use Dependent DOB 2',
					'DOB 2',
					'Notes 2',
					'Coverage Start Date 3',
					'Coverage End Date 3',
					'Person Type 3',
					'Connected Employee SSN 3',
					'Use Dependent DOB 3',
					'DOB 3',
					'Notes 3',
					'Coverage Start Date 4',
					'Coverage End Date 4',
					'Person Type 4',
					'Connected Employee SSN 4',
					'Use Dependent DOB 4',
					'DOB 4',
					'Notes 4',
					'Coverage Start Date 5',
					'Coverage End Date 5',
					'Person Type 5',
					'Connected Employee SSN 5',
					'Use Dependent DOB 5',
					'DOB 5',
					'Notes 5',
					'Coverage Start Date 6',
					'Coverage End Date 6',
					'Person Type 6',
					'Connected Employee SSN 6',
					'Use Dependent DOB 6',
					'DOB 6',
					'Notes 6',
					'Coverage Start Date 7',
					'Coverage End Date 7',
					'Person Type 7',
					'Connected Employee SSN 7',
					'Use Dependent DOB 7',
					'DOB 7',
					'Notes 7',
					'Coverage Start Date 8',
					'Coverage End Date 8',
					'Person Type 8',
					'Connected Employee SSN 8',
					'Use Dependent DOB 8',
					'DOB 8',
					'Notes 8',
					'Coverage Start Date 9',
					'Coverage End Date 9',
					'Person Type 9',
					'Connected Employee SSN 9',
					'Use Dependent DOB 9',
					'DOB 9',
					'Notes 9',
					'Coverage Start Date 10',
					'Coverage End Date 10',
					'Person Type 10',
					'Connected Employee SSN 10',
					'Use Dependent DOB 10',
					'DOB 10',
					'Notes 10',
					'Coverage Start Date 11',
					'Coverage End Date 11',
					'Person Type 11',
					'Connected Employee SSN 11',
					'Use Dependent DOB 11',
					'DOB 11',
					'Notes 11',
					'Coverage Start Date 12',
					'Coverage End Date 12',
					'Person Type 12',
					'Connected Employee SSN 12',
					'Use Dependent DOB 12',
					'DOB 12',
					'Notes 12' 
			)
			;
			fputcsv ( $fp1, $header );
			
			foreach ( $newCsvData as $line ) {
				
				$v = implode ( ", ", $line );
				$array_v = array (
						$v 
				);
				
				foreach ( $array_v as $l ) {
					fputcsv ( $fp1, explode ( ',', $l ) );
				}
			}
			
			fclose ( $fp1 );
			
			/**
			 * **** upload the document into sharefile *******
			 */
			
			/**
			 * ***** getting the sharefile credentials *****
			 */
			$share_file = json_decode ( file_get_contents ( getcwd () . '/config/sharefile-credentials.json' ) );
			
			/*
			 * $hostname = \Yii::$app->params['shareFileHostname']; $client_api_id = \Yii::$app->params['shareFileClientApiId']; $client_secret = \Yii::$app->params['shareFileClientSecret'];
			 */
			
			$hostname = $share_file->hostname;
			$client_api_id = $share_file->client_api_id;
			$client_secret = $share_file->client_secret;
			
			/**
			 * ***** getting the sharefile folder details based on comapny id *****
			 */
			$folder_details = TblAcaSharefileFolders::find ()->where ( [ 
					'company_id' => $company_id 
			] )->One ();
			if (! empty ( $folder_details )) {
				$sharefile_folder_id = $folder_details->sharefile_folder_id;
			}
			
			$attachment = '';
			$attachment = $local_path = getcwd () . '/files/csv/error_csv/' . $company_client_number . '/' . $name;
			/**
			 * ***** getting the sharefile login details based on logged id *****
			 */
			$sharefile_details = TblAcaSharefileEmployees::find ()->where ( [ 
					'user_id' => $logged_user_id 
			] )->One ();
			if (! empty ( $sharefile_details )) {
				$new_username = $sharefile_details->username;
				$enc_password = $sharefile_details->password;
				$new_password = \Yii::$app->EncryptDecrypt->decryptUser ( $enc_password );
				$client_logged_id = $sharefile_details->user_id;
				
				//$local_path = getcwd () . '/files/csv/error_csv/' . $company_client_number . '/' . $name;
				// print_r($local_path);die();
				$result = \Yii::$app->Sharefile->upload_file ( $hostname, $client_api_id, $client_secret, $new_username, $new_password, $sharefile_folder_id, $local_path );
			}
			
		
		/*if($result){
		
						exec ( 'rm ' . getcwd () . '/files/csv/error_csv/'.$company_client_number.'/'.$name);	
		}*/
		
			// send error mail
			// get company detail
			$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company detail
			$client_details = TblAcaClients::Clientuniquedetails ( $check_company_details->client_id );
			
			$model_brands = TblAcaBrands::Branduniquedetails ( $client_details->brand_id );
			$brand_emailid = $model_brands->support_email;
			$brand_phonenumber = $model_brands->support_number;
			if (! empty ( $model_brands->brand_logo )) {
				$picture = 'profile_image/brand_logo/' . $model_brands->brand_logo;
			} else {
				$picture = 'ACA-Reporting-Logo.png';
			}
			$brand_name = $model_brands->brand_name;
			$link_brandimage = \Yii::$app->urlManager->createAbsoluteUrl ( '/Images' ) . '/' . $picture;
			
			// recepients
			if (! empty ( $client_details->account_manager )) {
				
				$manager_details = TblAcaUsers::find ()->select ( 'useremail' )->where ( [ 
						'user_id' => $client_details->account_manager 
				] )->One ();
				$manager_name_details = TblAcaStaffUsers::find ()->select ( 'first_name, last_name' )->where ( [ 
						'user_id' => $client_details->account_manager 
				] )->One ();
				$recepients [0] ['name'] = '';
				$recepients [0] ['email'] = $manager_details->useremail;
				
				if (! empty ( $manager_name_details )) {
					$recepients [0] ['name'] = $manager_name_details->first_name . ' ' . $manager_name_details->last_name;
				}
			}
			
			if ($client_details->package_type == 14) {
				
				$recepients [1] ['email'] = 'data@skyinsurancetech.com';
				$recepients [1] ['name'] = 'data@skyinsurancetech.com';
			}
			
			$created_by_user_detail = TblAcaUsers::find ()->select ( 'useremail' )->where ( [ 
					'user_id' => $logged_user_id 
			] )->One ();
			$created_by_name_details = TblAcaCompanyUsers::find ()->select ( 'first_name, last_name' )->where ( [ 
					'user_id' => $logged_user_id,
					'client_id' => $check_company_details->client_id 
			] )->One ();
			$recepients [2] ['name'] = '';
			$recepients [2] ['email'] = $created_by_user_detail->useremail;
			
			if (! empty ( $created_by_name_details )) {
				$recepients [2] ['name'] = $created_by_name_details->first_name . ' ' . $created_by_name_details->last_name;
			}
			
			\Yii::$app->CustomMail->Senderrorreport ( $recepients, $brand_emailid, $brand_phonenumber, $link_brandimage, $attachment,$check_company_details->company_name,$check_company_details->company_client_number );
		
			/**
			* ** removing files  **
			*/
			if (file_exists ( $attachment ))
			{
				unlink ( $attachment );
			}
		
		} else {
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	
	private function dateFormat($value) {
		$date = preg_replace ( '/[^0-9\-\/]/', '', $value );
		return $date;
	}
	
	
	public function actionComparision() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
			$this->layout = 'main';
			date_default_timezone_set ( "America/Chicago" );
			
			/**
			 * Declaring session variables***
			 */
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			/**
			 * Get data from url*
			 */
			$get_company_id = \Yii::$app->request->get ();
			
			if (! empty ( $get_company_id )) {
				/**
				 * Get encrypted company id from URL*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = (new EncryptDecryptComponent ())->decryptUser ( $encrypt_company_id ); // decrypted company id
					$check_company_details = (new TblAcaCompanies ())->Companyuniquedetails ( $company_id ); // Checking if company exists with that company id
					if (! empty ( $check_company_details )) {
						$client_id = $check_company_details->client_id; // Company clien Id
					}
				}
				
				/**
				 * Security check if the company related to the particular
				 * user by checking if company and client is present in session array *
				 */
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$this->encoded_company_id = $_GET ['c_id'];
					
					$encrypt_component = new EncryptDecryptComponent ();
					
					$company_id = $encrypt_component->decryptUser ( $_GET ['c_id'] );
					
					$model_medical_comparision = new TblAcaCompareMedicalData ();
					$model_enrollment_period = new TblAcaMedicalEnrollmentPeriod ();
					$model_accountsetting = new TblAcaGlobalSettings ();
					$model_validation_log = new TblAcaValidationLog ();
					$sessionid = $_COOKIE ['PHPSESSID'];
					$fileName1 = $session ['csv_file_name'];
					$logged_user_id = $session ['client_user_id'];
					
					$model_compare_redirect = $model_medical_comparision->findbysessionid ( $sessionid );
					
					$model_settingtime = $model_accountsetting->settinguniquedetails ( 4 );
					
					$time_setting_value = $model_settingtime->value;
					
					$tenminutebfore = date ( 'Y-m-d G:i:s', strtotime ( '-' . $model_settingtime->value . ' minutes' ) );
					
					$to_time = strtotime ( date ( 'Y-m-d G:i:s' ) );
					$from_time = strtotime ( $model_compare_redirect ['uploaded_date'] );
					$count_down_time = $model_compare_redirect ['uploaded_date'];
					
					$time_value = round ( abs ( $to_time - $from_time ) / 60, 2 ); // in minutes
					
					$webroot = getcwd ();
					$folder_name = 'csv_upload';
					$file = $webroot . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'csv' . DIRECTORY_SEPARATOR . $folder_name . DIRECTORY_SEPARATOR . $fileName1;
					
					TblAcaCompareMedicalData::deleteAll ( 'uploaded_date < :uploaded_date', [ 
							':uploaded_date' => $tenminutebfore 
					] );
					
					$model_compare_medical = $model_medical_comparision->findbysessionandcompanyid ( $company_id, $sessionid );
					
					if ((! empty ( $model_compare_medical ))) {
						
						$transaction = \Yii::$app->db->beginTransaction ();
						// try block
						try {
							
							if (! empty ( $_POST ['TblAcaCompareMedicalData'] )) {
								$postvalues = $_POST ['TblAcaCompareMedicalData'];
								$i = 0;
								$y = 0;
								$r = 0;
								$csv = [ ];
								$fp = '';
								$old_ssn = '';
								
								$search = array (
										"\\",
										"\x00",
										"\n",
										"\r",
										"'",
										'"',
										"\x1a",
										"-" 
								);
								$replace = array (
										"\\\\",
										"\\0",
										"\\n",
										"\\r",
										"\'",
										'\"',
										"\\Z",
										"" 
								);
								
								$fp = fopen ( $file, 'r' );
								
								while ( ($result = fgetcsv ( $fp, 0, "," )) !== false ) {
									$csv [] = $result;
								}
								
								foreach ( $postvalues as $key => $value ) {
									
									$ssnnew = explode ( "_", $value );
									$line_number = $ssnnew [2] - 1;
									/* $model_medicaldetails=new TblAcaMedicalData(); */
									$model_medicaldetails = TblAcaMedicalData::find ()->where ( [ 
											'employee_id' => $key 
									] )->one ();
									$old_ssn = $model_medicaldetails->ssn;
									$old_ssn_hypen = strip_tags ( preg_replace ( '/\D/', '', $old_ssn ) );
									$csv_ssn = strip_tags ( preg_replace ( '/\D/', '', $csv [$line_number] ['4'] ) );
									
									if ($old_ssn_hypen == $csv_ssn) {
										
										if ($fp) {
											
											if (! empty ( $csv [$line_number] ['0'] )) {
												$first_name = strip_tags ( preg_replace ( '/[^a-z]/i', '', $csv [$line_number] [0] ) );
												
												$model_medicaldetails->first_name = substr ( $first_name, 0, 25 );
											} else {
												$model_medicaldetails->first_name = '';
											}
											
											if (! empty ( $csv [$line_number] ['1'] )) {
												$model_medicaldetails->middle_name = substr ( strip_tags ( preg_replace ( '/[^a-z]/i', '', $csv [$line_number] [1] ) ), 0, 2 );
											} else {
												$model_medicaldetails->middle_name = '';
											}
											
											if (! empty ( $csv [$line_number] ['2'] )) {
												$last_name = strip_tags ( preg_replace ( '/[^a-z]/i', '', $csv [$line_number] [2] ) );
												$model_medicaldetails->last_name = substr ( $last_name, 0, 25 );
											} else {
												$model_medicaldetails->last_name = '';
											}
											
											if (! empty ( $csv [$line_number] ['3'] )) {
												$suffix = strtolower ( preg_replace ( '/[^A-Za-z0-9\-]/', '', $csv [$line_number] [3] ) );
												if ($suffix != '') {
													
													$resp = TblAcaLookupOptions::find ()->select ( 'lookup_id' )->where ( 'LCASE(lookup_value) LIKE :suffix AND code_id = :code_id', [ 
															'suffix' => '%' . $suffix,
															'code_id' => 7 
													] )->one ();
													
													if (! empty ( $resp->lookup_id )) {
														$model_medicaldetails->suffix = $resp->lookup_id;
													}
												}
											} else {
												$model_medicaldetails->suffix = '';
											}
											
											if (! empty ( $csv [$line_number] ['5'] )) {
												$model_medicaldetails->address1 = substr ( strip_tags ( preg_replace ( '/[^A-Za-z0-9 \-]/', '', $csv [$line_number] [5] ) ), 0, 100 );
											} else {
												$model_medicaldetails->address1 = '';
											}
											
											if (! empty ( $csv [$line_number] ['6'] )) {
												$model_medicaldetails->apt_suite = substr ( strip_tags ( preg_replace ( '/[^A-Za-z0-9 \-]/', '', $csv [$line_number] [6] ) ), 0, 100 );
											} else {
												$model_medicaldetails->apt_suite = '';
											}
											
											if (! empty ( $csv [$line_number] ['7'] )) {
												$model_medicaldetails->city = substr ( strip_tags ( strtoupper ( preg_replace ( '/[^a-z ]/i', '', $csv [$line_number] [7] ) ) ), 0, 25 );
											} else {
												$model_medicaldetails->city = '';
											}
											
											if (! empty ( $csv [$line_number] ['8'] )) {
												$model_medicaldetails->state = substr ( strip_tags ( strtoupper ( preg_replace ( '/[^a-z]/i', '', $csv [$line_number] [8] ) ) ), 0, 2 );
											} else {
												$model_medicaldetails->state = '';
											}
											
											if (! empty ( $csv [$line_number] ['9'] )) {
												$zip = strip_tags ( preg_replace ( '/\D/', '', $csv [$line_number] [9] ) );
												$zip_length = strlen ( $zip );
												if ($zip_length > 1 && $zip_length < 6) {
													$model_medicaldetails->zip = $zip;
												}
											} else {
												$model_medicaldetails->zip = '';
											}
											
											$model_medicaldetails->dob = '';
											if (! empty ( trim ( $csv [$line_number] ['10'], ' ' ) )) {
												$details_dob = $this->dateFormat ( $csv [$line_number] [10] );
												if (! empty ( $details_dob )) {
													$model_medicaldetails->dob = date ( "Y-m-d", strtotime ( $details_dob ) );
												}
											}
											
											if (! empty ( $csv [$line_number] ['11'] )) {
												$notes = strip_tags ( preg_replace ( '/[^A-Za-z0-9 \-]/', '', $csv [$line_number] [11] ) );
												$model_medicaldetails->notes = substr ( $notes, 0, 150 );
											} else {
												$model_medicaldetails->notes = '';
											}
											
											if ($model_medicaldetails->save () && $model_medicaldetails->validate ()) {
												$i ++;
												
												$temp = TblAcaMedicalEnrollmentPeriod::deleteAll ( [ 
														'employee_id' => $key 
												] );
												
												// echo $temp.'<br/>---'.$key; die();
											}
											
											if (isset ( $csv [$line_number] ['12'] )) {
												
												for($j = 12; $j <= 83; $j += 7) {
													if (! empty ( $csv [$line_number] [$j] )) {
														
														$model_enrollment_period->employee_id = $key;
														$model_enrollment_period->isNewRecord = true;
														$model_enrollment_period->period_id = null;
														
														
														$model_enrollment_period->coverage_start_date = '';
														if (! empty ( trim ( $csv [$line_number] [$j], ' ' ) )) {
															$start_date = $this->dateFormat ( $csv [$line_number] [$j] );
															if (! empty ( $start_date )) {
																$model_enrollment_period->coverage_start_date = date ( "Y-m-d", strtotime ( $start_date ) );
															}
														}
														
														
														$model_enrollment_period->coverage_end_date = '';
														
														if (! empty ( trim ( $csv [$line_number] [$j + 1], ' ' ) ))  {
															$end_date = $this->dateFormat ( $csv [$line_number] [$j + 1] );
															if (! empty ( $end_date )) {
																$model_enrollment_period->coverage_end_date = date ( "Y-m-d", strtotime ( $end_date ) );
															}
														}
														
														
														$person_type = '';
														$resp = array ();
														if (! empty ( $csv [$line_number] [$j + 2] )) {
															$person_type = strtolower ( preg_replace ( '/[^A-Za-z0-9 \-]/', '', $csv [$line_number] [$j + 2] ) );
															
															// print_r($person_type); die();
															if ($person_type != '') {
																// query to get he plan class id from tbl_aca_plan_coverage_type table
																$resp = TblAcaLookupOptions::find ()->select ( 'lookup_id' )->where ( 'LCASE(lookup_value) LIKE :person_type AND code_id = :code_id', [ 
																		'person_type' => '%' . $person_type,
																		'code_id' => 10 
																] )->one ();
																
																if (! empty ( $resp->lookup_id )) {
																	$model_enrollment_period->person_type = $resp->lookup_id;
																}
															}
														}
														
														if (! empty ( $csv [$line_number] [$j + 3] )) {
															
															$ssn = '';
															$ssn = strip_tags ( preg_replace ( '/\D/', '', $csv [$line_number] [$j + 3] ) );
															
															if (strlen ( $ssn ) > 1 && strlen ( $ssn ) < 10) {
																$model_enrollment_period->ssn = $ssn;
															}
														}
														
														if (! empty ( $csv [$line_number] [$j + 4] )) {
															
															$dependent_dob = '';
															$dependent_dob = strtolower ( preg_replace ( '/[^A-Za-z0-9\-]/', '', $csv [$line_number] [$j + 4] ) );
															$model_enrollment_period->dependent_dob = $dependent_dob == 'yes' ? 1 : null;
														}
														
														$model_enrollment_period->dob = '';
														if (! empty ( trim ( $csv [$line_number] [$j + 5], ' ' ) )) {
															$enrolled_dob = $this->dateFormat ( $csv [$line_number] [$j + 5] );
															if (! empty ( $enrolled_dob )) {
																$model_enrollment_period->dob = date ( "Y-m-d", strtotime ( $enrolled_dob ) );
															}
														}
														
														if (! empty ( $csv [$line_number] [$j + 6] )) {
															
															$notes = strip_tags ( preg_replace ( '/[^A-Za-z0-9 \-]/', '', $csv [$line_number] [$j + 6] ) );
															
															$model_enrollment_period->notes = substr ( $notes, 0, 150 );
														}
														
														$model_enrollment_period->created_by = $logged_user_id;
														
														if ($model_enrollment_period->validate () && $model_enrollment_period->save ()) {
															$y ++;
															
															$model_enrollment_period->coverage_start_date = null;
															$model_enrollment_period->coverage_end_date = null;
															$model_enrollment_period->person_type = null;
															$model_enrollment_period->ssn = null;
															$model_enrollment_period->dependent_dob = null;
															$model_enrollment_period->dob = null;
															$model_enrollment_period->notes = null;
														}
													}
												}
											}
											
											// echo '<br/>';
											// print_r($model_enrollment_period);
										}
									} else {
										throw new \Exception ( 'Selected Ssn doesnot match with the exist Ssn ,please select another' );
									}
								}
								// die();
								
								if ($i > 0 || $y > 0) {
									
									/**
									 * *Delete all previous validations from DB**
									 */
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
									
									TblAcaMedicalValidationLog::deleteAll ( 'company_id = :company_id', [ 
											':company_id' => $company_id 
									] );
									
									TblAcaMedicalEnrollmentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
											':company_id' => $company_id 
									] );
									
									$model_company_validation_log = TblAcaCompanyValidationStatus::find ()->where ( [ 
											'company_id' => $company_id 
									] )->one ();
									
									if (! empty ( $model_company_validation_log )) {
										$model_company_validation_log->is_initialized = 0;
										$model_company_validation_log->is_executed = 0;
										$model_company_validation_log->is_completed = 0;
										
										$model_company_validation_log->is_medical_data = 0;
										$model_company_validation_log->save ();
										
										// update company status
										$check_company_details->reporting_status = 29;
										$check_company_details->save ();
									}
									
									$model_validation_log->company_id = $company_id;
									$model_validation_log->validation_rule_id = 142;
									$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
									$model_validation_log->is_validated = 1;
									$model_validation_log->save ();
									
									$transaction->commit ();
									
									TblAcaCompareMedicalData::deleteAll ( [ 
											'session_id' => $_COOKIE ["PHPSESSID"] 
									] );
									
									if (file_exists ( $file ))
										unlink ( $file );
									
									\Yii::$app->session->setFlash ( 'success', 'Employee details updated succesfully' );
									return $this->redirect ( \Yii::$app->getUrlManager ()->getBaseUrl () . '/client/medical?c_id=' . $_GET ['c_id'] );
								}
								
								// file closing
								// fclose ( $fp );
							}
						} catch ( \Exception $e ) {
							
							// print_r($e);die();
							$msg = $e->getMessage ();
							\Yii::$app->session->setFlash ( 'error', $msg );
							$transaction->rollback ();
						}
					} else {
						
						TblAcaCompareMedicalData::deleteAll ( [ 
								'session_id' => $_COOKIE ["PHPSESSID"] 
						] );
						
						if (file_exists ( $file ))
							unlink ( $file );
						\Yii::$app->session->setFlash ( 'error', 'This screen has been Active for ' . $model_settingtime->value . '' );
						
						return $this->redirect ( \Yii::$app->getUrlManager ()->getBaseUrl () . '/client/medical?c_id=' . $_GET ['c_id'] );
					}
					return $this->render ( 'comparision', [ 
							'model_compare' => $model_compare_medical,
							'count_down_time' => $count_down_time,
							'time_setting_value' => $time_setting_value 
					] );
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
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
}
