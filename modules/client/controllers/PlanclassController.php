<?php

/**
 * 
 * 
 * @author PRAVEEN
 *
 */
namespace app\modules\client\controllers;

use yii\web\Controller;
use app\models\TblAcaCompanies;
use app\models\TblAcaClients;
use app\components\EncryptDecryptComponent;
use app\models\TblAcaCompanyReportingPeriod;
use app\models\TblAcaCompanyUsers;
use app\models\TblAcaClientRightsMaster;
use app\models\TblAcaCompanyUserPermission;
use app\models\TblAcaUsers;
use app\models\TblAcaElementMaster;
use app\models\TblAcaPlanCoverageType;
use app\models\TblAcaPlanOfferTypeYears;
use app\models\TblAcaPlanCoverageTypeOffered;
use yii\db\Exception;
use app\models\TblAcaEmpContributions;
use app\models\TblAcaEmpContributionsPremium;
use yii\helpers\ArrayHelper;
use app\models\TblAcaPlanClassValidationLog;
use app\models\TblAcaCompanyValidationStatus;
use app\models\TblAcaValidationLog;
use app\models\TblAcaMedicalEnrollmentPeriodValidationLog;
use app\models\TblAcaMedicalValidationLog;

class PlanclassController extends Controller {
	
	/**Action is used for rendering plan class grid**/
	public function actionIndex() {
		$this->layout = 'main';
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			/**Initializing models**/
			$encrypt_component = new EncryptDecryptComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_company_users = new TblAcaCompanyUsers ();
			$model_client_rights_master = new TblAcaClientRightsMaster ();
			$model_users = new TblAcaUsers ();
			$model_plan_coverage_type = new TblAcaPlanCoverageType ();
			$model_plan_coverage_type_offered = new TblAcaPlanCoverageTypeOffered ();
			
			/***Declaring Variables**/
			$user_details = array ();
			$permissions = array ();
			$company_user_permissions = array ();
			$result = array ();
			$client_id= '';
			
			/**Declaring Session Variables***/
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			/**Get from URL**/
			$get_company_id = \Yii::$app->request->get ();
			
			if (! empty ( $get_company_id )) {
				/**Encrypted company ID**/
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); //Decrypted company Id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); //Company details
					if(!empty($check_company_details)){
					$client_id = $check_company_details->client_id; // Company clien Id
					}
				}
				/***Checking if company details exists for the company_id and company and client is present in session***/
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					
					
					/***Query all plan class**/
					$all_plan_class = $model_plan_coverage_type->Findallplans ($company_id);
					
					return $this->render ( 'index', [ 
							'all_plan_class' => $all_plan_class,
							'company_details' => $check_company_details,
							'encrypt_component' => $encrypt_component,
							'model_plan_coverage_type_offered' => $model_plan_coverage_type_offered,
											
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
			\Yii::$app->SessionCheck->clientlogout (); //client logout
			
			return $this->goHome ();
		}
	}
	
	/**Action is used for add new plan class **/
	public function actionAddplanclass() {
		$this->layout = 'main';
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			/**Initializing models**/
			$encrypt_component = new EncryptDecryptComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_company_users = new TblAcaCompanyUsers ();
			$model_client_rights_master = new TblAcaClientRightsMaster ();
			$model_users = new TblAcaUsers ();
			$model_element_master = new TblAcaElementMaster ();
			$model_plan_coverage_type = new TblAcaPlanCoverageType ();
			
			/**Declaring variables**/
			$user_details = array ();
			$permissions = array ();
			$company_user_permissions = array ();
			$result = array ();
			
			/**Declaring session variables****/
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			/**Get data from url**/
			$get_company_id = \Yii::$app->request->get ();
			
			if (! empty ( $get_company_id )) {
				/**Get encrypted company id from URL**/
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); //decrypted company id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); //Checking if company exists with that company id
					$client_id = $check_company_details->client_id; //company client_id
				}
				
				/**Security check if the company related to the particular
				user by checking if company and client is present in session array **/
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					/***************get section elements**********************/
					$section_ids = ['9'];
					$all_elements = $model_element_master->FindallbysectionIds($section_ids);
						
					$arrsection_elements = ArrayHelper::map($all_elements, 'element_id', 'element_label');
						
					
					
					
					
					/**Checking if plan_id is set in url**/
					if (! empty ( $get_company_id ['plan_id'] )) {
						$encrypt_plan_id = $get_company_id ['plan_id'];
						$plan_id = $encrypt_component->decryptUser ( $encrypt_plan_id );
						
						/**Get details of that plan by plan_id**/
						$plan_details = $model_plan_coverage_type->FindplanbyId ( $plan_id,$company_id );
						$model_plan_coverage_type = $plan_details;
					}
					
					/**Get all existing plan count**/
					$all_plans_count = $model_plan_coverage_type->Countplans($company_id);
					
					
					/**Check for any post of data**/
					if ($model_plan_coverage_type->load ( \Yii::$app->request->post () )) {
						
						/**Assign all post data to a variable**/
						$plan_coverage_type_details = \Yii::$app->request->post ();
						
						/**Check if plan_class_name not empty**/
						if (! empty ( $model_plan_coverage_type)) {
							
							/**Check for the type of button clicked i.e (Save and continue) or (Save and Exit)**/
							$redirect_button = $plan_coverage_type_details ['button'];
							
							/**Calling plan coverage type function**/
							$result = $this->PlanCoverageType ( $plan_coverage_type_details, $encrypt_company_id );
							
							/**Checking for success**/
							if (! empty ( $result ['success'] )) {
								$plan_class_id = $result ['plan_class_id'];
								$encrypt_plan_id = $encrypt_component->encrytedUser ( $plan_class_id );
								
								
								if ($redirect_button == 'exit') {
									\Yii::$app->session->setFlash ( 'success', 'Plan Class coverage type updated successfully' );
									/**Redirect to Index (Plan class grid)**/
									return $this->redirect ( array (
											'/client/planclass?c_id=' . $encrypt_company_id 
									) );
								} else {
									
									\Yii::$app->session->setFlash ( 'success', 'Plan Class coverage type updated successfully' );
									/**Redirect to next tab i.e Type of coverage offered**/
									return $this->redirect ( array (
											'/client/planclass/updateplanclass?c_id=' . $encrypt_company_id . '&plan_id=' . $encrypt_plan_id . '#typeofcoverage' 
									) );
								}
							} elseif (! empty ( $result ['error'] )) { //Checking if error exists
								
								if (! empty ( $result ['error'] ['plan_class_name'] )) {
									$error = $result ['error'] ['plan_class_name'] [0];
									$model_plan_coverage_type->addError ( 'plan_class_name', $error );
								} else {
									
									\Yii::$app->session->setFlash ( 'error', $result ['error'] );
								}
							}
						}
					}
					
					return $this->render ( 'addplanclass', [ 
							'model_element_master' => $model_element_master,
							'company_details' => $check_company_details,
							'model_plan_coverage_type' => $model_plan_coverage_type,
							'all_plans_count'=>$all_plans_count,
							'arrsection_elements'=>$arrsection_elements
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
			\Yii::$app->SessionCheck->clientlogout (); //logout
			
			return $this->goHome ();
		}
	}
	
	/***Action is used to add or update plan coverage type***/
	protected function PlanCoverageType($plan_coverage_type_details, $encrypt_company_id) {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			// declaring models
			$encrypt_component = new EncryptDecryptComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_company_users = new TblAcaCompanyUsers ();
			$model_client_rights_master = new TblAcaClientRightsMaster ();
			$model_users = new TblAcaUsers ();
			$model_element_master = new TblAcaElementMaster ();
			$model_plan_coverage_type = new TblAcaPlanCoverageType ();
			$model_plan_offer_years = new TblAcaPlanOfferTypeYears ();
			$model_validation_log = new TblAcaValidationLog();
			
			// declaring variables
			$user_details = array ();
			$permissions = array ();
			$company_user_permissions = array ();
			$Planoffertypeyears = array ();
			$result = array ();
			
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
							'74' 
					];
			
			$planname = '';
			$plantype = '';
			$employeemedicalplan = '';
			$doh = '';
			$period_id = '';
			$redirect_action = '';
			$old_plan_type = '';
			
			/**Declaring session variables****/
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			if (! empty ( $plan_coverage_type_details )) {
				
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); //decrypted company id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); //Checking if company exists with that company id
					$client_id = $check_company_details->client_id; //company client_id
				}
				
				/**Security check if the company related to the particular
				user by checking if company and client is present in session array **/
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					/**Get all existing plan**/
					$all_plans_count = $model_plan_coverage_type->Countplans($company_id);
					
					$period_details = $model_companies->getcompanyperiod ( $company_id );
					$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
					/**Assigning post data to variables**/
					if(!empty($plan_coverage_type_details ['TblAcaPlanCoverageType'] ['plan_class_name'])){
					$planname = $plan_coverage_type_details ['TblAcaPlanCoverageType'] ['plan_class_name'];
					}
					
					if(!empty($plan_coverage_type_details ['TblAcaPlanCoverageType'] ['plantype'])){
					$plantype = $plan_coverage_type_details ['TblAcaPlanCoverageType'] ['plantype'];
					}
					
					if(!empty($plan_coverage_type_details ['TblAcaPlanCoverageType'] ['employeemedicalplan'])){
					$employeemedicalplan = $plan_coverage_type_details ['TblAcaPlanCoverageType'] ['employeemedicalplan'];
					}
					
					if(!empty($plan_coverage_type_details ['TblAcaPlanCoverageType'] ['doh'])){
					$doh = $plan_coverage_type_details ['TblAcaPlanCoverageType'] ['doh'];
					}
					// checking for old plan class
					if (! empty ( $plan_coverage_type_details ['TblAcaPlanCoverageType'] ['plan_class_id'] )) {
						$plan_id = $plan_coverage_type_details ['TblAcaPlanCoverageType'] ['plan_class_id'];
						$plan_details = $model_plan_coverage_type->FindplanbyId ( $plan_id,$company_id );
						
						if (! empty ( $plan_details )) {
							$model_plan_coverage_type = $plan_details;
							$old_plan_type = $plan_details->plan_offer_type;
						}
					}
					
					$Planoffertypeyears = $plan_coverage_type_details ['Planoffertypeyears'];
					
					$model_plan_coverage_type->company_id = $company_id;
					$model_plan_coverage_type->period_id = $period_id;
					$model_plan_coverage_type->plan_class_name = $planname;
					$model_plan_coverage_type->plan_offer_type = $plantype;
					$model_plan_coverage_type->plan_type_doh = $doh;
					$model_plan_coverage_type->employee_medical_plan = $employeemedicalplan;
					
					if ($model_plan_coverage_type->isNewRecord) {
						$plan_number = $all_plans_count + 1;
						$model_plan_coverage_type->plan_class_number = 'Plan Class #'.$plan_number;
						$model_plan_coverage_type->created_date = date ( 'Y-m-d H:i:s' );
						$model_plan_coverage_type->created_by = $logged_user_id;
					} else {
						$model_plan_coverage_type->modified_date = date ( 'Y-m-d H:i:s' );
						$model_plan_coverage_type->modified_by = $logged_user_id;
					}
					
					
					// begin transaction
					$transaction = \Yii::$app->db->beginTransaction ();
					
					try {
						
						if ($model_plan_coverage_type->save () && $model_plan_coverage_type->validate ()) {
							$plan_class_id = $model_plan_coverage_type->plan_class_id;
							
							if (! empty ( $Planoffertypeyears )) {
								
								$model_plan_offer_years = new TblAcaPlanOfferTypeYears ();
								
								$check_all_offertype_years = $model_plan_offer_years->FindbyplanclassId ( $plan_class_id );
								if (! empty ( $check_all_offertype_years )) {
									TblAcaPlanOfferTypeYears::deleteAll ( [ 
											'plan_class_id' => $plan_class_id,
											
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
											
											
											$result ['error'] = $model_plan_offer_years->errors;
										}
									}
									
								}
								
								
								TblAcaValidationLog::deleteAll ( [ 
														'and',
														'company_id  = :company_id',
														[ 
																'in',
																'validation_rule_id',
																140 
														] 
												], [ 
														':company_id' => $company_id 
												] );
												
									/*start validation status*/
									TblAcaPlanClassValidationLog::deleteAll ( [
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
									
							$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();		

                                    if(!empty($model_company_validation_log))		{				
										$model_company_validation_log->is_initialized = 0;	
                                        $model_company_validation_log->is_executed = 0;		
                                        $model_company_validation_log->is_completed = 0;	

										$model_company_validation_log->is_plan_class = 0;
										if($plantype != $old_plan_type )
										{
											
											$model_company_validation_log->is_medical_data = 0;
											
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
										
										$model_company_validation_log->save();
										
										//update company status
										$check_company_details->reporting_status = 29;
										$check_company_details->save();
																					
                                         }	
										 
										 
								$model_validation_log->company_id = $company_id;
								$model_validation_log->validation_rule_id = 140;
								$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
								$model_validation_log->is_validated = 1;
								$model_validation_log->save();	

								
								$transaction->commit ();
								$result ['success'] = 'success';
								$result ['plan_class_id'] = $plan_class_id;
							}
						} else {
							$result ['error'] = $model_plan_coverage_type->errors[1];
						}
					} catch ( \Exception $e ) {
						
						$result ['error'] = $e->getMessage ();
						
						// rollback transaction
						$transaction->rollback ();
					}
					
					return $result;
					
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
	/**Action for updating plan classes**/
	public function actionUpdateplanclass() {
		$this->layout = 'main';
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			/**Initializing models**/
			$encrypt_component = new EncryptDecryptComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_company_users = new TblAcaCompanyUsers ();
			$model_client_rights_master = new TblAcaClientRightsMaster ();
			$model_users = new TblAcaUsers ();
			$model_element_master = new TblAcaElementMaster ();
			$model_plan_coverage_type = new TblAcaPlanCoverageType ();
			$model_plan_offer_type_years = new TblAcaPlanOfferTypeYears ();
			$model_plan_coverage_type_offered = new TblAcaPlanCoverageTypeOffered ();
			$model_plan_emp_contributions = new TblAcaEmpContributions ();
			$model_plan_emp_contributions_premium = new TblAcaEmpContributionsPremium ();
			
			/**Declaring Variables***/
			$user_details = array ();
			$permissions = array ();
			$company_user_permissions = array ();
			$result = array ();
			$arr_offer_types = array();
			
			/**Declaring Session variables**/
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			$get_company_id = \Yii::$app->request->get ();
			
			if (! empty ( $get_company_id )) {
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id );//decrypted company id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); //Checking if company exists with that company id
					$client_id = $check_company_details->client_id;//company client_id
				}
				
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					if (! empty ( $get_company_id ['plan_id'] )) {
						$encrypt_plan_id = $get_company_id ['plan_id'];
						$plan_id = $encrypt_component->decryptUser ( $encrypt_plan_id );
						
						/**
						 * Get plan class
						 */
						$plan_details = $model_plan_coverage_type->FindplanbyId ( $plan_id,$company_id );
						
						/**
						 * *Get plan class coverage type*
						 */
						$plan_coverage_type_offered = $model_plan_coverage_type_offered->FindplanbyId ( $plan_id );
						
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
						
						if (! empty ( $plan_details )) {
							
							/***************get section elements**********************/
							$section_ids = ['9','10','11'];
							$all_elements = $model_element_master->FindallbysectionIds($section_ids);
							
							$arrsection_elements = ArrayHelper::map($all_elements, 'element_id', 'element_label');
								
							/******************Get plan offer type years***************************/
							
							$all_offer_types = $model_plan_offer_type_years->FindbyplanclassId($plan_id);
							if(!empty($all_offer_types)){
							$arr_offer_types = ArrayHelper::map($all_offer_types, 'plan_year', 'plan_year_value', 'plan_year_type');
							}
							
							
							$model_plan_coverage_type = $plan_details;
							
							if ($model_plan_coverage_type->load ( \Yii::$app->request->post () )) {
								
								$plan_coverage_type_details = \Yii::$app->request->post ();
								$plan_coverage_type_details ['TblAcaPlanCoverageType'] ['plan_class_id'] = $plan_id;
								
								if (! empty ( $model_plan_coverage_type)) {
									
									$redirect_button = $plan_coverage_type_details ['button'];
									$result = $this->PlanCoverageType ( $plan_coverage_type_details, $encrypt_company_id );
									
									if (! empty ( $result ['success'] )) {
										
										if ($redirect_button == 'exit') {
											\Yii::$app->session->setFlash ( 'success', 'Plan Class coverage type updated successfully' );
											
											return $this->redirect ( array (
													'/client/planclass?c_id=' . $encrypt_company_id 
											) );
										} else {
											
											\Yii::$app->session->setFlash ( 'success', 'Plan Class coverage type updated successfully' );
											
											return $this->redirect ( array (
													'/client/planclass/updateplanclass?c_id=' . $encrypt_company_id . '&plan_id=' . $encrypt_plan_id . '#typeofcoverage' 
											) );
										}
									} elseif (! empty ( $result ['error'] )) {
										
										if (! empty ( $result ['error'] ['plan_class_name'] )) {
											$error = $result ['error'] ['plan_class_name'] [0];
											$model_plan_coverage_type->addError ( 'plan_class_name', $error );
										} else {
											
											\Yii::$app->session->setFlash ( 'error', $result ['error'] );
										}
									}
								}
							}
							
							return $this->render ( 'updateplanclass', [ 
									'model_element_master' => $model_element_master,
									'company_details' => $check_company_details,
									'model_plan_coverage_type' => $model_plan_coverage_type,
									'model_plan_offer_type_years' => $model_plan_offer_type_years,
									'model_plan_coverage_type_offered' => $model_plan_coverage_type_offered,
									'model_plan_emp_contributions' => $model_plan_emp_contributions,
									'model_plan_emp_contributions_premium' => $model_plan_emp_contributions_premium,
									'arrsection_elements'=>$arrsection_elements,
									'arr_offer_types'=>$arr_offer_types
							] );
						} else {
							return $this->redirect ( array (
									'/client/planclass?c_id=' . $encrypt_company_id 
							) );
						}
					} else {
						return $this->redirect ( array (
								'/client/planclass?c_id=' . $encrypt_company_id 
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
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	public function actionCoveragetypeoffered() {
		$this->layout = 'main';
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			$encrypt_component = new EncryptDecryptComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_company_users = new TblAcaCompanyUsers ();
			$model_client_rights_master = new TblAcaClientRightsMaster ();
			$model_users = new TblAcaUsers ();
			$model_element_master = new TblAcaElementMaster ();
			$model_plan_coverage_type = new TblAcaPlanCoverageType ();
			$model_plan_offer_type_years = new TblAcaPlanOfferTypeYears ();
			$model_plan_coverage_type_offered = new TblAcaPlanCoverageTypeOffered ();
			$model_validation_log =  new TblAcaValidationLog();
			
			$user_details = array ();
			$permissions = array ();
			$company_user_permissions = array ();
			$result = array ();
			$mv_coverage_months_array = array ();
			$essential_coverage_months_array = array ();
			$validation_rule_ids =  array();
			$employee_mv_coverage = '';
			$mv_coverage_months = '';
			$employee_essential_coverage = '';
			$essential_coverage_months = '';
			$spouse_essential_coverage = '';
			$spouse_conditional_coverage = '';
			$dependent_essential_coverage = '';
			
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
							'74' 
					];
			
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			$get_company_id = \Yii::$app->request->get ();
			
			if (! empty ( $get_company_id )) {
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id );
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id );
					$client_id = $check_company_details->client_id;
				}
				
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					if (! empty ( $get_company_id ['plan_id'] )) {
						$encrypt_plan_id = $get_company_id ['plan_id'];
						$plan_id = $encrypt_component->decryptUser ( $encrypt_plan_id );
						
						/**
						 * Get plan class
						 */
						$plan_details = $model_plan_coverage_type->FindplanbyId ( $plan_id,$company_id );
						
						/**
						 * *Get plan class coverage type*
						 */
						$plan_coverage_type_offered = $model_plan_coverage_type_offered->FindplanbyId ( $plan_id );
						if (! empty ( $plan_details )) {
							
							$coverage_offer_type_post = \Yii::$app->request->post ();
							
							if (! empty ( $coverage_offer_type_post['TblAcaPlanCoverageTypeOffered'] )) {
								$redirect_button = $coverage_offer_type_post ['button'];
								
								if (! empty ( $plan_coverage_type_offered )) {
									$model_plan_coverage_type_offered = $plan_coverage_type_offered;
								}
								
								/**
								 * assigning post variables*
								 */
								if(!empty($coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['employee_mv_coverage'])){
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
								
								if(!empty($coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['employee_essential_coverage'])){
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
								
								if(!empty($coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['spouse_essential_coverage'])){
								$spouse_essential_coverage = $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['spouse_essential_coverage'];
								}
								if(!empty($coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['spouse_conditional_coverage'])){
								$spouse_conditional_coverage = $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['spouse_conditional_coverage'];
								}
								if(!empty($coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['dependent_essential_coverage'])){
								$dependent_essential_coverage = $coverage_offer_type_post ['TblAcaPlanCoverageTypeOffered'] ['dependent_essential_coverage'];
								}
								// ***Assigning variables in model***//
								$model_plan_coverage_type_offered->plan_class_id = $plan_id;
								$model_plan_coverage_type_offered->employee_mv_coverage = $employee_mv_coverage;
								$model_plan_coverage_type_offered->mv_coverage_months = $mv_coverage_months;
								$model_plan_coverage_type_offered->employee_essential_coverage = $employee_essential_coverage;
								$model_plan_coverage_type_offered->essential_coverage_months = $essential_coverage_months;
								$model_plan_coverage_type_offered->spouse_essential_coverage = $spouse_essential_coverage;
								$model_plan_coverage_type_offered->spouse_conditional_coverage = $spouse_conditional_coverage;
								$model_plan_coverage_type_offered->dependent_essential_coverage = $dependent_essential_coverage;
								
								if ($model_plan_coverage_type_offered->isNewRecord) {
									$model_plan_coverage_type_offered->created_date = date ( 'Y-m-d H:i:s' );
									$model_plan_coverage_type_offered->created_by = $logged_user_id;
								} else {
									$model_plan_coverage_type_offered->modified_date = date ( 'Y-m-d H:i:s' );
									$model_plan_coverage_type_offered->modified_by = $logged_user_id;
								}
								
								// begin transaction
								$transaction = \Yii::$app->db->beginTransaction ();
								
								try {
									
									if ($model_plan_coverage_type_offered->save () && $model_plan_coverage_type_offered->validate ()) {
									
										
								TblAcaValidationLog::deleteAll ( [ 
														'and',
														'company_id  = :company_id',
														[ 
																'in',
																'validation_rule_id',
																140 
														] 
												], [ 
														':company_id' => $company_id 
												] );
												
									/*start validation status*/
									TblAcaPlanClassValidationLog::deleteAll ( [
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
									
							$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();		

                                    if(!empty($model_company_validation_log))		{				
										$model_company_validation_log->is_initialized = 0;	
                                        $model_company_validation_log->is_executed = 0;		
                                        $model_company_validation_log->is_completed = 0;	

										$model_company_validation_log->is_plan_class = 0;
										
										
										$model_company_validation_log->save();	

										//update company status
										$check_company_details->reporting_status = 29;
										$check_company_details->save();										
                                         }	
										 
										 
								$model_validation_log->company_id = $company_id;
								$model_validation_log->validation_rule_id = 140;
								$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
								$model_validation_log->is_validated = 1;
								$model_validation_log->save();	

								
								
										$transaction->commit ();
										if ($redirect_button == 'exit') {
											\Yii::$app->session->setFlash ( 'success', 'Plan Class coverage type offered updated successfully' );
											
											return $this->redirect ( array (
													'/client/planclass?c_id=' . $encrypt_company_id 
											) );
										} else {
											
											\Yii::$app->session->setFlash ( 'success', 'Plan Class coverage type offered updated successfully' );
											
											return $this->redirect ( array (
													'/client/planclass/updateplanclass?c_id=' . $encrypt_company_id . '&plan_id=' . $encrypt_plan_id . '#empcontributions' 
											) );
										}
									} else {
										
										\Yii::$app->session->setFlash ( 'error', 'Error occurred while saving.' );
										
										return $this->redirect ( array (
												'/client/planclass/updateplanclass?c_id=' . $encrypt_company_id . '&plan_id=' . $encrypt_plan_id . '#typeofcoverage' 
										) );
									}
								} catch ( \Exception $e ) {
									
									$msg = $e->getMessage ();
									\Yii::$app->session->setFlash ( 'error', $msg );
									
									// rollback transaction
									$transaction->rollback ();
								}
							}
							else {
								
								\Yii::$app->session->setFlash ( 'error', 'No data to save' );
									
								return $this->redirect ( array (
												'/client/planclass/updateplanclass?c_id=' . $encrypt_company_id . '&plan_id=' . $encrypt_plan_id . '#typeofcoverage' 
										) );
							}
						} else {
							return $this->redirect ( array (
									'/client/planclass?c_id=' . $encrypt_company_id 
							) );
						}
					} else {
						return $this->redirect ( array (
								'/client/planclass?c_id=' . $encrypt_company_id 
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
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
	}
	public function actionEmpcontribution() {
		$this->layout = 'main';
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			$encrypt_component = new EncryptDecryptComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_company_users = new TblAcaCompanyUsers ();
			$model_client_rights_master = new TblAcaClientRightsMaster ();
			$model_users = new TblAcaUsers ();
			$model_element_master = new TblAcaElementMaster ();
			$model_plan_coverage_type = new TblAcaPlanCoverageType ();
			$model_plan_offer_type_years = new TblAcaPlanOfferTypeYears ();
			$model_plan_coverage_type_offered = new TblAcaPlanCoverageTypeOffered ();
			$model_plan_emp_contributions = new TblAcaEmpContributions ();
			$model_plan_emp_contributions_premium = new TblAcaEmpContributionsPremium ();
			
			$user_details = array ();
			$permissions = array ();
			$company_user_permissions = array ();
			$result = array ();
			$safe_harbor = '';
			$employee_plan_contribution = '';
			
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			$get_company_id = \Yii::$app->request->get ();
			
			if (! empty ( $get_company_id )) {
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id );
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id );
					$client_id = $check_company_details->client_id;
				}
				
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					if (! empty ( $get_company_id ['plan_id'] )) {
						$encrypt_plan_id = $get_company_id ['plan_id'];
						$plan_id = $encrypt_component->decryptUser ( $encrypt_plan_id );
						
						/**
						 * Get plan class
						 */
						$plan_details = $model_plan_coverage_type->FindplanbyId ( $plan_id,$company_id );
						
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
							
							$emp_contribution_post = \Yii::$app->request->post ();
							
							if(!empty($emp_contribution_post ['TblAcaEmpContributionsPremium']))
							{
							$redirect_button = $emp_contribution_post ['button'];
							
							
							$premium_contribution = $emp_contribution_post ['TblAcaEmpContributionsPremium'] ['premium_value'];
							
							if(!empty($emp_contribution_post ['TblAcaEmpContributions'] ['safe_harbor']))
							{
								$safe_harbor = $emp_contribution_post ['TblAcaEmpContributions'] ['safe_harbor'];
							}
							
							if(!empty($emp_contribution_post ['TblAcaEmpContributions'] ['employee_plan_contribution']))
							{
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
							
							
							// begin transaction
							$transaction = \Yii::$app->db->beginTransaction ();
							
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
											$result ['success'] = 'success';
										} else {
											$result ['error'] = $model_plan_emp_contributions_premium->errors;
											
										}
									}
									
									if ($result ['success'] == 'success') {
										$transaction->commit ();
										
										if ($redirect_button == 'exit') {
											\Yii::$app->session->setFlash ( 'success', 'Plan Class employee contributions updated successfully' );
											
											return $this->redirect ( array (
													'/client/planclass?c_id=' . $encrypt_company_id 
											) );
										} else {
											
											\Yii::$app->session->setFlash ( 'success', 'Plan Class employee contributions updated successfully' );
											
											return $this->redirect ( array (
													'/client/planclass?c_id=' . $encrypt_company_id 
											) );
										}
									}
								} else {
									
									\Yii::$app->session->setFlash ( 'error', 'Error occurred while saving.' );
									
									return $this->redirect ( array (
											'/client/planclass/updateplanclass?c_id=' . $encrypt_company_id . '&plan_id=' . $encrypt_plan_id . '#empcontributions' 
									) );
								}
							} catch ( \Exception $e ) {
								
								$msg = $e->getMessage ();
								\Yii::$app->session->setFlash ( 'error', $msg );
								
								// rollback transaction
								$transaction->rollback ();
							}
							
						}
						else {
						
							\Yii::$app->session->setFlash ( 'error', 'No data to save' );
								
							return $this->redirect ( array (
									'/client/planclass/updateplanclass?c_id=' . $encrypt_company_id . '&plan_id=' . $encrypt_plan_id . '#empcontributions'
							) );
						}	
						} else {
							return $this->redirect ( array (
									'/client/planclass?c_id=' . $encrypt_company_id 
							) );
						}
					} else {
						return $this->redirect ( array (
								'/client/planclass?c_id=' . $encrypt_company_id 
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
			\Yii::$app->SessionCheck->clientlogout ();
			
			return $this->goHome ();
		}
		
		
		
	}
}
