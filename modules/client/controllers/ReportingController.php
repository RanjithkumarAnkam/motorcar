<?php

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
use yii\db\Exception;
use app\models\TblAcaBasicInformation;
use app\models\TblAcaEmpStatusTrack;
use app\models\TblAcaPlanCriteria;
use app\models\TblAcaDesignatedGovtEntity;
use app\models\TblAcaBasicAdditionalDetail;
use app\models\TblAcaAggregatedGroup;
use app\models\TblAcaAggregatedGroupList;
use yii\helpers\ArrayHelper;
use app\models\TblAcaCompanyValidationStatus;
use app\models\TblAcaValidationLog;


class ReportingController extends Controller {
	public function actionIndex() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			$this->layout = 'main';
			
			/**Initializing models**/
			$encrypt_component = new EncryptDecryptComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_company_users = new TblAcaCompanyUsers ();
			$model_client_rights_master = new TblAcaClientRightsMaster ();
			$model_users = new TblAcaUsers ();
			$model_element_master = new TblAcaElementMaster ();
			$model_basic_info = new TblAcaBasicInformation();
			$model_large_emp_status = new TblAcaEmpStatusTrack();
			$model_plan_offering_criteria =  new TblAcaPlanCriteria();
			$model_designated_govt_entity = new TblAcaDesignatedGovtEntity();
			$model_basic_additional_details = new TblAcaBasicAdditionalDetail();
			$model_aggregated_group = new TblAcaAggregatedGroup();
			$model_aggregated_group_list = new TblAcaAggregatedGroupList();
			
			$client_id = '';
			$aggregated_list= '';
			$arrsection_elements = array();
			/**
			 * Declaring Session Variables**
			 */
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			/**
			 * Get from URL*
			 */
			$get_company_id = \Yii::$app->request->get ();
			
			if (! empty ( $get_company_id )) {
				/**
				 * Encrypted company ID*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
					if(!empty($check_company_details)){
					$client_id = $check_company_details->client_id; // Company clien Id
					}
					}
				/**
				 * *Checking if company details exists for the company_id and company and client is present in session**
				 */
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$period_details = $model_companies->getcompanyperiod ( $company_id );
					$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
					
					/***************get section elements**********************/
					$section_ids = ['1','2','3','4','5','6'];
					$all_elements = $model_element_master->FindallbysectionIds($section_ids);
					
					$arrsection_elements = ArrayHelper::map($all_elements, 'element_id', 'element_label');
					
					
					
					/**********Check basic information****************/	
					$check_basic_info = $model_basic_info->FindbycompanyIdperiodId($company_id, $period_id);
					if(!empty($check_basic_info))
					{
						$model_basic_info = $check_basic_info;
					}
					
					/**********Check Large Employer Status & Tracking****************/
					$check_emp_status = $model_large_emp_status->FindbycompanyIdperiodId($company_id, $period_id);
					if(!empty($check_emp_status))
					{
						$model_large_emp_status = $check_emp_status;
					}
					
					/**********Check  Plan Offering Criteria****************/
					$check_plan_criteria = $model_plan_offering_criteria->FindbycompanyIdperiodId($company_id, $period_id);
					if(!empty($check_plan_criteria))
					{
						$model_plan_offering_criteria = $check_plan_criteria;
					}
					
					
					/**********Check  Designated Government Entity****************/
					$check_designated_govt_entity = $model_designated_govt_entity->FindbycompanyIdperiodId($company_id, $period_id);
					if(!empty($check_designated_govt_entity))
					{
						$model_designated_govt_entity = $check_designated_govt_entity;
					}
					

					/**********Check  Any thing else to do****************/
					$anything_else_to = $model_basic_additional_details->FindbycompanyIdperiodId($company_id, $period_id);
					if(!empty($anything_else_to))
					{
						$model_basic_additional_details = $anything_else_to;
					}
						
					/**********Check  agregated group ****************/
					$check_aggregated = $model_aggregated_group->FindbycompanyIdperiodId($company_id, $period_id);
					if(!empty($check_aggregated))
					{
						$model_aggregated_group = $check_aggregated;
					
						/**********Check  agregated group list****************/
						$aggregated_list = $model_aggregated_group_list->FindbyaggregateId($check_aggregated->aggregated_grp_id);
					
					}
						
					
					return $this->render ( 'index', [ 
							'model_element_master' => $model_element_master,
							'company_details' => $check_company_details,
							'model_basic_info'=>$model_basic_info,
							'model_large_emp_status'=>$model_large_emp_status,
							'model_plan_offering_criteria'=>$model_plan_offering_criteria,
							'model_designated_govt_entity'=>$model_designated_govt_entity,
							'model_basic_additional_details'=>$model_basic_additional_details,
							'model_aggregated_group_list'=>$model_aggregated_group_list,
							'model_aggregated_group'=>$model_aggregated_group,
							'aggregated_list'=>$aggregated_list,
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
			\Yii::$app->SessionCheck->clientlogout (); // client logout
			
			return $this->goHome ();
		}
		
		
		
		
	}
	
	public function actionSavebasicinfo()
	{
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			
			/**Initializing models**/
			$encrypt_component = new EncryptDecryptComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_company_users = new TblAcaCompanyUsers ();
			$model_client_rights_master = new TblAcaClientRightsMaster ();
			$model_users = new TblAcaUsers ();
			$model_element_master = new TblAcaElementMaster ();
			$model_basic_info = new TblAcaBasicInformation();
			$client_id = '';
			$contact_phone_number = '';
			$emp_benefit_phone_number = '';
			$result = array();
			$arrerrors = array();
			$validation_rule_ids =  array();
			
			for($i=1;$i<=54;$i++)
			{
				$validation_rule_ids[] = $i;
				
			}
			
			$validation_rule_ids[] = 143;
			$validation_rule_ids[] = 144;
			$validation_rule_ids[] = 145;
			
			
					
			/**
			 * Declaring Session Variables**
			 */
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			
				$encrypt_company_id = \Yii::$app->request->get ('c_id');
			
				/**
				 * Encrypted company ID*
				 */
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
					if(!empty($check_company_details)){
					$client_id = $check_company_details->client_id; // Company clien Id
					}
					}
				/**
				 * *Checking if company details exists for the company_id and company and client is present in session**
				 */
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$period_details = $model_companies->getcompanyperiod ( $company_id );
					$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
						
					
					$check_basic_info = $model_basic_info->FindbycompanyIdperiodId($company_id, $period_id);
					if(!empty($check_basic_info))
					{
						$model_basic_info = $check_basic_info;
					}
					
					/**Check for any post of data**/
					if ($model_basic_info->load ( \Yii::$app->request->post () )) {
						
						/**Check for the type of button clicked i.e (Save and continue) or (Save and Exit)**/
						$redirect_button = \Yii::$app->request->post ('button');
						$postbasicinformation = \Yii::$app->request->post ('TblAcaBasicInformation');
						if (! empty ( $postbasicinformation ['contact_phone_number'] )) {
							$contact_phone_number = preg_replace ( '/[^A-Za-z0-9\']/', '',  $postbasicinformation ['contact_phone_number'] ); // escape apostraphe
						}
						if (! empty ( $postbasicinformation ['emp_benefit_phone_number'] )) {
							$emp_benefit_phone_number = preg_replace ( '/[^A-Za-z0-9\']/', '',  $postbasicinformation ['emp_benefit_phone_number'] ); // escape apostraphe
						}
						
						// begin transaction
						$transaction = \Yii::$app->db->beginTransaction ();
							
						try {
						$model_basic_info->attributes =  $postbasicinformation;
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
						
						if($model_basic_info->save() && $model_basic_info->validate())
						{
							
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
												
												
					$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();		

                                    if(!empty($model_company_validation_log))		{				
										$model_company_validation_log->is_initialized = 0;	
                                        $model_company_validation_log->is_executed = 0;		
                                        $model_company_validation_log->is_completed = 0;	

										$model_company_validation_log->is_basic_info = 0;
										$model_company_validation_log->save();	
										
										//update company status
										$check_company_details->reporting_status = 29;
										$check_company_details->save();
                                         }	
										 
							$transaction->commit();
							
							if ($redirect_button == 'exit') {
								\Yii::$app->session->setFlash ( 'success', 'Basic Information updated successfully' );
								/**Redirect to Index (Company dashboard)**/
								return $this->redirect ( array (
												'/client/dashboard?c_id=' . $encrypt_company_id
										) );
							} else {
									
								\Yii::$app->session->setFlash ( 'success', 'Basic Information updated successfully' );
								/**Redirect to next tab i.e Employee status tracking**/
								return $this->redirect ( array (
									'/client/reporting?c_id=' . $encrypt_company_id.'#empstatustracking'
							) );
							}	
						}
						else {
							$arrerrors = $model_basic_info->getFirstErrors();
							$errorstring = '';
							/*******Converting error into string********/
							foreach ($arrerrors as $key=>$value)
							{
								$errorstring .= $value.'<br>';
							}
							
							throw new \Exception($errorstring);
						}
						} catch ( \Exception $e ) {
						
							$msg  = $e->getMessage ();
							\Yii::$app->session->setFlash ( 'error', $msg );
							// rollback transaction
							$transaction->rollback ();
							/**Redirect to Index (Company dashboard)**/
							return $this->redirect ( array (
									'/client/reporting?c_id=' . $encrypt_company_id.'#basicinformation'
							) );
							
							
						}
					
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
	
	
	
	public function actionLargeempstatustrack()
	{
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			
			
			/**Initializing models**/
			$encrypt_component = new EncryptDecryptComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_company_users = new TblAcaCompanyUsers ();
			$model_client_rights_master = new TblAcaClientRightsMaster ();
			$model_users = new TblAcaUsers ();
			$model_element_master = new TblAcaElementMaster ();
			$model_large_emp_status = new TblAcaEmpStatusTrack();
			$client_id = '';
			$result = array();
			$arrerrors = array();
			
			$validation_rule_ids =  array();
			
			for($i=1;$i<=54;$i++)
			{
				$validation_rule_ids[] = $i;
				
			}
			
			$validation_rule_ids[] = 143;
			$validation_rule_ids[] = 144;
			$validation_rule_ids[] = 145;
			
			/**
			 * Declaring Session Variables**
			 */
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			
				$encrypt_company_id = \Yii::$app->request->get ('c_id');
			
				/**
				 * Encrypted company ID*
				 */
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
					if(!empty($check_company_details)){
					$client_id = $check_company_details->client_id; // Company clien Id
					}
					}
				/**
				 * *Checking if company details exists for the company_id and company and client is present in session**
				 */
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$period_details = $model_companies->getcompanyperiod ( $company_id );
					$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
						
					
					$check_emp_status = $model_large_emp_status->FindbycompanyIdperiodId($company_id, $period_id);
					if(!empty($check_emp_status))
					{
						$model_large_emp_status = $check_emp_status;
					}
					
					/**Check for any post of data**/
					if ($model_large_emp_status->load ( \Yii::$app->request->post () )) {
						
						/**Check for the type of button clicked i.e (Save and continue) or (Save and Exit)**/
						$redirect_button = \Yii::$app->request->post ('button');
						$postempstatus = \Yii::$app->request->post ('TblAcaEmpStatusTrack');
						
						// begin transaction
						$transaction = \Yii::$app->db->beginTransaction ();
							
						try {
						$model_large_emp_status->attributes =  $postempstatus;
						$model_large_emp_status->company_id = $company_id;
						$model_large_emp_status->period_id = $period_id;
						
						if ($model_large_emp_status->isNewRecord) {
							$model_large_emp_status->created_date = date ( 'Y-m-d H:i:s' );
							$model_large_emp_status->created_by = $logged_user_id;
						} else {
							$model_large_emp_status->modified_date = date ( 'Y-m-d H:i:s' );
							$model_large_emp_status->modified_by = $logged_user_id;
						}
						
						if($model_large_emp_status->save() && $model_large_emp_status->validate())
						{
							
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
												
												
				$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();		

                                    if(!empty($model_company_validation_log))		{				
										$model_company_validation_log->is_initialized = 0;	
                                        $model_company_validation_log->is_executed = 0;		
                                        $model_company_validation_log->is_completed = 0;	

										$model_company_validation_log->is_basic_info = 0;
										$model_company_validation_log->save();	

										//update company status
										$check_company_details->reporting_status = 29;
										$check_company_details->save();										
                                         }	
							$transaction->commit();
							
							if ($redirect_button == 'exit') {
								\Yii::$app->session->setFlash ( 'success', 'Large Employer Status & Tracking Updated Successfully' );
								/**Redirect to Index (Company dashboard)**/
								return $this->redirect ( array (
												'/client/dashboard?c_id=' . $encrypt_company_id
										) );
							} else {
									
								\Yii::$app->session->setFlash ( 'success', 'Large Employer Status & Tracking Updated Successfully' );
								/**Redirect to next tab i.e Type of coverage offered**/
								return $this->redirect ( array (
									'/client/reporting?c_id=' . $encrypt_company_id.'#planofferingcriteria'
							) );
							}	
						}
						else {
							$arrerrors = $model_large_emp_status->getFirstErrors();
							$errorstring = '';
							
							foreach ($arrerrors as $key=>$value)
							{
								$errorstring .= $value.'<br>';
							}
							
							throw new \Exception($errorstring);
						}
						} catch ( \Exception $e ) {
						
							$msg  = $e->getMessage ();
							\Yii::$app->session->setFlash ( 'error', $msg );
							// rollback transaction
							$transaction->rollback ();
							/**Redirect to Index (Company dashboard)**/
							return $this->redirect ( array (
									'/client/reporting?c_id=' . $encrypt_company_id.'#empstatustracking'
							) );
							
							
						}
					
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
	
	
	
	public function actionPlanofferingcriteria()
	{
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			
			
			/**Initializing models**/
			$encrypt_component = new EncryptDecryptComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_company_users = new TblAcaCompanyUsers ();
			$model_client_rights_master = new TblAcaClientRightsMaster ();
			$model_users = new TblAcaUsers ();
			$model_element_master = new TblAcaElementMaster ();
			$model_plan_offering_criteria =  new TblAcaPlanCriteria();
			$client_id = '';
			$plan_offering_criteria_type ='';
			$initial_measurment_period_begin= '';
			$result = array();
			$arrerrors = array();
			
			$validation_rule_ids =  array();
			
			for($i=1;$i<=54;$i++)
			{
				$validation_rule_ids[] = $i;
				
			}
			
			$validation_rule_ids[] = 143;
			$validation_rule_ids[] = 144;
			$validation_rule_ids[] = 145;
			
			/**
			 * Declaring Session Variables**
			 */
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			
				$encrypt_company_id = \Yii::$app->request->get ('c_id');
			
				/**
				 * Encrypted company ID*
				 */
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
					if(!empty($check_company_details)){
					$client_id = $check_company_details->client_id; // Company clien Id
					}
					}
				/**
				 * *Checking if company details exists for the company_id and company and client is present in session**
				 */
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$period_details = $model_companies->getcompanyperiod ( $company_id );
					$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
						
					
				/**********Check  Plan Offering Criteria****************/
					$check_plan_criteria = $model_plan_offering_criteria->FindbycompanyIdperiodId($company_id, $period_id);
					if(!empty($check_plan_criteria))
					{
						$model_plan_offering_criteria = $check_plan_criteria;
					}
					
					
					/**Check for any post of data**/
					if ($model_plan_offering_criteria->load ( \Yii::$app->request->post () )) {
						
						/**Check for the type of button clicked i.e (Save and continue) or (Save and Exit)**/
						$redirect_button = \Yii::$app->request->post ('button');
						$postplancriteria = \Yii::$app->request->post ('TblAcaPlanCriteria');
						if (! empty ( $postplancriteria ['plan_offering_criteria_type'] )) {
							
							$criteria_type = $postplancriteria ['plan_offering_criteria_type'];
							foreach ($criteria_type as $key=>$value)
							{
								$plan_offering_criteria_type .= $value.',';
							}
						}
						
						if (! empty ( $postplancriteria ['initial_measurment_period_begin'] )) {
								
							$initial_measurment_period_begin = $postplancriteria ['initial_measurment_period_begin'];
							
						}
						
						
						// begin transaction
						$transaction = \Yii::$app->db->beginTransaction ();
						
						try {
						$model_plan_offering_criteria->attributes =  $postplancriteria;
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
						
						if($model_plan_offering_criteria->save() && $model_plan_offering_criteria->validate())
						{
							
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
												
												
					$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();		

                                    if(!empty($model_company_validation_log))		{				
										$model_company_validation_log->is_initialized = 0;	
                                        $model_company_validation_log->is_executed = 0;		
                                        $model_company_validation_log->is_completed = 0;	

										$model_company_validation_log->is_basic_info = 0;
										$model_company_validation_log->save();	

										//update company status
										$check_company_details->reporting_status = 29;
										$check_company_details->save();										
                                         }	
							$transaction->commit();
							
							if ($redirect_button == 'exit') {
								\Yii::$app->session->setFlash ( 'success', 'Plan Offering Criteria Updated Successfully' );
								/**Redirect to Index (Company dashboard)**/
								return $this->redirect ( array (
												'/client/dashboard?c_id=' . $encrypt_company_id
										) );
							} else {
									
								\Yii::$app->session->setFlash ( 'success', 'Plan Offering Criteria Updated Successfully' );
								/**Redirect to next tab i.e Type of coverage offered**/
								return $this->redirect ( array (
									'/client/reporting?c_id=' . $encrypt_company_id.'#designatedgovtentity'
							) );
							}	
						}
						else {
							$arrerrors = $model_plan_offering_criteria->getFirstErrors();
							$errorstring = '';
							
							foreach ($arrerrors as $key=>$value)
							{
								$errorstring .= $value.'<br>';
							}
							
							throw new \Exception($errorstring);
						}
						} catch ( \Exception $e ) {
						
							$msg  = $e->getMessage ();
							\Yii::$app->session->setFlash ( 'error', $msg );
							// rollback transaction
							$transaction->rollback ();
							/**Redirect to Index (Company dashboard)**/
							return $this->redirect ( array (
									'/client/reporting?c_id=' . $encrypt_company_id.'#planofferingcriteria'
							) );
							
							
						}
					
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
	
	
	public function actionDesignatedgovtentity()
	{
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			
			
			/**Initializing models**/
			$encrypt_component = new EncryptDecryptComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_company_users = new TblAcaCompanyUsers ();
			$model_client_rights_master = new TblAcaClientRightsMaster ();
			$model_users = new TblAcaUsers ();
			$model_element_master = new TblAcaElementMaster ();
			$model_designated_govt_entity = new TblAcaDesignatedGovtEntity();
			$client_id = '';
			$plan_offering_criteria_type ='';
			$dge_reporting = '';
			$dge_contact_phone_number = '';
			$result = array();
			$arrerrors = array();
			
			$validation_rule_ids =  array();
			
			for($i=1;$i<=54;$i++)
			{
				$validation_rule_ids[] = $i;
				
			}
			
			$validation_rule_ids[] = 143;
			$validation_rule_ids[] = 144;
			$validation_rule_ids[] = 145;
			
			/**
			 * Declaring Session Variables**
			 */
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			
				$encrypt_company_id = \Yii::$app->request->get ('c_id');
			
				/**
				 * Encrypted company ID*
				 */
				if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
					if(!empty($check_company_details)){
					$client_id = $check_company_details->client_id; // Company clien Id
					}
					}
				/**
				 * *Checking if company details exists for the company_id and company and client is present in session**
				 */
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					$period_details = $model_companies->getcompanyperiod ( $company_id );
					$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
						
					
				/**********Check  Designated Government Entity****************/
					$check_designated_govt_entity = $model_designated_govt_entity->FindbycompanyIdperiodId($company_id, $period_id);
					if(!empty($check_designated_govt_entity))
					{
						$model_designated_govt_entity = $check_designated_govt_entity;
					}
					
					
					/**Check for any post of data**/
					if ($model_designated_govt_entity->load ( \Yii::$app->request->post () )) {
						
						/**Check for the type of button clicked i.e (Save and continue) or (Save and Exit)**/
						$redirect_button = \Yii::$app->request->post ('button');
						$postdesignated = \Yii::$app->request->post ('TblAcaDesignatedGovtEntity');
						if (! empty ( $postdesignated ['dge_reporting'] )) {
						
							$dge_reporting = $postdesignated ['dge_reporting'];
								
						}
						
						if (! empty ( $postdesignated ['dge_contact_phone_number'] )) {
							$dge_contact_phone_number = preg_replace ( '/[^A-Za-z0-9\']/', '',  $postdesignated ['dge_contact_phone_number'] ); // escape apostraphe
						}
						
						// begin transaction
						$transaction = \Yii::$app->db->beginTransaction ();
							
						try {
						$model_designated_govt_entity->attributes =  $postdesignated;
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
						
						if($model_designated_govt_entity->save() && $model_designated_govt_entity->validate())
						{
							
							
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
												
												
					$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();		

                                    if(!empty($model_company_validation_log))		{				
										$model_company_validation_log->is_initialized = 0;	
                                        $model_company_validation_log->is_executed = 0;		
                                        $model_company_validation_log->is_completed = 0;	

										$model_company_validation_log->is_basic_info = 0;
										$model_company_validation_log->save();	
										
										//update company status
										$check_company_details->reporting_status = 29;
										$check_company_details->save();										
                                         }	
							$transaction->commit();
							
							if ($redirect_button == 'exit') {
								\Yii::$app->session->setFlash ( 'success', 'Designated Government Entity Updated Successfully' );
								
								return $this->redirect ( array (
												'/client/dashboard?c_id=' . $encrypt_company_id
										) );
							} else {
									
								\Yii::$app->session->setFlash ( 'success', 'Designated Government Entity Updated Successfully' );
								/**Redirect to next tab i.e Type of coverage offered**/
								return $this->redirect ( array (
									'/client/reporting?c_id=' . $encrypt_company_id.'#aggregatedgroup'
							) );
							}	
						}
						else {
							$arrerrors = $model_designated_govt_entity->getFirstErrors();
							$errorstring = '';
							
							foreach ($arrerrors as $key=>$value)
							{
								$errorstring .= $value.'<br>';
							}
							
							throw new \Exception($errorstring);
						}
						} catch ( \Exception $e ) {
						
							$msg  = $e->getMessage ();
							\Yii::$app->session->setFlash ( 'error', $msg );
							// rollback transaction
							$transaction->rollback ();
							/**Redirect to Index (Company dashboard)**/
							return $this->redirect ( array (
									'/client/reporting?c_id=' . $encrypt_company_id.'#designatedgovtentity'
							) );
							
							
						}
					
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
	
	
	public function actionAnythingelse(){
	
	
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
				
				
			/**Initializing models**/
			$encrypt_component = new EncryptDecryptComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_company_users = new TblAcaCompanyUsers ();
			$model_client_rights_master = new TblAcaClientRightsMaster ();
			$model_users = new TblAcaUsers ();
			$model_element_master = new TblAcaElementMaster ();
			$model_basic_info = new TblAcaBasicInformation();
			$model_basic_additional_details = new TblAcaBasicAdditionalDetail();
			$client_id = '';
			$hear_about_us = '';
			$others = '';
			$anything_else= '';
			/**
			 * Declaring Session Variables**
			 */
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
					
				/**
				 * Get from URL*
				*/
				$get_company_id = \Yii::$app->request->get ();
					
				if (! empty ( $get_company_id )) {
					/**
					 * Encrypted company ID*
					 */
					$encrypt_company_id = $get_company_id ['c_id'];
					if (! empty ( $encrypt_company_id )) {
						$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
						$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
						if(!empty($check_company_details)){
							$client_id = $check_company_details->client_id; // Company clien Id
						}
					}
					/**
					 * *Checking if company details exists for the company_id and company and client is present in session**
					 */
					if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
							
						$period_details = $model_companies->getcompanyperiod ( $company_id );
						$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
	
							
						$check_basic_additional_info = $model_basic_additional_details->FindbycompanyIdperiodId($company_id, $period_id);
	
	
						if(!empty($check_basic_additional_info))
						{
							$model_basic_additional_details = $check_basic_additional_info;
						}
							
						/**Check for any post of data**/
						if ($model_basic_additional_details->load ( \Yii::$app->request->post () )) {
	
							$anything_else_post= \Yii::$app->request->post ();
	
							if(!empty($anything_else_post['TblAcaBasicAdditionalDetail'])){
								$redirect_button = $anything_else_post ['button'];
							}
	
							if (! empty ( $anything_else_post ['TblAcaBasicAdditionalDetail'] ['hear_about_us'] )) {
								$anything_else_array = $anything_else_post ['TblAcaBasicAdditionalDetail'] ['hear_about_us'];
	
								if ($anything_else_array) {
									foreach ( $anything_else_array as $key => $value ) {
										$hear_about_us .= $value . ',';
									}
								}
							}
	
							if(!empty($anything_else_post ['TblAcaBasicAdditionalDetail'] ['others'])){
								$others = $anything_else_post ['TblAcaBasicAdditionalDetail'] ['others'];
							}
							if(!empty($anything_else_post ['TblAcaBasicAdditionalDetail'] ['anything_else'])){
								$anything_else = $anything_else_post ['TblAcaBasicAdditionalDetail'] ['anything_else'];
							}
							$model_basic_additional_details->company_id = $company_id;
							$model_basic_additional_details->period_id = $period_id;
							$model_basic_additional_details->hear_about_us = $hear_about_us;
							$model_basic_additional_details->others = $others;
							$model_basic_additional_details->anything_else = $anything_else;
	
	
							if ($model_basic_additional_details->isNewRecord) {
								$model_basic_additional_details->created_date = date ( 'Y-m-d H:i:s' );
								$model_basic_additional_details->created_by = $logged_user_id;
									
							} else {
								$model_basic_additional_details->modified_date = date ( 'Y-m-d H:i:s' );
								$model_basic_additional_details->modified_by = $logged_user_id;
							}
	
							// begin transaction
							$transaction = \Yii::$app->db->beginTransaction ();
	
							try {
	
								if ($model_basic_additional_details->save () && $model_basic_additional_details->validate ()) {
	
									$transaction->commit ();
									if ($redirect_button == 'exit') {
										\Yii::$app->session->setFlash ( 'success', 'Anything Else to Tell Us Updated Successfully' );
	
										return $this->redirect ( array (
												'/client/dashboard?c_id=' . $encrypt_company_id
										) );
									} else {
	
										\Yii::$app->session->setFlash ( 'success', 'Anything Else to Tell Us Updated Successfully' );
	
										return $this->redirect ( array (
												'/client/benefit?c_id=' . $encrypt_company_id .  '#generalplaninformation'
										) );
									}
								} else {
	
									\Yii::$app->session->setFlash ( 'error', 'Error occurred while saving.' );
	
									return $this->redirect ( array (
											'/client/reporting?c_id=' . $encrypt_company_id . '#anythingelse'
									) );
								}
							} catch ( \Exception $e ) {
	
								$msg = $e->getMessage ();
								\Yii::$app->session->setFlash ( 'error', $msg );
	
								// rollback transaction
								$transaction->rollback ();
							}
							
	
	
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
	
	
	public function actionSaveaggregatedgroup(){
	
	
	
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
				
				
			/**Initializing models**/
			$encrypt_component = new EncryptDecryptComponent ();
			$model_companies = new TblAcaCompanies ();
			$model_company_users = new TblAcaCompanyUsers ();
			$model_client_rights_master = new TblAcaClientRightsMaster ();
			$model_users = new TblAcaUsers ();
			$model_element_master = new TblAcaElementMaster ();
			$model_basic_info = new TblAcaBasicInformation();
			$model_basic_additional_details = new TblAcaBasicAdditionalDetail();
			$model_aggragated_group = new TblAcaAggregatedGroup();
			$model_aggragated_group_list = new TblAcaAggregatedGroupList();
			$client_id = '';
			$hear_about_us = '';
			$others = '';
			$total_aggregated_grp_months='';
			$total_1095_forms='';
			$authoritative_transmittal= '';
			$is_ale_member= '';
			$is_other_entity = '';
			
			$validation_rule_ids =  array();
			
			for($i=1;$i<=54;$i++)
			{
				$validation_rule_ids[] = $i;
				
			}
			
			$validation_rule_ids[] = 143;
			$validation_rule_ids[] = 144;
			$validation_rule_ids[] = 145;
			
			/**
			 * Declaring Session Variables**
			 */
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
	
				/**
				 * Get from URL*
				*/
				$get_company_id = \Yii::$app->request->get ();
	
				if (! empty ( $get_company_id )) {
					/**
					 * Encrypted company ID*
					 */
					$encrypt_company_id = $get_company_id ['c_id'];
					if (! empty ( $encrypt_company_id )) {
						$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); // Decrypted company Id
						$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
						if(!empty($check_company_details)){
							$client_id = $check_company_details->client_id; // Company clien Id
						}
					}
					/**
					 * *Checking if company details exists for the company_id and company and client is present in session**
					 */
					if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
	
						$period_details = $model_companies->getcompanyperiod ( $company_id );
						$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
							
	
						$check_aggregated_group = $model_aggragated_group->FindbycompanyIdperiodId($company_id, $period_id);
							
	
						if(!empty($check_aggregated_group))
						{
							$model_aggragated_group = $check_aggregated_group;
							$aggregated_list = $model_aggragated_group_list->FindbyaggregateId($check_aggregated_group->aggregated_grp_id);
						}
	
						/**Check for any post of data**/
						if ($model_aggragated_group->load ( \Yii::$app->request->post () )) {
								
							$aggragate_group_post= \Yii::$app->request->post ();
	
							if(!empty($aggragate_group_post['TblAcaAggregatedGroup'])){
								$redirect_button = $aggragate_group_post ['button'];
							}
								
	
							if(!empty($aggragate_group_post ['TblAcaAggregatedGroup'] ['total_aggregated_grp_months'])){
								$total_aggregated_grp_months_array = $aggragate_group_post ['TblAcaAggregatedGroup'] ['total_aggregated_grp_months'];
	
								if ($total_aggregated_grp_months_array) {
									foreach ( $total_aggregated_grp_months_array as $key => $value ) {
										$total_aggregated_grp_months .= $value . ',';
									}
								}
							}
	
							if(!empty($aggragate_group_post ['TblAcaAggregatedGroup'] ['is_authoritative_transmittal'])){
								$authoritative_transmittal = $aggragate_group_post ['TblAcaAggregatedGroup'] ['is_authoritative_transmittal'];
							}
	
							if(!empty($aggragate_group_post ['TblAcaAggregatedGroup'] ['is_ale_member'])){
								$is_ale_member = $aggragate_group_post ['TblAcaAggregatedGroup'] ['is_ale_member'];
							}
	
							if(!empty($aggragate_group_post ['TblAcaAggregatedGroup'] ['is_other_entity'])){
								$is_other_entity = $aggragate_group_post ['TblAcaAggregatedGroup'] ['is_other_entity'];
							}
	
							if(!empty($aggragate_group_post ['TblAcaAggregatedGroup'] ['total_1095_forms'])){
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
										
									$aggregated_grp_id=$model_aggragated_group->aggregated_grp_id;
	
									if ($model_aggragated_group_list->load ( \Yii::$app->request->post () )) {
										$group_list=\Yii::$app->request->post ();
										$group_list_array=	$group_list['TblAcaAggregatedGroupList'];
	
										if(!empty($aggregated_list)){
												
											TblAcaAggregatedGroupList::deleteAll ( [
											'aggregated_grp_id' => $aggregated_grp_id
											] );
												
										}
											
	
										foreach($group_list_array as $list){
											
											if(!empty($list['group_name']) || !empty($list['group_ein']))
											{
											$model_aggragated_group_list->aggregated_grp_id=$aggregated_grp_id;
											$model_aggragated_group_list->group_name=$list['group_name'];
											$model_aggragated_group_list->group_ein=$list['group_ein'];
											$model_aggragated_group_list->created_by=$logged_user_id;
											$model_aggragated_group_list->created_date = date ( 'Y-m-d H:i:s' );
											$model_aggragated_group_list->aggregated_ein_list_id=NULL;
											$model_aggragated_group_list->isNewRecord=TRUE;
											$model_aggragated_group_list->save();
											}
										}
									}
									
									
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
												
												
					$model_company_validation_log =TblAcaCompanyValidationStatus::find()->where(['company_id'=>$company_id])->one();		

                                    if(!empty($model_company_validation_log))		{				
										$model_company_validation_log->is_initialized = 0;	
                                        $model_company_validation_log->is_executed = 0;		
                                        $model_company_validation_log->is_completed = 0;	

										$model_company_validation_log->is_basic_info = 0;
										$model_company_validation_log->save();	

										//update company status
										$check_company_details->reporting_status = 29;
										$check_company_details->save();										
                                         }	
									$transaction->commit ();
									if ($redirect_button == 'exit') {
										\Yii::$app->session->setFlash ( 'success', 'Aggregated Group Updated Successfully' );
											
										return $this->redirect ( array (
												'/client/dashboard?c_id=' . $encrypt_company_id
										) );
									} else {
											
										\Yii::$app->session->setFlash ( 'success', 'Aggregated Group Updated Successfully' );
											
										return $this->redirect ( array (
												'/client/reporting?c_id=' . $encrypt_company_id .  '#anythingelse'
										) );
									}
								} else {
									
									\Yii::$app->session->setFlash ( 'error', 'Error occurred while saving.' );
										
									return $this->redirect ( array (
											'/client/reporting?c_id=' . $encrypt_company_id . '#anythingelse'
									) );
								}
							} catch ( \Exception $e ) {
	
								$msg = $e->getMessage ();
								\Yii::$app->session->setFlash ( 'error', $msg );
									
								// rollback transaction
								$transaction->rollback ();
							}
							
								
								
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
}
