<?php

namespace app\modules\client\controllers;
use yii\web\Controller;
use yii;
use app\models\TblAcaSharefileFolders;
use app\models\TblAcaSharefileEmployees;
use app\models\UploadfileForm;
use yii\web\UploadedFile;
use app\models\TblAcaClients;
use app\models\TblAcaCompanyUsers;
use app\models\TblAcaUsers;
use app\models\TblAcaCompanies;
use app\models\TblAcaCompanyUserPermission;
use app\models\TblAcaStaffUsers;
use app\models\TblAcaRightSignatureDocs;
use app\models\TblAcaVideoLinks;
use app\models\TblAcaElementMaster;
use app\models\TblAcaGeneralPlanInfo;
use app\models\TblAcaGeneralPlanMonths;
use app\components\EncryptDecryptComponent;
use app\models\TblAcaMecCoverage;
use yii\helpers\ArrayHelper;
use app\models\TblAcaCompanyValidationStatus;
use app\models\TblAcaValidationLog;


class BenefitController extends Controller
{
    public function actionIndex()
    {
    	if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
    	$this->layout='main';
    	$elements=array();
    	$encrypt_component = new EncryptDecryptComponent ();
    	$model_companies = new TblAcaCompanies ();
    	$model_company_users = new TblAcaCompanyUsers ();
    	$model_element_master=new TblAcaElementMaster();
    	$model_general_plan_info=new TblAcaGeneralPlanInfo();
    	$model_general_plan_info_months=new TblAcaGeneralPlanMonths();
    	$model_mec_coverage=new TblAcaMecCoverage();
     
    	
    	
    	
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
    		$month_list=array();
    		$arrsection_months=array();
    	
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
    			
    			if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
    					
    				$period_details = $model_companies->getcompanyperiod ( $company_id );
    				$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
    				

					$section_ids = ['7','8'];
					$all_elements = $model_element_master->FindallbysectionIds($section_ids);
					 
					$arrsection_elements = ArrayHelper::map($all_elements, 'element_id', 'element_label');
    						
			    	/**********Check  General Plan info****************/
			    	$general_plan_info = $model_general_plan_info->FindbycompanyIdperiodId($company_id, $period_id);
			    	if(!empty($general_plan_info))
			    	{
			    		$model_general_plan_info = $general_plan_info;
			    		
			    		$general_plan_id=$general_plan_info->general_plan_id;
		
			    		/**********Check  month group list****************/
			    		
			    		$month_list = $model_general_plan_info_months->FindbygeneralId($general_plan_id);
			    		
			    		
			    		$all_months = $model_general_plan_info_months->FindallbymonthIds($general_plan_id);
			    		
			    		$arrsection_months = ArrayHelper::map($all_months, 'month_id', 'plan_value');
			    	}
			    	
			    	/**********Check  Mec Coverage****************/
			    	$mec_coverage = $model_mec_coverage->FindbycompanyIdperiodId($company_id, $period_id);
			    	if(!empty($mec_coverage))
			    	{
			    		$model_mec_coverage = $mec_coverage; 
			    	}
			  
			    	return $this->render('index',[
					         'company_details' => $check_company_details,
			    			'model_general_plan_info'=>$model_general_plan_info,
			    			'model_general_plan_info_months'=>$model_general_plan_info_months,
			    			'month_list'=>$month_list   ,
			    			'model_mec_coverage'=>$model_mec_coverage,
			    			'arrsection_elements'=>$arrsection_elements,
			    			'arrsection_months'=>$arrsection_months			 
			    			]);
    	
				
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
    

    public function actionSaveplaninformation()
    {
    	 
    		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
		
    	/**Declaring Session Variables***/
    	$session = \Yii::$app->session;
    	$logged_user_id = $session ['client_user_id'];
    	$client_ids = $session ['client_ids']; // all related clients to the logged user
    	$company_ids = $session ['company_ids']; // all related companies to the logged user
    	$mapped_company_ids = array_map ( function ($piece) {
    		return ( string ) $piece;
    	}, $company_ids );
    		 
    		$encrypt_component = new EncryptDecryptComponent ();
    		$model_companies = new TblAcaCompanies ();
    		$model_company_users = new TblAcaCompanyUsers ();
    		$model_element_master=new TblAcaElementMaster();
    		$model_general_plan_info=new TblAcaGeneralPlanInfo();
    		$model_general_plan_months=new TblAcaGeneralPlanMonths();
    		
    		$get_company_id = \Yii::$app->request->get ();
    
    		$renewal_month='';
    		$plan_type_description='';
    		$is_multiple_waiting_periods='';
    		$multiple_description='';
    		$is_employees_hra='';
    		$offer_type='';
    		
			$validation_rule_ids = [ 
							'55',
							'56',
							'57',
							'58',
							'59',
							'60',
							'61' 
					];
					
    		if (! empty ( $get_company_id )) {
    			/**Encrypted company ID**/
    			$encrypt_company_id = $get_company_id ['c_id'];
    			if (! empty ( $encrypt_company_id )) {
    				$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); //Decrypted company Id
    				$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); //Company details
    				$client_id = $check_company_details->client_id; //Company clien Id
    			}

    			/***Checking if company details exists for the company_id and company and client is present in session***/
    			if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
    				 
    				$period_details = $model_companies->getcompanyperiod ( $company_id );
    				$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
    					
    				
    				$check_benefit_plan_info = $model_general_plan_info->FindbycompanyIdperiodId($company_id, $period_id);
    					
    				if(!empty($check_benefit_plan_info))
    				{
    					$model_general_plan_info = $check_benefit_plan_info;
    				}
    				if ($model_general_plan_info->load ( \Yii::$app->request->post () )) {
    					$general_plan_info = \Yii::$app->request->post ();
    					
    					
    					if(!empty($general_plan_info['TblAcaGeneralPlanInfo'])){
    						$redirect_button = $general_plan_info ['button'];
    					}
    					
    					if(!empty($general_plan_info ['TblAcaGeneralPlanInfo'] ['renewal_month'])){
    						$renewal_month = $general_plan_info ['TblAcaGeneralPlanInfo'] ['renewal_month'];
    					}
    					
    					if(!empty($general_plan_info ['TblAcaGeneralPlanInfo'] ['plan_type_description'])){
    						$plan_type_description = $general_plan_info ['TblAcaGeneralPlanInfo'] ['plan_type_description'];
    					}
    					if(!empty($general_plan_info ['TblAcaGeneralPlanInfo'] ['offer_type'])){
    						$offer_type = $general_plan_info ['TblAcaGeneralPlanInfo'] ['offer_type'];
    					}
    					
    					if(!empty($general_plan_info ['TblAcaGeneralPlanInfo'] ['is_multiple_waiting_periods'])){
    						$is_multiple_waiting_periods = $general_plan_info ['TblAcaGeneralPlanInfo'] ['is_multiple_waiting_periods'];
    					}
    					if(!empty($general_plan_info ['TblAcaGeneralPlanInfo'] ['multiple_description'])){
							
							if(!empty($is_multiple_waiting_periods) && $is_multiple_waiting_periods==1){
    						$multiple_description = $general_plan_info ['TblAcaGeneralPlanInfo'] ['multiple_description'];
							}else{
							$multiple_description = '';
							}
    					}
    					
    					if(!empty($general_plan_info ['TblAcaGeneralPlanInfo'] ['is_employees_hra'])){
    						$is_employees_hra = $general_plan_info ['TblAcaGeneralPlanInfo'] ['is_employees_hra'];
    					}
    					$model_general_plan_info->company_id=$company_id;
    					$model_general_plan_info->period_id=$period_id;
    					$model_general_plan_info->offer_type = $offer_type;
    					$model_general_plan_info->renewal_month = $renewal_month;
    					$model_general_plan_info->plan_type_description = $plan_type_description;
    					$model_general_plan_info->is_multiple_waiting_periods = $is_multiple_waiting_periods;
    					$model_general_plan_info->multiple_description = $multiple_description;
    					$model_general_plan_info->is_employees_hra = $is_employees_hra;
    					
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
    							
								
								/*  inserting in validation log*/
									
									
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

										 $model_company_validation_log->is_benefit_info = 0;
										$model_company_validation_log->save();

										//update company status
										$check_company_details->reporting_status = 29;
										$check_company_details->save();										
                                         }	
									
									
									
									
    							$general_plan_id=$model_general_plan_info->general_plan_id;
    					
    							if ($model_general_plan_months->load ( \Yii::$app->request->post () )) {
    								$month_list=\Yii::$app->request->post ();
    								$month_list_array=	$month_list['TblAcaGeneralPlanMonths']['plan_value'];
    					         
    							if(!empty($check_benefit_plan_info)){
    										
    								TblAcaGeneralPlanMonths::deleteAll ( [
    									'general_plan_id' => $general_plan_id
    									] );
    										
    								}
    					            	
    					           $i=0;
    								foreach($month_list_array as $key=>$value){
    									
    									$model_general_plan_months->general_plan_id=$general_plan_id;
    									//$model_general_plan_months->both_self_fully=$yes_value;
    									$model_general_plan_months->month_id=$key;
    									
    									if(!empty($offer_type) && $offer_type==1){
    									$model_general_plan_months->plan_value=$value;
    									}else{
    									$model_general_plan_months->plan_value=0;
    									}
    									
    									$model_general_plan_months->created_by=$logged_user_id;
    									$model_general_plan_months->created_date = date ( 'Y-m-d H:i:s' );
    									$model_general_plan_months->plan_month_id=NULL;
    									$model_general_plan_months->isNewRecord=TRUE;
    								if ($model_general_plan_months->save() && $model_general_plan_months->validate ()) {
    										$i ++;
    									}
    								}
    					            	
    							}
    							if ($i > 0) {
    							
    								$transaction->commit (); // commit the transaction
    							
    							if ($redirect_button == 'exit') {
    								\Yii::$app->session->setFlash ( 'success', 'Benefit Plan info added successfully' );
    									
    								return $this->redirect ( array (
    										'/client/dashboard?c_id=' . $encrypt_company_id 
    								) );
    							} else {
    									
    								\Yii::$app->session->setFlash ( 'success', 'Benefit Plan info added successfully' );
    									
    								return $this->redirect ( array (
    										'/client/benefit?c_id=' . $encrypt_company_id .  '#meccoverage'
    								) );
    							}
    							}
    							
    						} else {
    							
    							throw new Exception ( 'Something error occured while saving' ); // throws a exception
    							
    						}
    					} catch ( \Exception $e ) {
    					
    						$msg = $e->getMessage ();
    						\Yii::$app->session->setFlash ( 'error', $msg );
    							
    						// rollback transaction
    						$transaction->rollback ();
    						
    						return $this->redirect ( array (
    								'/client/benefit?c_id=' . $encrypt_company_id . '#anythingelse'
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
    
    public function actionSavemeccoverage()
    {
    		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
		
    	/**Declaring Session Variables***/
    	$session = \Yii::$app->session;
    	$logged_user_id = $session ['client_user_id'];
    	$client_ids = $session ['client_ids']; // all related clients to the logged user
    	$company_ids = $session ['company_ids']; // all related companies to the logged user
    	$mapped_company_ids = array_map ( function ($piece) {
    		return ( string ) $piece;
    	}, $company_ids );
    		 
    		$encrypt_component = new EncryptDecryptComponent ();
    		$model_companies = new TblAcaCompanies ();
    		$model_company_users = new TblAcaCompanyUsers ();
    		$model_element_master=new TblAcaElementMaster();
    		$model_general_plan_info=new TblAcaGeneralPlanInfo();
    		$model_general_plan_months=new TblAcaGeneralPlanMonths();
    		$model_mec_coverage=new TblAcaMecCoverage();
    		
			$validation_rule_ids = [ 
							'62' 
					];
					
    		$get_company_id = \Yii::$app->request->get ();
    
    		$mec_months='';
    
    		if (! empty ( $get_company_id )) {
    			/**Encrypted company ID**/
    			$encrypt_company_id = $get_company_id ['c_id'];
    			if (! empty ( $encrypt_company_id )) {
    				$company_id = $encrypt_component->decryptUser ( $encrypt_company_id ); //Decrypted company Id
    				$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); //Company details
    				$client_id = $check_company_details->client_id; //Company clien Id
    			}
    
    			
    			/***Checking if company details exists for the company_id and company and client is present in session***/
    			if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
    					
    				$period_details = $model_companies->getcompanyperiod ( $company_id );
    				$period_id = $period_details->tbl_aca_company_reporting_period->period_id;
    					
    
    				$check_mec_coverage = $model_mec_coverage->FindbycompanyIdperiodId($company_id, $period_id);
    					
    				if(!empty($check_mec_coverage))
    				{
    					$model_mec_coverage = $check_mec_coverage;
    				}
    				if ( \Yii::$app->request->post () ) {
    					$mec_coverage_info = \Yii::$app->request->post ();
    					
    					
    					if(!empty($mec_coverage_info)){
    						$redirect_button = $mec_coverage_info ['button'];
    					}
    						
    					if(!empty($mec_coverage_info ['TblAcaMecCoverage'] ['mec_months'])){
    						$mec_months = $mec_coverage_info ['TblAcaMecCoverage'] ['mec_months'];
    						$mec_months=implode(",",$mec_months);
    					}
    					
    					$model_mec_coverage->company_id=$company_id;
    					$model_mec_coverage->period_id=$period_id;
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
    
	
								/*  inserting in validation log*/
									
									
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

										 $model_company_validation_log->is_benefit_info = 0;
										$model_company_validation_log->save();

										//update company status
										$check_company_details->reporting_status = 29;
										$check_company_details->save();										
                                         }	
									
									
    								$transaction->commit (); // commit the transaction
    									
    								if ($redirect_button == 'exit') {
    									\Yii::$app->session->setFlash ( 'success', 'Mec coverage added successfully' );
    										
    									return $this->redirect ( array (
    											'/client/dashboard?c_id=' . $encrypt_company_id 
    									) );
    							
    							} else {
    								\Yii::$app->session->setFlash ( 'success', 'Mec coverage added successfully' );
    								return $this->redirect ( array (
    											'/client/planclass?c_id=' . $encrypt_company_id
    									) );
    							}
    
    								
    						} else {
    							
    							throw new Exception ( 'Error occurred while saving' ); // throws a exception

    						}
    					} catch ( \Exception $e ) {
    							
    						$msg = $e->getMessage ();
    						\Yii::$app->session->setFlash ( 'error', $msg );
    							
    						// rollback transaction
    						$transaction->rollback ();
    						
    						return $this->redirect ( array (
    								'/client/benefit?c_id=' . $encrypt_company_id . '#meccoverage'
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
    
    

    }