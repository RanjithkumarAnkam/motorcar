<?php

namespace app\modules\client\controllers;

use app\components\EncryptDecryptComponent;
use app\models\TblAcaPayrollData;
use app\models\TblAcaPayrollEmploymentPeriod;
use app\models\TblAcaLookupOptions;
use app\models\TblAcaPlanCoverageType;
use app\models\TblAcaCompanies;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\TblAcaSharefileFolders;
use app\models\TblAcaSharefileEmployees;
use app\models\TblAcaPayrollInconsistentContribution;
use app\models\TblAcaComparePayrollData;
use app\models\TblAcaGlobalSettings;
use app\models\TblAcaPayrollValidationLog;
use app\models\TblAcaPayrollEmploymentPeriodValidationLog;
use app\models\TblAcaCompanyValidationStatus;
use app\models\TblAcaValidationLog;
use app\models\TblAcaBrands;
use app\models\TblAcaUsers;
use app\models\TblAcaStaffUsers;
use app\models\TblAcaCompanyUsers;
use app\models\TblAcaClients;


/**
 * This class is used to manage all the payroll data screen
 */
class PayrollController extends Controller {
	
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
					
					// rendering the layout
					$this->layout = 'main';
					$this->encoded_company_id = $_GET ['c_id'];
					// collecting the company id from the url and decoding it
					$encrypt_component = new EncryptDecryptComponent ();
					$company_id = $encrypt_component->decryptUser ( $_GET ['c_id'] );
					
					$company_detals = TblAcaCompanies::find ()->select ( 'company_client_number,company_name' )->where ( 'company_id = :company_id', [ 
							'company_id' => $company_id 
					] )->one ();
					
					$template = (new TblAcaPlanCoverageType ())->plancheck ( $company_id );
					
					if (! empty ( $template )) {
						$template_name = 'PayrollTemplate_No.csv';
					} else {
						$template_name = 'PayrollTemplate_Yes.csv';
					}
					// print_r($company_detals); die();
					
					return $this->render ( 'index', array (
							'company_id' => $company_id,
							'encoded_company_id' => $_GET ['c_id'],
							'company_detals' => $company_detals,
							'template_name' => $template_name 
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
	public function actionPayrolldata() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
			
			$encrypt_component = new EncryptDecryptComponent ();
			// check for the company id post
			if (! empty ( $_POST ['c_id'] )) {
				$this->encoded_company_id = $_POST ['c_id'];
				// collecting the company id from the post and decoding it
				$company_id = $encrypt_component->decryptUser ( $_POST ['c_id'] );
				
				$objPayrollData = new TblAcaPayrollData ();
				
				// calling the model function to collect all the employess specific to company id
				$employees = $objPayrollData->payrolldata ( $company_id );
				
				// initialising
				$employee_data = array ();
				
				// creating an array of employees as required for dx data grid
				foreach ( $employees as $employee ) {
					
					$data = array ();
					$emp_period_data = array ();
					$data = $objPayrollData->employmentdata ( $employee ['employee_id'] );
					
					/**
					 * this loop is used to change the format of the date*
					 */
					foreach ( $data as $value ) {
						
						// change the date format for hire_date column
						if ($value ['hire_date'] && $value ['hire_date']!='0000-00-00'){
							$value ['hire_date'] = date ( "m/d/Y", strtotime ( $value ['hire_date'] ) );
						}else{
							$value ['hire_date'] = '';
						}
							
						// change the date format for termination_date column
						if ($value ['termination_date'] && $value ['termination_date']!='0000-00-00'){
							$value ['termination_date'] = date ( "m/d/Y", strtotime ( $value ['termination_date'] ) );
						}else{
							$value ['termination_date'] = '';
						}	
							// push that array into $emp_period_data array
						array_push ( $emp_period_data, $value );
					}
					
					// change the date format for dob column
					if ($employee ['dob'] && $employee ['dob']!='0000-00-00'){
						$employee ['dob'] = date ( "m/d/Y", strtotime ( $employee ['dob'] ) );
					}else{
							$employee ['dob'] = '';
						}
					$employee ['employmentperiods'] = $emp_period_data;
					
					array_push ( $employee_data, $employee );
				}
				
				// convering the array to json
				$employees_data = Json::encode ( $employee_data );
				
				$arrempployes = array ();
				$arrempployes ['employ'] = $employees_data;
				
				// collecting the suffixes
				$encoded_suffix = Json::encode ( $objPayrollData->Suffixes () );
				$arrempployes ['suffix'] = $encoded_suffix;
				
				// collecting the plan classes
				$arrempployes ['planclass'] = Json::encode ( (new TblAcaPlanCoverageType ())->planclasses ( $company_id ) );
				
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
			
			$encrypt_component = new EncryptDecryptComponent ();
			// check for the data post
			if (! empty ( $_POST ['newdata'] )) {
				
				// assiging Posted values to the variables
				$data = $_POST ['newdata'];
				
				$company_id = $encrypt_component->decryptUser ( $_POST ['company_id'] );
				$check_company_details = TblAcaCompanies::find()->where(['company_id'=>$company_id])->One();
				// collecting the loged user id from the session
				$logged_user = \Yii::$app->session->get ( 'client_user_id' );
				
				$response = array ();
				
				$first_name = $data ['first_name'];
				$last_name = $data ['last_name'];
				$ssn = $data ['ssn'];
				
				// $sql = "SELECT employee_id FROM tbl_aca_payroll_data WHERE LCASE(first_name) LIKE '%" . strtolower($first_name) . "%' AND LCASE(last_name) LIKE '%" . strtolower($last_name) . "%' AND company_id='".$company_id."'";
				
				$record_exist = TblAcaPayrollData::find ()->select ( 'employee_id' )->where ( 'ssn = :ssn AND company_id = :company_id', [ 
						'ssn' => $ssn,
						'company_id' => $company_id 
				] )->one ();
				
				// check for duplicate entry
				if (empty ( $record_exist ['employee_id'] )) {
					
					// initialising the model
					$model = new TblAcaPayrollData ();
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
						$model->address1 = $data ['address1'];
					
					if (isset ( $data ['apt_suite'] ) && $data ['apt_suite'] != '')
						$model->apt_suite = $data ['apt_suite'];
					
					if (isset ( $data ['city'] ) && $data ['city'] != '')
						$model->city = $data ['city'];
					
					if (isset ( $data ['state'] ) && $data ['state'] != '')
						$model->state = $data ['state'];
					
					if (isset ( $data ['zip'] ) && $data ['zip'] != '')
						$model->zip = $data ['zip'];
					
					if (isset ( $data ['dob'] ) && $data ['dob'] != ''){
					$model->dob = $data ['dob'];
					}else{
						$model->dob = '';
					}
					
					if (isset ( $data ['notes'] ) && $data ['notes'] != '')
						$model->notes = $data ['notes'];
					
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
											141 
									] 
							], [ 
									':company_id' => $company_id 
							] );
							
							TblAcaPayrollValidationLog::deleteAll ( 'company_id = :company_id', [ 
									':company_id' => $company_id 
							] );
							
							TblAcaPayrollEmploymentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
									':company_id' => $company_id 
							] );
							
							$model_company_validation_log = TblAcaCompanyValidationStatus::find ()->where ( [ 
									'company_id' => $company_id 
							] )->one ();
							
							if (! empty ( $model_company_validation_log )) {
								$model_company_validation_log->is_initialized = 0;
								$model_company_validation_log->is_executed = 0;
								$model_company_validation_log->is_completed = 0;
								
								$model_company_validation_log->is_payroll_data = 0;
								$model_company_validation_log->save ();
								
								//update company status
								$check_company_details->reporting_status = 29;
								$check_company_details->save();	
							}
							
							$model_validation_log->company_id = $company_id;
							$model_validation_log->validation_rule_id = 141;
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
			$encrypt_component = new EncryptDecryptComponent ();
			// check for the data post
			if (! empty ( $_POST ['newdata'] )) {
				
				// assiging Posted values to the variables
				$newdata = $_POST ['newdata'];
				
				$olddata = $_POST ['olddata'];
				// print_r($_POST); die();
				$company_id = $encrypt_component->decryptUser ( $_POST ['company_id'] );
				$check_company_details = TblAcaCompanies::find()->where(['company_id'=>$company_id])->One();
				// collecting the loged user id from the session
				$logged_user = \Yii::$app->session->get ( 'client_user_id' );
				
				// initialising
				$response = array ();
				
				// initialising the model
				$model = TblAcaPayrollData::findOne ( [ 
						'employee_id' => $olddata ['employee_id'],
						'company_id' => $company_id 
				] );
				
				$existing_ssn = false;
				if (! empty ( $newdata ['ssn'] )) {
					// print_r($model); die();
					$ssn = $newdata ['ssn'];
					// $sql = "SELECT first_name FROM tbl_aca_payroll_data WHERE ssn='" . $ssn . "' AND company_id='" . $company_id . "' AND employee_id!='" . $model->employee_id . "'";
					// $ssn_exist = TblAcaPayrollData::findBySql ( $sql )->one ();
					
					$ssn_exist = TblAcaPayrollData::find ()->select ( 'first_name' )->where ( 'ssn = :ssn AND company_id = :company_id AND employee_id!=:employee_id', [ 
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
					
					$model->company_id = $company_id;
					$model_validation_log = new TblAcaValidationLog ();
					// assiging the values to the model based on the condition
					if (isset ( $newdata ['first_name'] ))
						$model->first_name = $newdata ['first_name'];
					
					if (isset ( $newdata ['middle_name'] ))
						$model->middle_name = $newdata ['middle_name'];
					
					if (isset ( $newdata ['last_name'] ))
						$model->last_name = $newdata ['last_name'];
					
					if (isset ( $newdata ['suffix'] ))
						$model->suffix = $newdata ['suffix'];
					
					if (isset ( $newdata ['ssn'] ))
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
					
					$model->modified_by = $logged_user;
					
					$model->modified_date = date ( 'Y-m-d H:i:s' );
					
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
											141 
									] 
							], [ 
									':company_id' => $company_id 
							] );
							
							TblAcaPayrollValidationLog::deleteAll ( 'company_id = :company_id', [ 
									':company_id' => $company_id 
							] );
							
							TblAcaPayrollEmploymentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
									':company_id' => $company_id 
							] );
							
							$model_company_validation_log = TblAcaCompanyValidationStatus::find ()->where ( [ 
									'company_id' => $company_id 
							] )->one ();
							
							if (! empty ( $model_company_validation_log )) {
								$model_company_validation_log->is_initialized = 0;
								$model_company_validation_log->is_executed = 0;
								$model_company_validation_log->is_completed = 0;
								
								$model_company_validation_log->is_payroll_data = 0;
								$model_company_validation_log->save ();
								
								//update company status
								$check_company_details->reporting_status = 29;
								$check_company_details->save();	
								
								
							}
							
							$model_validation_log->company_id = $company_id;
							$model_validation_log->validation_rule_id = 141;
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
				$model_validation_log = new TblAcaValidationLog ();
				$model = TblAcaPayrollData::findOne ( [ 
						'employee_id' => $data ['employee_id'] 
				] );
				
				$employment_model = TblAcaPayrollInconsistentContribution::deleteAll ( [ 
						'employee_id' => $data ['employee_id'] 
				] );
				
				$employment_model = TblAcaPayrollEmploymentPeriod::deleteAll ( [ 
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
						
						TblAcaPayrollValidationLog::deleteAll ( 'company_id = :company_id AND employee_id = :employee_id', [ 
								':company_id' => $model->company_id,
								':employee_id' => $data ['employee_id'] 
						] );
						
						TblAcaPayrollEmploymentPeriodValidationLog::deleteAll ( 'company_id = :company_id AND employee_id = :employee_id', [ 
								':company_id' => $model->company_id,
								'employee_id' => $data ['employee_id'] 
						] );
						
						$payroll_data = TblAcaPayrollData::find ()->select ( 'employee_id' )->where ( [ 
								'company_id' => $model->company_id 
						] )->Count ();
						
						if ($payroll_data == 0) {
							TblAcaValidationLog::deleteAll ( [ 
									'and',
									'company_id  = :company_id',
									[ 
											'in',
											'validation_rule_id',
											141 
									] 
							], [ 
									':company_id' => $model->company_id 
							] );
							
							$model_validation_log->company_id = $model->company_id;
							$model_validation_log->validation_rule_id = 141;
							$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
							$model_validation_log->is_validated = 0;
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
				$model = new TblAcaPayrollEmploymentPeriod ();
				$model_validation_log = new TblAcaValidationLog ();
				
				$check_payroll = TblAcaPayrollData::findOne ( [ 
						'employee_id' => $employee_details ['employee_id'] 
				]
				 );
				$company_id = $check_payroll->company_id;
				$check_company_details = TblAcaCompanies::find()->where(['company_id'=>$company_id])->One();
				$model->employee_id = $employee_details ['employee_id'];
				
				// assiging the values to the model based on the condition
				if (isset ( $data ['hire_date'] ) && $data ['hire_date'] != '')
					$model->hire_date = $data ['hire_date'];
				
				if (isset ( $data ['termination_date'] ) && $data ['termination_date'] != '')
					$model->termination_date = $data ['termination_date'];
				
				if (isset ( $data ['plan_class'] ) && $data ['plan_class'] != '')
					$model->plan_class = $data ['plan_class'];
				
				if (isset ( $data ['status'] ) && $data ['status'] != '')
					$model->status = $data ['status'];
				
				if (isset ( $data ['waiting_period'] ) && $data ['waiting_period'] != '')
					$model->waiting_period = $data ['waiting_period'] == true ? 1 : 0;
				
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
										141 
								] 
						], [ 
								':company_id' => $company_id 
						] );
						
						TblAcaPayrollValidationLog::deleteAll ( 'company_id = :company_id', [ 
								':company_id' => $company_id 
						] );
						
						TblAcaPayrollEmploymentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
								':company_id' => $company_id 
						] );
						
						$model_company_validation_log = TblAcaCompanyValidationStatus::find ()->where ( [ 
								'company_id' => $company_id 
						] )->one ();
						
						if (! empty ( $model_company_validation_log )) {
							$model_company_validation_log->is_initialized = 0;
							$model_company_validation_log->is_executed = 0;
							$model_company_validation_log->is_completed = 0;
							
							$model_company_validation_log->is_payroll_data = 0;
							$model_company_validation_log->save ();
							
							//update company status
							$check_company_details->reporting_status = 29;
							$check_company_details->save();	
						}
						
						$model_validation_log->company_id = $company_id;
						$model_validation_log->validation_rule_id = 141;
						$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
						$model_validation_log->is_validated = 1;
						$model_validation_log->save ();
						
						// commiting the model
						$transaction->commit ();
						
						$response ['status'] = 1;
						$response ['message'] = 'New employment record added successfully';
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
				$model = TblAcaPayrollEmploymentPeriod::findOne ( [ 
						'period_id' => $olddata ['period_id'] 
				] );
				
				$model_validation_log = new TblAcaValidationLog ();
				
				$check_payroll = TblAcaPayrollData::findOne ( [ 
						'employee_id' => $model->employee_id 
				]
				 );
				$company_id = $check_payroll->company_id;
				$check_company_details = TblAcaCompanies::find()->where(['company_id'=>$company_id])->One();
				// $model->employee_id=$employee_details['employee_id'];
				
				// assiging the values to the model based on the condition
				if (isset ( $data ['hire_date'] ) && $data ['hire_date'] != '')
					$model->hire_date = $data ['hire_date'];
				
				if (isset ( $data ['termination_date'] ))
					$model->termination_date = $data ['termination_date'];
				
				if (isset ( $data ['plan_class'] ))
					$model->plan_class = $data ['plan_class'];
				
				if (isset ( $data ['status'] ))
					$model->status = $data ['status'];
				
				if (isset ( $data ['waiting_period'] ))
					
					$model->waiting_period = $data ['waiting_period'] == "true" ? 1 : null;
				
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
										141 
								] 
						], [ 
								':company_id' => $company_id 
						] );
						
						TblAcaPayrollValidationLog::deleteAll ( 'company_id = :company_id', [ 
								':company_id' => $company_id 
						] );
						
						TblAcaPayrollEmploymentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
								':company_id' => $company_id 
						] );
						
						$model_company_validation_log = TblAcaCompanyValidationStatus::find ()->where ( [ 
								'company_id' => $company_id 
						] )->one ();
						
						if (! empty ( $model_company_validation_log )) {
							$model_company_validation_log->is_initialized = 0;
							$model_company_validation_log->is_executed = 0;
							$model_company_validation_log->is_completed = 0;
							
							$model_company_validation_log->is_payroll_data = 0;
							$model_company_validation_log->save ();
							
							//update company status
							$check_company_details->reporting_status = 29;
							$check_company_details->save();	
						}
						
						$model_validation_log->company_id = $company_id;
						$model_validation_log->validation_rule_id = 141;
						$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
						$model_validation_log->is_validated = 1;
						$model_validation_log->save ();
						
						// commiting the model
						$transaction->commit ();
						$response ['status'] = 1;
						$response ['message'] = 'Employment record updated successfully';
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
				$model = TblAcaPayrollEmploymentPeriod::findOne ( [ 
						'period_id' => $data ['period_id'] 
				] );
				
				$model_payroll_validation_log = new TblAcaPayrollValidationLog ();
				
				$check_payroll = TblAcaPayrollData::findOne ( [ 
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
						
						
						TblAcaPayrollValidationLog::deleteAll ( 'company_id = :company_id', [ 
								':company_id' => $company_id 
						] );
						
						TblAcaPayrollEmploymentPeriodValidationLog::deleteAll ( 'company_id = :company_id AND employee_id = :employee_id AND period_id = :period_id', [ 
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
							
							$model_company_validation_log->is_payroll_data = 0;
							$model_company_validation_log->save ();
							
							// update company status
							$check_company_details->reporting_status = 29;
							$check_company_details->save ();
						}
						
						
						/*
						$payroll_employmemt_period = TblAcaPayrollEmploymentPeriod::find ()->select ( 'employee_id' )->where ( [ 
								'employee_id' => $data ['employee_id'] 
						] )->Count ();
						
						if ($payroll_employmemt_period == 0) {
							
							TblAcaPayrollValidationLog::deleteAll ( 'company_id = :company_id AND employee_id = :employee_id AND validation_rule_id = :validation_rule_id', [ 
									':company_id' => $company_id,
									'employee_id' => $data ['employee_id'],
									'validation_rule_id' => 147 
							] );
							
							$model_payroll_validation_log->company_id = $company_id;
							$model_payroll_validation_log->employee_id = $data ['employee_id'];
							$model_payroll_validation_log->validation_rule_id = 147;
							$model_payroll_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
							$model_payroll_validation_log->is_validated = 0;
							$model_payroll_validation_log->save ();
						}
						*/
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
		ini_set ( "memory_limit", - 1 );
		$session = \Yii::$app->session;
		
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
			
			/**
			 * Declaring session variables***
			 */
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
			
			$encrypt_component = new EncryptDecryptComponent ();
			if (! empty ( $get_company_id )) {
				/**
				 * Get encrypted company id from URL*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // decrypted company id
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
					// echo $this->encoded_company_id; die();
					$company_id = $encrypt_component->decryptUser ( $_GET ['c_id'] );
					
					// rendering the main
					$this->layout = 'main';
					
					// initialsing the model
					$model_employee = new TblAcaPayrollData ();
					$model_employment_period = new TblAcaPayrollEmploymentPeriod ();
					$model_compare = new TblAcaComparePayrollData ();
					$model_validation_log = new TblAcaValidationLog ();
					// if(! empty ( $_FILES)){
					// print_r($_FILES); die();
					// }
					// print_r($_FILES); die();
					// check for file post
					if (! empty ( $_FILES ['TblAcaPayrollData'] ['tmp_name'] ['employee_id'] )) {
						// $info = pathinfo( $_FILES );
						$info = pathinfo ( $_FILES ['TblAcaPayrollData'] ['name'] ['employee_id'] );
						$date_time = '';
						if (isset ( $_POST ['new_file_name'] )) {
							$date_time = $_POST ['new_file_name'];
						}
						
						$file_extension = strtolower ( strrchr ( $_FILES ['TblAcaPayrollData'] ['name'] ['employee_id'], '.' ) );
						
						// $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
						
						// check for csv file
						// / if (in_array($_FILES['TblAcaPayrollData']['type'],$mimes) && ($file_extension == '.csv')) {
						
						// print_r($file_extension); die();
						
						$no_file_size_error = false;
						if (! empty ( $_FILES ['TblAcaPayrollData'] ['size'] ['employee_id'] )) {
							$file_size = ($_FILES ['TblAcaPayrollData'] ['size'] ['employee_id'] / (1024 * 1024));
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
								// $file_name = rand ( 5, 20 ) . '.csv';
								// $fileName1 = $info['filename'].'_'.$date_time. '.csv';
								$fileName1 = $info ['filename'] . '_' . date ( 'd' ) . '-' . date ( 'M' ) . '-' . date ( 'Y' ) . '_' . date ( 'H' ) . 'h ' . date ( 'i' ) . 'm ' . date ( 's' ) . 's.csv';
								// print_r($fileName1);die();
								
								// file name
								// $fileName1 = "{$file_name}";
								
								$folder_name = 'csv_upload';
								
								if (empty ( $session ['csv_file_name'] )) {
									
									$session ['csv_file_name'] = $fileName1;
								} else {
									$webroot = getcwd ();
									
									$file_delete = $webroot . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'csv' . DIRECTORY_SEPARATOR . $folder_name . DIRECTORY_SEPARATOR . $session ['csv_file_name'];
									
									// deleting the file
									if (file_exists ( $file_delete )) {
										// deleting the file
										unlink ( $file_delete );
									}
								}
								
								if ($session ['csv_file_name'] != $fileName1) {
									TblAcaComparePayrollData::deleteAll ( [ 
											'session_id' => $_COOKIE ["PHPSESSID"] 
									] );
								}
								
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
							// die();
							$webroot = getcwd ();
							
							$file = $webroot . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'csv' . DIRECTORY_SEPARATOR . $folder_name . DIRECTORY_SEPARATOR . $fileName1;
							
							$fp = fopen ( $file, 'r' );
							
							if ($fp) {
								$line = fgetcsv ( $fp, 1000, "," );
								
								// initialising the variables
								$CLEAN_GET = array ();
								
								$first_time = true;
								$x = 0; // this is for employee records
								$y = 0; // this is for employment records
								$r = 0;
								$v = 0;
								$result_count = $count = $InsertedCount = 0;
								$m = 1;
								$f = 1;
								$record_count = '';
								$record_count_first = '';
								$NotInsertedRecord = '';
								$existingRecords = 0;
								
								$Total_records = 0;
								$or_info = 0;
								
								$model_user = '';
								$model_agents = '';
								$model_agent_alloc = '';
								$csv_line_number = 0;
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
									ini_set ( 'max_execution_time', 0 );
									set_time_limit ( 0 );
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
											$csv_line_number ++;
											
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
													$record_exist = TblAcaPayrollData::find ()->select ( 'employee_id' )->where ( 'ssn = :ssn AND company_id = :company_id', [ 
															'ssn' => $ssn,
															'company_id' => $company_id 
													] )->one ();
												} else {
													$ssn = '';
												}
												
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
															
															$resp = TblAcaLookupOptions::find ()->select ( 'lookup_id' )->where ( 'LCASE(lookup_value) LIKE :suffix AND code_id = :code_id', [ 
																	'suffix' => '%' . $suffix,
																	'code_id' => 7 
															] )->one ();
															
															if (! empty ( $resp->lookup_id )) {
																$model_employee->suffix = $resp->lookup_id;
															}
														}
													}
													
													if (! empty ( $line [4] )) {
														$ssn = strip_tags ( preg_replace ( '/\D/', '', $line [4] ) );
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
														$dob_emp = $this->dateFormat($line [10]);
														$model_employee->dob = date ( "Y-m-d", strtotime ( $dob_emp ) );
													}
													
													if (! empty ( $line [11] )) {
														$model_employee->notes = substr ( strip_tags ( preg_replace ( '/[^A-Za-z0-9 \-]/', '', $line [11] ) ), 0, 150 );
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
														
														if (isset ( $line ['72'] )) {
															
															// saving inconsistent employee contribution details
															$model_employee_contribution = new TblAcaPayrollInconsistentContribution ();
															
															$model_employee_contribution->employee_id = $last_id;
															$model_employee_contribution->isNewRecord = true;
															
															if (isset ( $line ['72'] ))
																$model_employee_contribution->january = round ( preg_replace ( '/[^0-9.\-]/', '', $line [72] ), 2 );
															
															if (isset ( $line ['73'] ))
																$model_employee_contribution->febuary = round ( preg_replace ( '/[^0-9.\-]/', '', $line [73] ), 2 );
															
															if (isset ( $line ['74'] ))
																$model_employee_contribution->march = round ( preg_replace ( '/[^0-9.\-]/', '', $line [74] ), 2 );
															
															if (isset ( $line ['75'] ))
																$model_employee_contribution->april = round ( preg_replace ( '/[^0-9.\-]/', '', $line [75] ), 2 );
															
															if (isset ( $line ['76'] ))
																$model_employee_contribution->may = round ( preg_replace ( '/[^0-9.\-]/', '', $line [76] ), 2 );
															
															if (isset ( $line ['77'] ))
																$model_employee_contribution->june = round ( preg_replace ( '/[^0-9.\-]/', '', $line [77] ), 2 );
															
															if (isset ( $line ['78'] ))
																$model_employee_contribution->july = round ( preg_replace ( '/[^0-9.\-]/', '', $line [78] ), 2 );
															
															if (isset ( $line ['79'] ))
																$model_employee_contribution->august = round ( preg_replace ( '/[^0-9.\-]/', '', $line [79] ), 2 );
															
															if (isset ( $line ['80'] ))
																$model_employee_contribution->september = round ( preg_replace ( '/[^0-9.\-]/', '', $line [80] ), 2 );
															
															if (isset ( $line ['81'] ))
																$model_employee_contribution->october = round ( preg_replace ( '/[^0-9.\-]/', '', $line [81] ), 2 );
															
															if (isset ( $line ['82'] ))
																$model_employee_contribution->november = round ( preg_replace ( '/[^0-9.\-]/', '', $line [82] ), 2 );
															
															if (isset ( $line ['83'] ))
																$model_employee_contribution->december = round ( preg_replace ( '/[^0-9.\-]/', '', $line [83] ), 2 );
															
															$model_employee_contribution->created_by = $logged_id;
															
															if ($model_employee_contribution->validate () && $model_employee_contribution->save ()) {
																$model_employee_contribution->january = NULL;
																$model_employee_contribution->febuary = NULL;
																$model_employee_contribution->march = NULL;
																$model_employee_contribution->may = NULL;
																$model_employee_contribution->june = NULL;
																$model_employee_contribution->july = NULL;
																$model_employee_contribution->august = NULL;
																$model_employee_contribution->september = NULL;
																$model_employee_contribution->october = NULL;
																$model_employee_contribution->november = NULL;
																$model_employee_contribution->december = NULL;
															} else {
																$msg = 'unable to add the contribution of record';
															}
														}
														
														for($i = 0, $j = 12; $i < 12; $i ++, $j += 5) {
															if (! empty ( $line [$j] )) {
																
																// this block is for employment period
																$model_employment_period->period_id = NULL;
																$model_employment_period->isNewRecord = true;
																$model_employment_period->employee_id = $last_id;
																
																$model_employment_period->hire_date = '';
																if (! empty ( $this->dateFormat($line [$j] ))) {
																	$model_employment_period->hire_date = date ( "Y-m-d", strtotime ( $this->dateFormat($line [$j] ) ) );
																}
																
																$model_employment_period->termination_date = '';
																if (! empty ( $line [$j + 1] )) {
																	$emp_period = $this->dateFormat($line [$j + 1]);
																	if(!empty($emp_period)){
																	$model_employment_period->termination_date = date ( "Y-m-d", strtotime ( $emp_period) );
																}
																}
																
																$plan = '';
																if (! empty ( $line [$j + 2] )) {
																	$plan = strtolower ( str_replace ( $search, $replace, $line [$j + 2] ) );
																	if ($plan != '') {
																		// query to get he plan class id from tbl_aca_plan_coverage_type table
																		// $sql = "SELECT plan_class_id FROM tbl_aca_plan_coverage_type WHERE LCASE(plan_class_number) LIKE '%" . $plan . "%' ";
																		// $resp = TblAcaPlanCoverageType::findBySql ( $sql )->one ();
																		
																		$resp = TblAcaPlanCoverageType::find ()->select ( 'plan_class_id' )->where ( 'LCASE(plan_class_number) LIKE :plan AND company_id = :company_id', [ 
																				'plan' => '%' . $plan,
																				'company_id' => $company_id 
																		] )->one ();
																		
																		if (! empty ( $resp->plan_class_id )) {
																			$model_employment_period->plan_class = $resp->plan_class_id;
																		}
																	}
																}
																
																if (! empty ( $line [$j + 3] )) {
																	if ($line [$j + 3] != '') {
																		$status = '';
																		$status = strtolower ( preg_replace ( '/[^A-Za-z0-9\-]/', '', $line [$j + 3] ) );
																		$model_employment_period->status = $status == 'ft' ? 1 : ($status == 'pt' ? 2 : '');
																	}
																}
																
																if (! empty ( $line [$j + 4] )) {
																	if ($line [$j + 4] != '') {
																		$waiting_period = '';
																		$waiting_period = strtolower ( preg_replace ( '/[^A-Za-z0-9\-]/', '', $line [$j + 4] ) );
																		$model_employment_period->waiting_period = $waiting_period == 'yes' ? 1 : null;
																	}
																}
																
																$model_employment_period->created_by = $logged_id;
																
																// print_r($model_employment_period);
																if ($model_employment_period->save ()) {
																	$y ++;
																	
																	// initialising model to null
																	$model_employment_period->hire_date = NULL;
																	$model_employment_period->termination_date = NULL;
																	$model_employment_period->waiting_period = NULL;
																	$model_employment_period->plan_class = NULL;
																	$model_employment_period->status = NULL;
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
													
													$model_compare->compare_id = NULL;
													$model_compare->isNewRecord = TRUE;
													
													$model_compare->session_id = $_COOKIE ["PHPSESSID"];
													$model_compare->company_id = $company_id;
													$model_compare->employee_id = $record_exist ['employee_id'];
													$model_compare->line_number = $csv_line_number + 1;
													$model_compare->file_name = $fileName1;
													
													if ($model_compare->validate () && $model_compare->save ()) {
														
														$r ++;
														// echo $r;
														// print_r($model_compare);
													} else {
														// echo "<pre>";
														// print_r($model_compare->errors);
													}
													
													// echo "<pre>";
													// print_r($model_compare->attributes);
												}
											}else{//csv for error occured payroll
												
												$newCsvData [] =$line;
												
												$v++;										
											}
										}
									} while ( ($line = fgetcsv ( $fp, 1000, ",", "'" )) != FALSE );
									
										if($v > 0){
										
										$this->prepareerrorcsv($newCsvData,$company_id,$company_client_number);
										
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
														141 
												] 
										], [ 
												':company_id' => $company_id 
										] );
										
										TblAcaPayrollValidationLog::deleteAll ( 'company_id = :company_id', [ 
												':company_id' => $company_id 
										] );
										
										TblAcaPayrollEmploymentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
												':company_id' => $company_id 
										] );
										
										$model_company_validation_log = TblAcaCompanyValidationStatus::find ()->where ( [ 
												'company_id' => $company_id 
										] )->one ();
										
										if (! empty ( $model_company_validation_log )) {
											$model_company_validation_log->is_initialized = 0;
											$model_company_validation_log->is_executed = 0;
											$model_company_validation_log->is_completed = 0;
											
											$model_company_validation_log->is_payroll_data = 0;
											$model_company_validation_log->save ();
											
											//update company status
											$check_company_details->reporting_status = 29;
											$check_company_details->save();																
										}
										
										$model_validation_log->company_id = $company_id;
										$model_validation_log->validation_rule_id = 141;
										$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
										$model_validation_log->is_validated = 1;
										$model_validation_log->save ();
									}
									
									$transaction->commit ();
									// echo $r; die();
									if ($x > 0 || $y > 0 || $r > 0) {
										
										/**
										 * **** upload the document into sharefile *******
										 */
										
										/**
										 * ***** getting the sharefile credentials *****
										 */
										$share_file = json_decode ( file_get_contents ( getcwd () . '/config/sharefile-credentials.json' ) );
										
										/*$hostname = \Yii::$app->params['shareFileHostname'];
										$client_api_id = \Yii::$app->params['shareFileClientApiId'];
										$client_secret = \Yii::$app->params['shareFileClientSecret'];*/
										
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
											// print_r($local_path);die();
											$result = \Yii::$app->Sharefile->upload_file ( $hostname, $client_api_id, $client_secret, $new_username, $new_password, $sharefile_folder_id, $local_path );
										}
										
										// $transaction->commit();
										// echo "<pre/>";
										// print_r($model_compare); die();
									} else {
										$transaction->rollBack ();
									}
								} catch ( \Exception $e ) {
									
									//print_r($e); die();
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
									
									$session->setFlash ( 'error', "$x Record(s) uploaded. <br> <span > Total Records: $Total_records <br> Imported: $x   </span><br> <span > Some errors encounterd.</span><br><span > Total number of records found with same ssn: $existingRecords .</span><br><span style='float: left;word-break: break-all;'>Errors: $actual_error_count - this is because the data in mandatory fields such as first name, last name, ssn is missing.</span><br>" );
								} else {
									$session->setFlash ( 'success', "$Total_records Record(s) uploaded. <br><span > Total Records: $Total_records <br> Imported : $x </span>" );
								}
								// echo $existingRecords; die();
								if ($existingRecords > 0) {
									return $this->redirect ( \Yii::$app->getUrlManager ()->getBaseUrl () . '/client/payroll/comparision?c_id=' . $_GET ['c_id'] );
								} else {
									return $this->redirect ( \Yii::$app->getUrlManager ()->getBaseUrl () . '/client/payroll?c_id=' . $_GET ['c_id'] );
								}
							}
						} else {
							// echo 'test'; die();
						}
					} else {
						$msg = '';
						if (! empty ( $_FILES ['TblAcaPayrollData'] ['error'] ['employee_id'] )) {
							switch ($_FILES ['TblAcaPayrollData'] ['error'] ['employee_id']) {
								
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
	*funtion to generate error csv file
	*/
	
	private function prepareerrorcsv($newCsvData,$company_id,$company_client_number){


		$session = \Yii::$app->session;
		
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
		
		/**
		 * Declaring session variables***
		 */
		$logged_user_id = $session ['client_user_id'];
		$logged_email = $session ['client_email']; 
		
		$webroot = getcwd ();
		$time = time();
		$template = (new TblAcaPlanCoverageType ())->plancheck ( $company_id );
		$model_companies =  new TblAcaCompanies();
		
				
				// create folder
		if (!file_exists(getcwd().'/files/csv/error_csv/'.$company_client_number)) {
			mkdir(getcwd().'/files/csv/error_csv/'.$company_client_number, 0777, true);
		}
		
		
		if (! empty ( $template )) {//PayrollTemplate_no.csv
		
			$name = 'payroll_no_'.$time.'.csv';
		
			$file_error_payrolldata = $webroot . DIRECTORY_SEPARATOR . 'files' .DIRECTORY_SEPARATOR . 'csv' .DIRECTORY_SEPARATOR . 'error_csv' .DIRECTORY_SEPARATOR .$company_client_number .DIRECTORY_SEPARATOR .$name;
			
			$fp1 = fopen ( $file_error_payrolldata, 'w' );
			
			
			$header = array('Legal First Name','M.I.','Legal Last Name','Suffix','SSN','Address 1','Apt #, Suite','City or Town','Two Letter State','zip(5 digits)','Date of Birth','Notes','Hire Date 1','Termination Date 1','Medical Plan Class Name 1' ,'FT/PT Status 1','Don t Apply Waiting Period (Yes or No) 1','Hire Date 2','Termination Date 2','Medical Plan Class Name 2','FT/PT Status 2','Don t Apply Waiting Period (Yes or No) 2','Hire Date 3','Termination Date 3','Medical Plan Class Name 3','FT/PT Status 3','Don t Apply Waiting Period (Yes or No) 3','Hire Date 4','Termination Date 4','Medical Plan Class Name 4','FT/PT Status 4','Dont Apply Waiting Period (Yes or No) 4','Hire Date 5','Termination Date 5','Medical Plan Class Name 5','FT/PT Status 5','Don t Apply Waiting Period (Yes or No) 5','Hire Date 6','Termination Date 6','Medical Plan Class Name 6','FT/PT Status 6','Don t Apply Waiting Period (Yes or No) 6','Hire Date 7','Termination Date 7','Medical Plan Class Name 7','FT/PT Status 7','Dont Apply Waiting Period (Yes or No) 7','Hire Date 8','Termination Date 8','Medical Plan Class Name 8','FT/PT Status 8','Dont Apply Waiting Period (Yes or No) 8','Hire Date 9','Termination Date 9','Medical Plan Class Name 9','FT/PT Status 9','Don t Apply Waiting Period (Yes or No) 9','Hire Date 10','Termination Date 10','Medical Plan Class Name 10','FT/PT Status 10','Don t Apply Waiting Period (Yes or No) 10','Hire Date 11','Termination Date 11','Medical Plan Class Name 11','FT/PT Status 11','Don t Apply Waiting Period (Yes or No) 11','Hire Date 12','Termination Date 12','Medical Plan Class Name 12','FT/PT Status 12','Don t Apply Waiting Period (Yes or No) 12','Employee Contribution for january','Employee Contribution for February','Employee Contribution for March','Employee Contribution for April','Employee Contribution for May','Employee Contribution for June','Employee Contribution for July','Employee Contribution for Aug','Employee Contribution for September','Employee Contribution for October','Employee Contribution for November','Employee Contribution for December'
					);
			fputcsv($fp1,$header);
			
		} else {//PayrollTemplate_Yes.csv
		
			$name = 'payroll_yes_'.$time.'.csv';
			
			$file_error_payrolldata = $webroot . DIRECTORY_SEPARATOR . 'files' .DIRECTORY_SEPARATOR . 'csv' .DIRECTORY_SEPARATOR . 'error_csv' .DIRECTORY_SEPARATOR .$company_client_number .DIRECTORY_SEPARATOR .$name;

			$fp1 = fopen ( $file_error_payrolldata, 'w' );
				
			$header = array('Legal First Name','M.I.','Legal Last Name','Suffix','SSN','Address 1','Apt # ,Suite','City or Town','Two Letter State','zip (5 digit)','Date of Birth','Notes','Hire Date 1','Termination Date 1','Medical Plan Class Name 1 ','FT/PT Status 1','Dont Apply Waiting Period (Yes or No) 1','Hire Date 2','Termination Date 2','Medical Plan Class Name 2','FT/PT Status 2','Dont Apply Waiting Period (Yes or No) 2','Hire Date 3','Termination Date 3','Medical Plan Class Name 3','FT/PT Status 3','Dont Apply Waiting Period (Yes or No) 3','Hire Date 4','Termination Date 4','Medical Plan Class Name 4','FT/PT Status 4','Dont Apply Waiting Period (Yes or No) 4','Hire Date 5','Termination Date 5','Medical Plan Class Name 5','FT/PT Status 5','Dont Apply Waiting Period (Yes or No) 5','Hire Date 6','Termination Date 6','Medical Plan Class Name 6','FT/PT Status 6','Dont Apply Waiting Period (Yes or No) 6','Hire Date 7','Termination Date 7','Medical Plan Class Name 7','FT/PT Status 7','Dont Apply Waiting Period (Yes or No) 7','Hire Date 8','Termination Date 8','Medical Plan Class Name 8','FT/PT Status 8','Dont Apply Waiting Period (Yes or No) 8','Hire Date 9','Termination Date 9','Medical Plan Class Name 9','FT/PT Status 9','Dont Apply Waiting Period (Yes or No) 9','Hire Date 10','Termination Date 10','Medical Plan Class Name 10','FT/PT Status 10','Dont Apply Waiting Period (Yes or No) 10','Hire Date 11','Termination Date 11','Medical Plan Class Name 11','FT/PT Status 11','Dont Apply Waiting Period (Yes or No) 11','Hire Date 12','Termination Date 12','Medical Plan Class Name 12','FT/PT Status 12','Dont Apply Waiting Period (Yes or No) 12'
			);
			fputcsv($fp1,$header);
		}
		
		
		foreach ($newCsvData as $line) {
		
			$v=implode(", ",$line);
			$array_v = array($v);
				
			foreach ($array_v as $l)
			{
				fputcsv($fp1,explode(',',$l));
			}
		
		}
		
		fclose($fp1);
		//print_r('nok');
		
		
		
		/**
		 * **** upload the document into sharefile *******
		 */
		
		/**
		 * ***** getting the sharefile credentials *****
		 */
		$share_file = json_decode ( file_get_contents ( getcwd () . '/config/sharefile-credentials.json' ) );
		
		/*$hostname = \Yii::$app->params['shareFileHostname'];
		$client_api_id = \Yii::$app->params['shareFileClientApiId'];
		$client_secret = \Yii::$app->params['shareFileClientSecret'];*/
		
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
		$attachment = $local_path = getcwd().'/files/csv/error_csv/'.$company_client_number.'/'.$name;		
		

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
			
			//$local_path = getcwd().'/files/csv/error_csv/'.$company_client_number.'/'.$name;
			// print_r($local_path);die();
			$result = \Yii::$app->Sharefile->upload_file ( $hostname, $client_api_id, $client_secret, $new_username, $new_password, $sharefile_folder_id, $local_path );
		}
		/**
		* ** removing files  **
		*/
		/*if($result){
		
						exec ( 'rm ' . getcwd () . '/files/csv/error_csv/'.$company_client_number.'/'.$name);	
		}*/
		
		
		//send error mail
		//get company detail
		$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company detail
		$client_details = TblAcaClients::Clientuniquedetails($check_company_details->client_id);
		
		$model_brands = TblAcaBrands::Branduniquedetails ( $client_details->brand_id );
		$brand_emailid=$model_brands->support_email;
		$brand_phonenumber=$model_brands->support_number;
		if(!empty($model_brands->brand_logo)){
			$picture = 'profile_image/brand_logo/'.$model_brands->brand_logo;
		}else{
			$picture = 'ACA-Reporting-Logo.png';
		}
		$brand_name = $model_brands->brand_name;
		$link_brandimage = \Yii::$app->urlManager->createAbsoluteUrl ( '/Images' ).'/'. $picture;
		
		//recepients 
		if(!empty($client_details->account_manager)){
		
		$manager_details = TblAcaUsers::find()->select('useremail')->where(['user_id'=>$client_details->account_manager])->One();
		$manager_name_details = TblAcaStaffUsers::find()->select('first_name, last_name')->where(['user_id'=>$client_details->account_manager])->One();
		$recepients[0]['name'] =  '';
		$recepients[0]['email'] =  $manager_details->useremail;
		
		if(!empty($manager_name_details)){
		$recepients[0]['name'] = $manager_name_details->first_name.' '. $manager_name_details->last_name;
		}
		
		
		}
		
		if($client_details->package_type == 14)
		{
			
		$recepients[1]['email'] =  'data@skyinsurancetech.com';
		$recepients[1]['name'] =  'data@skyinsurancetech.com';
		
		}
		
		$created_by_user_detail = TblAcaUsers::find()->select('useremail')->where(['user_id'=>$logged_user_id])->One();
		$created_by_name_details = TblAcaCompanyUsers::find()->select('first_name, last_name')->where(['user_id'=>$logged_user_id,'client_id'=>$check_company_details->client_id])->One();
		$recepients[2]['name'] =  '';
		$recepients[2]['email'] = $created_by_user_detail->useremail;
		
		if(!empty($created_by_name_details)){
		$recepients[2]['name'] = $created_by_name_details->first_name.' '.$created_by_name_details->last_name;
		}
		
			
		\Yii::$app->CustomMail->Senderrorreport($recepients,$brand_emailid,$brand_phonenumber,$link_brandimage,$attachment,$check_company_details->company_name,$check_company_details->company_client_number); 
		
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
	 
	 
	/**
	 * This function is used to update the particula inconsistanceemployee details and commit in the database
	 */
	public function actionUpdateinconsistancecontribution() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
			$session = \Yii::$app->session; // initialising session
			$logged_user_id = $session ['client_user_id'];
			$model_contribution = new TblAcaPayrollInconsistentContribution ();
			$model_validation_log = new TblAcaValidationLog ();
			$response = array ();
			// check for the data post
			
			if (\Yii::$app->request->post () != '') {
				
				$employee_months = \Yii::$app->request->post ();
				
				$employee_uniquedetails = $model_contribution::findOne ( [ 
						'employee_id' => $employee_months ['employee_id'] 
				] );
				
				$check_payroll = TblAcaPayrollData::findOne ( [ 
						'employee_id' => $employee_months ['employee_id'] 
				]
				 );
				$company_id = $check_payroll->company_id;
				$check_company_details = TblAcaCompanies::find()->where(['company_id'=>$company_id])->One();
				// print_r($employee_uniquedetails); die();
				if (! empty ( $employee_uniquedetails )) {
					$model_contribution = $employee_uniquedetails;
				}
				
				// print_r($employee_months); die();
				$model_contribution->employee_id = $employee_months ['employee_id'];
				
				$model_contribution->attributes = $employee_months ['TblAcaPayrollInconsistentContribution'];
				
				if ($model_contribution->isNewRecord) {
					$model_contribution->created_date = date ( 'Y-m-d H:i:s' );
					$model_contribution->created_by = $logged_user_id;
				} else {
					$model_contribution->modified_date = date ( 'Y-m-d H:i:s' );
					$model_contribution->modified_by = $logged_user_id;
				}
				
				/**
				 * transaction block for the sql transactions to the database
				 */
				
				$connection = \yii::$app->db;
				
				// starting the transaction
				$transaction = $connection->beginTransaction ();
				
				// try block
				try {
					// validating the model and saving the model
					if ($model_contribution->validate () && $model_contribution->save ()) {
						
						/**
						 * *Delete all previous validations from DB**
						 */
						TblAcaValidationLog::deleteAll ( [ 
								'and',
								'company_id  = :company_id',
								[ 
										'in',
										'validation_rule_id',
										141 
								] 
						], [ 
								':company_id' => $company_id 
						] );
						
						TblAcaPayrollValidationLog::deleteAll ( 'company_id = :company_id', [ 
								':company_id' => $company_id 
						] );
						
						TblAcaPayrollEmploymentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
								':company_id' => $company_id 
						] );
						
						$model_company_validation_log = TblAcaCompanyValidationStatus::find ()->where ( [ 
								'company_id' => $company_id 
						] )->one ();
						
						if (! empty ( $model_company_validation_log )) {
							$model_company_validation_log->is_initialized = 0;
							$model_company_validation_log->is_executed = 0;
							$model_company_validation_log->is_completed = 0;
							
							$model_company_validation_log->is_payroll_data = 0;
							$model_company_validation_log->save ();
							
							//update company status
							$check_company_details->reporting_status = 29;
							$check_company_details->save();	
						}
						
						$model_validation_log->company_id = $company_id;
						$model_validation_log->validation_rule_id = 141;
						$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
						$model_validation_log->is_validated = 1;
						$model_validation_log->save ();
						
						// commiting the model
						$transaction->commit ();
						
						$response ['status'] = 1;
						$response ['message'] = 'Updated successfully';
					} else {
						$response ['status'] = 2;
						$response ['message'] = 'some error occured';
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
	
	 private function dateFormat($value){
		 $date = preg_replace('/[^0-9\-\/]/', '', $value);
		 return $date;
	 }
	 
	 
	  /*
	 *action for comparision screen for the duplicate recoreds
	 */
	public function actionComparision() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
			date_default_timezone_set ( "America/Chicago" );
			$this->layout = 'main';
			
			$model_compare = [ ];
			
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
			
			$encrypt_component = new EncryptDecryptComponent ();
			if (! empty ( $get_company_id )) {
				/**
				 * Get encrypted company id from URL*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // decrypted company id
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
					
					$company_id = $encrypt_component->decryptUser ( $_GET ['c_id'] );
					
					// echo"hellio"; die();
					$model_comparision = new TblAcaComparePayrollData ();
					$model_employment_period = new TblAcaPayrollEmploymentPeriod ();
					$model_accountsetting = new TblAcaGlobalSettings ();
					$model_validation_log = new TblAcaValidationLog ();
					$sessionid = $_COOKIE ['PHPSESSID'];
					$fileName1 = $session ['csv_file_name'];
					$logged_user_id = $session ['client_user_id'];
					
					$model_compare_redirect = $model_comparision->findbysessionid ( $sessionid );
					
					$model_settingtime = $model_accountsetting->settinguniquedetails ( 4 );
					$time_setting_value = $model_settingtime->value;
					
					$calculated_time = date ( 'Y-m-d G:i:s', strtotime ( '-' . $model_settingtime->value . ' minutes' ) );
					
					$to_time = strtotime ( date ( 'Y-m-d G:i:s' ) );
					
					$from_time = strtotime ( $model_compare_redirect ['uploaded_date'] );
					$count_down_time = $model_compare_redirect ['uploaded_date'];
					
					$time_value = round ( abs ( $to_time - $from_time ) / 60, 2 ); // in minutes
					
					$webroot = getcwd ();
					$folder_name = 'csv_upload';
					$file = $webroot . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'csv' . DIRECTORY_SEPARATOR . $folder_name . DIRECTORY_SEPARATOR . $fileName1;
					
					// TblAcaComparePayrollData::deleteAll('uploaded_date < :uploaded_date', [ ':uploaded_date' => $calculated_time]);
					
					$model_compare = $model_comparision->findbysessionandcompanyid ( $company_id, $sessionid );
					
					if ((! empty ( $model_compare ))) {
						// print_r($model_compare); die();
					}
					
					if ((! empty ( $model_compare ))) {
						
						// try block
						try {
							
							if (! empty ( $_POST ['TblAcaComparePayrollData'] )) {
								$postvalues = $_POST ['TblAcaComparePayrollData'];
								$i = 0;
								$y = 0;
								$csv = [ ];
								$fp = '';
								
								$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
								
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
								// print_r(fgetcsv($fp,4));die();
								while ( ($result = fgetcsv ( $fp, 0, "," )) !== false ) {
									$csv [] = $result;
								}
								
								// print_r($postvalues); die();
								foreach ( $postvalues as $key => $value ) {
									
									$model_employeedetails = TblAcaPayrollData::find ()->where ( [ 
											'employee_id' => $key 
									] )->one ();
									$old_ssn = $model_employeedetails->ssn;
									$ssnnew = explode ( "_", $value );
									$line_number = $ssnnew [2] - 1;
									$old_ssn1 = strip_tags ( preg_replace ( '/\D/', '', $old_ssn ) );
									$csv_ssn = strip_tags ( preg_replace ( '/\D/', '', $csv [$line_number] ['4'] ) );
									if ($old_ssn1 == $csv_ssn) {
										
										if (! (empty ( $csv [$line_number] [0] ) || empty ( $csv [$line_number] [2] ) || empty ( $csv [$line_number] [4] ))) {
											
											if (! empty ( $csv [$line_number] ['0'] )) {
												$model_employeedetails->first_name = strip_tags ( preg_replace ( '/[^a-z]/i', '', $csv [$line_number] [0] ) );
											} else {
												$model_employeedetails->first_name = '';
											}
											
											if (! empty ( $csv [$line_number] ['1'] )) {
												$model_employeedetails->middle_name = substr ( strip_tags ( preg_replace ( '/[^a-z]/i', '', $csv [$line_number] [1] ) ), 0, 2 );
											} else {
												$model_employeedetails->middle_name = '';
											}
											
											if (! empty ( $csv [$line_number] ['2'] )) {
												$model_employeedetails->last_name = strip_tags ( preg_replace ( '/[^a-z]/i', '', $csv [$line_number] [2] ) );
											} else {
												$model_employeedetails->last_name = '';
											}
											
											if (! empty ( $csv [$line_number] ['3'] )) {
												
												$suffix = strtolower ( preg_replace ( '/[^A-Za-z0-9\-]/', '', $csv [$line_number] [3] ) );
												if ($suffix != '') {
													
													$resp = TblAcaLookupOptions::find ()->select ( 'lookup_id' )->where ( 'LCASE(lookup_value) LIKE :suffix AND code_id = :code_id', [ 
															'suffix' => '%' . $suffix,
															'code_id' => 7 
													] )->one ();
													
													if (! empty ( $resp->lookup_id )) {
														$model_employeedetails->suffix = $resp->lookup_id;
													} else {
														$model_employeedetails->suffix = '';
													}
												}
											} else {
												$model_employeedetails->suffix = '';
											}
											
											if (! empty ( $csv [$line_number] ['5'] )) {
												$model_employeedetails->address1 = substr ( strip_tags ( preg_replace ( '/[^A-Za-z0-9 \-]/', '', $csv [$line_number] [5] ) ), 0, 100 );
											} else {
												$model_employeedetails->address1 = '';
											}
											
											if (! empty ( $csv [$line_number] ['6'] )) {
												$model_employeedetails->apt_suite = substr ( strip_tags ( preg_replace ( '/[^A-Za-z0-9 \-]/', '', $csv [$line_number] [6] ) ), 0, 100 );
											} else {
												$model_employeedetails->apt_suite = '';
											}
											
											if (! empty ( $csv [$line_number] ['7'] )) {
												$model_employeedetails->city = substr ( strip_tags ( strtoupper ( preg_replace ( '/[^a-z ]/i', '', $csv [$line_number] [7] ) ) ), 0, 25 );
											} else {
												$model_employeedetails->city = '';
											}
											
											if (! empty ( $csv [$line_number] ['8'] )) {
												$model_employeedetails->state = substr ( strip_tags ( strtoupper ( preg_replace ( '/[^a-z]/i', '', $csv [$line_number] [8] ) ) ), 0, 2 );
											} else {
												$model_employeedetails->state = '';
											}
											
											if (! empty ( $csv [$line_number] ['9'] )) {
												$zip = strip_tags ( preg_replace ( '/\D/', '', $csv [$line_number] [9] ) );
												$zip_length = strlen ( $zip );
												if ($zip_length > 1 && $zip_length < 6) {
													$model_employeedetails->zip = $zip;
												} else {
													$model_employeedetails->zip = '';
												}
											} else {
												$model_employeedetails->zip = '';
											}
											
											$model_employeedetails->dob = '';
											if (! empty ( $csv [$line_number] ['10'] )) {
												$employee_dob = $this->dateFormat($csv [$line_number] [10]);
											if(!empty($employee_dob)){
												$model_employeedetails->dob = date ( "Y-m-d", strtotime ( $employee_dob ) );
											}
											}
											if (! empty ( $csv [$line_number] ['11'] )) {
												$model_employeedetails->notes = substr ( strip_tags ( preg_replace ( '/[^A-Za-z0-9 \-]/', '', $csv [$line_number] [11] ) ), 0, 150 );
											} else {
												$model_employeedetails->notes = '';
											}
											
											if ($model_employeedetails->save ()) {
												$i ++;
											}
											
											$template = (new TblAcaPlanCoverageType ())->plancheck ( $company_id );
											
											// ////////////////////////////////////////////////
											if (! empty ( $template )) {
												
												// saving inconsistent employee contribution details
												$model_employee_contribution = TblAcaPayrollInconsistentContribution::find ()->where ( [ 
														'employee_id' => $key 
												] )->one ();
												
												if (empty ( $model_employee_contribution )) {
													
													$model_employee_contribution = new TblAcaPayrollInconsistentContribution ();
													
													$model_employee_contribution->isNewRecord = true;
												}
												
												if (! empty ( $csv [$line_number] ['72'] )) {
													$model_employee_contribution->january = round ( preg_replace ( '/[^0-9.\-]/', '', $csv [$line_number] [72] ), 2 );
												} else {
													$model_employee_contribution->january = '';
												}
												if (! empty ( $csv [$line_number] ['73'] )) {
													$model_employee_contribution->febuary = round ( preg_replace ( '/[^0-9.\-]/', '', $csv [$line_number] [73] ), 2 );
												} else {
													$model_employee_contribution->febuary = '';
												}
												if (! empty ( $csv [$line_number] ['74'] )) {
													$model_employee_contribution->march = round ( preg_replace ( '/[^0-9.\-]/', '', $csv [$line_number] [74] ), 2 );
												} else {
													$model_employee_contribution->march = '';
												}
												if (! empty ( $csv [$line_number] ['75'] )) {
													$model_employee_contribution->april = round ( preg_replace ( '/[^0-9.\-]/', '', $csv [$line_number] [75] ), 2 );
												} else {
													$model_employee_contribution->april = '';
												}
												if (! empty ( $csv [$line_number] ['76'] )) {
													$model_employee_contribution->may = round ( preg_replace ( '/[^0-9.\-]/', '', $csv [$line_number] [76] ), 2 );
												} else {
													$model_employee_contribution->may = '';
												}
												if (! empty ( $csv [$line_number] ['77'] )) {
													$model_employee_contribution->june = round ( preg_replace ( '/[^0-9.\-]/', '', $csv [$line_number] [77] ), 2 );
												} else {
													$model_employee_contribution->june = '';
												}
												
												if (! empty ( $csv [$line_number] ['78'] )) {
													$model_employee_contribution->july = round ( preg_replace ( '/[^0-9.\-]/', '', $csv [$line_number] [78] ), 2 );
												} else {
													$model_employee_contribution->july = '';
												}
												
												if (! empty ( $csv [$line_number] ['79'] )) {
													$model_employee_contribution->august = round ( preg_replace ( '/[^0-9.\-]/', '', $csv [$line_number] [79] ), 2 );
												} else {
													$model_employee_contribution->august = '';
												}
												
												if (! empty ( $csv [$line_number] ['80'] )) {
													$model_employee_contribution->september = round ( preg_replace ( '/[^0-9.\-]/', '', $csv [$line_number] [80] ), 2 );
												} else {
													$model_employee_contribution->september = '';
												}
												
												if (! empty ( $csv [$line_number] ['81'] )) {
													$model_employee_contribution->october = round ( preg_replace ( '/[^0-9.\-]/', '', $csv [$line_number] [81] ), 2 );
												} else {
													$model_employee_contribution->october = '';
												}
												
												if (! empty ( $csv [$line_number] ['82'] )) {
													$model_employee_contribution->november = round ( preg_replace ( '/[^0-9.\-]/', '', $csv [$line_number] [82] ), 2 );
												} else {
													$model_employee_contribution->november = '';
												}
												
												if (! empty ( $csv [$line_number] ['83'] )) {
													$model_employee_contribution->december = round ( preg_replace ( '/[^0-9.\-]/', '', $csv [$line_number] [83] ), 2 );
												} else {
													$model_employee_contribution->december = '';
												}
												$model_employee_contribution->created_by = $logged_user_id;
												
												if ($model_employee_contribution->validate () && $model_employee_contribution->save ()) {
													$model_employee_contribution->january = NULL;
													$model_employee_contribution->febuary = NULL;
													$model_employee_contribution->march = NULL;
													$model_employee_contribution->may = NULL;
													$model_employee_contribution->june = NULL;
													$model_employee_contribution->july = NULL;
													$model_employee_contribution->august = NULL;
													$model_employee_contribution->september = NULL;
													$model_employee_contribution->october = NULL;
													$model_employee_contribution->november = NULL;
													$model_employee_contribution->december = NULL;
												} else {
													$msg = 'unable to add the contribution of record';
												}
											}
											
											if (! empty ( $csv [$line_number] )) {
												
												TblAcaPayrollEmploymentPeriod::deleteAll ( [ 
														'employee_id' => $key 
												] );
												
												for($i = 0, $j = 12; $i < 12; $i ++, $j += 5) {
													if (! empty ( $csv [$line_number] [$j] )) {
														
														// this block is for employment period
														$model_employment_period->period_id = NULL;
														$model_employment_period->isNewRecord = true;
														$model_employment_period->employee_id = $key;
														
														$model_employment_period->hire_date = '';
														if (! empty ( $csv [$line_number] [$j] )) {
															$hire_date = $this->dateFormat($csv [$line_number] [$j]);
															
															if(!empty($hire_date)){
															$model_employment_period->hire_date = date ( "Y-m-d", strtotime ( $hire_date ) );
														}
														}
														
														$model_employment_period->termination_date = '';
														if (! empty ( $csv [$line_number] [$j + 1] )) {
															$termination_date = $this->dateFormat($csv [$line_number] [$j+1]);
															if(!empty($termination_date)){
															$model_employment_period->termination_date = date ( "Y-m-d", strtotime ( $termination_date ) );
														}															
														}
														
														$plan = '';
														if (! empty ( $csv [$line_number] [$j + 2] )) {
															$plan = strtolower ( str_replace ( $search, $replace, $csv [$line_number] [$j + 2] ) );
															
															if ($plan != '') {
																
																// query to get he plan class id from tbl_aca_plan_coverage_type table
																$resp = TblAcaPlanCoverageType::find ()->select ( 'plan_class_id' )->where ( 'LCASE(plan_class_number) LIKE :plan AND company_id = :company_id', [ 
																		'plan' => '%' . $plan,
																		'company_id' => $company_id 
																] )->one ();
																
																if (! empty ( $resp->plan_class_id )) {
																	$model_employment_period->plan_class = $resp->plan_class_id;
																}
															}
														}
														
														if (! empty ( $csv [$line_number] [$j + 3] )) {
															if ($csv [$line_number] [$j + 3] != '') {
																$status = '';
																$status = strtolower ( preg_replace ( '/[^A-Za-z0-9\-]/', '', $csv [$line_number] [$j + 3] ) );
																$model_employment_period->status = $status == 'ft' ? 1 : ($status == 'pt' ? 2 : '');
															}
														}
														
														if (! empty ( $csv [$line_number] [$j + 4] )) {
															if ($csv [$line_number] [$j + 4] != '') {
																$waiting_period = '';
																$waiting_period = strtolower ( preg_replace ( '/[^A-Za-z0-9\-]/', '', $csv [$line_number] [$j + 4] ) );
																$model_employment_period->waiting_period = $waiting_period == 'yes' ? 1 : null;
															}
														}
														
														$model_employment_period->created_by = $logged_user_id;
														
														// print_r($model_employment_period);
														if ($model_employment_period->save ()) {
															$y ++;
															
															// initialising model to null
															$model_employment_period->hire_date = NULL;
															$model_employment_period->termination_date = NULL;
															$model_employment_period->waiting_period = NULL;
															$model_employment_period->plan_class = NULL;
															$model_employment_period->status = NULL;
														}
													}
												}
											}
										}
									} else {
										throw new \Exception ( 'Selected Ssn doesnot match with the exist ssn ,please select another' );
									}
								}
								
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
													141 
											] 
									], [ 
											':company_id' => $company_id 
									] );
									
									TblAcaPayrollValidationLog::deleteAll ( 'company_id = :company_id', [ 
											':company_id' => $company_id 
									] );
									
									TblAcaPayrollEmploymentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
											':company_id' => $company_id 
									] );
									
									$model_company_validation_log = TblAcaCompanyValidationStatus::find ()->where ( [ 
											'company_id' => $company_id 
									] )->one ();
									
									if (! empty ( $model_company_validation_log )) {
										$model_company_validation_log->is_initialized = 0;
										$model_company_validation_log->is_executed = 0;
										$model_company_validation_log->is_completed = 0;
										
										$model_company_validation_log->is_payroll_data = 0;
										$model_company_validation_log->save ();
										
										//update company status
										$check_company_details->reporting_status = 29;
										$check_company_details->save();	
									}
									
									$model_validation_log->company_id = $company_id;
									$model_validation_log->validation_rule_id = 141;
									$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
									$model_validation_log->is_validated = 1;
									$model_validation_log->save ();
									
									$transaction->commit ();
									
									TblAcaComparePayrollData::deleteAll ( [ 
											'session_id' => $_COOKIE ["PHPSESSID"] 
									] );
									
									// file closing
									fclose ( $fp );
									
									// delete the file and clear the records from db table
									if (file_exists ( $file ))
										unlink ( $file );
									\Yii::$app->session->setFlash ( 'success', 'Employee details updated succesfully' );
									return $this->redirect ( \Yii::$app->getUrlManager ()->getBaseUrl () . '/client/payroll?c_id=' . $_GET ['c_id'] );
								}
							}
						} catch ( \Exception $e ) {
							
							// print_r($e);die();
							$msg = $e->getMessage ();
							\Yii::$app->session->setFlash ( 'error', $msg );
							$transaction->rollback ();
						}
					} else {
						
						// delete the file and records from the db
						
						TblAcaComparePayrollData::deleteAll ( [ 
								'session_id' => $_COOKIE ["PHPSESSID"] 
						] );
						
						if (file_exists ( $file )) {
							unlink ( $file );
						}
						\Yii::$app->session->setFlash ( 'error', 'Some Error Occured, Please select another CSV' );
						
						return $this->redirect ( \Yii::$app->getUrlManager ()->getBaseUrl () . '/client/payroll?c_id=' . $_GET ['c_id'] );
					}
					
					return $this->render ( 'comparision', [ 
							'model_compare' => $model_compare,
							'count_down_time' => $count_down_time,
							'time_setting_value' => $time_setting_value,
							'time_value_one' => $time_value 
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
