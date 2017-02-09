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
use app\models\TblAcaGlobalSettings;
use app\models\TblAcaBrands;
use app\models\TblAcaValidationLog;
use app\models\TblAcaCompanyValidationStatus;
use app\models\TblAcaMedicalEnrollmentPeriodValidationLog;
use app\models\TblAcaMedicalValidationLog;
use app\models\TblAcaPlanClassValidationLog;
use app\models\TblAcaPayrollEmploymentPeriodValidationLog;
use app\models\TblAcaPlanCoverageType;
use app\models\TblAcaPayrollValidationLog;
use app\components\EncryptDecryptComponent;
use app\models\TblAcaMedicalData;
use app\models\TblAcaPayrollData;
use app\models\TblAcaGeneralPlanInfo;
use app\models\TblAcaBasicInformation;
use app\models\TblAcaForms;
use app\models\TblGenerateForms;
use app\components\ValidateCheckErrorsComponent;

class DashboardController extends Controller {
	public function actionIndex() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			$this->layout = 'main';
			\Yii::$app->view->title = 'ACA Reporting Service | Dashboard';
			/**
			 * **** initializing session variables ******
			 */
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			$model_company_user = new TblAcaCompanyUsers ();
			$model_clients = new TblAcaClients ();
			$model_companies = new TblAcaCompanies ();
			$model_company_user_permission = new TblAcaCompanyUserPermission ();
			$model_global = new TblAcaGlobalSettings ();
			$right_sign_permission = FALSE;
			$right_sign_docs = array ();
			$arruserpermission = array ();
			$signdocumentpermission = FALSE;
			$company_client_id = '';
			$users_list = '';
			$doc_signed = 0;
			$aca_days = 0;
			$efile_days = 0;
			$brand_right_sign_url = '';
			$signed_doc_url = '';
			$today = date('Y-m-d H:i:s');
			$in_progress=0;
			$initialized = '';
			$completed = '';
			$executed = '';
			$end_date = '';
			$basic_info_date = '';
			$benefit_info_date = '';
						
						
			$arr_forms_ids = array ();
			$encrypt_component = new EncryptDecryptComponent ();
			$validate_check_errors = new ValidateCheckErrorsComponent ();
			
			
			$c_id = Yii::$app->request->get ( 'c_id' );
			$company_id = \Yii::$app->EncryptDecrypt->decryptUser ( $c_id );
			
			$check_company_details = $model_companies->Companyuniquedetails ( $company_id );
			
			if (! empty ( $check_company_details )) {
				$company_client_id = $check_company_details->client_id;
			}
			
			if (! empty ( $check_company_details ) && in_array ( $company_client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
				
				
				
					
				/**
				 * *******Get 1095 forms deadline days*********
				 */
				$aca_forms = $model_global->settinguniquedetails ( '2' ); // getting data
				$aca_last_date = date ( 'Y-m-d', strtotime ( $aca_forms->value ) );
				
				if ($aca_last_date >= date ( 'Y-m-d' )) {
					$aca_form_interval = date_diff ( date_create ( date ( 'Y-m-d' ) ), date_create ( $aca_last_date ) );
					$aca_days = $aca_form_interval->format ( '%a' );
				} else {
					$aca_form_interval = date_diff ( date_create ( date ( 'Y-m-d' ) ), date_create ( $aca_last_date ) );
					$aca_days = '-' . $aca_form_interval->format ( '%a' );
				}
				
				/**
				 * *******Get Deadline to E-File with IRS*********
				 */
				$aca_efile = $model_global->settinguniquedetails ( '3' ); // getting data
				$efile_last_date = date ( 'Y-m-d', strtotime ( $aca_efile->value ) );
				
				if ($efile_last_date >= date ( 'Y-m-d' )) {
					$efile_form_interval = date_diff ( date_create ( date ( 'Y-m-d' ) ), date_create ( $efile_last_date ) );
					$efile_days = $efile_form_interval->format ( '%a' );
				} else {
					$efile_form_interval = date_diff ( date_create ( date ( 'Y-m-d' ) ), date_create ( $efile_last_date ) );
					$efile_days = '-' . $efile_form_interval->format ( '%a' );
				}
				
				$arruserpermission = \Yii::$app->Permission->Checkclientallpermission ( $logged_user_id, $company_id );
				if (in_array ( 'dashboard', $arruserpermission, TRUE ) || in_array ( 'all', $arruserpermission, TRUE )) {
					
					/**
					 * Check for sign document permission*
					 */
					if (in_array ( 'signdocument', $arruserpermission, TRUE ) || in_array ( 'all', $arruserpermission, TRUE )) {
						$signdocumentpermission = TRUE;
					}
					// $signdocumentpermission = TRUE;
					
					/**
					 * ****** checking whether the company has company user or not ******
					 */
					// /
					// / getting the client details based on client id
					// /
					$client_details = $model_clients->Clientuniquedetails ( $company_client_id );
					$client_user_id = $client_details->user_id;
					$client_email_id = $client_details->email;
					$client_brand = $client_details->brand_id;
					
					/**
					 * ******* getting brand details *********
					 */
					$brand_details = TblAcaBrands::find ()->where ( [ 
							'brand_id' => $client_brand 
					] )->One ();
					$brand_right_sign_url = $brand_details->right_sign_url;
					/**
					 * ***************************************
					 */
					
					// /
					// / getting the user details based on the email ID (checking if there are multiple accounts with same email)
					// /
					$user_details = TblAcaClients::find ()->where ( [ 
							'email' => $client_email_id 
					] )->orderBy ( [ 
							'client_id' => SORT_ASC 
					] )->All ();
					
					$user_count = count ( $user_details );
					// /
					// / getting the company users based on client id
					// /
					$company_user_details = TblAcaCompanyUsers::find ()->where ( [ 
							'client_id' => $company_client_id 
					] )->orderBy ( [ 
							'company_user_id' => SORT_ASC 
					] )->All ();
					
					$company_user_count = count ( $company_user_details );
					
					if (! empty ( $session ['is_client'] ) && $session ['is_client'] == 'client') {
						// /
						// / checking the conditions
						// /
						if ($user_count > 1) {
							if ($user_details [0]->client_id == $company_client_id) {
								$right_sign_permission = TRUE;
							} else {
								if (! empty ( $company_user_details )) {
									if (($company_user_count == 1) || $company_user_count == 0) {
										$right_sign_permission = FALSE;
									} else {
										foreach ( $company_user_details as $company_user ) {
											if ($logged_user_id != $company_user->user_id) {
												$company_user_id = $company_user->company_user_id;
												$user_permissions = $model_company_user_permission->Checkrightsignpermission ( $company_user_id, $company_id );
												
												if ($user_permissions == 'rightsignpermission') {
													$right_sign_permission = TRUE;
													break;
												} else {
													$right_sign_permission = FALSE;
												}
											}
										}
									}
								} else {
									$right_sign_permission = FALSE;
								}
							}
						} else {
							$right_sign_permission = TRUE;
						}
					} elseif (! empty ( $session ['is_client'] ) && $session ['is_client'] == 'companyuser') {
						$logged_company_user = TblAcaCompanyUsers::find ()->where ( [ 
								'user_id' => $logged_user_id 
						] )->andWhere ( [ 
								'client_id' => $company_client_id 
						] )->One ();
						$company_user_id = $logged_company_user->company_user_id;
						/**
						 * ******* checking for sign documents permissions *********
						 */
						$user_permissions = $model_company_user_permission->Checkrightsignpermission ( $company_user_id, $company_id );
						if ($user_permissions == 'rightsignpermission') {
							$right_sign_permission = TRUE;
						} else {
							$right_sign_permission = FALSE;
							/**
							 * ***** get the list of company users who have sign doc permission *******
							 */
							foreach ( $company_user_details as $company_users ) {
								/**
								 * ******* checking for sign documents permissions *********
								 */
								$user_permission = $model_company_user_permission->Checkrightsignpermission ( $company_users->company_user_id, $company_id );
								if ($user_permission == 'rightsignpermission') {
									$users_list .= ' ' . $company_users->first_name . ' ' . $company_users->last_name . ',';
								}
							}
							$users_list = rtrim ( $users_list, ',' );
						}
					}
					
					$client_details = TblAcaClients::find ()->where ( [ 
							'user_id' => $client_user_id 
					] )->orderBy ( [ 
							'client_id' => SORT_ASC 
					] )->groupBy ( [ 
							'user_id' 
					] )->One ();
					
					if ($client_details->client_id == $company_client_id) {
						/**
						 * ******* now checking whether already signed the document or not ************
						 */
						foreach ( $company_user_details as $company_user_detail ) {
							
							$user_email = $company_user_detail->email;
							// if($client_email_id != $user_email){
							/**
							 * ******* now getting the Right signature docs based on logged email **********
							 */
							/**
							 * * first check in our db **
							 */
							$right_sign_docs = TblAcaRightSignatureDocs::find ()->where ( [ 
									'recipient_email' => $user_email 
							] )->One ();
							
							/**
							 * * records are not in our db **
							 */
							if (empty ( $right_sign_docs )) {
								
								/**
								 * getting the Right signature docs *
								 */
								$right_sign_result = \Yii::$app->Rightsignature->documentdetails ( $user_email, 'email', $client_brand );
								
								/**
								 * if docs available in RIGHT SIGNATURE *
								 */
								if (! empty ( $right_sign_result->page ) && ! empty ( $right_sign_result->page->total_documents )) {
									
									if ($right_sign_result->page->total_documents != 0) {
										
										/**
										 * * insert in our db **
										 */
										$model_rightsign = new TblAcaRightSignatureDocs ();
										
										$model_rightsign->guid = $right_sign_result->page->documents [0]->guid;
										$model_rightsign->doc_name = $right_sign_result->page->documents [0]->original_filename;
										$model_rightsign->doc_subject = $right_sign_result->page->documents [0]->subject;
										$model_rightsign->recipient_name = $right_sign_result->page->documents [0]->recipients [1]->name;
										$model_rightsign->recipient_email = $right_sign_result->page->documents [0]->recipients [1]->email;
										$model_rightsign->signed_doc_url = urldecode ( $right_sign_result->page->documents [0]->signed_pdf_url );
										$model_rightsign->isNewRecord = true;
										$model_rightsign->doc_id = NULL;
										
										if ($model_rightsign->save ()) {
											/**
											 * ** update company status to signed **
											 */
											/*
											 * $company_model = TblAcaCompanies::Companyuniquedetails($company_id); $company_model->reporting_status = 24; $company_model->save();
											 */
											
											$company_model = TblAcaCompanies::updateAll ( [ 
													'reporting_status' => 24 
											], 'client_id = ' . $company_client_id );
											
											/**
											 * * used in view ***
											 */
											$doc_signed = 1;
											/**
											 * ******************
											 */
											break;
										}
									}
								}
							} else {
								$doc_id = $right_sign_docs->guid;
								$right_sign_doc = \Yii::$app->Rightsignature->documentdetails ( $doc_id, 'guid', $client_brand );
								// print_r($right_sign_doc->document->signed_doc_url);
								// die();
								if (! empty ( $right_sign_doc->document ) && ! empty ( $right_sign_doc->document->guid )) {
									$signed_doc_url = urldecode ( $right_sign_doc->document->signed_pdf_url );
									$signed_details = TblAcaRightSignatureDocs::updateAll ( [ 
											'signed_doc_url' => $signed_doc_url 
									], 'guid = "' . $doc_id . '"' );
									
									break;
								}
							}
							// }
						}
					} else {
						
						foreach ( $company_user_details as $company_user_detail ) {
							
							$user_email = $company_user_detail->email;
							
							if ($client_email_id != $user_email) {
								
								/**
								 * ******* now getting the Right signature docs based on logged email **********
								 */
								/**
								 * * first check in our db **
								 */
								$right_sign_docs = TblAcaRightSignatureDocs::find ()->where ( [ 
										'recipient_email' => $user_email 
								] )->One ();
								
								/**
								 * * records are not in our db **
								 */
								if (empty ( $right_sign_docs )) {
									
									/**
									 * getting the Right signature docs *
									 */
									$right_sign_result = \Yii::$app->Rightsignature->documentdetails ( $user_email, 'email', $client_brand );
									
									if (! empty ( $right_sign_result->page ) && ! empty ( $right_sign_result->page->total_documents )) {
										
										if ($right_sign_result->page->total_documents != 0) {
											
											/**
											 * * insert in our db **
											 */
											$model_rightsign = new TblAcaRightSignatureDocs ();
											
											$model_rightsign->guid = $right_sign_result->page->documents [0]->guid;
											$model_rightsign->doc_name = $right_sign_result->page->documents [0]->original_filename;
											$model_rightsign->doc_subject = $right_sign_result->page->documents [0]->subject;
											$model_rightsign->recipient_name = $right_sign_result->page->documents [0]->recipients [1]->name;
											$model_rightsign->recipient_email = $right_sign_result->page->documents [0]->recipients [1]->email;
											$model_rightsign->signed_doc_url = urldecode ( $right_sign_result->page->documents [0]->signed_pdf_url );
											$model_rightsign->isNewRecord = true;
											$model_rightsign->doc_id = NULL;
											
											if ($model_rightsign->save ()) {
												/**
												 * ** update company status to signed **
												 */
												/*
												 * $company_model = TblAcaCompanies::Companyuniquedetails($company_id); $company_model->reporting_status = 24; $company_model->save(); break;
												 */
												
												$company_model = TblAcaCompanies::updateAll ( [ 
														'reporting_status' => 24 
												], 'client_id = ' . $company_client_id );
												/**
												 * * used in view ***
												 */
												$doc_signed = 1;
												/**
												 * ******************
												 */
												break;
											}
										}
									}
								} else {
									$doc_id = $right_sign_docs->guid;
									$right_sign_doc = \Yii::$app->Rightsignature->documentdetails ( $doc_id, 'guid', $client_brand );
									if (! empty ( $right_sign_doc->document ) && ! empty ( $right_sign_doc->document->guid )) {
										$signed_doc_url = urldecode ( $right_sign_doc->document->signed_pdf_url );
										$signed_details = TblAcaRightSignatureDocs::updateAll ( [ 
												'signed_doc_url' => $signed_doc_url 
										], 'guid = "' . $doc_id . '"' );
										
										break;
									}
								}
							}
						}
					}
					
					/**
					 * ******* checking permissions for upload & download documents **********
					 */
					$document_upload_permission = FALSE;
					$document_download_permission = FALSE;
					$company_user_total_details = $model_company_user->FindByuserId ( $logged_user_id );
					if (! empty ( $company_user_total_details )) {
						$company_user_id = $company_user_total_details->company_user_id;
						$user_upload_permissions = $model_company_user_permission->Checkfileuploadpermission ( $company_user_id, $company_id );
						$user_download_permissions = $model_company_user_permission->Checkfiledownloadpermission ( $company_user_id, $company_id );
						
						if ($user_upload_permissions == 'uploadpermission') {
							$document_upload_permission = TRUE;
						} else {
							$document_upload_permission = FALSE;
						}
						if ($user_download_permissions == 'downloadpermission') {
							$document_download_permission = TRUE;
						} else {
							$document_download_permission = FALSE;
						}
					}
					
					
					
					/**
					 * * get list of available documents in SHAREFILE **
					 */
					$folder_children = '';
					/**
					 * * get sharefile folder details **
					 */
					$folder_details = TblAcaSharefileFolders::find ()->select('folder_name, sharefile_folder_id, client_id')->where ( [ 
							'company_id' => $company_id 
					] )->One ();
					
					if (! empty ( $folder_details )) {
						$folder_name = $folder_details->folder_name;
						$sharefile_folder_id = $folder_details->sharefile_folder_id;
						$client_id = $folder_details->client_id;
						
						/**
						 * * get sharefile account details **
						 */
						/*
						 * $sharefile_details = TblAcaSharefileEmployees::find()->where(['user_id' => $logged_user_id])->One(); $new_username = $sharefile_details->username; $enc_password = $sharefile_details->password; $new_password = \Yii::$app->EncryptDecrypt->decryptUser($enc_password); $client_logged_id = $sharefile_details->user_id;
						 */
						
						/**
						 * ***** getting the sharefile credentials *****
						 */
						 
						/*$hostname = \Yii::$app->params['shareFileHostname'];
						$client_api_id = \Yii::$app->params['shareFileClientApiId'];
						$client_secret = \Yii::$app->params['shareFileClientSecret'];
						$username = \Yii::$app->params['shareFileUsername'];
						$password = \Yii::$app->params['shareFilePassword'];*/
						 
						$share_file = json_decode ( file_get_contents ( getcwd () . '/config/sharefile-credentials.json' ) );
						
						$hostname = $share_file->hostname;
						$client_api_id = $share_file->client_api_id;
						$client_secret = $share_file->client_secret;
						$username = $share_file->username;
						$password = $share_file->password;
						
						/**
						 * * getting list of items in sharefile **
						 */
						
						$result = \Yii::$app->Sharefile->get_children ( $hostname, $client_api_id, $client_secret, $username, $password, $sharefile_folder_id );
						
						if (! empty ( $result )) {
							$folder_children = $result->value;
						} else {
							$folder_children = '';
						}
						
						/**
						 * **** removing already downloaded files *******
						 */
						exec ( 'rm -R ' . getcwd () . '/Images/sharefile_docs/' . $folder_name );
						exec ( 'rm ' . getcwd () . '/Images/sharefile_docs/' . $folder_name . '.zip' );
					}
					
					
					
					
					
					return $this->render ( 'index', array (
							'folder_children' => $folder_children,
							'right_sign_docs' => $right_sign_docs,
							'right_sign_permission' => $right_sign_permission,
							'document_upload_permission' => $document_upload_permission,
							'document_download_permission' => $document_download_permission,
							'signdocumentpermission' => $signdocumentpermission,
							'model_companies_year' => $check_company_details,
							'session' => $session,
							'users_list' => $users_list,
							'doc_signed' => $doc_signed,
							'aca_days' => $aca_days,
							'efile_days' => $efile_days,
							'brand_right_sign_url' => $brand_right_sign_url,
							
											
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
	
	
	
	public function actionDashboardstatus()
	{
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			
			/**
			 * **** initializing session variables ******
			 */
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			$company_client_id = '';
			$in_progress=0;
			$initialized = '';
			$completed = '';
			$executed = '';
			$end_date = '';
			$basic_info_date = '';
			$benefit_info_date = '';
			
			$status_data = array();
			
			
			
			$model_companies = new TblAcaCompanies ();
			$encrypt_component = new EncryptDecryptComponent ();
			$validate_check_errors = new ValidateCheckErrorsComponent ();
			
			
			$c_id = Yii::$app->request->post ( 'c_id' );
			$company_id = \Yii::$app->EncryptDecrypt->decryptUser ( $c_id );
			
			$check_company_details = $model_companies->Companyuniquedetails ( $company_id );
			if (! empty ( $check_company_details )) {
				$company_client_id = $check_company_details->client_id;
			}
			
			if (! empty ( $check_company_details ) && in_array ( $company_client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
			
			
			/* getting errors for form validations */
					
					/**
					 * ****Get validation results***********
					*/
					
					$validation_results = TblAcaValidationLog::find ()->select ( 'validation_rule_id, is_validated' )->where ( [ 
							'company_id' => $company_id 
					] )->All ();
					/**
					 * Validation status*/
					 
					$validation_status = TblAcaCompanyValidationStatus::find ()->where ( [ 
							'company_id' => $company_id 
					] )->One ();
					
					if (! empty ( $validation_status )) {
						$initialized = $validation_status->is_initialized;
						$completed = $validation_status->is_completed;
						$executed = $validation_status->is_executed;
						$end_date = $validation_status->end_date_time;
						$basic_info_date = $validation_status->basic_info_date;
						$benefit_info_date = $validation_status->benefit_info_date;
					} 
					
					
					// Checking if validations results are empty
						if (! empty ( $validation_results )) {
							
							$arr_validations = $validate_check_errors->CheckErrors ( $validation_results, $company_id );
							
							$arr_plan_class_individual_issues = $arr_validations ['arr_plan_class_individual_issues'];
						}
						
						// check if all values are validated
						if (empty ( $arr_validations ['basic_info'] ) && empty ( $arr_validations ['benefit_plan'] ) && empty ( $arr_validations ['plan_class_validation'] ) && empty ( $arr_validations ['payroll_data_validation'] ) && empty ( $arr_validations ['medical_data_validation'] )) {
							$is_all_validated = 1;
						}
								
								
								
					// check if all values are validated
					if (empty ( $arr_validations ['basic_info'] )) 

					{
						$is_basic_info_validated = 1;
					} else {
						$is_basic_info_validated = 0;
					}
					
					if (empty ( $arr_validations ['benefit_plan'] )) 

					{
						$is_benefit_plan_validated = 1;
					} else {
						$is_benefit_plan_validated = 0;
					}
					
					if (empty ( $arr_validations ['plan_class_validation'] )) 

					{
						$is_plan_class_validation_validated = 1;
					} else {
						$is_plan_class_validation_validated = 0;
					}
					
					if (empty ( $arr_validations ['payroll_data_validation'] )) 

					{
						$is_payroll_data_validation_validated = 1;
					} else {
						$is_payroll_data_validation_validated = 0;
					}
					
					if (empty ( $arr_validations ['medical_data_validation'] )) {
						$is_medical_data_validation_validated = 1;
					} else {
						$is_medical_data_validation_validated = 0;
					}
					
					
			
					/********Check form generation status for the particular company***********/
					
					$model_acaform = TblAcaForms::find ()->select('created_date, efile_status, efile_approved_date, approved_date')->where ( [ 
						'company_id' => $company_id ,
						'is_approved'=>1
				        ] )->one ();
						
					// get all generated forms
					$model_generated_forms = TblGenerateForms::find ()->select ( 'id, cron_status, version ,created_date' )->where ( [ 
							'company_id' => $company_id
					] )->orderBy(['created_date'=>SORT_DESC,])->All ();
				
					if (! empty ( $model_generated_forms )) {
							foreach ( $model_generated_forms as $generated_forms ) {
								
								if ($generated_forms->cron_status == 2 ) {
									$arr_forms_ids [] = $generated_forms->created_date;
								} else {
									$in_progress ++;
									
								}
							}
						}
			
			
				$basic_info_status = ''; //1 = pending, 2= progress, 3 = completed
				$benefit_plan_status = '';//1 = pending, 2= progress, 3 = completed
				$payroll_status = '';//1 = pending, 2= progress, 3 = completed
				$medical_status = ''; //1 = pending, 2= progress, 3 = completed
				$form_generation_status = '';//1 = pending, 2= progress, 3 = completed
				$approved_status = '';//1 = pending, 2= progress, 3 = completed
				$efile_status = '';//1 = pending, 2= progress, 3 = completed
				$approved_date = '';
				
				//Basic Reporting Info
				if(!empty($validation_status)){
					
						if($initialized==1 && $executed == 0 && $completed == 0)
						{
										 
						$status_data['basic_info_status'] = 'Validation In Progress';
						$status_data['basic_info_status_class'] = 'label label-info';
						
						}
						elseif($is_basic_info_validated==0 || $validation_status->is_basic_info==0){
						
						$status_data['basic_info_status'] = 'Validation Pending';
						$status_data['basic_info_status_class'] = 'label label-warning';						
						
										 
						}
						elseif($is_basic_info_validated == 1  && $validation_status->is_basic_info==1){
											 
						$status_data['basic_info_status'] = 'Validation Successful';
						$status_data['basic_info_status_class'] = 'label label-success';						

						}
										
				}
				else{
					
				$status_data['basic_info_status'] = 'Validation Pending';
				$status_data['basic_info_status_class'] = 'label label-warning';
								 
				}
				
				if(!empty($validation_status) && $is_basic_info_validated == 1  && $validation_status->is_basic_info==1){
				$status_data['basic_info_date'] = date('m-d-Y, h:i A',strtotime($basic_info_date));
				}
				
				//Benefit Plan Info
				if(!empty($validation_status)){
					
						if($initialized==1 && $executed == 0 && $completed == 0)
						{
										 
						$status_data['benefit_plan_status'] = 'Validation In Progress';
						$status_data['benefit_plan_status_class'] = 'label label-info';
						
						}
						elseif($is_benefit_plan_validated==0 || $validation_status->is_benefit_info==0){
										 
						$status_data['benefit_plan_status'] = 'Validation Pending';
						$status_data['benefit_plan_status_class'] = 'label label-warning';
										 
						}
						elseif($is_benefit_plan_validated == 1  && $validation_status->is_benefit_info==1){
											 
						$status_data['benefit_plan_status'] = 'Validation Successful';
						$status_data['benefit_plan_status_class'] = 'label label-success';	

						}
										
				}
				else{
					
				$status_data['benefit_plan_status'] = 'Validation Pending';
				$status_data['benefit_plan_status_class'] = 'label label-warning';
								 
				}
				
				if(!empty($validation_status) && $is_basic_info_validated == 1  && $validation_status->is_benefit_info==1){
				$status_data['benefit_info_date'] = date('m-d-Y, h:i A',strtotime($benefit_info_date));
				}
							
						//Payroll Data
				if(!empty($validation_status)){
				 
				  if($initialized==1 && $executed == 0 && $completed == 0)
				  {
					   
				  $status_data['payroll_status'] = 'Validation In Progress';
				  $status_data['payroll_status_class'] = 'label label-info';
				  
				  }
				  elseif (! empty ( $arr_validations ['payroll_data'] )) {
				   
				   if (! empty ( $arr_validations ['payroll_data_validation'] ) && $arr_validations ['payroll_data_validation'] > 0) {
					
					$status_data['payroll_status'] = 'Validation Pending';
					$status_data['payroll_status_class'] = 'label label-warning';
					
				   }else if(!empty($validation_status) && $validation_status->is_payroll_data==0){
					
					
					$status_data['payroll_status'] = 'Validation Pending';
					$status_data['payroll_status_class'] = 'label label-warning';
				   }else
				   {
						  
					$status_data['payroll_status'] = 'Validation Successful';
					$status_data['payroll_status_class'] = 'label label-success';
				   }
				   
				  }else
				  {
					$status_data['payroll_status'] = 'Validation Pending';
					$status_data['payroll_status_class'] = 'label label-warning';
				  }
				  
					  
				}
				else{
				 
				$status_data['payroll_status'] = 'Validation Pending';
				$status_data['payroll_status_class'] = 'label label-warning';
					 
				} 

				
				if(!empty($validation_status) && $is_basic_info_validated == 1  && $validation_status->is_payroll_data==1){
				$status_data['payroll_date'] = $validation_status->payroll_info_date;
				}
				
				//Medical Plan Data
				if(!empty($validation_status)){
				 
				  if($initialized==1 && $executed == 0 && $completed == 0)
				  {
					   
				  $status_data['medical_status'] = 'Validation In Progress';
				  $status_data['medical_status_class'] = 'label label-info';
				  
				  }
				  elseif (! empty ( $arr_validations ['medical_data'] )) {
				   
				   if (! empty ( $arr_validations ['medical_data_validation'] ) && $arr_validations ['medical_data_validation'] > 0) {
					
					$status_data['medical_status'] = 'Validation Pending';
					$status_data['medical_status_class'] = 'label label-warning';
					
				   }else if(!empty($validation_status) && $validation_status->is_medical_data==0){
					
					
					$status_data['medical_status'] = 'Validation Pending';
					$status_data['medical_status_class'] = 'label label-warning';
				   }else
				   {
						  
					$status_data['medical_status'] = 'Validation Successful';
					$status_data['medical_status_class'] = 'label label-success';
				   }
				   
				   
				   
				   
				  }
				  else
				  {
				  $status_data['medical_status'] = 'Validation Pending';
				  $status_data['medical_status_class'] = 'label label-warning';
				   
				  }
					  
				}
				else{
				 
				$status_data['medical_status'] = 'Validation Pending';
				$status_data['medical_status_class'] = 'label label-warning';
					 
				} 
				
				if(!empty($validation_status) && $is_basic_info_validated == 1  && $validation_status->is_medical_data==1){
				$status_data['medical_date'] = $validation_status->medical_info_date;
				}
				
				//ACA Form Generation
				if(!empty($model_generated_forms) && $in_progress == 0){
					
				$status_data['form_generation_status'] = 'Form Generated';
				$status_data['form_generation_status_class'] = 'label label-success';					
				}
				else if($in_progress != 0){
					
				$status_data['form_generation_status'] = 'In Progress';
				$status_data['form_generation_status_class'] = 'label label-warning';
				
				
				}else{
											 
				$status_data['form_generation_status'] = 'Pending';
				$status_data['form_generation_status_class'] = 'label label-warning';
				
				}
				
				if(!empty($model_generated_forms[0]->created_date) && $in_progress == 0){
					$status_data['form_generation_date'] = date('m-d-Y, h:i A',strtotime($model_generated_forms[0]->created_date));
				}				
											 

				//ACA Form Approval
				if(!empty($model_acaform)){
					
					$status_data['approved_status'] = 'Form Approved' ;
					$status_data['approved_status_class'] = 'label label-success';

					}else{
						
					$status_data['approved_status'] = 'Pending' ;
					$status_data['approved_status_class'] = 'label label-warning';
						
				}
				
				if(!empty($model_acaform)){  
				
				$status_data['approved_date'] = date('m-d-Y, h:i A',strtotime($model_acaform->approved_date));

				}		
						

				//E-Filing
				if(!empty($model_acaform->efile_status) && $model_acaform->efile_status == 'Approved'){
					
					$status_data['efile_status'] = 'E-File Approved' ;
					$status_data['efile_status_class'] = 'label label-success';
					
				}else
				{
					$status_data['efile_status'] = 'Pending' ;
					$status_data['efile_status_class'] = 'label label-warning';
				}
									
				if(!empty($model_acaform->efile_status) && $model_acaform->efile_status == 'Approved' && !empty($model_acaform->efile_approved_date)){ 
				
				$status_data['efile_date'] =  date('m-d-Y, h:i A',strtotime($model_acaform->efile_approved_date));

				}						
			
			
			
			return json_encode($status_data);
			
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
	
	
	public function actionGetsharefilefolders()
	{
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			/**
			 * **** initializing session variables ******
			 */
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			$company_client_id = '';
			$folder_children = '';
			
			$model_companies = new TblAcaCompanies ();
			$encrypt_component = new EncryptDecryptComponent ();
			$validate_check_errors = new ValidateCheckErrorsComponent ();
			
			
			$c_id = Yii::$app->request->post ( 'c_id' );
			$company_id = \Yii::$app->EncryptDecrypt->decryptUser ( $c_id );
			
			$check_company_details = $model_companies->Companyuniquedetails ( $company_id );
			if (! empty ( $check_company_details )) {
				$company_client_id = $check_company_details->client_id;
			}
			
			if (! empty ( $check_company_details ) && in_array ( $company_client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
			
					/**
					 * * get list of available documents in SHAREFILE **
					 */
					
					/**
					 * * get sharefile folder details **
					 */
					$folder_details = TblAcaSharefileFolders::find ()->select('folder_name, sharefile_folder_id, client_id')->where ( [ 
							'company_id' => $company_id 
					] )->One ();
					
					if (! empty ( $folder_details )) {
						$folder_name = $folder_details->folder_name;
						$sharefile_folder_id = $folder_details->sharefile_folder_id;
						$client_id = $folder_details->client_id;
						
						/**
						 * * get sharefile account details **
						 */
						/*
						 * $sharefile_details = TblAcaSharefileEmployees::find()->where(['user_id' => $logged_user_id])->One(); $new_username = $sharefile_details->username; $enc_password = $sharefile_details->password; $new_password = \Yii::$app->EncryptDecrypt->decryptUser($enc_password); $client_logged_id = $sharefile_details->user_id;
						 */
						
						/**
						 * ***** getting the sharefile credentials *****
						 */
						$share_file = json_decode ( file_get_contents ( getcwd () . '/config/sharefile-credentials.json' ) );
						
						/*$hostname = \Yii::$app->params['shareFileHostname'];
						$client_api_id = \Yii::$app->params['shareFileClientApiId'];
						$client_secret = \Yii::$app->params['shareFileClientSecret'];
						$username = \Yii::$app->params['shareFileUsername'];
						$password = \Yii::$app->params['shareFilePassword'];*/
						
						$hostname = $share_file->hostname;
						$client_api_id = $share_file->client_api_id;
						$client_secret = $share_file->client_secret;
						$username = $share_file->username;
						$password = $share_file->password;
						
						/**
						 * * getting list of items in sharefile **
						 */
						
						$result = \Yii::$app->Sharefile->get_children ( $hostname, $client_api_id, $client_secret, $username, $password, $sharefile_folder_id );
						
						if (! empty ( $result )) {
							$folder_children = $result->value;
						} else {
							$folder_children = '';
						}
						
						/**
						 * **** removing already downloaded files *******
						 */
						exec ( 'rm -R ' . getcwd () . '/Images/sharefile_docs/' . $folder_name );
						exec ( 'rm ' . getcwd () . '/Images/sharefile_docs/' . $folder_name . '.zip' );
					}
					
			return json_encode($folder_children);
			
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
	 * ****** Action to Download Secure Documents **********
	 */
	public function actionDownloadfiles() {
		$session = \Yii::$app->session;
		$logged_user_id = $session ['client_user_id'];
		$request = Yii::$app->request;
		$c_id = $request->get ( 'company_id' );
		$company_id = \Yii::$app->EncryptDecrypt->decryptUser ( $c_id );
		
		/**
		 * * get sharefile folder details **
		 */
		$folder_details = TblAcaSharefileFolders::find ()->where ( [ 
				'company_id' => $company_id 
		] )->One ();
		
		$sharefile_folder_id = $folder_details->sharefile_folder_id;
		$folder_name = $folder_details->folder_name;
		$file_id = Yii::$app->request->get ( 'id' );
		$file_name = Yii::$app->request->get ( 'name' );
		
		$client_id = $folder_details->client_id;
		
		/**
		 * * get sharefile account details **
		 */
		$sharefile_details = TblAcaSharefileEmployees::find ()->where ( [ 
				'user_id' => $logged_user_id 
		] )->One ();
		
		$new_username = $sharefile_details->username;
		$enc_password = $sharefile_details->password;
		$new_password = \Yii::$app->EncryptDecrypt->decryptUser ( $enc_password );
		$client_logged_id = $sharefile_details->user_id;
		
		/**
		 * ***** getting the sharefile credentials *****
		 */
		$share_file = json_decode ( file_get_contents ( getcwd () . '/config/sharefile-credentials.json' ) );
		
		/*$hostname = \Yii::$app->params['shareFileHostname'];
		$client_api_id = \Yii::$app->params['shareFileClientApiId'];
		$client_secret = \Yii::$app->params['shareFileClientSecret'];
	//	$username = \Yii::$app->params['shareFileUsername'];
	//	$password = \Yii::$app->params['shareFilePassword'];*/
	
		$hostname = $share_file->hostname;
		$client_api_id = $share_file->client_api_id;
		$client_secret = $share_file->client_secret;
		
		
		/**
		 * * download item from sharefile to our local folder **
		 */
		$result = \Yii::$app->Sharefile->download_item ( $hostname, $client_api_id, $client_secret, $new_username, $new_password, $file_id, $file_name, $folder_name );
		
		// $result = \Yii::$app->Sharefile->download_content($hostname, $client_api_id, $client_secret, $new_username, $new_password, $sharefile_folder_id);
		// $result = \Yii::$app->Sharefile->create_link($hostname, $client_api_id, $client_secret, $new_username, $new_password, $sharefile_folder_id);
		
		$res_array = array("result"=>$result,"folder"=>$folder_name);
		return json_encode($res_array);
	}
	
	/**
	 * ***** Action to Convert all files into a Zipfolder *****
	 */
	public function actionConvertfoldertozip() {
		$request = Yii::$app->request;
		$c_id = $request->get ( 'company_id' );
		$company_id = \Yii::$app->EncryptDecrypt->decryptUser ( $c_id );
		
		/**
		 * * get sharefile folder details **
		 */
		$folder_details = TblAcaSharefileFolders::find ()->where ( [ 
				'company_id' => $company_id 
		] )->One ();
		
		$sharefile_folder_id = $folder_details->sharefile_folder_id;
		$folder_name = $folder_details->folder_name;
		
		/**
		 * * converting the folder into zip **
		 */
		$result = \Yii::$app->Sharefile->zipaDirectory ( getcwd () . '/Images/sharefile_docs/' . $folder_name . '/', getcwd () . '/Images/sharefile_docs/' . $folder_name . '.zip' );
		if ($result == 'success') {
			$res_array = array (
					"result" => "success",
					"folder" => $folder_name 
			);
			return json_encode ( $res_array );
		}
	}
	
	/**
	 * ***** Action to delete already downloaded folders drom server *****
	 */
	public function actionRemovedownloadedfolders() {
		$request = Yii::$app->request;
		$c_id = $request->get ( 'id' );
		$company_id = \Yii::$app->EncryptDecrypt->decryptUser ( $c_id );
		
		/**
		 * * get sharefile folder details **
		 */
		$folder_details = TblAcaSharefileFolders::find ()->where ( [ 
				'company_id' => $company_id 
		] )->One ();
		$folder_name = $folder_details->folder_name;
		
		/**
		 * ** removing files & folders from server **
		 */
		exec ( 'rm -R ' . getcwd () . '/Images/sharefile_docs/' . $folder_name );
		exec ( 'rm ' . getcwd () . '/Images/sharefile_docs/' . $folder_name . '.zip' );
		return 'success';
	}
	
	/**
	 * ***** Action to upload documents into sharefile *****
	 */
	public function actionUploaddocuments() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			exec ( 'rm -fr ' . getcwd () . '/Images/sharefile_docs/*' );
			$model_companies = new TblAcaCompanies ();
			$model_clients = new TblAcaClients ();
			$model_company_users = new TblAcaCompanyUsers ();
			$model_users = new TblAcaUsers ();
			$model_company_user_permission = new TblAcaCompanyUserPermission ();
			$model_staff_users = new TblAcaStaffUsers ();
			
			$logged_name = '';
			/**
			 * **** initializing session variables ******
			 */
			$session = \Yii::$app->session;
			$logged_user_id = $session ['client_user_id'];
			$admin_user_id = $session ['admin_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			
			/**
			 * Check logged in user if client or company user*
			 */
			if (! empty ( $session ['is_client'] ) && $session ['is_client'] == 'client') {
				$client_details = $model_clients->findbyuserid ( $logged_user_id );
				$logged_name = $client_details->contact_first_name . ' ' . $client_details->contact_last_name;
			} else {
				
				$company_user_details = $model_company_users->FindByuserId ( $logged_user_id );
				$logged_name = $company_user_details->first_name . ' ' . $company_user_details->last_name;
			}
			
			/**
			 * ***** getting requestr variables from URL *****
			 */
			$request = Yii::$app->request;
			$c_id = $request->get ( 'c_id' );
			$company_id = \Yii::$app->EncryptDecrypt->decryptUser ( $c_id );
			
			$check_company_details = $model_companies->Companyuniquedetails ( $company_id );
			$company_client_id = $check_company_details->client_id;
			$company_number = $check_company_details->company_client_number;
			$company_name = $check_company_details->company_name;
			
			/**
			 * *** Get client details***
			 */
			$client_details = $model_clients->Clientuniquedetails ( $company_client_id );
			$client_account_manager = $client_details->account_manager;
			$client_package = $client_details->package_type;
			$client_email = $client_details->email;
			
			/**
			 * ***** getting the sharefile folder details based on comapny id *****
			 */
			$folder_details = TblAcaSharefileFolders::find ()->where ( [ 
					'company_id' => $company_id 
			] )->One ();
			if (! empty ( $folder_details )) {
				$sharefile_folder_id = $folder_details->sharefile_folder_id;
				$client_id = $folder_details->client_id;
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
				 * **** uploading the document into local server ****
				 */
				$model_upload_form = new UploadfileForm ();
				$file = UploadedFile::getInstance ( $model_upload_form, 'Document' );
				
				if ($file) {
					$ext = explode ( ".", $file->name );
					$model_upload_form->Document = $file->name;
					$path = \Yii::$app->basePath . '/Images/sharefile_docs/' . $model_upload_form->Document;
					
					$file->saveAs ( $path );
					chmod ( $path, 0777 );
				}
				
				/**
				 * **** upload the document into sharefile *******
				 */
				$local_path = $path;
				$result = \Yii::$app->Sharefile->upload_file ( $hostname, $client_api_id, $client_secret, $new_username, $new_password, $sharefile_folder_id, $local_path );
				
				/**
				 * ******** redirection after upload ******
				 */
				if (strpos ( $result, 'OK' ) !== false) {
					exec ( 'rm ' . $local_path );
					$from = 'admin@acareporting.com';
					$document_name = $model_upload_form->Document;
					
					/**
					 * **** sending mails after document upload ******
					 */
					if (! empty ( $admin_user_id ) && $admin_user_id == $client_account_manager) {
						
						// get all company users
						$all_company_users = $model_company_users->FindAllbyclient ( $company_client_id, $company_id );
						$logged_manager_details = $model_staff_users->findById ( $admin_user_id );
						$logged_name = $logged_manager_details->first_name . ' ' . $logged_manager_details->last_name;
						
						if (! empty ( $all_company_users )) 						// mail to users
						{
							foreach ( $all_company_users as $users ) {
								$user_permissions = $model_company_user_permission->Checkfileuploadpermission ( $users->company_user_id, $company_id );
								
								if ($user_permissions == 'uploadpermission') {
									$to = $users->email;
									
									\Yii::$app->CustomMail->Uploaddocumentusermail ( $to, $from, $document_name, $company_number, $company_name, $logged_name );
								}
							}
						}
						
						// mail to the client
						
						\Yii::$app->CustomMail->Uploaddocumentusermail ( $client_email, $from, $document_name, $company_number, $company_name, $logged_name );
					} else {
						if ($client_package != 12) { // 12 denotes Budget Package
						                             
							// mail to admin
							if (! empty ( $client_account_manager )) {
								
								$account_manager_details = $model_users->findById ( $client_account_manager );
								$account_manager_mail = $account_manager_details->useremail;
								
								\Yii::$app->CustomMail->Uploaddocumentadminmail ( $account_manager_mail, $from, $document_name, $company_number, $company_name, $logged_name );
							}
						} else {
							
							// mail to ankamranjithkumar@gmail.com
							\Yii::$app->CustomMail->Uploaddocumentadminmail ( 'help@skyinsurancetech.com', $from, $document_name, $company_number, $company_name, $logged_name );
						}
					}
					\Yii::$app->session->setFlash ( 'success', 'Document uploaded successfully' );
					return $this->redirect ( array (
							'/client/dashboard?c_id=' . $c_id 
					) );
				}
			} else {
				\Yii::$app->session->setFlash ( 'error', 'An error occured while uploading, please contact support' );
				return $this->redirect ( array (
						'/client/dashboard?c_id=' . $c_id 
				) );
			}
		}
	}
}
