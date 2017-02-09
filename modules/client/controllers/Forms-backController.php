<?php

namespace app\modules\client\controllers;

use yii\web\Controller;
use yii\web\UploadedFile;
use app\components\EncryptDecryptComponent;
use app\models\TblAcaCompanies;
use app\models\TblAcaBasicInformation;
use yii\db\Query;
use app\models\TblUsaStates;
use app\models\TblAcaPayrollData;
use app\models\TblAcaCompanyReportingPeriod;
use app\models\TblAcaPlanCoverageType;
use app\models\TblAcaMedicalEnrollmentPeriod;
use app\models\TblAcaMedicalData;
use yii\helpers\ArrayHelper;
use app\models\TblGenerateForms;
use app\models\TblAcaForms;
use app\models\TblAca1094;
use app\models\TblAcaPlanCriteria;
use app\models\TblAca1095;
use app\models\TblAcaFormErrors;
use app\models\TblAcaValidationLog;
use app\models\TblAcaPlanClassValidationLog;
use app\models\TblAcaPayrollValidationLog;
use app\models\TblAcaPayrollEmploymentPeriodValidationLog;
use app\models\TblAcaMedicalValidationLog;
use app\models\TblAcaMedicalEnrollmentPeriodValidationLog;
use app\models\TblAcaCompanyValidationStatus;
use app\components\ValidateCheckErrorsComponent;
use app\models\TblAcaPrintAndMail;
use app\models\TblAcaCompanyUsers;
use app\models\TblAcaGlobalSettings;
use app\models\TblCityStatesUnitedStates;
use app\models\TblAcaPdfGenerate;
use app\models\TblAcaPdfForms;
use app\models\TblAcaLookupOptions;
use mikehaertl\pdftk\Pdf;
use app\models\Tbl1094PdfFields;
use app\models\Tbl1095PdfFields;
use app\models\TblAcaGeneralPlanInfo;
use app\models\TblAcaFormPricing;
use app\models\TblAcaBrands;
use app\models\TblAcaClients;
use yii\base\Object;

/**
 * This class is used to manage all the forms generation data screen
 */
class FormsController extends Controller {
	/*
	 * this is the default function which is use to render the forms data to the view
	 */
	public function actionIndex() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
		                                                           
			// rendering the layout
			$this->layout = 'main';
		\Yii::$app->view->title = 'ACA Reporting Service | Manage ACA Reporting Forms';
			$session = \Yii::$app->session; // declaring session
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			
			$get_company_id = \yii::$app->request->get (); // getting values using get
			$is_all_validated = 0;
			
			if (! empty ( $get_company_id['c_id'] )) {
				
				$validation_status = '';                  //initialising the values
				$model_acaforms_approve = false;
				$arr_validations = array();
				$arr_forms_ids = array ();
				$progress_version = '';
				$in_progress = 0;
				$model_acaforms = '';
				$model_generated_forms= '';
				$model_print_mail = new TblAcaPrintAndMail();
				$encrypt_component = new EncryptDecryptComponent ();
				$validate_check_errors = new ValidateCheckErrorsComponent ();
				$model_companies = new TblAcaCompanies ();
				$model_companyuser = new TblAcaCompanyUsers();
				$estimated_date = '+1d';
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
					
				$arruserpermission = \Yii::$app->Permission->Checkclientallpermission ( $logged_user_id, $company_id ); //getting permission for user
				
				$company_detals = TblAcaCompanies::find ()->select ( 'company_client_number,company_name,reporting_status' )->where ( 'company_id = :company_id', [ 
						'company_id' => $company_id 
				] )->one ();
				
				/**
				 * ****Get validation results***********
				 */
				$validation_results = TblAcaValidationLog::find ()->select ( 'validation_rule_id, is_validated' )->where ( [ 
						'company_id' => $company_id 
				] )->All ();
				
				$validation_status = TblAcaCompanyValidationStatus::find ()->where ( [ 
						'company_id' => $company_id 
				] )->One ();
				// Checking if validations results are empty
				if (! empty ( $validation_results )) {
					
					$arr_validations = $validate_check_errors->CheckErrors ( $validation_results, $company_id );
				}
				
				// check if all values are validated
				if (empty ( $arr_validations ['basic_info'] ) && empty ( $arr_validations ['benefit_plan'] ) && empty ( $arr_validations ['plan_class_validation'] ) && empty ( $arr_validations ['payroll_data_validation'] ) && empty ( $arr_validations ['medical_data_validation'] )) {
					$is_all_validated = 1;
				}
				
				// get all generated forms
				$model_generated_forms = TblGenerateForms::find ()->select ( 'id, cron_status, version' )->where ( [ 
						'company_id' => $company_id 
				] )->all ();
				
				
				if (! empty ( $model_generated_forms )) {
					foreach ( $model_generated_forms as $generated_forms ) {
						
						if ($generated_forms->cron_status == 2 ) {
							$arr_forms_ids [] = $generated_forms->id;
						} else {
							$in_progress ++;
							$progress_version .= $generated_forms->version;
						}
					}
				}
				
				
				
				if (!empty ( $arr_forms_ids )) {
					// get all generated forms
					$model_acaforms = TblAcaForms::find ()->where ( [ 
							'company_id' => $company_id,
							'generate_form_id'=>$arr_forms_ids 
					] )->all ();
					
							
					// check if form is already approved
					if (! empty ( $model_acaforms )) {
						foreach ( $model_acaforms as $forms ) {
							if ($forms->is_approved == 1) {
								$model_acaforms_approve = true;
								break;
							}
						}
					}
				}
				
				
				
				$model_company_user = TblAcaCompanyUsers::find()->where(['user_id'=>$logged_user_id])->one();
				
				if(!empty($model_company_user->client->brand_id)){
					$brand_id = $model_company_user->client->brand_id;
					$model_acabrand = TblAcaBrands::find()->select('brand_url')->where(['brand_id'=>$brand_id])->one();
						
					$link = $model_acabrand->brand_url;
				}
				
				if(!empty($link)){
					$link = $model_acabrand->brand_url;
				}else{
					$link = \Yii::$app->params['defaultBrandLink'];
				}
				
				
				return $this->render ( 'index', [ 
						'company_id' => $encrypt_company_id, // rendering the values to view
						'company_detals' => $company_detals,
						'model_acaforms' => $model_acaforms,
						'is_all_validated' => $is_all_validated,
						'arr_validations' => $arr_validations,
						'validation_status' => $validation_status,
						'model_acaforms_approve' => $model_acaforms_approve,
						'arruserpermission' => $arruserpermission,
						'in_progress'=>$in_progress,
						'progress_version'=>$progress_version,
                        'model_print_mail'=>$model_print_mail,
                       // 'estimated_date'=>$estimated_date,
						//'date_value'=>$date_value,
						'model_companyuser'=>$model_companyuser,
						'link'=>$link
				] );
				
			}
			else {                           //if not empty of company id redirects here
				return $this->redirect ( array (
						'/client/companies'
				) );
			}
			} else {                           //if not empty of company id redirects here
				return $this->redirect ( array (
						'/client/companies' 
				) );
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // session expires then logouts
			
			return $this->goHome ();
		}
	}
	
	/*
	 * for saving 1094c form
	 */
	public function actionForm1094() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
		                                                           
			// rendering the layout
			$this->layout = 'main';
			$encrypt_company_id = '';     //initialising the values
			$form_id = '';
			$update_part1 = '';
			$update_part2 = '';
			$update_part3 = '';
			$update_part4 = '';
			$part_1='';
			$part_2='';
			$part_3='';
			$part_4='';
			$arrmonth = array ('jan',
			'feb',
			'mar',
			'apr',
			'may',
			'june',
			'july',
			'aug',
			'sept',
			'oct',
			'nov',
			'dec');
			$countmonth=0;
			
			
			$session = \Yii::$app->session; // declaring session
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			$encrypt_component = new EncryptDecryptComponent ();
			$get_company_id = \yii::$app->request->get ();
			
			
			
			if (! empty ( $get_company_id ['c_id'] ) && ! empty ( $get_company_id ['form_id'] )) {
				
				/**
				 * Get encrypted company id from URL*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				$encrypt_form_id = $get_company_id ['form_id'];
				$form_id = $encrypt_component->decryptUser ( $encrypt_form_id );
				
				if (! empty ( $encrypt_company_id )) {
					$company_id = (new EncryptDecryptComponent ())->decryptUser ( $encrypt_company_id ); // decrypted company id
					$check_company_details = (new TblAcaCompanies ())->Companyuniquedetails ( $company_id ); // Checking if company exists with that company id
					if (! empty ( $check_company_details )) {
						$client_id = $check_company_details->client_id; // Company clien Id
					}
				}
				
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					
					$post_values = \yii::$app->request->post ();
					
					$model_1094c = TblAca1094::find ()->joinwith ( 'form' )->where ( [ 
							'form_id' => $form_id,
							'tbl_aca_forms.company_id' => $company_id 
					] )->one (); // for particular id getting values
					
					if (! empty ( $model_1094c )) {
						// part1 unserialized and decode format
						$unserialise_data_part1 = unserialize ( $model_1094c->serialise_data1 );
						$update_part1 = json_decode ( $unserialise_data_part1 );
						
						// part2 unserialized and decode format
						$unserialise_data_part2 = unserialize ( $model_1094c->serialise_data2 );
						$update_part2 = json_decode ( $unserialise_data_part2 );
						
						// part3 unserialized and decode format
						$unserialise_data_part3 = unserialize ( $model_1094c->serialise_data3 );
						$update_part3 = json_decode ( $unserialise_data_part3 );
						
						// part4 unserialized and decode format
						$unserialise_data_part4 = unserialize ( $model_1094c->serialise_data4 );
						$update_part4 = json_decode ( $unserialise_data_part4 );
						
						// xml serialize data
						$unserialise_data_part_xml = unserialize ( $model_1094c->xml_data );
						$update_part_xml = json_decode ( $unserialise_data_part_xml );
						
						$model_company_reportingperiod = TblAcaCompanyReportingPeriod::find()->select('reporting_year')->where(['company_id'=>$company_id])->one();
							
							
						$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
						
						try {
							if ($post_values) {
								

								$post_values ['part2']['total_no_of_1095c_filled_II'] = empty($update_part2->total_no_of_1095c_filled_II)?'':$update_part2->total_no_of_1095c_filled_II;
									
								/************************************** part 1****************************************/
								$part_1 = $model_1094c->serialise_data1; // serialising the array
								
							/************************************** part 2****************************************/	
								if(!empty($post_values ['part2'])){
									$part_2 = serialize ( json_encode ( $post_values ['part2'] ) ); // serialising the array
								}
								
								
								/************************************** part xml****************************************/
								$part_xml = $model_1094c->xml_data;
								
								
								/************************************** part 3****************************************/
								if(!empty($post_values ['part3'])){
									
										/*     full time employee */
									$valuefulltimeall =$post_values ['part3']['section_4980h_fulltime_employee_count_all_III'];

									if($post_values ['part3']['section_4980h_fulltime_employee_count_all_III']!=''){
										$post_values ['part3']['section_4980h_fulltime_employee_count_all_III'] = $valuefulltimeall;
										foreach($arrmonth as $key=>$value){
										$post_values ['part3']['section_4980h_fulltime_employee_count_'.$value.'_III'] = '';
										}
									}else{
										
									$valuejan =$post_values ['part3']['section_4980h_fulltime_employee_count_jan_III'];
												// Check all codes for a particular month
									foreach($arrmonth as $key=>$value) {
										if ( $post_values ['part3']['section_4980h_fulltime_employee_count_'.$value.'_III'] == $valuejan) {
										$countmonth++;
										   }
									}	
									
									if($countmonth >= 12){
										$post_values ['part3']['section_4980h_fulltime_employee_count_all_III'] = $valuejan;
										foreach($arrmonth as $key=>$value){
										$post_values ['part3']['section_4980h_fulltime_employee_count_'.$value.'_III'] = '';
										}
									}else{
										$post_values ['part3']['section_4980h_fulltime_employee_count_all_III'] = '';
									}
									
									}
							/* end for full time employee */
							
							
							/*     employee count */
									$valueemployeecountall =$post_values ['part3']['total_employee_count_all_III'];

									if($post_values ['part3']['total_employee_count_all_III']!=''){
										$post_values ['part3']['total_employee_count_all_III'] = $valueemployeecountall;
										foreach($arrmonth as $key=>$value){
										$post_values ['part3']['total_employee_count_'.$value.'_III'] = '';
										}
									}else{
										
									$valuejan =$post_values ['part3']['total_employee_count_jan_III'];
												// Check all codes for a particular month
									foreach($arrmonth as $key=>$value) {
										if ( $post_values ['part3']['total_employee_count_'.$value.'_III'] == $valuejan) {
										$countmonth++;
										   }
									}	
									
									if($countmonth >= 12){
										$post_values ['part3']['total_employee_count_all_III'] = $valuejan;
										foreach($arrmonth as $key=>$value){
										$post_values ['part3']['total_employee_count_'.$value.'_III'] = '';
										}
									}else{
										$post_values ['part3']['total_employee_count_all_III'] = '';
									}
									
									}
							/* end for full time employee */
							
							/*     transition relief indicator */
									$valuetransitionall =$post_values ['part3']['section_4980h_transition_all_III'];

									if($post_values ['part3']['section_4980h_transition_all_III']!=''){
										$post_values ['part3']['section_4980h_transition_all_III'] = $valuetransitionall;
										foreach($arrmonth as $key=>$value){
										$post_values ['part3']['section_4980h_transition_'.$value.'_III'] = '';
										}
									}else{
										
									$valuejan =$post_values ['part3']['section_4980h_transition_jan_III'];
												// Check all codes for a particular month
									foreach($arrmonth as $key=>$value) {
										if ( $post_values ['part3']['section_4980h_transition_'.$value.'_III'] == $valuejan) {
										$countmonth++;
										   }
									}	
									
									if($countmonth >= 12){
										$post_values ['part3']['section_4980h_transition_all_III'] = $valuejan;
										foreach($arrmonth as $key=>$value){
										$post_values ['part3']['section_4980h_transition_'.$value.'_III'] = '';
										}
									}else{
										$post_values ['part3']['section_4980h_transition_all_III'] = '';
									}
									
									}
							/* end for transition relief indicator */
							
							
									$part_3 = serialize ( json_encode ( $post_values ['part3'] ) ); // serialising the array
								}
								
								/************************************** part 4****************************************/
								if(!empty($post_values ['part4'])){
									
									for($i=36,$j=36;$i<66;$i++){
									if(!empty($post_values['part4']['name_IV_'.$i])){
										$name=$post_values['part4']['name_IV_'.$i];
										$ein=$post_values['part4']['ein_IV_'.$i];
										$post_values['part4']['ein_IV_'.$i]='';
										$post_values['part4']['name_IV_'.$i]='';
										$post_values['part4']['name_IV_'.$j]=$name;
										$post_values['part4']['ein_IV_'.$j]=$ein;
										$j++;
									}
								}
								
									$part_4 = serialize ( json_encode ( $post_values ['part4'] ) ); // serialising the array
								}
								
								$model_1094c->serialise_data1 = $part_1;
								$model_1094c->serialise_data2 = $part_2;
								$model_1094c->serialise_data3 = $part_3;
								$model_1094c->serialise_data4 = $part_4;
								$model_1094c->xml_data = $part_xml;
								$model_1094c->updated_by = $logged_user_id;
								
								if ($model_1094c->save () && $model_1094c->validate ()) { // model save
									
									$check_zip = TblAcaPdfForms::find()->select('pdf_zip_name')->where(['form_id'=>$form_id])->One();
									if(!empty($check_zip))
									{
									$zip_name = $check_zip->pdf_zip_name;
									
									TblAcaPdfForms::deleteAll ( 'form_id = :form_id ', [
									':form_id' => $form_id
									] );
									//deleting zip
									
									if (file_exists ('files/pdf/' . $encrypt_company_id.'/'.$zip_name.'.zip' ))
									{
									$path = 'files/pdf/' . $encrypt_company_id.'/'.$zip_name.'.zip';
									$this->Deletefile($path);
									}
									
									}
									
									
									
									
									$model_acaforms= TblAcaForms::find()->where(['id'=>$form_id])->one();
									$model_acaforms->modified_date_form = date('Y-m-d H:i:s');
									$model_acaforms->modified_by = $logged_user_id;
									$model_acaforms->save();
									 
									 //Check if pdf file exists deleteAll
									 
									
									if (is_dir ( 'files/pdf/' . $encrypt_company_id . '/' . $encrypt_form_id )) {
									
									$path = 'files/pdf/' . $encrypt_company_id . '/' . $encrypt_form_id;
									$this->Deletefile($path);
									}
									
									$transaction->commit (); // commit the transaction
									
									
									\Yii::$app->session->setFlash ( 'success', '1094C form successfully Updated' );
									return $this->redirect ( array (
											'/client/forms?c_id=' . $encrypt_company_id /*. '&form_id=' . $encrypt_form_id */ // redirecting to grid if form is updated
																		) );
								} else {
									
									\Yii::$app->session->setFlash ( 'error', 'Some error occured,while saving' );
									return $this->redirect ( array (
											'/client/forms/form1094?c_id=' . $encrypt_company_id . '&form_id=' . $encrypt_form_id  // redirecting to grid if form is updated
																		) );
								}
							}
						} catch ( \Exception $e ) { // any \Exceptions catch throws error msg
							$msg = $e->getMessage ();
							\Yii::$app->session->setFlash ( 'error', $msg );
							
							$transaction->rollback (); // if \Exception occurs transaction rollbacks
						}
						
						return $this->render ( 'index-f1094', [ 
								'company_id' => $encrypt_company_id,
								'update_part1' => $update_part1,
								'update_part2' => $update_part2,
								'update_part3' => $update_part3,
								'update_part4' => $update_part4,
								'update_part_xml'=>$update_part_xml,
								'model_company_reportingperiod'=>$model_company_reportingperiod								
						] ); // rendering values
					} else {
						
						\Yii::$app->session->setFlash ( 'error', 'No 1094 C form avaliable' );
						return $this->redirect ( array (
								'/client/forms/index?c_id=' . $encrypt_company_id  // redirecting to form if form is updated
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
			\Yii::$app->SessionCheck->clientlogout (); // session expires then logouts
			
			return $this->goHome ();
		}
	}
	
	/*
	 * for saving 1095c form
	 */
	public function actionForm1095() {
		
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
		                                                           
			// rendering the layout
			$this->layout = 'main';
			$encrypt_company_id = '';
			$form_id = '';
			$update_part1 = '';
			$update_part2 = '';
			$update_part3 = '';
			$part_1='';
			$part_2='';
			$part_3='';
			$ssn = '';
			$previous_button = '';
			$next_button = '';
			$arrmonth = array ('all_12_months','jan',
			'feb',
			'march',
			'april',
			'may',
			'june',
			'july',
			'august',
			'september',
			'october',
			'november',
			'december');
			
			$session = \Yii::$app->session; // declaring session
			$logged_user_id = $session ['client_user_id'];
			$client_ids = $session ['client_ids']; // all related clients to the logged user
			$company_ids = $session ['company_ids']; // all related companies to the logged user
			$mapped_company_ids = array_map ( function ($piece) {
				return ( string ) $piece;
			}, $company_ids );
			$encrypt_component = new EncryptDecryptComponent ();
			$get_company_id = \yii::$app->request->get ();
			
	
			if (!empty ( $get_company_id ['c_id'] ) && !empty ( $get_company_id ['form_id'] )) {
				/**
				 * Get encrypted company id from URL*
				 */
				$encrypt_company_id = $get_company_id ['c_id'];
				$encrypt_form_id = $get_company_id ['form_id'];
				
				$form_id = $encrypt_component->decryptUser ( $encrypt_form_id );
				
				
				
				if (isset ( $get_company_id ['ssn'] ) && $get_company_id ['ssn'] != '') {
					$ssn = $get_company_id ['ssn'];
				}
				
				if (! empty ( $encrypt_company_id )) {
					$company_id = (new EncryptDecryptComponent ())->decryptUser ( $encrypt_company_id ); // decrypted company id
					$check_company_details = (new TblAcaCompanies ())->Companyuniquedetails ( $company_id ); // Checking if company exists with that company id
					if (! empty ( $check_company_details )) {
						$client_id = $check_company_details->client_id; // Company client Id
					}
				}
				
				if (! empty ( $check_company_details ) && in_array ( $client_id, $client_ids, TRUE ) && in_array ( $company_id, $mapped_company_ids, TRUE )) {
					
					
						
					if(empty($ssn))
					{
						//check for first ssn
						$get_first_ssn = TblAca1095::find ()->select('ssn')->joinwith ( 'forms' )->where ( [
								'form_id' => $form_id,
								'tbl_aca_forms.company_id' => $company_id
								] )
								->orderby ( [
										'tbl_aca_1095.id' => SORT_ASC
										] )->one ();
						if($get_first_ssn){	
						$ssn = $get_first_ssn->ssn;
						}
							
					}
					
					if (! empty ( $form_id ) && !empty($ssn)) {
						
						
						
						$model_1095c = TblAca1095::find ()->joinwith ( 'forms' )->where ( [ 
								'form_id' => $form_id,
								'ssn' => $ssn,
								'tbl_aca_forms.company_id' => $company_id 
						] )->one (); // for particular id getting values
						
						//get all existing ssn in 1095 form
						$model_1095c_ssn = TblAca1095::find ()->select('ssn')->where(['form_id'=>$form_id])->all();
						
						if (! empty ( $model_1095c )) {
							
							$next_button = TblAca1095::find()->joinwith ( 'forms' )->select('ssn')
							->where(['>', 'tbl_aca_1095.id', $model_1095c->id])
							->andWhere(['form_id' => $form_id,'tbl_aca_forms.company_id' => $company_id ])
							->one();;
							$previous_button = TblAca1095::find()->joinwith ( 'forms' )->select('ssn')
							->where(['<', 'tbl_aca_1095.id', $model_1095c->id])
							->andWhere(['form_id' => $form_id,'tbl_aca_forms.company_id' => $company_id ])
							->orderBy('tbl_aca_1095.id desc')->one();;
								
							// part1 unserialized and decode format
							$unserialise_data_part1 = unserialize ( $model_1095c->serialise_data1 );
							$update_part1 = json_decode ( $unserialise_data_part1 );
							
							// part2 unserialized and decode format
							$unserialise_data_part2 = unserialize ( $model_1095c->serialise_data2 );
							$update_part2 = json_decode ( $unserialise_data_part2 );
							
							// part3 unserialized and decode format
							$unserialise_data_part3 = unserialize ( $model_1095c->serialise_data3 );
							$update_part3 = json_decode ( $unserialise_data_part3 );
							
							// xml serialize data
							$unserialise_data_part_xml = unserialize ( $model_1095c->xml_data );
							$update_part_xml = json_decode ( $unserialise_data_part_xml );
							
							$model_company_reportingperiod = TblAcaCompanyReportingPeriod::find()->select('reporting_year')->where(['company_id'=>$company_id])->one();
							
							$post_values = \yii::$app->request->post ();
							$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
						
							try {
								if (! empty ( $post_values )) {
									
									/**************************ravi for employee name and street address in part 1*************************************/
									$post_values ['part1']['employee_name__I']= $post_values ['xml']['first_name__1'].' '.$post_values ['xml']['middle_name__1'].' '.$post_values ['xml']['last_name__1'].' '.$post_values ['xml']['suffix__1'];
									$post_values ['part1']['employee_street_Address__I']= $post_values ['xml']['street_address_1__3'].' '.$post_values ['xml']['street_address_2__3'];
								
									$street_employer_address = $update_part_xml->street_address_1__9;
									$street_employer_address2 = $update_part_xml->street_address_2__9;
									$post_values ['part1']['employer_street_address__I']= $street_employer_address.' '.$street_employer_address2;
									
									
								$post_values ['part1']['employee_ssn__I']= $update_part1->employee_ssn__I;
								
								$post_values ['part1']['employer_name__I']= $update_part1->employer_name__I;
								$post_values ['part1']['employer_ein__I']= $update_part1->employer_ein__I;
								
								$post_values ['part1']['employer_contact_telephone_number__I']= $update_part1->employer_contact_telephone_number__I;
								$post_values ['part1']['employer_city_town__I']= $update_part1->employer_city_town__I;
								$post_values ['part1']['employer_state_province__I']= $update_part1->employer_state_province__I;
								$post_values ['part1']['employer_country_and_zip__I']= $update_part1->employer_country_and_zip__I;
								
								$post_values ['xml']['street_address_1__9']=$update_part_xml->street_address_1__9;
								$post_values ['xml']['street_address_2__9']=$update_part_xml->street_address_2__9;
								
								
								if(!empty($post_values ['part1'])){
									$part_1 = serialize ( json_encode ( $post_values ['part1'] ) );
								}									// serialising the array
								if(!empty($post_values ['part2'])){

									foreach($arrmonth as $month){
										if(!empty($post_values ['part2']['employee_required_contributions_'.$month.'__II'])){
											$number = $post_values ['part2']['employee_required_contributions_'.$month.'__II'];
											
											$post_values ['part2']['employee_required_contributions_'.$month.'__II'] = number_format($number,2);
											
										}
									}
									
								$part_2 = serialize ( json_encode ( $post_values ['part2'] ) );
								}
									if(!empty($post_values ['part3']) && (isset($post_values ['part3']['employer_self_insured__III']) && $post_values ['part3']['employer_self_insured__III']=='1')){
										
										for ($i=17;$i<=34;$i++){
												
											if(!empty($post_values ['xml']['section_2__'.$i]['first_name'])){
												$post_values ['part3']['name_'.$i.'_name_of_covered_individual__III']= $post_values ['xml']['section_2__'.$i]['first_name'] .' '.$post_values ['xml']['section_2__'.$i]['middle_name'] .' '.$post_values ['xml']['section_2__'.$i]['last_name'] .' '.$post_values ['xml']['section_2__'.$i]['suffix'];
											}else{
												$post_values ['part3']['name_'.$i.'_name_of_covered_individual__III']='';
											}
										}
										
										$part_3 = serialize ( json_encode ( $post_values ['part3'] ) );
									}else{
										$part_3 = '';
									}
									
									if(!empty($post_values ['xml'])){
									
										$part_xml = serialize ( json_encode ( $post_values ['xml'] ) );
									}
									
									$clean_ssn = preg_replace ( '/[^0-9]/s', '', $update_part1->employee_ssn__I );
									
									// assigning to model
									$model_1095c->ssn = $clean_ssn;
									$model_1095c->serialise_data1 = $part_1;
									$model_1095c->serialise_data2 = $part_2;
									$model_1095c->serialise_data3 = $part_3;
									$model_1095c->xml_data = $part_xml;
									$model_1095c->updated_by = $logged_user_id;
									
									if ($model_1095c->save () && $model_1095c->validate ()) { // model save
									
										$check_zip = TblAcaPdfForms::find()->select('pdf_zip_name')->where(['form_id'=>$form_id])->One();
									if(!empty($check_zip))
									{
									$zip_name = $check_zip->pdf_zip_name;
									
									
									
									
									//deleting zip
									if (file_exists ('files/pdf/' . $encrypt_company_id.'/'.$zip_name.'.zip' ))
									{
									$path = 'files/pdf/' . $encrypt_company_id.'/'.$zip_name.'.zip';
									unlink($path);
									}
									TblAcaPdfForms::deleteAll ( 'form_id = :form_id ', [
									':form_id' => $form_id
									] );
									
									}
									
									
									
									
									$model_acaforms= TblAcaForms::find()->where(['id'=>$form_id])->one();
									$model_acaforms->modified_date_form = date('Y-m-d H:i:s');
									$model_acaforms->modified_by = $logged_user_id;
									$model_acaforms->save();
									 
									 //Check if pdf file exists deleteAll
									 
									
									if (is_dir ( 'files/pdf/' . $encrypt_company_id . '/' . $encrypt_form_id )) {
									
									$path = 'files/pdf/' . $encrypt_company_id . '/' . $encrypt_form_id;
									$this->Deletefile($path);
									}
									
										$transaction->commit (); // commit the transaction
										
										\Yii::$app->session->setFlash ( 'success', '1095C form successfully Updated' );
										return $this->redirect ( array (
												'/client/forms?c_id=' . $encrypt_company_id /*. '&form_id=' . $encrypt_form_id.'&ssn='.$ssn */ // redirecting to grid if form is updated
																				) );
									} else {
										
										\Yii::$app->session->setFlash ( 'error', 'Some error occured' );
										
										return $this->redirect ( array (
												'/client/forms/form1095?c_id=' . $encrypt_company_id . '&form_id=' . $encrypt_form_id.'&ssn='.$ssn  // redirecting to grid if form is updated
																				) );
									}
								}
							} catch ( \Exception $e ) { // any \Exceptions catch throws error msg
								$msg = $e->getMessage ();
							
								\Yii::$app->session->setFlash ( 'error', $msg );
								
								$transaction->rollback (); // if \Exception occurs transaction rollbacks
							}
							
							return $this->render ( 'index-f1095', [ 
									'company_id' => $encrypt_company_id,
									'update_part1' => $update_part1,
									'update_part2' => $update_part2,
									'update_part3' => $update_part3,
									'update_part_xml'=>$update_part_xml,
									'ssn'=>$ssn,
									'previous_button'=>$previous_button,
									'next_button'=>$next_button,
									'model_1095c_ssn'=>$model_1095c_ssn,
									'model_company_reportingperiod'=>$model_company_reportingperiod
							] ); // rendering values
						} else {
							\Yii::$app->session->setFlash ( 'error', 'No 1095 C forms avaliable' );
							return $this->redirect ( array (
									'/client/forms/index?c_id=' . $encrypt_company_id  // redirecting to grid if form is updated
														) );
						}
					} else {
						
						return $this->redirect ( array (
								'/client/forms/index?c_id=' . $encrypt_company_id  // redirecting to grid if form is updated
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
			\Yii::$app->SessionCheck->clientlogout (); // session expires then logouts
			
			return $this->goHome ();
		}
	
	}
	
	
	private function Deletefile($dirname) {
		$dir_handle='';
         if (is_dir($dirname))
           $dir_handle = opendir($dirname);
	 if (!$dir_handle)
	      return false;
	 while($file = readdir($dir_handle)) {
	       if ($file != "." && $file != "..") {
	            if (!is_dir($dirname."/".$file))
	                 unlink($dirname."/".$file);
	            else
	                 delete_directory($dirname.'/'.$file);
	       }
	 }
	 closedir($dir_handle);
	 rmdir($dirname);
	 return true;
	}

	/*
	 * *action used to find entered state is avaliable in db
	 */
	public function actionGetstate() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
			
			$post_values = \yii::$app->request->post (); // getting post values
			
			
			if (! empty ( $post_values ['value'] ) || ! empty ( $post_values ['value_2'] )) {   //checking for the value
				
				$state = $post_values ['value'];
				$state_2 = $post_values ['value_2'];
				
				$model_state = TblUsaStates::find ()->where ( [  //geting the information
						'state_code' => $state 
				] )->one (); // checking for state
				if (! empty ( $model_state )) {
					
					$model_state = TblUsaStates::find ()->where ( [ 
							'state_code' => $state_2 
					] )->one (); // checking for state
					if (! empty ( $model_state )) {
						return 'success';
					} else if (! empty ( $state_2 )) {
						return 'fail2';
					}
				} else {
					return 'fail1';
				}
			} else {
				return 'fail';
			}
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // session expires then logouts
			
			return $this->goHome ();
		}
	}
	/**
	 * Function is used to set cron for form generation for particluar company
	 */
	function actionCronset() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
			
			$session = \Yii::$app->session; // declaring session
			$logged_user_id = $session ['client_user_id'];
			
			$post_values = \yii::$app->request->post (); // getting post values
			$company_id = $post_values ['company_id'];
			$company_id = (new EncryptDecryptComponent ())->decryptUser ( $company_id ); // decrypted company id

			$output = array ();
			$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
			$version = 1.0;
			$cron_entry = true;
			try {
				$model_cronset = TblGenerateForms::find ()->where ( [ 
						'company_id' => $company_id 
				] )->orderby ( [ 
						'version' => SORT_DESC 
				] )->one ();
				if (! empty ( $model_cronset )) {
					
					if ($model_cronset->cron_status == 1 || $model_cronset->cron_status == 0) {
						$cron_entry = false;
						throw new \Exception ( 'Form generation is already in progress' ); // sending response to ajax
					} else {
						$version = ($model_cronset->version) + 1;
						// $model_cronset->cron_status=0;
						$cron_entry = true;
					}
				}
				
				if ($cron_entry) {
					$model_cronset = new TblGenerateForms ();
					
					$model_cronset->version = $version;
					$model_cronset->company_id = $company_id;
					$model_cronset->cron_status = 0;
					$model_cronset->created_by = $logged_user_id;
					$model_cronset->created_date = date ( 'Y-m-d H:i:s' );
					$model_cronset->updated_date = date ( 'Y-m-d H:i:s' );
				}
				
				if ($model_cronset->validate() && $model_cronset->save ()) { // model save
				
					$model_companystatus = TblAcaCompanies::find()->where(['company_id'=>$company_id])->one();
							
					$model_lookupid = TblAcaLookupOptions::find()->select('lookup_id')->where(['lookup_value'=>'Forms Creation in Progress','code_id'=>6])->one();
					
					if(!empty($model_lookupid)){
						$model_companystatus->reporting_status = $model_lookupid->lookup_id; //92 in armor dev
						$model_companystatus->save();
					}
					$transaction->commit ();
					$output ['success'] = 'Form creation got initialised successfully';
				} else {
					// print_r($model_cronset->errors);die();
					$output ['error'] = 'Error occured while saving. Please try again';
				}
			} catch ( \Exception $e ) { // any \Exceptions catch throws error msg
				$msg = $e->getMessage ();
				$output ['error'] = $msg;
				
				$transaction->rollback (); // if \Exception occurs transaction rollbacks
			}
			return json_encode ( $output );
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // session expires then logouts
			
			return $this->goHome ();
		}
	}
	
	/*
	 * this function used to update approved by
	 */
	function actionApproveefile() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
			
			$session = \Yii::$app->session; // declaring session
			$logged_user_id = $session ['client_user_id'];
			$approve_name = '';
			$post_values = \yii::$app->request->post (); // getting post values
			$form_id = $post_values ['form_id'];
			$approve_name = $post_values ['approve_name'];
			$form_id = (new EncryptDecryptComponent ())->decryptUser ( $form_id ); // decrypted company id
			$output = array ();
			$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
			try {
				
				
				
				$model_acaform = TblAcaForms::find ()->where ( [ 
						'id' => $form_id 
				] )->one ();
				if (! empty ( $model_acaform )) {
					
					$company_id =  $model_acaform->company_id;
					//check if file is already approved by this company
					
					$model_acaform->approved_by_name = $approve_name;
					$model_acaform->approved_by = $logged_user_id;
					$model_acaform->approved_date = date('Y-m-d H:i:s');
					$model_acaform->is_approved = 1;
				}
				
				if ($model_acaform->save () && $model_acaform->validate ()) { // model save
				
				if(!empty($company_id)){
					
					 $model_companystatus = TblAcaCompanies::find()->where(['company_id'=>$company_id])->one();
						
					$model_lookupid = TblAcaLookupOptions::find()->select('lookup_id')->where(['lookup_value'=>'Efile Approval','code_id'=>6])->one();
						//changing company status to efile approved
					if(!empty($model_lookupid)){
						$model_companystatus->reporting_status = $model_lookupid->lookup_id; //92 in armor dev
						$model_companystatus->save();
					}
				}
					$transaction->commit ();
					$output ['success'] = 'Form Approved succesfully';
				} else {
					
					$output ['error'] = 'Error occured while approving';
				}
			} catch ( \Exception $e ) { // any \Exceptions catch throws error msg
				$msg = $e->getMessage ();
				$output ['error'] = $msg;
				
				$transaction->rollback (); // if \Exception occurs transaction rollbacks
			}
			return json_encode ( $output );
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // session expires then logouts
			
			return $this->goHome ();
		}
	}
	
	
	/*
	 * this function used to set cron in pdf
	*/
	public function actionDownloadpdf() {
		
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
			
			$session = \Yii::$app->session; // declaring session
			$logged_user_id = $session ['client_user_id'];
			
			$post_values = \yii::$app->request->post (); // getting post values
			
			$encrypt_form_id = $post_values ['form_id']; 
			$encrypt_company_id = $post_values ['company_id'];
			
			$form_id = (new EncryptDecryptComponent ())->decryptUser ( $encrypt_form_id ); // decrypted form id
			$company_id = (new EncryptDecryptComponent ())->decryptUser ( $encrypt_company_id ); // decrypted company id
			
			$output = array ();
			$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
			try {
				
				// Check for records in generation for particular form_id
				$model_pdfgenerate = TblAcaPdfGenerate::find ()->select ( 'status' )->where ( [ 
						'form_id' => $form_id,
				] )->one ();
				
				// Check if forms are generated for this form_id
				$model_pdfforms = TblAcaPdfForms::find ()->where ( [ 
						'form_id' => $form_id 
				] )->one ();
				
				
				// Check if value exists in generation and not generated yet
				if (! empty ( $model_pdfgenerate ) && empty ( $model_pdfforms )) {
					
					$output ['success'] = 'Pdf generation is in process, Please wait';
					
				}
				// Check if value exists in generation and generated 
				else if (empty ( $model_pdfgenerate ) && !empty ( $model_pdfforms )) {
					
					
					//$output ['success'] = 'Downloading...';
					
					$filepath = 'files/pdf/' . $encrypt_company_id . '/'.$model_pdfforms->pdf_zip_name.'.zip' ;
					
					if(file_exists($filepath)){
					$output ['success'] = 'Downloading...';
					$output ['filepath'] =  '/'.$filepath;
					}
					else
					{
						$output['error'] = "No files found";
					}
					
				}
				else {
					
					$model_pdfgeneratesave = new TblAcaPdfGenerate ();
					$model_pdfgeneratesave->form_id = $form_id;
					$model_pdfgeneratesave->status = 0;
					$model_pdfgeneratesave->created_by = $logged_user_id;
					$model_pdfgeneratesave->updated_date = date ( 'Y-m-d H:i:s' );
					
					if ($model_pdfgeneratesave->save () && $model_pdfgeneratesave->validate ()) { // model save
						$transaction->commit ();
						$output ['success'] = 'Pdf generation has been started and will be ready to download in some time, Please come back again';
					} else {
						
						$output ['error'] = 'Error occured while saving';
					}
				}
			} catch ( \Exception $e ) { // any \Exceptions catch throws error msg
				$msg = $e->getMessage ();
				$output ['error'] = $msg;
				
				$transaction->rollback (); // if \Exception occurs transaction rollbacks
			}
			
			return json_encode ( $output );
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // session expires then logouts
			
			return $this->goHome ();
		}
	
	}
	
	/*
	 * function to save print and mail details
	 */
	
	public function actionPrintandmail(){
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
		
			$session = \Yii::$app->session; // declaring session
			$logged_user_id = $session ['client_user_id'];
		    $output = array();
			$upload_result =  array();
			$is_generated = false;
			$encrypt_component = new EncryptDecryptComponent ();
			$model_companies = new TblAcaCompanies ();
			
			$post_values = \yii::$app->request->get (); // getting post values
			if(!empty($post_values['company_id']) && !empty($post_values['form_id']))
			{
			$encrypt_company_id = $post_values['company_id'];
			$encrypt_form_id = $post_values['form_id'];
			
			$company_id = $encrypt_component->decryptUser ( $encrypt_company_id );
			$form_id = $encrypt_component->decryptUser ( $encrypt_form_id );
			
			$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
			$company_name = $check_company_details->company_name;
			$clean_company_name = preg_replace('/[^A-Za-z0-9]/', "_", $company_name); //cleaning company name
			
			//check if already approved
			$approved_form = TblAcaForms::find()->select('id')->where(['company_id'=>$company_id,'id'=>$form_id])->One();
			if(!empty($approved_form))
			{
				
			//check if one print is already in progress
			$check_print = TblAcaPrintAndMail::find()->select('print_id')->where(['form_id'=>$form_id,'is_printed'=>0])->One();
			if(empty($check_print))
			{
				
			$model_globalsettings = TblAcaGlobalSettings::find()->where(['setting_id'=>5])->one();
			
			$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
			try{
				
				if(!empty ($post_values['TblAcaPrintAndMail'])){
					
					$encrypt_form_id = $encrypt_component->encrytedUser ( $approved_form->id );
					// Check for records in generation for particular form_id
					$model_pdfgenerate = TblAcaPdfGenerate::find ()->select ( 'status' )->where ( [
							'form_id' => $approved_form->id,
							] )->one ();
			
					// Check if forms are generated for this form_id
					$model_pdfforms = TblAcaPdfForms::find ()->where ( [
							'form_id' => $approved_form->id
							] )->one ();
					
					//getting count of ssn to be printed
					$model_1095c_ssn = TblAca1095::find ()->select('ssn')->where(['form_id'=>$approved_form->id])->count();	
		            $package_cost = TblAcaFormPricing::find()->select('value')->where(['price_id'=>9])->one();
		
					$values= $post_values['TblAcaPrintAndMail'];
					$model_printmail = new TblAcaPrintAndMail();
					
					$model_printmail->form_id= $approved_form->id ;
					$model_printmail->print_requested_by=$logged_user_id;
					$model_printmail->requested_date=date('Y-m-d H:i:s');
					$model_printmail->no_of_forms=$model_1095c_ssn;
				//	$model_printmail->estimated_date=$values['estimated_date'];
					$model_printmail->created_by=$logged_user_id;
					$model_printmail->created_date=date ('Y-m-d H:i:s');
					$model_printmail->package_and_shipping=$package_cost->value;
					
				
					
					//calculating price according to person type
					if($values['person_type'] == 1){
						
						$arrtotvalues = $this->Getpricevalues(1 ,$model_1095c_ssn);
						$model_printmail->person_type=$values['person_type'];
						$model_printmail->price_per_form=$arrtotvalues['price_value'];
					    $model_printmail->expedite_processing_fee=$arrtotvalues['expedite_value'];
						$total = ($model_1095c_ssn * $arrtotvalues['price_value'])+$arrtotvalues['expedite_value'] + $package_cost->value;
						
						
					}else {
						
						$arrtotvalues = $this->Getpricevalues(2 ,$model_1095c_ssn);
						$model_printmail->person_type=$values['person_type'];
						$model_printmail->price_per_form=$arrtotvalues['price_value'];
						$model_printmail->expedite_processing_fee=0;
						$total = ($model_1095c_ssn * $arrtotvalues['price_value']) + $package_cost->value;
					
					
					}
					
				
					$model_printmail->total_processing_amount=$total;
					
						
					if ($model_printmail->save () && $model_printmail->validate ()) { // model save
					
					$print_id = $model_printmail->print_id;
					
					$print_output = '';
					
						
						if (! empty ( $model_pdfgenerate ) && empty ( $model_pdfforms )) {
					
							$print_output = 'Print & Mail is in process, We will notify you when completed.';
							$model_printmail->is_printed = 0;	
						}
						else if (empty ( $model_pdfgenerate ) && !empty ( $model_pdfforms )) {
							
							$person_type = $model_printmail->person_type;
							$filepath= '';
							$file_name = '';
								
							//creating local file path
							$filepath = getcwd () . '/files/pdf/' . $encrypt_company_id . '/'.$encrypt_form_id.'/'.$company_id.'_'.$approved_form->id.'_consolidate_masked_1095.pdf' ;
							$file_name = $clean_company_name.'_'.time().'.pdf';
							//check if file exists in location
							if(file_exists($filepath)){
										/***************details for mail**************************/
										$model_print_mail = TblAcaPrintAndMail::find()->where(['print_id'=>$print_id])->one();
										$bulk_mail_fee = '';
										$packaging_shipping_cost = '';
										$forms_amount = $model_print_mail->total_processing_amount;
										if($model_print_mail->person_type == 1){
											
											$type = 'Employer';
											
											//get form pricing
											$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>[9,18],'type'=>1])->asArray()->all();
											
											$packaging_shipping_cost = $model_formpricing[0]['value'];
											$bulk_mail_fee = $model_formpricing[1]['value'];
											
										}elseif($model_print_mail->person_type == 2){
											
											$type = 'Employee';
											
											//get form pricing
											$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>[19],'type'=>2])->asArray()->all();
											
											$bulk_mail_fee = $model_formpricing[0]['value'];
										}else{
											
											$type='';
											$model_formpricing = '';
											$bulk_mail_fee = '';
											$packaging_shipping_cost = '';
										}
										
												
										$model_globalsettings = TblAcaGlobalSettings::find()->select(['value'])->where(['setting_id'=>[1,5]])->asArray()->all();
										
										$from_email = $model_globalsettings[0]['value'];
										
										$to_email = $model_globalsettings[1]['value'];
										
										$clients_details = TblAcaClients::Clientuniquedetails($check_company_details->client_id);
										$model_brands = TblAcaBrands::Branduniquedetails ( $clients_details->brand_id );
										$brand_emailid=$model_brands->support_email;
										
										
										$print_details = array(
												'company_name'=>$model_print_mail->form->company->company_name,
												'client_name'=>$model_print_mail->form->company->client->client_name,
												'printed_by'=>$model_print_mail->username->first_name.' '.$model_print_mail->username->last_name,
												'print_date'=>$model_print_mail->form->modified_date_print,
												'no_form_print'=>$model_print_mail->no_of_forms,
												'amount'=>$forms_amount,
												'sent_to'=>$type,
												'expedite_fee'=>$model_print_mail->expedite_processing_fee,
												'to'=>$to_email,
												'from'=>$brand_emailid,
												'price_per_form'=>$model_print_mail->price_per_form,
												'bulk_mailing_fee'=>$bulk_mail_fee,
												'packaging_shipping_cost'=>$packaging_shipping_cost
												
										);
										
								$upload_result = $this->uploadpdffiles($filepath,$file_name,$person_type,$print_details);
								
								if(!empty($upload_result['error']))
								{
									throw new \Exception ($upload_result['error']);
								}
								else
								{
									$model_printmail->is_printed = 1;
									$print_output = 'Print & mailed successfully';
								}
								
							}
							else
							{
								throw new \Exception ($filepath);
							}
								
						}
						else {
						
								$model_pdfgeneratesave = new TblAcaPdfGenerate ();
								$model_pdfgeneratesave->form_id = $approved_form->id;
								$model_pdfgeneratesave->status = 0;
								$model_pdfgeneratesave->created_by = $logged_user_id;
								$model_pdfgeneratesave->updated_date = date ( 'Y-m-d H:i:s' );
									
								if ($model_pdfgeneratesave->save () && $model_pdfgeneratesave->validate ()) { // model save
									$model_printmail->is_printed = 0;	
									$print_output = 'Print & Mail is in process, We will notify you when completed.';
								
								} else {
					
									throw new \Exception ('Error occured while generating pdf for print and mail');
								}
							}
							
							
						
						if($model_printmail->save()){
							
						$model_acaforms= TblAcaForms::find()->where(['id'=>$approved_form->id])->one();
						$model_acaforms->modified_date_print = date('Y-m-d H:i:s');
						$model_acaforms->save();
									
						$transaction->commit();
						$output['success']= $print_output;
						
						}
						
						
							
						
						
						
					}else{
						
						throw new \Exception ('Error occured while saving');
					}
				}else{
						
						throw new \Exception ('Error occured while saving');
					}
			
			} catch ( \Exception $e ) { // any \Exceptions catch throws error msg
			//print_r($e);die();
			
				$msg = $e->getMessage ();
				
				$output['error'] = $msg;
					
				$transaction->rollback (); // if \Exception occurs transaction rollbacks
			}
			
			
			}else
			{
				
				$output['error'] = 'Print & mail for this form is already in progress.';
			}
			
			
			
			}else
		{
			
			$output['error'] = 'Please approve any one form to Print and mail';
		}
		}else
		{
			
			$output['error'] = 'Invalid Company';
		}
		
		
		
		
			return json_encode($output);
			
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // session expires then logouts
		
			return $this->goHome ();
		}
	}
	
	
	/*
	 * action used for uploading files to different sftp server
	 */
	private function Uploadpdffiles($filepath,$file_name,$person_type,$print_details)
	{
		$arrerror = array();
		$result = array();
		  /********Server SFTP credentials************/
		  $ftp_username = \Yii::$app->params['ftpUserName'];
		  $ftp_userpass = \Yii::$app->params['ftpUserPassword'];
		  $ftp_server = \Yii::$app->params['ftpServer'];
		  
		  
		 $arrerror ['error_desc'] = 'Could not connect to $ftp_server';
		 $arrerror ['error_type'] = 4; 
			
		  /********Creating connections************/
		  $ftp_conn = ftp_connect($ftp_server,21) or $this->Saveerrors ( $arrerror );
		  $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
		  
		  
		   /********File location************/
		  $file = $filepath;
		  
		  ftp_pasv($ftp_conn, true);
		  
		  //person type
		  if($person_type == 1)
		  {
			  $pdf_path = 'employer/NOM_'.$file_name;
		  }
		  elseif($person_type == 2)
		  {
			   $pdf_path = 'employee/'.$file_name;
		  }
		  
		  // upload file
		  if (ftp_put($ftp_conn, $pdf_path, $file, FTP_BINARY))
		  {
			   \Yii::$app->CustomMail->Printandmail ( $print_details['to'], $print_details['from'], $print_details);
			   
		   $result['success'] = "Successfully uploaded $file.";
		  }
		  else
		  {
		  $result['error'] =  "Error uploading $file.";
		  }
		
		
		return $result;
		
	}
	
	
	/*
	 * action used for details in modal
	 */
	public function actionPrintandmaildetails(){
	
		if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
	
			$session = \Yii::$app->session; // declaring session
			$logged_user_id = $session ['client_user_id'];
			$array_printvalues=array();
			$encrypt_component = new EncryptDecryptComponent ();
			$label = '';
			$post_values = \yii::$app->request->post (); // getting post values
			
			if(!empty($post_values['company_id']) && !empty($post_values['form_id']))
			{
			$encrypt_company_id = $post_values['company_id'];
			$encrypt_form_id = $post_values['form_id'];
			$company_id = $encrypt_component->decryptUser ( $encrypt_company_id );
			$form_id = $encrypt_component->decryptUser ( $encrypt_form_id );
			
			
			//check if form exists
			$approved_form = TblAcaForms::find()->select('id')->where(['company_id'=>$company_id,'id'=>$form_id])->One();
			if(!empty($approved_form))
			{
			
			//check if one print is already in progress
			$check_print = TblAcaPrintAndMail::find()->select('print_id')->where(['form_id'=>$form_id,'is_printed'=>0])->One();
			if(empty($check_print))
			{
			$model_company_user = TblAcaCompanyUsers::find()->select('first_name, last_name')->where(['user_id'=>$logged_user_id])->one();
			$model_1095c_ssn = TblAca1095::find ()->select('ssn')->where(['form_id'=>$approved_form->id])->count();
			
			
			
			
				if(!empty($model_company_user)){
					
				$arrtotvalues = $this->Getpricevalues(1 ,$model_1095c_ssn);
				
				$package_model = TblAcaFormPricing::find()->select('value')->where(['price_id'=>9])->one();
				$model_globalsettings = TblAcaGlobalSettings::find()->select('value')->where(['setting_id'=>6])->one();
				
				if(!empty($model_globalsettings->value)){
					$label = $model_globalsettings->value;
				}
				$package_cost = $package_model->value;
				$price_value=$arrtotvalues['price_value'];
				$expedite_value = $arrtotvalues['expedite_value'];
			
			
				$name = $model_company_user->first_name.' '.$model_company_user->last_name;
				$count = $model_1095c_ssn;
				$total_fees = ($count*$price_value)+ $package_cost + $expedite_value;
				$array_values = array (
						'name'=>$name,
						'value'=>$price_value,
						'count'=>$count,
						'label'=>$label,
						'expedite_value'=>$expedite_value,
						'total_fees'=>$total_fees,
						'package_cost'=>$package_cost
				);
				$array_values=json_encode($array_values);
				$array_printvalues['success']=$array_values;
				
				}else{
					$array_printvalues['error']='Company user does not exists';
				}
				
				}else{
				$array_printvalues['error']='Print & mail for this form is already in progress.';
			}
			}else{
				$array_printvalues['error']='Form does not exists';
			}
		}
		else{
				$array_printvalues['error']='No post values';
			}
			
			
	   return json_encode($array_printvalues);
		} else {
			\Yii::$app->SessionCheck->clientlogout (); // session expires then logouts
	
			return $this->goHome ();
		}
	
	}
	/**
	 * Function is used to create forms.
	 * Particular function is triggered by cron
	 */
	final function actionCreateforms() {
		
		
		ini_set ( 'memory_limit', '1024M' );
		ini_set ( 'max_execution_time', 3600 );
		ini_set ( 'max_input_time', 3600 );
			
		// Declaring variables
		$arrerror = array ();
		$error_type = '';
		
		// Initializing models
		$forms = new TblGenerateForms ();
		$newform = new TblAcaForms ();
		
		// Query to get all companies for which cron status is 0 and ready for form generation
		$query = new Query ();
		$query->select ( [ 
				'id',
				'version',
				'company_id',
				'created_by' 
		] )->from ( 'tbl_generate_forms' )->where ( 'cron_status=0' );
		$command = $query->createCommand ();
		$all_companies = $command->queryAll ();
			
		if (! empty ( $all_companies )) 		// If companies
		{
			foreach ( $all_companies as $company ) {
				
				/**
				 * transaction block for the sql transactions to the database
				 */
				
				$connection = \yii::$app->db;
				$post = TblGenerateForms::updateAll ( [
						'cron_status' => 1,
						'updated_date' => date ( 'Y-m-d H:i:s' )
						], 'id =' . $company ['id'] ); // making status to running/pending
				// starting the transaction
				$transaction = $connection->beginTransaction ();
				
			
				
				$newform->id = '';
				$newform->isNewRecord = true;
				$newform->generate_form_id = $company['id'];
				$newform->version = $company ['version'];
				$newform->company_id = $company ['company_id'];
				$newform->created_by = $company ['created_by'];
				
				// try block
				try {
					if ($newform->validate () && $newform->save ()) {
						
						$last_id = $newform->id;
						
						/**
						 * *
						 * Below function creates 1094 forms
						 * $company_id INT
						 * $last_id INT
						 * $created_by INT
						 */
						$resp1094 = self::actionCreate1094 ( $company ['company_id'], $last_id, $company ['created_by'] );
						
						// Check if response has errors
						if (! empty ( $resp1094 ['error'] )) {
							// throws errors as exceptions
							$error_type = '1';
							$company_id=$company ['company_id'];
							throw new \Exception ( $resp1094 ['error'] );
						}
						
						/**
						 * *
						 * Below function creates 1095 forms
						 * $company_id INT
						 * $last_id INT
						 * $created_by INT
						 */
						$resp1095 = self::actionCreate1095forms ( $company ['company_id'], $last_id, $company ['created_by'] );
						if (! empty ( $resp1095 ['error'] )) {
							// throws errors as exceptions
							$error_type = '2';
							$company_id=$company ['company_id'];
							throw new \Exception ( $resp1095 ['error'] );
						}
						
						// Check for no errors in 1094 and 1095
						if (! empty ( $resp1094 ['success'] ) && ! empty ( $resp1095 ['success'] )) {
							$post = TblGenerateForms::updateAll ( [ 
									'cron_status' => 2,
									'updated_date' => date ( 'Y-m-d H:i:s' ) 
							], 'id =' . $company ['id'] ); // making status to completed
							
							
							$model_companystatus = TblAcaCompanies::find()->where(['company_id'=>$company ['company_id']])->one();
							
							$model_lookupid = TblAcaLookupOptions::find()->select('lookup_id')->where(['lookup_value'=>'Forms Creation Complete','code_id'=>6])->one();
							
							if(!empty($model_lookupid)){
							$model_companystatus->reporting_status = $model_lookupid->lookup_id; //92 in armor dev
							$model_companystatus->save();
							}
						
						}
						// commiting the model
						$transaction->commit ();
					}
				} catch ( \Exception $e ) {
					
					$msg = $e->getMessage ();
					
					$arrerror ['error_desc'] = $msg;
					$arrerror ['error_type'] = $error_type;
					
					if(!empty($company_id)){
						$arrerror ['company_id'] = $company ['company_id'];
					}
					$transaction->rollback ();
				
					// Below function saves exceptions if occurs
					$this->Saveerrors ( $arrerror );
					
					
				}
			}
		}
	}
	
	/**
	 * *
	 * Below function creates 1094 forms
	 * $company_id INT
	 * $last_id INT
	 * $created_by INT
	 */
	private function actionCreate1094($company_id, $form_id, $created_by) {
		
		
		ini_set ( 'memory_limit', '1024M' );
		ini_set ( 'max_execution_time', 3600 );
		ini_set ( 'max_input_time', 3600 );
			
		$part1 = array ();
		$part2 = array ();
		$part3 = array ();
		$part4 = array ();
		$form_data = array ();
		$result = array ();
		$xml_data=array();
		
		$arr_individual_months_count = array ();
		
		/*
		 * start fill data from basic information table i.e for fields 1 to 8
		 */
		$connection = \yii::$app->db;
		
		// starting the transaction
		$transaction = $connection->beginTransaction ();
		// try block
		try {
			$query = new Query ();
			$query->select ( [ 
					'tc.company_name',
					'tbi.contact_first_name',
					'tbi.contact_middle_name',
					'tbi.contact_last_name',
					'tbi.contact_person_suffix',
					'tbi.contact_person_title',
					'tbi.contact_phone_number',
					'tc.company_ein',
					'tbi.street_address_1',
					'tbi.street_address_2',
					'tbi.contact_state',
					'tbi.contact_city',
					'tbi.contact_country',
					'tbi.contact_zip' 
			] )->from ( 'tbl_aca_basic_information tbi' )->join ( 'INNER JOIN', 'tbl_aca_companies tc', 'tc.company_id = tbi.company_id' )->where ( 'tc.company_id=' . $company_id );
			
			$command = $query->createCommand ();
			$employe_details = $command->queryOne ();
			
			if (! empty ( $employe_details )) {
				$part1 ['name_of_ale_member_1_I'] = $employe_details ['company_name'];
				
				$suffix ='';
				$model_lookupvalue = TblAcaLookupOptions::find()->select('lookup_value')->where(['lookup_id'=>$employe_details ['contact_person_suffix'],'code_id'=>7])->one();
				if(!empty($model_lookupvalue)){
					$suffix =$model_lookupvalue->lookup_value;
				}
				
				$part1 ['name_of_the_person_contact_I'] = $employe_details ['contact_first_name'] . ' ' . $employe_details ['contact_middle_name'] . ' ' . $employe_details ['contact_last_name'] . ' ' .  $suffix;
				$part1 ['employer_identification_number_I'] = $employe_details ['company_ein'];
				$part1 ['street_address_1_I'] = $employe_details ['street_address_1'] . ' ' . $employe_details ['street_address_2'];
				$part1 ['contact_telephone_number_I'] = $employe_details ['contact_phone_number'];
			
				
				$xml_data['street_address_1__3'] = $employe_details ['street_address_1'];
				$xml_data['street_address_2__3'] = $employe_details ['street_address_2'];
				
				$xml_data['first_name__7'] = $employe_details ['contact_first_name'];
				$xml_data['last_name__7'] = $employe_details ['contact_last_name'];
				$xml_data['middle_name__7'] = $employe_details ['contact_middle_name'];
				$xml_data['suffix__7'] = $suffix;
				
				
				if($employe_details ['contact_country'] == 'US'){
					$city = $employe_details ['contact_city'];
					$city_name = TblCityStatesUnitedStates::find()->select('city')->where(['LocationId' => $city])->One();
					
					$part1 ['city_or_town_I'] = $city_name->city;
					
				}
				else
				{
					$part1 ['city_or_town_I'] = $employe_details ['contact_city'];
				}
				
				$part1 ['state_or_province_I'] = $employe_details ['contact_state'];
				$part1 ['country_and_zip_I'] = $employe_details ['contact_zip'];
			}
			
			/*
			 * end to fill data from basic information table i.e for fields 1 to 8
			 */
		
		
		/*
		 * fill data  from tbl_aca_designated_govt_entity table i.e for fields 9 to 16
		*/
		$query1 = new Query ();
			$query1->select ( [ 
					'assign_dge',
					'dge_ein',
					'street_address_1',
					'street_address_2',
					'dge_city',
					'dge_name',
					'dge_state',
					'dge_zip',
					'dge_contact_first_name',
					'dge_contact_middle_name',
					'dge_contact_last_name',
					'dge_contact_suffix',
					'dge_contact_phone_number' 
			]
			 )->from ( 'tbl_aca_designated_govt_entity' )->where ( 'assign_dge=1 AND company_id=' . $company_id );
			
			$command = $query1->createCommand ();
			$dge_details = $command->queryOne ();
			
			if (! empty ( $dge_details )) {
				$part1 ['name_of_designated_government_entity_I'] = $dge_details ['dge_name'];
				$part1 ['employer_identification_number_2_I'] = $dge_details ['dge_ein'];
				$part1 ['state_or_province_2_I'] = $dge_details ['dge_state'];
				$part1 ['street_Address_2_I'] = $dge_details ['street_address_1'] . ' ' . $dge_details ['street_address_2'];
    //	$city = $dge_details->dge_city;
					$city_name = TblCityStatesUnitedStates::find()->select('city')->where(['LocationId' => $dge_details ['dge_city']])->One();
				if(!empty($city_name->city)){
					$part1 ['city_or_town_2_I'] = $city_name->city;
				}else{
					$part1 ['city_or_town_2_I'] = '';
				}
			//	$part1 ['city_or_town_2_I'] = $dge_details ['dge_city'];
				$part1 ['country_and_zip_2_I'] = $dge_details ['dge_zip'];

				$suffix ='';
				$model_lookupvalue = TblAcaLookupOptions::find()->select('lookup_value')->where(['lookup_id'=>$dge_details ['dge_contact_suffix'],'code_id'=>7])->one();
				if(!empty($model_lookupvalue)){
					$suffix =$model_lookupvalue->lookup_value;
				}
				
				$part1 ['name_of_person_to_contact_2_I'] = $dge_details ['dge_contact_first_name'] . ' ' . $dge_details ['dge_contact_middle_name'] . ' ' . $dge_details ['dge_contact_last_name'] . ' ' .$suffix ;
				$part1 ['contact_telephone_number_2_I'] = $dge_details ['dge_contact_phone_number'];
				
				$xml_data['street_address_1__11'] = $dge_details ['street_address_1'];
				$xml_data['street_address_2__11'] = $dge_details ['street_address_2'];
				
				$xml_data['first_name__15'] = $dge_details ['dge_contact_first_name'];
				$xml_data['last_name__15'] = $dge_details ['dge_contact_last_name'];
				$xml_data['middle_name__15'] = $dge_details ['dge_contact_middle_name'];
				$xml_data['suffix__15'] = $suffix;
				
			}
			
			/*
			 * end to fill data from tbl_aca_designated_govt_entity table i.e for fields 9 to 16
			 */
		
		
		
		/*
		 * fill data for field 18 Total number of Forms 1095-C submitted with this transmittal
		*/
		
		$result_unique_employees = self::actionGetresponsiblessn ( $company_id );
		//print_r($result_unique_employees); die();
			if (! empty ( $result_unique_employees ['error'] )) {
				throw new \Exception ( $result_unique_employees ['error'] );
			} else {
				
				
				$i=0;
				foreach($result_unique_employees ['success'][1] as $key=>$value){
					if (in_array($value, $result_unique_employees ['success'][0])){$i++;}
				}
				
				$forms_count = count($result_unique_employees ['success'][0])+count($result_unique_employees ['success'][1])-$i;
				
				
				
				$part1 ['total_no_of_1095c_submitted_I'] = $forms_count;
				
			}
			/*
			 * end to fill data for field 18 Total number of Forms 1095-C submitted with this transmittal
			 */
			
			
		/*
		 * fill data for field 19 to 22
		*/
			$query2 = new Query ();
			$query2->select ( [ 
					'tag.is_authoritative_transmittal',
					'tag.is_ale_member',
					'tag.total_1095_forms',
					'tpc.plan_offering_criteria_type',
					'tpi.renewal_month',
					'tpc.company_certification_workforce',
					'tpc.company_certification_medical_eligibility',
					'tpc.company_certification_employer_contribution',
					'tag.total_aggregated_grp_months' 
			] )->from ( 'tbl_aca_aggregated_group tag' )->join ( 'INNER JOIN', 'tbl_aca_plan_criteria tpc', 'tpc.company_id = tag.company_id' )->join ( 'INNER JOIN', 'tbl_aca_general_plan_info tpi', 'tpc.company_id = tpi.company_id' )->where ( 'tag.is_authoritative_transmittal=1 AND tag.company_id=' . $company_id );
			
			$command = $query2->createCommand ();
			$plan_details = $command->queryOne ();
			
			if (! empty ( $plan_details )) {
				
				$part1 ['is_this_authoritative_I'] = $plan_details ['is_authoritative_transmittal'];
				
				if ($plan_details ['total_1095_forms'] != '') {
					$part2 ['total_no_of_1095c_filled_II'] = $part1 ['total_no_of_1095c_submitted_I'] + $plan_details ['total_1095_forms'];
				} else {
					$part2 ['total_no_of_1095c_filled_II'] = $part1 ['total_no_of_1095c_submitted_I'];
				}
				
				if ($plan_details ['is_ale_member'] == 1) {
					$part2 ['is_ale_member_yes_II'] = 1;
					$part2 ['is_ale_member_no_II'] = 0;
				} else {
					
					$part2 ['is_ale_member_no_II'] = 1;
					$part2 ['is_ale_member_yes_II'] = 0;
				}
				
				if (in_array("1", (explode(",",$plan_details ['plan_offering_criteria_type'])))) {
					$part2 ['quality_offer_method_II'] = 1;
				}
				
				if ($plan_details ['renewal_month'] != 1 
				&& $plan_details ['company_certification_workforce'] == 1 
				&& $plan_details ['company_certification_medical_eligibility'] == 1 
				&& $plan_details ['company_certification_employer_contribution'] == 1) {
					$part2 ['section_4980_transition_II'] = 1;
				} else {
					$part2 ['section_4980_transition_II'] = 0;
				}
				
				if (in_array("1", (explode(",",$plan_details ['plan_offering_criteria_type'])))) {
					$part2 ['offer_method_II'] = 1;
				}
				
				if (! empty ( $employe_details )) {
					//$part2 ['title_II'] = $employe_details ['contact_person_title'];
					$part2 ['title_II'] = '';
				}
			}
			
			/*
			 * end to fill data for field 19 to 22
			 */
			
			
			
		/*
		 * start block for fields 23 to 35
		 */	
			

			$query = new Query ();
			$query->select ( [ 
					'mec_months' 
			] )->from ( 'tbl_aca_mec_coverage' )->where ( 'company_id=' . $company_id );
			$command = $query->createCommand ();
			$arr_mec_details = $command->queryOne ();
			
			if (! empty ( $arr_mec_details )) {
				
				/**
				 * fill fields from 24(a) to 34(a)
				 */
				 
				 
				
				 if(isset($arr_mec_details ['mec_months']) && $arr_mec_details ['mec_months'] !='')
				 {
					if ($arr_mec_details ['mec_months'] == 0) {
						$part3 ['minimal_essential_coverage_all_yes_III'] = 1;
					} else {
						
						$array_months = explode(',',$arr_mec_details ['mec_months']);
						// for january check
						if (in_array ( '1', $array_months, TRUE ) || $arr_mec_details ['mec_months'] == 1) {
							$part3 ['minimal_essential_coverage_jan_yes_III'] = 1;
						} else {
							$part3 ['minimal_essential_coverage_jan_no_III'] = 1;
						}
						
						// for febuary check
						if (in_array ( '2', $array_months, TRUE )  || $arr_mec_details ['mec_months'] == 2) {
							$part3 ['minimal_essential_coverage_feb_yes_III'] = 1;
						} else {
							$part3 ['minimal_essential_coverage_feb_no_III'] = 1;
						}
						
						// for march check
						if (in_array ( '3', $array_months, TRUE )  || $arr_mec_details ['mec_months'] == 3) {
							$part3 ['minimal_essential_coverage_mar_yes_III'] = 1;
						} else {
							$part3 ['minimal_essential_coverage_mar_no_III'] = 1;
						}
						
						// for april check
						if (in_array ( '4', $array_months, TRUE )  || $arr_mec_details ['mec_months'] == 4) {
							$part3 ['minimal_essential_coverage_apr_yes_III'] = 1;
						} else {
							$part3 ['minimal_essential_coverage_apr_no_III'] = 1;
						}
						
						// for may check
						if (in_array ( '5', $array_months, TRUE )  || $arr_mec_details ['mec_months'] == 5) {
							$part3 ['minimal_essential_coverage_may_yes_III'] = 1;
						} else {
							$part3 ['minimal_essential_coverage_may_no_III'] = 1;
						}
						
						// for june check
						if (in_array ( '6', $array_months, TRUE )  || $arr_mec_details ['mec_months'] == 6) {
							$part3 ['minimal_essential_coverage_june_yes_III'] = 1;
						} else {
							$part3 ['minimal_essential_coverage_june_no_III'] = 1;
						}
						
						// for july check
						if (in_array ( '7', $array_months, TRUE )  || $arr_mec_details ['mec_months'] == 7) {
							$part3 ['minimal_essential_coverage_july_yes_III'] = 1;
						} else {
							$part3 ['minimal_essential_coverage_july_no_III'] = 1;
						}
						
						// for august check
						if (in_array ( '8', $array_months, TRUE )  || $arr_mec_details ['mec_months'] == 8) {
							$part3 ['minimal_essential_coverage_aug_yes_III'] = 1;
						} else {
							$part3 ['minimal_essential_coverage_aug_no_III'] = 1;
						}
						
						// for sep check
						if (in_array ( '9', $array_months, TRUE )  || $arr_mec_details ['mec_months'] == 9) {
							$part3 ['minimal_essential_coverage_sept_yes_III'] = 1;
						} else {
							$part3 ['minimal_essential_coverage_sept_no_III'] = 1;
						}
						
						// for oct check
						if (in_array ( '10', $array_months, TRUE )  || $arr_mec_details ['mec_months'] == 10) {
							$part3 ['minimal_essential_coverage_oct_yes_III'] = 1;
						} else {
							$part3 ['minimal_essential_coverage_oct_no_III'] = 1;
						}
						
						// for nov check
						if (in_array ( '11', $array_months, TRUE )  || $arr_mec_details ['mec_months'] == 11) {
							$part3 ['minimal_essential_coverage_nov_yes_III'] = 1;
						} else {
							$part3 ['minimal_essential_coverage_nov_no_III'] = 1;
						}
						
						// for dec check
						if (in_array ( '12', $array_months, TRUE )  || $arr_mec_details ['mec_months'] == 12) {
							$part3 ['minimal_essential_coverage_dec_yes_III'] = 1;
						} else {
							$part3 ['minimal_essential_coverage_dec_no_III'] = 1;
						}
					
						
					}
				
				
				 }
				 else
				 {
					 $part3 ['minimal_essential_coverage_all_no_III'] = 1;
				 }
				
				
			
			}else{
				$part3 ['minimal_essential_coverage_all_no_III'] = 1;
			}
			
			/**
			 * end fill fields from 24(a) to 35(a)
			 */
			 
			 
			/*
			 * start fields for 23(b,c) to 35(b,c)
			 */
			
			
				
			$arr_individual_months_count = self::actionCountdetails ( $company_id, 0 );
				
				//create check array
				$count_4980 = 0;
				$count_employee = 1;
				$arr_section4980 = array();
				$arr_employee_count = array();
				
				for($k=0;$k<=11;$k++)
				{
					
					$arr_section4980[] = $arr_individual_months_count[$k][$count_4980];
					$arr_employee_count[]  = $arr_individual_months_count[$k][$count_employee];
					
				}
				
					if (count ( array_unique ( $arr_section4980 ) ) == 1)
					{
						
					$part3 ['section_4980h_fulltime_employee_count_all_III'] = $arr_section4980[0];
					
						
					}else 
					{
						
						$part3 ['section_4980h_fulltime_employee_count_jan_III'] = $arr_individual_months_count [0][0];
						$part3 ['section_4980h_fulltime_employee_count_feb_III'] = $arr_individual_months_count [1][0];
						$part3 ['section_4980h_fulltime_employee_count_mar_III'] = $arr_individual_months_count [2][0];
						$part3 ['section_4980h_fulltime_employee_count_apr_III'] = $arr_individual_months_count [3] [0];
						$part3 ['section_4980h_fulltime_employee_count_may_III'] = $arr_individual_months_count [4] [0];
						$part3 ['section_4980h_fulltime_employee_count_june_III'] = $arr_individual_months_count [5] [0];
						$part3 ['section_4980h_fulltime_employee_count_july_III'] = $arr_individual_months_count [6] [0];
						$part3 ['section_4980h_fulltime_employee_count_aug_III'] = $arr_individual_months_count [7] [0];
						$part3 ['section_4980h_fulltime_employee_count_sept_III'] = $arr_individual_months_count [8] [0];
						$part3 ['section_4980h_fulltime_employee_count_oct_III'] = $arr_individual_months_count [9] [0];
						$part3 ['section_4980h_fulltime_employee_count_nov_III'] = $arr_individual_months_count [10] [0];
						$part3 ['section_4980h_fulltime_employee_count_dec_III'] = $arr_individual_months_count [11] [0];
						
						
					}
					
					
					if (count ( array_unique ( $arr_employee_count ) ) == 1)
					{
						$part3 ['total_employee_count_all_III'] = $arr_employee_count[0];
						
					}
					else 
					{
						$part3 ['total_employee_count_jan_III'] = $arr_individual_months_count [0][1];
						$part3 ['total_employee_count_feb_III'] = $arr_individual_months_count [1][1];
						$part3 ['total_employee_count_mar_III'] = $arr_individual_months_count [2][1];
						$part3 ['total_employee_count_apr_III'] = $arr_individual_months_count [3][1];
						$part3 ['total_employee_count_may_III'] = $arr_individual_months_count [4][1];
						$part3 ['total_employee_count_june_III'] = $arr_individual_months_count [5][1];
						$part3 ['total_employee_count_july_III'] = $arr_individual_months_count [6][1];
						$part3 ['total_employee_count_aug_III'] = $arr_individual_months_count [7][1];
						$part3 ['total_employee_count_sept_III'] = $arr_individual_months_count [8][1];
						$part3 ['total_employee_count_oct_III'] = $arr_individual_months_count [9][1];
						$part3 ['total_employee_count_nov_III'] = $arr_individual_months_count [10][1];
						$part3 ['total_employee_count_dec_III'] = $arr_individual_months_count [11][1];
						
						
					}
					
						 
					
			
			
			/*
			 * end fields for 23(b,c) to 35(b,c)
			 */
			
			if (! empty ( $plan_details )) {
				



				/**
				 * fill fields from 24(d) to 34(d)
				 */
				if ($plan_details ['total_aggregated_grp_months'] == '0') {
				
					$part3 ['aggregate_group_all_III'] = 1;
				
				} else {
						
					$array_total_aggregated_grp_months = explode(',',$plan_details ['total_aggregated_grp_months']);
					// for january check
					if (in_array ( '1', $array_total_aggregated_grp_months, TRUE ) || $plan_details ['total_aggregated_grp_months'] == 1) {
						$part3 ['aggregate_group_jan_III'] = 1;
					}
						
					// for febuary check
					if (in_array ( '2', $array_total_aggregated_grp_months, TRUE ) || $plan_details ['total_aggregated_grp_months'] == 2) {
						$part3 ['aggregate_group_feb_III'] = 1;
					}
						
					// for march check
					if (in_array ( '3', $array_total_aggregated_grp_months, TRUE ) || $plan_details ['total_aggregated_grp_months'] == 3) {
						$part3 ['aggregate_group_mar_III'] = 1;
					}
						
					// for april check
					if (in_array ( '4', $array_total_aggregated_grp_months, TRUE ) || $plan_details ['total_aggregated_grp_months'] == 4) {
						$part3 ['aggregate_group_apr_III'] = 1;
					}
						
					// for may check
					if (in_array ( '5', $array_total_aggregated_grp_months, TRUE ) || $plan_details ['total_aggregated_grp_months'] == 5) {
						$part3 ['aggregate_group_may_III'] = 1;
					}
						
					// for june check
					if (in_array ( '6', $array_total_aggregated_grp_months, TRUE ) || $plan_details ['total_aggregated_grp_months'] == 6) {
						$part3 ['aggregate_group_june_III'] = 1;
					}
						
					// for july check
					if (in_array ( '7', $array_total_aggregated_grp_months, TRUE ) || $plan_details ['total_aggregated_grp_months'] == 7) {
						$part3 ['aggregate_group_july_III'] = 1;
					}
						
					// for august check
					if (in_array ( '8', $array_total_aggregated_grp_months, TRUE ) || $plan_details ['total_aggregated_grp_months'] == 8) {
						$part3 ['aggregate_group_aug_III'] = 1;
					}
						
					// for sep check
					if (in_array ( '9', $array_total_aggregated_grp_months, TRUE ) || $plan_details ['total_aggregated_grp_months'] == 9) {
						$part3 ['aggregate_group_sept_III'] = 1;
					}
						
					// for oct check
					if (in_array ( '10', $array_total_aggregated_grp_months, TRUE ) || $plan_details ['total_aggregated_grp_months'] == 10) {
						$part3 ['aggregate_group_oct_III'] = 1;
					}
						
					// for nov check
					if (in_array ( '11', $array_total_aggregated_grp_months, TRUE ) || $plan_details ['total_aggregated_grp_months'] == 11) {
						$part3 ['aggregate_group_nov_III'] = 1;
					}
						
					// for dec check
					if (in_array ( '12', $array_total_aggregated_grp_months, TRUE ) || $plan_details ['total_aggregated_grp_months'] == 12) {
						$part3 ['aggregate_group_dec_III'] = 1;
					}
				}
				
				
			
			}
			
			/*
			 * end block for fields 23 to 35
			 */
		
		
		/*
		 * fill data for part IV i.e fields from 36 to end
		*/
			if (! empty ( $part2 ) && $part2 ['is_ale_member_yes_II'] == 1) {
				
				$query = new Query ();
				$query->select ( [ 
						'tagl.group_name',
						'tagl.group_ein' 
				] )->from ( 'tbl_aca_aggregated_group tag' )->join ( 'INNER JOIN', 'tbl_aca_aggregated_group_list tagl', 'tagl.aggregated_grp_id = tag.aggregated_grp_id' )->where ( 'tag.is_authoritative_transmittal=1 AND tag.company_id=' . $company_id );
				$command = $query->createCommand ();
				$arr_agg_list_details = $command->queryAll ();
				
				if (! empty ( $arr_agg_list_details )) {
					
					$i = 36;
					foreach ( $arr_agg_list_details as $arr_agg_list_detail ) {
						if ($i < 66) {
							$part4 ['name_IV_' . $i] = $arr_agg_list_detail ['group_name'];
							$part4 ['ein_IV_' . $i] = $arr_agg_list_detail ['group_ein'];
							$i ++;
						}
					}
				}
			}
			
			/*
			 * end fill data for field 36 to end
			 */
			
			
			
			/**
			 * transaction block for the sql transactions to the database
			 */
			
			$new1094form = new TblAca1094 ();
			
			$new1094form->form_id = $form_id;
			$new1094form->serialise_data1 = serialize ( json_encode ( $part1 ) );
			$new1094form->serialise_data2 = serialize ( json_encode ( $part2 ) );
			$new1094form->serialise_data3 = serialize ( json_encode ( $part3 ) );
			$new1094form->serialise_data4 = serialize ( json_encode ( $part4 ) );
			$new1094form->xml_data = serialize ( json_encode ( $xml_data ) );
			$new1094form->created_by = $created_by;
			
			if ($new1094form->validate () && $new1094form->save ()) {
				
				// commiting the model
				$transaction->commit ();
				// print_r($new1094form); die();
				$result ['success'] = 'success';
			} else {
				$arrerrors = $new1094form->getFirstErrors ();
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
			
			
			$result ['error'] = $e->getMessage ().' at line no '.$e->getLine();
			
			$transaction->rollback ();
			
			
		}
		
	
		
		return $result;
	}
	/***
	*Function is used for getting month count
	**/
	private function actionCountdetails($company_id, $months) {
		$arr_month_details = array ();
		
		for($i = 1; $i < 13; $i ++) {
			${'alemonthcount_' . $i} = 0;
			${'allemployeemonthcount_' . $i} = 0;
			
		}
		
		$arr_months = array ();
		
		if (rtrim ( $months, ',' ) == 0) {
			for($i = 1; $i <= 12; $i ++) {
				$arr_months [] = $i;
			}
		} else {
			$arr_months = explode ( ',', rtrim ( $months, ',' ) );
		}
		
		/**
		 * ***Get a list of all unique employee details*******
		 */
		$arr_get_all_unique_payroll_employee = TblAcaPayrollData::find ()->select ( 'employee_id,ssn' )->where ( [ 
				'company_id' => $company_id 
		] )->groupBy ( 'ssn' )->all ();
		
		/**
		 * *****Get reporting year********
		 */
		$reporting_year_id = TblAcaCompanyReportingPeriod::find ()->select ( 'reporting_year' )->where ( [ 
				'company_id' => $company_id 
		] )->One ();
		
		if (! empty ( $reporting_year_id )) {
			$reporting_year = $reporting_year_id->year->lookup_value;
		}
		
		if (! empty ( $arr_get_all_unique_payroll_employee )) {
			/**
			 * *****Get unique employee count********
			 */
			
			foreach ( $arr_get_all_unique_payroll_employee as $employee ) {
				/**
				 * ***Get all the employment period for the particular employee*****
				 */
				$employment_periods = $employee->tblAcaPayrollEmploymentPeriods;
				
				if (! empty ( $employment_periods )) {
					
					for($i = 1; $i < 13; $i ++) {
						${'temp_alemonthcount_' . $i} = false;
						${'temp_allemployeemonthcount_' . $i} = false;
					}
					
					foreach ( $employment_periods as $periods ) {
						$temptermdate = '';
						$eligible_date = '';
						$maxtermdate = '';
						
						/**
						 * *****Check for employment_period where termination_date == '' or termination_date Year == reporting_year
						 *
						 * **********
						 */
						
						$medical_plan_class = $periods->planClass;
						if (! empty ( $medical_plan_class )) {
							if (empty ( $periods->termination_date ) || (date ( 'Y', strtotime ( $periods->termination_date ) ) == $reporting_year)) {
								if (! empty ( $arr_months )) {
									// loop for months
									foreach ( $arr_months as $each_month ) {
										
										$days = '';
										$first_time_jan = false;
										$days = cal_days_in_month ( CAL_GREGORIAN, $each_month, $reporting_year );
										
										$end_of_month = $reporting_year . '-' . $each_month . '-' . $days;
										
										if (empty ( $periods->termination_date )) {
											$temptermdate = $reporting_year . '-12-31'; // Y-m-d
										} else {
											// check whether 9.4 is selected or not
											if ($medical_plan_class->employee_medical_plan == 1) {
												
												// place eod date of month
												$days = '';
												$days = cal_days_in_month ( CAL_GREGORIAN, date ( 'm', strtotime ( $periods->termination_date ) ), $reporting_year );
												$temptermdate = date ( 'Y-m-' . $days, strtotime ( $periods->termination_date ) );
											} else {
												$temptermdate = $periods->termination_date;
											}
										}
										
										if ((strtotime ( $periods->hire_date ) <= strtotime ( $end_of_month )) && (strtotime ( $temptermdate ) >= strtotime ( $end_of_month ))) {
											
											if (! ${'temp_allemployeemonthcount_' . $each_month}) {
												${'temp_allemployeemonthcount_' . $each_month} = true;
												${'allemployeemonthcount_' . $each_month} ++;
											}
											
											
											
											if ($periods->status == 1) {
												
												if (! ${'temp_alemonthcount_' . $each_month}) {
													${'temp_alemonthcount_' . $each_month} = true;
													${'alemonthcount_' . $each_month} ++;
												}
												// $alemonthcount++;
											}
										}
									}
								}
							} // end loop month
						}
					}
				}
			}
			// echo $alemonthcount_1; die();
		}
		
		for($i = 1; $i < 13; $i ++) {
			$arr_new = array ();
			array_push ( $arr_new, ${'allemployeemonthcount_' . $i} );
			array_push ( $arr_new, ${'alemonthcount_' . $i} );
			array_push ( $arr_month_details, $arr_new );
		}
		
		return $arr_month_details;
	}
	
	/**
	 * this function is used to calculate the responsible person for group1 and group2
	 *
	 * @param number $company_id        	
	 */
	private function actionGetresponsiblessn($company_id) {
		/**
		 * Declare variables*
		 */
		$arr_get_all_unique_payroll_employee = array ();
		$arr_responsible_person = array ();
		$arr_group1 = array ();
		$result = array ();
		$arr_group2 = array ();
		$unique_employee_count = 0;
		$emp_pay_period_result = 0;
		$employment_periods = '';
		$reporting_year = '';
		$reporting_year_id = '';
		
		/*
		 * group 1 calculation
		 */
		try {
			/**
			 * ***Get a list of all unique employee details*******
			 */
			$arr_get_all_unique_payroll_employee = TblAcaPayrollData::find ()->select ( 'employee_id,ssn' )->where ( [ 
					'company_id' => $company_id 
			] )->groupBy ( 'ssn' )->all ();
			
			/**
			 * *****Get reporting year********
			 */
			$reporting_year_id = TblAcaCompanyReportingPeriod::find ()->select ( 'reporting_year' )->where ( [ 
					'company_id' => $company_id 
			] )->One ();
			
			if (! empty ( $reporting_year_id )) {
				$reporting_year = $reporting_year_id->year->lookup_value;
			}
			
			if (! empty ( $arr_get_all_unique_payroll_employee )) {
				/**
				 * *****Get unique employee count********
				 */
				$unique_employee_count = count ( $unique_employee_count );
				foreach ( $arr_get_all_unique_payroll_employee as $employee ) {
					/**
					 * ***Get all the employment period for the particular employee*****
					 */
					$employment_periods = $employee->tblAcaPayrollEmploymentPeriods;
					
					if (! empty ( $employment_periods )) {
						
						foreach ( $employment_periods as $periods ) {
							$temptermdate = '';
							$eligible_date = '';
							$maxtermdate = '';
							/**
							 * *****Check for employment_period where termination_date == '' or termination_date Year == reporting_year
							 * and status == FT
							 * **********
							 */
							
							if ($periods->status == 1) {
								
								$medical_plan_class = $periods->planClass;
								if (! empty ( $medical_plan_class )) {
									
									// function to get the waiting period value based on $medical_plan_class['plan_type_doh']
										$waiting_period = $medical_plan_class ['plan_type_doh'];
										
									if($periods->waiting_period==1){
											
											$eligible_date = $periods->hire_date;
										}else{
											// function to get the eligibility_date dont apply waiting period
											$eligible_date = self::actionGeteligibiltydate ( $waiting_period, $periods->hire_date );
										}
									
									if (empty ( $periods->termination_date )) {
											$temptermdate = $reporting_year . '-12-31'; // Y-m-d
										} else {
											// check whether 9.4 is selected or not
											if ($medical_plan_class->employee_medical_plan == 1) {
												
												// place eod date of month
												$days = '';
												$days = cal_days_in_month ( CAL_GREGORIAN, date ( 'm', strtotime ( $periods->termination_date ) ), $reporting_year );
												$temptermdate = date ( 'Y-m-' . $days, strtotime ( $periods->termination_date ) );
											} else {
												$temptermdate = $periods->termination_date;
											}
										}
										
										
									 if ((strtotime($eligible_date)<=strtotime($temptermdate) && (date ( 'Y', strtotime ( $temptermdate ) ) == $reporting_year)) ) {
									//if (empty ( $periods->termination_date ) || (date ( 'Y', strtotime ( $periods->termination_date ) ) == $reporting_year)) {
										
										
										
										
										$maxtermdate = $temptermdate;
										$maxtermyear = date ( 'Y', strtotime ( $maxtermdate ) );
										
										if ((strtotime ( $maxtermdate ) >= strtotime ( $eligible_date )) && ($maxtermyear == $reporting_year)) {
											
											array_push ( $arr_group1, $employee->ssn );
											break;
										}
									}
								}
							}
						}
					}
				}
			}
			
			// print_r($arr_responsible_person); die();
			
			/*
			 * group 2 calculation
			 */
			
			// query to get the plan_type=Ã¯Â¿Â½combinationÃ¯Â¿Â½ or plan_type=Ã¯Â¿Â½self insuredÃ¯Â¿Â½.
			$arr_planclass_group2 = TblAcaPlanCoverageType::find ()->select ( 'plan_class_id' )->where ( [ 
					'company_id' => $company_id,
					'plan_offer_type' => [ 
							2,
							5 
					] 
			] )->one ();
			
			if (! empty ( $arr_planclass_group2 )) {
				
				// query to get the person type = Employees or Non-Employees enrolled from enrolment medical data
				$medical_enrollment_data = TblAcaMedicalData::find ()->joinWith ( 'tblAcaMedicalEnrollmentPeriods tep' )->where ( [ 
						'company_id' => $company_id,
						'tep.person_type' => [ 
								84,
								87 
						] 
				] )->all ();
				
				// print_r($medical_enrollment_data); die();
				foreach ( $medical_enrollment_data as $each_data ) {
					foreach ( $each_data ['tblAcaMedicalEnrollmentPeriods'] as $each_period ) {
						if($each_period ['person_type']==84 || $each_period ['person_type']==87){
						$temp_coverage_end_date = '';
						
						if ($each_period ['coverage_end_date']) {
							$temp_coverage_end_date = $each_period ['coverage_end_date'];
						} else {
							$temp_coverage_end_date = $reporting_year . '-12-31';
						}
						// echo $each_period ['coverage_end_date'].'----$temp_coverage_end_date --'.$temp_coverage_end_date.'--$each_period coverage_end_date---'.$each_period ['coverage_end_date'].'-----$reporting_year'.$reporting_year.'<br>';
						if ((strtotime ( $temp_coverage_end_date ) >= strtotime ( $each_period ['coverage_end_date'] )) && (date ( 'Y', strtotime ( $temp_coverage_end_date ) ) == $reporting_year)) {
							array_push ( $arr_group2, $each_data->ssn );
							break;
						}
					}
					}
				//	print_r($arr_group2); 
				}
			}
			
			array_push ( $arr_responsible_person, $arr_group1 );
			array_push ( $arr_responsible_person, $arr_group2 );
			$result ['success'] = $arr_responsible_person;
		} catch ( \Exception $e ) { // catching the exception
			
			$result ['error'] = $e->getMessage ();
		}
		
		return $result;
	}
	
	/**
	 *
	 * @param unknown $waiting_period        	
	 * @param unknown $start_date        	
	 * @return number
	 */
private function actionGeteligibiltydate($waiting_period, $start_date, $value_3_1_1=0, $status=1) {
		
		if($status!=2){
			$value_3_1_1=0;
		}
		
		switch ($waiting_period) {
			case 1 :
				$eligible_date = $start_date;
				$eligible_date = date ( 'Y-m-d', strtotime ( $eligible_date . "+$value_3_1_1 day" ) );
				break;
			case 2 :
				$adddays=29+$value_3_1_1;
				$eligible_date = date ( 'Y-m-d', strtotime ( $start_date . "+$adddays day" ) );
				break;
			case 3 :
				$adddays=59+$value_3_1_1;
				$eligible_date = date ( 'Y-m-d', strtotime ( $start_date . "+$adddays day" ) );
				break;
			case 4 :
				$adddays=89+$value_3_1_1;
				$eligible_date = date ( 'Y-m-d', strtotime ( $start_date . "+$adddays day" ) );
				break;
			case 5 :
				$days = '';
				$temptermdate = '';
				$adddays=$value_3_1_1;
				$temptermdate = date ( 'Y-m-d', strtotime ( $start_date . "+$adddays day" ) );
				
				
				
				$days = cal_days_in_month ( CAL_GREGORIAN, date ( 'm', strtotime ( $temptermdate ) ), date ( 'Y', strtotime ( $temptermdate ) ) );
				
				//$days=1;
				$eligible_date = date ( 'Y-m-'. $days, strtotime ( $temptermdate . "+1 day") );
				
				break;
			case 6 :
				$days = '';
				$temptermdate = '';
				
				$adddays=29+$value_3_1_1;
				$temptermdate = date ( 'Y-m-d', strtotime ( $start_date . "+$adddays day" ) );
								
				$days = cal_days_in_month ( CAL_GREGORIAN, date ( 'm', strtotime ( $temptermdate ) ), date ( 'Y', strtotime ( $temptermdate ) ) );
				$eligible_date = date ( 'Y-m-'. $days , strtotime ( $temptermdate . "+1 day") );
				
				break;
			case 7 :
				$days = '';
				$temptermdate = '';
				
							
				$adddays=59+$value_3_1_1;
				$temptermdate = date ( 'Y-m-d', strtotime ( $start_date . "+$adddays day" ) );
				
				$days = cal_days_in_month ( CAL_GREGORIAN, date ( 'm', strtotime ( $temptermdate ) ), date ( 'Y', strtotime ( $temptermdate ) ) );
				$eligible_date = date ( 'Y-m-d'. $days , strtotime ( $temptermdate . "+1 day") );
				
				break;
			case 8 :
				$days = '';
				$temptermdate = '';
				
				
				
				$adddays=89+$value_3_1_1;
				$temptermdate = date ( 'Y-m-d', strtotime ( $start_date . "+$adddays day" ) );
				
				$days = cal_days_in_month ( CAL_GREGORIAN, date ( 'm', strtotime ( $temptermdate ) ), date ( 'Y', strtotime ( $temptermdate ) ) );
				$eligible_date = date ( 'Y-m-'.$days , strtotime ( $temptermdate . "+1 day") );
				
				break;
			
			default :
				$eligible_date = $start_date;
				break;
		}
		return $eligible_date;
	}
	
	/**
	 * *
	 * Below function creates 1095 forms
	 * $company_id INT
	 * $last_id INT
	 * $created_by INT
	 */
	private function actionCreate1095forms($company_id, $form_id, $created_by) {
		
		ini_set ( 'memory_limit', '1024M' );
		ini_set ( 'max_execution_time', 3600 );
		ini_set ( 'max_input_time', 3600 );
			
		/**
		 * Declare variables*
		 */
		$get_employer_details = '';
		$get_all_payroll_employee = '';
		$get_company_plan_offering_criteria = '';
		$get_company_general_plan_info = '';
		$final_code = '';
		$get_inconsistent_contributions = '';
		$get_self_insured_plan = '';
		$month_flags = array ();
		$arrcode = array ();
		$arrcleancode = array ();
		$result = array ();
		$xml_data=array();
		
		$arr_plan_start_month = ['1'=>'01','2'=>'02','3'=>'03','4'=>'04','5'=>'05','6'=>'06','7'=>'07','8'=>'08','9'=>'09','10'=>'10','11'=>'11','12'=>'12','13'=>'00'];
		
		$arrmonthcontribution = array ();
		
		$arr_resposible_ssn = array ();
		
		try {
			/**
			 * *******Get all responsible ssn**********
			 */
			$result_unique_employees = $this->actionGetresponsiblessn ( $company_id );
			if (! empty ( $result_unique_employees ['error'] )) {
				throw new \Exception ( $result_unique_employees ['error'] );
			} else {
				
				
				
				if (! empty ( $result_unique_employees ['success'] [0] )) {
					/**
					 * ****assign variable*****
					 */
					$arr_resposible_ssn = $result_unique_employees ['success'] [0];
					
					/**
					 * **Get employer data from DB**
					 */
					$get_employer_details = TblAcaCompanies::find ()->select ( 'company_name, company_ein' )->where ( [ 
							'company_id' => $company_id 
					] )->One ();
					$get_company_basic_details = TblAcaBasicInformation::find ()->select ( 'street_address_1, street_address_2, contact_phone_number, contact_city, contact_state, contact_country, contact_zip' )->where ( [ 
							'company_id' => $company_id 
					] )->One ();
					$get_company_plan_offering_criteria = TblAcaPlanCriteria::find ()->where ( [ 
							'company_id' => $company_id 
					] )->One ();
					$get_company_general_plan_info = TblAcaGeneralPlanInfo::find()->select('renewal_month')->where(['company_id'=>$company_id])->One();
					
					if(!empty($get_company_plan_offering_criteria) && $get_company_plan_offering_criteria->hours_tracking_method==1){
						$value_3_1_1 = $get_company_plan_offering_criteria->initial_measurement_period;
					}else{
						$value_3_1_1 =0;
					}
					
					/**
					 * *Get plan class where 9.3 is self insured*
					 */
					
					$get_self_insured_plan = TblAcaPlanCoverageType::find ()->select ( 'plan_class_id' )->where ( [ 
							'company_id' => $company_id,
							'plan_offer_type' => 2 
					] )->One ();
					
					/**
					 * *****Get reporting year********
					 */
					$reporting_year_id = TblAcaCompanyReportingPeriod::find ()->select ( 'reporting_year' )->where ( [ 
							'company_id' => $company_id 
					] )->One ();
					
					if (! empty ( $reporting_year_id )) {
						$reporting_year = $reporting_year_id->year->lookup_value;
					}
					
					/**
					 * ***Get employee details*******
					 */
					$get_all_payroll_employee = TblAcaPayrollData::find ()->select ( 'employee_id, first_name, middle_name, last_name, suffix, ssn, address1, apt_suite, city, state, zip, dob' )->where ( [ 
							'company_id' => $company_id,
							'ssn' => $arr_resposible_ssn 
					] )->groupBy ( 'ssn' )->all ();
					
					if (! empty ( $get_all_payroll_employee )) 					// start of # section (i)
					{
						foreach ( $get_all_payroll_employee as $employee ) {
							$get_employment_periods = '';
							$get_medical_data = '';
							$get_medical_enrollment_periods = '';
							
							$arrmonthvalue = array ();
							$arrformdata = array ();
							$arrcode = array ();
							$arrcleancode = array ();
							$arrcode16 = array ();
							$arrcleancode16 = array ();
							
							/**
							 * ** Prepare array for the Part I ***********
							 */
							$suffix='';
							 $model_lookupvalue = TblAcaLookupOptions::find()->select('lookup_value')->where(['lookup_id'=>$employee->suffix,'code_id'=>7])->one();
							if(!empty($model_lookupvalue)){
								$suffix =$model_lookupvalue->lookup_value;
							}
							
							$xml_data['first_name__1']=$employee->first_name;
							$xml_data['middle_name__1']=$employee->middle_name;
							$xml_data['last_name__1']=$employee->last_name;
							$xml_data['suffix__1']=$suffix;
								
							$xml_data['street_address_1__3']=$employee->address1;
							$xml_data['street_address_2__3']=$employee->apt_suite;
								
							$xml_data['street_address_1__9']=$get_company_basic_details->street_address_1;
							$xml_data['street_address_2__9']=$get_company_basic_details->street_address_2;
							
							
							$arrformdata [$employee->ssn] ['1'] ['employee_name__I'] = $employee->first_name . ' ' . $employee->middle_name . ' ' . $employee->last_name . ' ' . $suffix;
							$arrformdata [$employee->ssn] ['1'] ['employee_ssn__I'] = $employee->ssn;
							$arrformdata [$employee->ssn] ['1'] ['employee_street_Address__I'] = $employee->address1 . ' ' . $employee->apt_suite;
							$arrformdata [$employee->ssn] ['1'] ['employee_city_or_town__I'] = $employee->city;
							$arrformdata [$employee->ssn] ['1'] ['employee_state_province__I'] = $employee->state;
							$arrformdata [$employee->ssn] ['1'] ['employee_country_and_zip_code__I'] = $employee->zip;
							
							$arrformdata [$employee->ssn] ['1'] ['employer_name__I'] = $get_employer_details->company_name;
							$arrformdata [$employee->ssn] ['1'] ['employer_ein__I'] = $get_employer_details->company_ein;
							$arrformdata [$employee->ssn] ['1'] ['employer_street_address__I'] = $get_company_basic_details->street_address_1 . ' ' . $get_company_basic_details->street_address_2;
							$arrformdata [$employee->ssn] ['1'] ['employer_contact_telephone_number__I'] = $get_company_basic_details->contact_phone_number;
							
							if($get_company_basic_details->contact_country == 'US'){
								$city = $get_company_basic_details->contact_city;
								$city_name = TblCityStatesUnitedStates::find()->select('city')->where(['LocationId' => $city])->One();
								
								$arrformdata [$employee->ssn] ['1'] ['employer_city_town__I'] = $city_name->city;
								
							}
							else
							{
								$arrformdata [$employee->ssn] ['1'] ['employer_city_town__I'] = $get_company_basic_details->contact_city;
							}
							
							$arrformdata [$employee->ssn] ['1'] ['employer_state_province__I'] = $get_company_basic_details->contact_state;
							$arrformdata [$employee->ssn] ['1'] ['employer_country_and_zip__I'] = $get_company_basic_details->contact_zip;
							
							/**
							 * ********************************** Prepare array for the Part 2*********
							 */
							
							/**
							 * ********************************* Filling section 14 START********************************
							 */
							
							$get_employment_periods = $employee->tblAcaPayrollEmploymentPeriods;
							$get_inconsistent_contributions = $employee->tblAcaPayrollInconsistentContribution;
							
							// Check if the particular employee has employment period or not
							// if(responsible person does not have an employment period) then 1G
							if (empty ( $get_employment_periods )) {
								
								for($i = 1; $i <= 12; $i ++) {
									$arrcode [$employee->ssn] [$i] [] = '1G';
								}
							} else {
								
								foreach ( $get_employment_periods as $periods ) {
									
									// check for FT status
									if($periods->status==1){
										
									$temptermdate = '';
									$eligible_date = '';
									$maxtermdate = '';
									$plan_emp_contributions = '';
									$flag1 = False;
									$flag2 = False;
									$month_flags = array ();
									$arrmonthcontribution = array ();
									
									$medical_plan_class = $periods->planClass;
									
									if (! empty ( $medical_plan_class )) {
										/**
										 * ****Assigning Month flags
										 * ---$month_flag2--$month_flag3--$month_flag4
										 * ---$month_flag5--$month_flag6**********
										 */
										
										 
										
									  $month_flags ['10.1.1'] = '';
							          $month_flags ['10.2.1'] = '';
							          $month_flags ['10.3'] = '';
							          $month_flags ['10.3.1'] = '';
							          $month_flags ['10.4'] = '';
							          $month_flags ['11.2'] = '';
							          $month_flags ['9.3'] = '';
							          
							          $medical_plan_class_coverage_offered = $medical_plan_class->tblAcaPlanCoverageTypeOffereds;
							          
							          if(!empty($medical_plan_class_coverage_offered))
							          {
							           
							          $month_flags ['10.1.1'] = $medical_plan_class_coverage_offered->mv_coverage_months;
							          $month_flags ['10.2.1'] = $medical_plan_class_coverage_offered->essential_coverage_months;
							          $month_flags ['10.3'] = $medical_plan_class_coverage_offered->spouse_essential_coverage;
							          $month_flags ['10.3.1'] = $medical_plan_class_coverage_offered->spouse_conditional_coverage;
							          $month_flags ['10.4'] = $medical_plan_class_coverage_offered->dependent_essential_coverage;
							          $month_flags ['9.3']= $medical_plan_class->plan_offer_type;
							           if(!empty($medical_plan_class_coverage_offered->tblAcaEmpContributions [0]->employee_plan_contribution))
							           {
							           $month_flags ['11.2'] = $medical_plan_class_coverage_offered->tblAcaEmpContributions [0]->employee_plan_contribution;
							           }
							          
							          }
										
										/**
										 * ****Assigning Month flags ---$month_flag1----**********
										 */
										if (! empty ( $get_company_plan_offering_criteria )) {
											$month_flags ['3.2'] = $get_company_plan_offering_criteria->plan_offering_criteria_type;
										}
						
									if(!empty($medical_plan_class_coverage_offered->tblAcaEmpContributions [0]->tblAcaEmpContributionsPremia)){
										$plan_emp_contributions = $medical_plan_class_coverage_offered->tblAcaEmpContributions [0]->tblAcaEmpContributionsPremia;
									}
										
										if (! empty ( $plan_emp_contributions )) {
											foreach ( $plan_emp_contributions as $monthcontribution ) {
												$arrmonthcontribution [$monthcontribution->premium_year] = $monthcontribution->premium_value;
											}
										}
										
										
										// If ( termination_Date is empty) 
										if (empty ( $periods->termination_date )) {
											
											/**
											 * Set temptermdate = 12/31/reportingyear)
											 * ( example : if reporting year is 2016 then temptermdate = 12/31/2016)
											 * *
											 */
											
											$temptermdate = $reporting_year . '-12-31';
										} else 										// start section (ii)
										{
											// check whether 9.4 is selected or not 
											// If ( 9.4 = yes)
											if ($medical_plan_class->employee_medical_plan == 1) {
												
												// place eod date of month
												$days = '';
												$days = cal_days_in_month ( CAL_GREGORIAN, date ( 'm', strtotime ( $periods->termination_date ) ), $reporting_year );
												$temptermdate = date ( 'Y-m-' . $days, strtotime ( $periods->termination_date ) );
											} else {
												$temptermdate = $periods->termination_date;
											}
										} // End section (ii)
										
										//If (temptermdate < First day of the reporting year)
										if (strtotime ( $temptermdate ) < strtotime (date($reporting_year . '-01-01'))) {
											
											// Ignore that line and Continue;
										} else {
											// function to get the waiting period value based on $medical_plan_class['plan_type_doh']
											$waiting_period = $medical_plan_class->plan_type_doh;
											
											// If (the record has checkbox as yes for Ã¢â‚¬Å“donÃ¢â‚¬â„¢t apply waiting periodÃ¢â‚¬ï¿½)
											if ($periods->waiting_period == 1) {
												
												// eligibility_date
												$eligible_date = $periods->hire_date;
											} else {
												// function to get the eligibility_date
												$eligible_date = self::actionGeteligibiltydate ( $waiting_period, $periods->hire_date );
											}
											
											// Setting flags
											// if (eligible_Date < = temptermdate) 
											if (strtotime ( $eligible_date ) <= strtotime ( $temptermdate )) {
												$flag1 = 1;
											} else {
												
												$flag1 = 0;
											}
											
											
											
											// Run for loop for all the months
											// For ( month = jan to dec )
											for($i = 1; $i <= 12; $i ++) {
																							
												
												$days = cal_days_in_month ( CAL_GREGORIAN, $i, $reporting_year );
												$last_day_month = date ( $reporting_year.'-'.$i.'-'.$days );
												
												//if ( eligible_date<= 1st day of the month of reporting year )and ( temptermdate> = last day of the month of the reporting year)
												if ((strtotime ( $eligible_date ) <= strtotime ( date($reporting_year .'-'.$i.'-01') )) && (strtotime ( $temptermdate ) >= strtotime ( $last_day_month ))) {
													$flag2 = 1;
												} else {
													$flag2 = 0;
												}
											
												if ($flag1 == 1 && $flag2 == 1) {
													
													$arrcode [$employee->ssn] [$i] [] = $this->GetmonthCode ( $month_flags );
												} else {
													
													$arrcode [$employee->ssn] [$i] [] = '1H';
												}
											}
										}
									
									}
								}
								}
							}
							
							//print_r($arrcode [$employee->ssn]); die();
							
							
							// Check all codes for a particular month
							for($i = 1; $i <= 12; $i ++) {
								
								$arr1H = [ 
										'1H' 
								];
								
								if (! empty ( $arrcode [$employee->ssn] [$i] )) {
									$diff_codes=array();
									$diff_codes = array_diff ($arrcode [$employee->ssn] [$i],$arr1H);
									
									// check if all_month_code have value other than 1H
									if (! empty ( $diff_codes )) {
										$arrcleancode [$employee->ssn] [$i] = array_values ( $diff_codes )[0];
									} else {
										$arrcleancode [$employee->ssn] [$i] = '1H';
									}
								} else {
									$arrcleancode [$employee->ssn] [$i] = '';
								}
							}
							
							/**
							 * ** Prepare array for the Part II plan start month ***********
							 */
							
							$arrformdata [$employee->ssn] ['2'] ['plan_start_month__II'] = $arr_plan_start_month[$get_company_general_plan_info->renewal_month];
							
							
							/**
							 * ** Prepare array for the Part II Section 14 ***********
							 */
							
							// Check if all elements in array are same
							if (count ( array_unique ( $arrcleancode [$employee->ssn] ) ) == 1) {
								$arrformdata [$employee->ssn] ['2'] ['offer_of_coverage_all_12_months__II'] = $arrcleancode [$employee->ssn] [1];
							} else {
								$arrformdata [$employee->ssn] ['2'] ['offer_of_coverage_jan__II'] = $arrcleancode [$employee->ssn] [1];
								$arrformdata [$employee->ssn] ['2'] ['offer_of_coverage_feb__II'] = $arrcleancode [$employee->ssn] [2];
								$arrformdata [$employee->ssn] ['2'] ['offer_of_coverage_march__II'] = $arrcleancode [$employee->ssn] [3];
								$arrformdata [$employee->ssn] ['2'] ['offer_of_coverage_april__II'] = $arrcleancode [$employee->ssn] [4];
								$arrformdata [$employee->ssn] ['2'] ['offer_of_coverage_may__II'] = $arrcleancode [$employee->ssn] [5];
								$arrformdata [$employee->ssn] ['2'] ['offer_of_coverage_june__II'] = $arrcleancode [$employee->ssn] [6];
								$arrformdata [$employee->ssn] ['2'] ['offer_of_coverage_july__II'] = $arrcleancode [$employee->ssn] [7];
								$arrformdata [$employee->ssn] ['2'] ['offer_of_coverage_august__II'] = $arrcleancode [$employee->ssn] [8];
								$arrformdata [$employee->ssn] ['2'] ['offer_of_coverage_september__II'] = $arrcleancode [$employee->ssn] [9];
								$arrformdata [$employee->ssn] ['2'] ['offer_of_coverage_october__II'] = $arrcleancode [$employee->ssn] [10];
								$arrformdata [$employee->ssn] ['2'] ['offer_of_coverage_november__II'] = $arrcleancode [$employee->ssn] [11];
								$arrformdata [$employee->ssn] ['2'] ['offer_of_coverage_december__II'] = $arrcleancode [$employee->ssn] [12];
							}
							
							/**
							 * ********************************* Filling section 14 END********************************
							 */
							
							/**
							 * ********************************* Filling section 15 START********************************
							 */
							
							for($i = 1; $i <= 12; $i ++) {
								
								// If code for 14 = 1B or 1C or 1D or 1E or 1J or 1K and 11.2 = yes then pull the value for that month and place against that month in 15.
								if (($arrcleancode [$employee->ssn] [$i] == '1B' || $arrcleancode [$employee->ssn] [$i] == '1C' || $arrcleancode [$employee->ssn] [$i] == '1D' || $arrcleancode [$employee->ssn] [$i] == '1E' || $arrcleancode [$employee->ssn] [$i] == '1J' || $arrcleancode [$employee->ssn] [$i] == '1K')) {
									
									if($month_flags ['11.2'] == 1)
									{
									$arrmonthvalue [$employee->ssn] [$i] = $arrmonthcontribution [$i];
									}
									else
									{
										
									if (! empty ( $get_inconsistent_contributions [0] )) {
										
										switch ($i) {
											case 1 :
												$arrmonthvalue [$employee->ssn] [$i] = $get_inconsistent_contributions [0]->january;
												break;
											case 2 :
												$arrmonthvalue [$employee->ssn] [$i] = $get_inconsistent_contributions [0]->febuary;
												break;
											case 3 :
												$arrmonthvalue [$employee->ssn] [$i] = $get_inconsistent_contributions [0]->march;
												break;
											case 4 :
												$arrmonthvalue [$employee->ssn] [$i] = $get_inconsistent_contributions [0]->april;
												break;
											case 5 :
												$arrmonthvalue [$employee->ssn] [$i] = $get_inconsistent_contributions [0]->may;
												break;
											case 6 :
												$arrmonthvalue [$employee->ssn] [$i] = $get_inconsistent_contributions [0]->june;
												break;
											case 7 :
												$arrmonthvalue [$employee->ssn] [$i] = $get_inconsistent_contributions [0]->july;
												break;
											case 8 :
												$arrmonthvalue [$employee->ssn] [$i] = $get_inconsistent_contributions [0]->august;
												break;
											
											case 9 :
												$arrmonthvalue [$employee->ssn] [$i] = $get_inconsistent_contributions [0]->september;
												break;
											case 10 :
												$arrmonthvalue [$employee->ssn] [$i] = $get_inconsistent_contributions [0]->october;
												break;
											case 11 :
												$arrmonthvalue [$employee->ssn] [$i] = $get_inconsistent_contributions [0]->november;
												break;
											case 12 :
												$arrmonthvalue [$employee->ssn] [$i] = $get_inconsistent_contributions [0]->december;
												break;
										}
									} else {
										$arrmonthvalue [$employee->ssn] [$i] = '';
									}
									
								
									}
									
									
									
								}
								// If code for 14 =1A, 1F, 1G, 1H then the values for the months is blank
								elseif ($arrcleancode [$employee->ssn] [$i] == '1A' || $arrcleancode [$employee->ssn] [$i] == '1F' || $arrcleancode [$employee->ssn] [$i] == '1G' || $arrcleancode [$employee->ssn] [$i] == '1H') {
									
									$arrmonthvalue [$employee->ssn] [$i] = '';
								}
								else
								{
									$arrmonthvalue [$employee->ssn] [$i] = '';
								}
							}
							
							
							/**
							 * ** Prepare array for the Part II Section 15 ***********
							 */
							
							if (! empty ( $arrmonthvalue [$employee->ssn] )) {
								// Check if all elements in array are same
								if (count ( array_unique ( $arrmonthvalue [$employee->ssn] ) ) == 1) {
									$arrformdata [$employee->ssn] ['2'] ['employee_required_contributions_all_12_months__II'] = empty($arrmonthvalue [$employee->ssn] [1])?'':number_format($arrmonthvalue [$employee->ssn] [1],2);
								} else {
									$arrformdata [$employee->ssn] ['2'] ['employee_required_contributions_jan__II'] = empty($arrmonthvalue [$employee->ssn] [1])?'':number_format($arrmonthvalue [$employee->ssn] [1],2);
									$arrformdata [$employee->ssn] ['2'] ['employee_required_contributions_feb__II'] = empty($arrmonthvalue [$employee->ssn] [2])?'':number_format($arrmonthvalue [$employee->ssn] [2],2);
									$arrformdata [$employee->ssn] ['2'] ['employee_required_contributions_march__II'] = empty($arrmonthvalue [$employee->ssn] [3])?'':number_format($arrmonthvalue [$employee->ssn] [3],2);
									$arrformdata [$employee->ssn] ['2'] ['employee_required_contributions_april__II'] = empty($arrmonthvalue [$employee->ssn] [4])?'':number_format($arrmonthvalue [$employee->ssn] [4],2);
									$arrformdata [$employee->ssn] ['2'] ['employee_required_contributions_may__II'] = empty($arrmonthvalue [$employee->ssn] [5])?'':number_format($arrmonthvalue [$employee->ssn] [5],2);
									$arrformdata [$employee->ssn] ['2'] ['employee_required_contributions_june__II'] = empty($arrmonthvalue [$employee->ssn] [6])?'':number_format($arrmonthvalue [$employee->ssn] [6],2);
									$arrformdata [$employee->ssn] ['2'] ['employee_required_contributions_july__II'] = empty($arrmonthvalue [$employee->ssn] [7])?'':number_format($arrmonthvalue [$employee->ssn] [7],2);
									$arrformdata [$employee->ssn] ['2'] ['employee_required_contributions_august__II'] = empty($arrmonthvalue [$employee->ssn] [8])?'':number_format($arrmonthvalue [$employee->ssn] [8],2);
									$arrformdata [$employee->ssn] ['2'] ['employee_required_contributions_september__II'] = empty($arrmonthvalue [$employee->ssn] [9])?'':number_format($arrmonthvalue [$employee->ssn] [9],2);
									$arrformdata [$employee->ssn] ['2'] ['employee_required_contributions_october__II'] = empty($arrmonthvalue [$employee->ssn] [10])?'':number_format($arrmonthvalue [$employee->ssn] [10],2);
									$arrformdata [$employee->ssn] ['2'] ['employee_required_contributions_november__II'] = empty($arrmonthvalue [$employee->ssn] [11])?'':number_format($arrmonthvalue [$employee->ssn] [11],2);
									$arrformdata [$employee->ssn] ['2'] ['employee_required_contributions_december__II'] = empty($arrmonthvalue [$employee->ssn] [12])?'':number_format($arrmonthvalue [$employee->ssn] [12],2);
								}
							}
							
							/**
							 * ********************************* Filling section 15 END********************************
							 */
							
							/**
							 * ********************************* Filling section 16 END********************************
							 */
							
							if (! empty ( $get_employment_periods )) {
								$get_medical_data = TblAcaMedicalData::find ()->where ( [ 
										'ssn' => $employee->ssn,
										'company_id'=>$company_id
								] )->One ();
								if (! empty ( $get_medical_data )) {
									$get_medical_enrollment_periods = $get_medical_data->tblAcaMedicalEnrollmentPeriods;
								}else{
									$get_medical_enrollment_periods=array();
									$object = (object) [
									'coverage_end_date' => NULL,
									'coverage_start_date' => NULL,
									];
									array_push($get_medical_enrollment_periods,$object);
								}
								
								$arrcode16 = array ();
								foreach ( $get_employment_periods as $periods ) {
									$medical_plan_class = $periods->planClass;
									
									if (! empty ( $medical_plan_class )) {
										$termination_date = $periods->termination_date;
										$temptermdate = '';
										
										if (! empty ( $get_medical_enrollment_periods )) {
											foreach ( $get_medical_enrollment_periods as $enrollment_periods ) {
												$tempcoverageenddate = '';
												
												
												//coverage_end_date is empty or getYear(coverage_end_date) == current reporting year
												if (empty ( $enrollment_periods->coverage_end_date ) || (date ( 'Y', strtotime ( $enrollment_periods->coverage_end_date ) ) == $reporting_year)) {
													
													// If ( termination_Date is empty) 
													if (empty ( $termination_date )) {
														
														$temptermdate = $reporting_year . '-12-31'; // Y-m-d
													} else {
														
														// check whether 9.4 is selected or not
														// If ( 9.4 = yes) 
														if ($medical_plan_class->employee_medical_plan == 1) {
															
															// place eod date of month
															$days = '';
															$days = cal_days_in_month ( CAL_GREGORIAN, date ( 'm', strtotime ( $periods->termination_date ) ), $reporting_year );
															$temptermdate = date ( 'Y-m-' . $days, strtotime ( $periods->termination_date ) );
														} else {
															$temptermdate = $periods->termination_date;
														}
													}
													
													$waiting_period = $medical_plan_class->plan_type_doh;
													
													// If (the record has checkbox as yes for Ã¢â‚¬Å“donÃ¢â‚¬â„¢t apply waiting periodÃ¢â‚¬ï¿½)
													if ($periods->waiting_period == 1) {
														
														// eligibility_date
														$eligible_date = $periods->hire_date;
													} else {
														// function to get the eligibility_date
														//$eligible_date = self::actionGeteligibiltydate ( $waiting_period, $periods->hire_date );
														$eligible_date = self::actionGeteligibiltydate($waiting_period, $periods->hire_date, $value_3_1_1, $periods->status);
													}
													
													// For ( month = jan to dec of report year)
													for($i = 1; $i <= 12; $i ++) {
														// place eod date of month
														$days = '';
														$end_date_month = '';
														$start_date_month = '';
														
														$days = cal_days_in_month ( CAL_GREGORIAN, $i, $reporting_year );
														$end_date_month = date ( $reporting_year.'-'.$i.'-'.$days );
														$start_date_month = date($reporting_year.'-'.$i.'-1');
  
														
														// if ( coverage_end_date ==empty )
														if (empty ( $enrollment_periods->coverage_end_date )) {
														
															$tempcoverageenddate = date($reporting_year.'-12-31');
														} else {
														
															$tempcoverageenddate = $enrollment_periods->coverage_end_date;
														
														}
														
 														//if (9.3 = Ã¢â‚¬Å“self InsuredÃ¢â‚¬ï¿½) and (coverage_start_date<= start of the month) and (tempcoverage_end_Date>= end of the month) {
														if(($medical_plan_class->plan_offer_type==2) && (!empty($enrollment_periods->coverage_start_date)) && (strtotime($enrollment_periods->coverage_start_date)<=strtotime($start_date_month)) && (strtotime($tempcoverageenddate)>=strtotime($end_date_month))){
															
															$arrcode16 [$employee->ssn] [$i] [] = '2C';
														}else{
															
															// if (employementstart_date<= end of the month) and ((temp_term_date>= start of the month &&temp_term_date<= end of the month) or ( temp_term_date>= end of the month)) {
															if((strtotime ( $periods->hire_date ) <= strtotime ( $end_date_month )) && ((strtotime ( $temptermdate ) >= strtotime ( $start_date_month )  && strtotime ( $temptermdate ) <= strtotime ( $end_date_month )) || (strtotime($temptermdate)>=strtotime($end_date_month)))){
																
																//if (eligib_date<= start of the month){ condition # 2
																if(strtotime($eligible_date)<=strtotime($start_date_month)){
																	
																	//if (( emp_status = PT)or If ( temptermdate<end of the month){
																	if(($periods->status == 2) || (strtotime($temptermdate)<strtotime($end_date_month))){
																		$arrcode16 [$employee->ssn] [$i] [] = '2B';
																	}else{
																		
																		// if plan type is multi employer plan
																		if($medical_plan_class->plan_offer_type == 4){
																			$arrcode16 [$employee->ssn] [$i] [] = '2E';
																		}else{
																		//if ( coverage_start_date<= start of the month ) and (tempcoverageenddate>= end of the month) {
																		if( (!empty($enrollment_periods->coverage_start_date)) && (strtotime($enrollment_periods->coverage_start_date)<=strtotime($start_date_month)) && (strtotime($tempcoverageenddate)>=strtotime($end_date_month))){
																			$arrcode16 [$employee->ssn] [$i] [] = '2C';
																		}else{
																			
																			
																				if (!empty($medical_plan_class_coverage_offered->tblAcaEmpContributions [0]->safe_harbor) && $medical_plan_class_coverage_offered->tblAcaEmpContributions [0]->safe_harbor == 2) { // if (11.1 == Ã¯Â¿Â½FTPÃ¯Â¿Â½ )
																				$arrcode16 [$employee->ssn] [$i] [] = '2G';
																			} elseif (!empty($medical_plan_class_coverage_offered->tblAcaEmpContributions [0]->safe_harbor) && $medical_plan_class_coverage_offered->tblAcaEmpContributions [0]->safe_harbor == 3) { // if (11.1 == Ã¯Â¿Â½ROPÃ¯Â¿Â½ )
																				$arrcode16 [$employee->ssn] [$i] [] = '2H';
																			} elseif (!empty($medical_plan_class_coverage_offered->tblAcaEmpContributions [0]->safe_harbor) && $medical_plan_class_coverage_offered->tblAcaEmpContributions [0]->safe_harbor == 1) { // if (11.1 == Ã¯Â¿Â½W2Ã¯Â¿Â½ )
																				$arrcode16 [$employee->ssn] [$i] [] = '2F';
																			} elseif (!empty($medical_plan_class_coverage_offered->tblAcaEmpContributions [0]->safe_harbor) && $medical_plan_class_coverage_offered->tblAcaEmpContributions [0]->safe_harbor == 4) { // if (11.1 == Ã¯Â¿Â½Not applicableÃ¯Â¿Â½ )
																				$arrcode16 [$employee->ssn] [$i] [] = '';
																			}
																			
																		}
																	}
																	}
																
																}else{ //end condition 2
																	$arrcode16 [$employee->ssn] [$i] [] = '2D';
																}
															}else{
																$arrcode16 [$employee->ssn] [$i] [] = '2A';
															}
															
															
														}
														
														
												
		
														
													}
												}
											}
										}
									}
								}
							}
							
							
							// Check all codes for a particular month
							for($i = 1; $i <= 12; $i ++) {
								
								// If (all_code_for_month == blank)
								if (empty ( $arrcode16 [$employee->ssn] [$i] )) {
									$arrcleancode16 [$employee->ssn] [$i] = '';
								} elseif (in_array ( '2E', $arrcode16 [$employee->ssn] [$i], TRUE )) {
									$arrcleancode16 [$employee->ssn] [$i] = '2E';
								} elseif (in_array ( '2C', $arrcode16 [$employee->ssn] [$i], TRUE )) {
									$arrcleancode16 [$employee->ssn] [$i] = '2C';
								} elseif (in_array ( '2B', $arrcode16 [$employee->ssn] [$i], TRUE )) {
									$arrcleancode16 [$employee->ssn] [$i] = '2B';
								} elseif (in_array ( '2D', $arrcode16 [$employee->ssn] [$i], TRUE )) {
									$arrcleancode16 [$employee->ssn] [$i] = '2D';
								} elseif (in_array ( '2H', $arrcode16 [$employee->ssn] [$i], TRUE )) {
									$arrcleancode16 [$employee->ssn] [$i] = '2H';
								} elseif (in_array ( '2G', $arrcode16 [$employee->ssn] [$i], TRUE )) {
									$arrcleancode16 [$employee->ssn] [$i] = '2G';
								} elseif (in_array ( '2F', $arrcode16 [$employee->ssn] [$i], TRUE )) {
									$arrcleancode16 [$employee->ssn] [$i] = '2F';
								} elseif (in_array ( '', $arrcode16 [$employee->ssn] [$i], TRUE )) {
									$arrcleancode16 [$employee->ssn] [$i] = '';
								} elseif (in_array ( '2A', $arrcode16 [$employee->ssn] [$i], TRUE )) {
									$arrcleancode16 [$employee->ssn] [$i] = '2A';
								}
							}
							
							/**
							 * * Prepare array for the Part II Section 16 **********
							 */
							// Check if all elements in array are same
							if (count ( array_unique ( $arrcleancode16 [$employee->ssn] ) ) == 1) {
								$arrformdata [$employee->ssn] ['2'] ['section_4980h_safe_harbor_all_12_months__II'] = $arrcleancode16 [$employee->ssn] [1];
							} else {
								$arrformdata [$employee->ssn] ['2'] ['section_4980h_safe_harbor_jan__II'] = $arrcleancode16 [$employee->ssn] [1];
								$arrformdata [$employee->ssn] ['2'] ['section_4980h_safe_harbor_feb__II'] = $arrcleancode16 [$employee->ssn] [2];
								$arrformdata [$employee->ssn] ['2'] ['section_4980h_safe_harbor_march__II'] = $arrcleancode16 [$employee->ssn] [3];
								$arrformdata [$employee->ssn] ['2'] ['section_4980h_safe_harbor_april__II'] = $arrcleancode16 [$employee->ssn] [4];
								$arrformdata [$employee->ssn] ['2'] ['section_4980h_safe_harbor_may__II'] = $arrcleancode16 [$employee->ssn] [5];
								$arrformdata [$employee->ssn] ['2'] ['section_4980h_safe_harbor_june__II'] = $arrcleancode16 [$employee->ssn] [6];
								$arrformdata [$employee->ssn] ['2'] ['section_4980h_safe_harbor_july__II'] = $arrcleancode16 [$employee->ssn] [7];
								$arrformdata [$employee->ssn] ['2'] ['section_4980h_safe_harbor_august__II'] = $arrcleancode16 [$employee->ssn] [8];
								$arrformdata [$employee->ssn] ['2'] ['section_4980h_safe_harbor_september__II'] = $arrcleancode16 [$employee->ssn] [9];
								$arrformdata [$employee->ssn] ['2'] ['section_4980h_safe_harbor_october__II'] = $arrcleancode16 [$employee->ssn] [10];
								$arrformdata [$employee->ssn] ['2'] ['section_4980h_safe_harbor_november__II'] = $arrcleancode16 [$employee->ssn] [11];
								$arrformdata [$employee->ssn] ['2'] ['section_4980h_safe_harbor_december__II'] = $arrcleancode16 [$employee->ssn] [12];
							}
							
							/**
							 * ********************************* Filling section 16 END********************************
							 */
							
							/**
							 * ********************************* Filling section 17-34 START********************************
							 */
							// intialising
							for($i=17;$i<=34;$i++){
								$xml_data['section_2__'.$i]=array();
							}
							
							// check if 9.3 is self insured
							if (! empty ( $get_self_insured_plan )) {
								
								$arrformdata [$employee->ssn] ['3'] ['employer_self_insured__III'] = 1;
								
								$get_connected_medical_data = TblAcaMedicalData::find ()->joinWith ( 'tblAcaMedicalEnrollmentPeriods' )->where ( [ 
										'company_id' => $company_id,
										'person_type' => [ 
												85,
												86 
										],
										'tbl_aca_medical_enrollment_period.ssn' => $employee->ssn 
								] )->All ();
								
								
								
								$get_all_enrollment_data = TblAcaMedicalData::find ()->joinWith ( 'tblAcaMedicalEnrollmentPeriods' )->where ( [ 
										'company_id' => $company_id,
										'tbl_aca_medical_enrollment_period.ssn' => $employee->ssn 
								] )->All ();
								
								//$get_all_enrollment_data = $get_all_enrollment_data1->tblAcaMedicalEnrollmentPeriods;
								
								
							 /********Creating array of month for checking of 2C in section 16****************/
							$arrmonths = array(
							'all_12_months',
							'jan',
							'feb',
							'march',
							'april',
							'may',
							'june',
							'july',
							'august',
							'september',
							'october',
							'november',
							'december');
							
							//flag for checking if any month has 2C
							$valuetwoc = 0;
							$checkedcoverage = array();
							$arrmedical_data = array ();
							
							
							
							
							if(empty($get_all_enrollment_data)){
								$medical_employees = 17;
							}else{
								$medical_employees = 18;
									
								// initialisation
								foreach($arrmonths as $key=>$value){
									$checkedcoverage[$value]=0;
									if($key>0){
										
										$arrmedical_data [$employee->ssn] [17] ['month'][$key] = '';
									}else{
										$arrmedical_data [$employee->ssn] [17] ['month']['all'] = '';
									}
								}
									
								$employee_dob = '';
								$arrmedical_data [$employee->ssn] [17] ['person_name'] = $employee->first_name . ' ' . $employee->middle_name . ' ' . $employee->last_name . ' ' . $suffix;
									
								if(!empty($employee->dob))
								{
									$employee_dob = date('m-d-Y',strtotime($employee->dob));
								}
									
								$arrmedical_data [$employee->ssn] [17] ['dob'] = $employee_dob;
								$arrmedical_data [$employee->ssn] [17] ['ssn'] = $employee->ssn;
									
								//	print_r($get_all_enrollment_data); die();
									
									
									foreach ($get_all_enrollment_data as $connected_medical){
										
									
									// enrollment periods
										$enrollment_periods = $connected_medical->tblAcaMedicalEnrollmentPeriods;
										
										if (! empty ( $enrollment_periods )){ 
											foreach ( $enrollment_periods as $each_period ) {
																		
									
									$temp_start_date=$each_period->coverage_start_date;
									if(empty($each_period->coverage_end_date)){
										$temp_end_date=$reporting_year.'-12-31';
									}else{
										$temp_end_date=$each_period->coverage_end_date;
									}
							
									foreach ($arrmonths as $key=>$every_month){
											
										if($checkedcoverage[$every_month]==0){
											if($key>0){
												$month_day = date ($reporting_year.'-'.$key.'-01');
												$date1_day = date ('Y-m-01', strtotime($temp_start_date) );
												$date2_day = date ('Y-m-01', strtotime($temp_end_date) );
													
												//if ( ($month_day >= min($date1_day, $date2_day))&& ($month_day <= max($date1_day, $date2_day)) ){
													if ( (strtotime($month_day)-strtotime($date1_day))>=0 && (strtotime($month_day)-strtotime($date2_day))<=0 ){
													$checkedcoverage[$every_month] = 1;
													$valuetwoc ++;
												}
											}
										}
									}
								}
											}
									}
									
								if($valuetwoc==12 )
								{
									$arrmedical_data [$employee->ssn] [17] ['month']['all'] = 1;
										
								}
								else{
										
									foreach($arrmonths as $key=>$value){
										if($key>0){
											$arrmedical_data [$employee->ssn] [17] ['month'][$key] = $checkedcoverage[$value];
										}
									}
										
								}
									
								$xml_data_part3=array();
								$xml_data_part3['first_name']=$employee->first_name;
								$xml_data_part3['middle_name']=$employee->middle_name;
								$xml_data_part3['last_name']=$employee->last_name;
								$xml_data_part3['suffix']=$suffix;
									
								array_push($xml_data['section_2__17'],$xml_data_part3);
									
							}
							
															
								if (! empty ( $get_connected_medical_data )) {
									
									
									foreach ( $get_connected_medical_data as $connected_medical ) {
										
										
										$person_name = '';
										$person_dob = '';
										$person_ssn = '';
										$xml_data_part3=array();
										$xml_data['section_2__'.$medical_employees]=array();
										
										for($i = 1; $i <= 12; $i ++) {
											${'temp_monthcount_' . $i} = 0;
										}
										
										$model_lookupvalue = TblAcaLookupOptions::find()->select('lookup_value')->where(['lookup_id'=>$connected_medical->suffix])->one();
										if(!empty($model_lookupvalue)){
											$medical_suffix =$model_lookupvalue->lookup_value;
										}else{
											$medical_suffix ='';
										}
										
										$person_name = $connected_medical->first_name . ' ' . $connected_medical->middle_name . ' ' . $connected_medical->last_name.' '.$medical_suffix;
										if(!empty($connected_medical->dob))
										{
											$person_dob = date('m-d-Y',strtotime($connected_medical->dob));
										}
										
										$person_ssn = $connected_medical->ssn;
										
										$xml_data_part3['first_name']=$connected_medical->first_name;
										$xml_data_part3['middle_name']=$connected_medical->middle_name;
										$xml_data_part3['last_name']=$connected_medical->last_name;
										$xml_data_part3['suffix']=$medical_suffix;
										
										array_push($xml_data['section_2__'.$medical_employees],$xml_data_part3);
										
										
										$arrmedical_data [$employee->ssn] [$medical_employees] ['person_name'] = $person_name;
										$arrmedical_data [$employee->ssn] [$medical_employees] ['dob'] = $person_dob;
										$arrmedical_data [$employee->ssn] [$medical_employees] ['ssn'] = $person_ssn;
										
										// enrollment periods
										$enrollment_periods = $connected_medical->tblAcaMedicalEnrollmentPeriods;
										
										if (! empty ( $enrollment_periods )) {
											foreach ( $enrollment_periods as $periods ) {
												
												if (($periods->ssn = $employee->ssn) && ($periods->person_type = '85' || $periods->person_type = '86')) {
													
													
													
													// get the coveage periods for the dependent where coverage_end date is empty or coverage_end_year = reporting year
													if (empty ( $periods->coverage_end_date ) || (date ( 'Y', strtotime ( $periods->coverage_end_date ) ) == $reporting_year)) {
														
														
														
														// setting the value for temp coverage end date
														if (empty ( $periods->coverage_end_date )) {
															$tempcovgenddate = $reporting_year . '-12-31'; // Y-m-d
														} else {
															$tempcovgenddate = $periods->coverage_end_date; // Y-m-d
														}
														
														
														for($i = 1; $i <= 12; $i ++) {
															$start_date_month = $reporting_year . '-' . $i . '-01';
															
															// if covergae start date <= start of the month and temp coverage end date is >= start of the month
															if (strtotime ( $periods->coverage_start_date ) <= strtotime ( $start_date_month ) && strtotime($tempcovgenddate)>=strtotime($start_date_month)) {
																
																if (! ${'temp_monthcount_' . $i}) {
																	${'temp_monthcount_' . $i} = 1;
																}
															}
														}
														
														
														
													}
												}
											}
										}
										
										for($i = 1; $i <= 12; $i ++) {
											
											$arrmedical_data [$employee->ssn] [$medical_employees] ['month'] [$i] = ${'temp_monthcount_' . $i};
										}
										
										if (! empty ( $arrmedical_data [$employee->ssn] [$medical_employees] ['month'] )) {
											$medical_period_count = array_count_values ( $arrmedical_data [$employee->ssn] [$medical_employees] ['month'] );
											
											if (isset($medical_period_count ['1']) && $medical_period_count ['1'] == 12) {
												$arrmedical_data [$employee->ssn] [$medical_employees] ['month'] ['all'] = 1;
												
												for($i = 1; $i <= 12; $i ++) {
													
													$arrmedical_data [$employee->ssn] [$medical_employees] ['month'] [$i] = 0;
												}
											} else {
												$arrmedical_data [$employee->ssn] [$medical_employees] ['month'] ['all'] = 0;
											}
										}
										
										$medical_employees ++;
									}
								}
								
								
								
							} else {
								$arrformdata [$employee->ssn] ['3'] ['employer_self_insured__III'] = 0;
							}
							
							
							
							
							
							/**
							 * ** Prepare array for the Part III Section 17-34 ***********
							 */
							
							if (! empty ( $arrmedical_data [$employee->ssn])) {
								for($i = 17; $i <= 34; $i ++) {
									
									if (! empty ( $arrmedical_data [$employee->ssn] [$i] )) {
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_name_of_covered_individual__III'] = $arrmedical_data [$employee->ssn] [$i] ['person_name'];
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_ssn__III'] = $arrmedical_data [$employee->ssn] [$i] ['ssn'];
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_dob__III'] = $arrmedical_data [$employee->ssn] [$i] ['dob'];
										
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_all_12_months__III'] = $arrmedical_data [$employee->ssn] [$i] ['month'] ['all'];
										
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_jan__III'] = $arrmedical_data [$employee->ssn] [$i] ['month'] ['1'];
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_feb__III'] = $arrmedical_data [$employee->ssn] [$i] ['month'] ['2'];
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_march__III'] = $arrmedical_data [$employee->ssn] [$i] ['month'] ['3'];
										
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_april__III'] = $arrmedical_data [$employee->ssn] [$i] ['month'] ['4'];
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_may__III'] = $arrmedical_data [$employee->ssn] [$i] ['month'] ['5'];
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_june__III'] = $arrmedical_data [$employee->ssn] [$i] ['month'] ['6'];
										
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_july__III'] = $arrmedical_data [$employee->ssn] [$i] ['month'] ['7'];
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_august__III'] = $arrmedical_data [$employee->ssn] [$i] ['month'] ['8'];
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_september__III'] = $arrmedical_data [$employee->ssn] [$i] ['month'] ['9'];
										
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_october__III'] = $arrmedical_data [$employee->ssn] [$i] ['month'] ['10'];
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_november__III'] = $arrmedical_data [$employee->ssn] [$i] ['month'] ['11'];
										$arrformdata [$employee->ssn] ['3'] ['name_'.$i . '_december__III'] = $arrmedical_data [$employee->ssn] [$i] ['month'] ['12'];
									}
								}
							}
							
							/**
							 * ********************************* Filling section 17-34 END********************************
							 */
							
							$insertresult = $this->Insert1095details ( $arrformdata,$xml_data, $form_id, $created_by );
							if (! empty ( $insertresult ['error'] )) {
								throw new \Exception ( $insertresult ['error'] );
							}
						}
					} // End of # section (i)
				}
			}
			$result ['success'] = 'success';
		} catch ( \Exception $e ) { // catching the exception
		//	print_r($e);
		//	die();
			$result ['error'] = $e->getMessage ().' at line no '.$e->getLine();;
			
		
		}
		
		return $result;
	}
	
	/***
	*Function is used for inserting 1095 details in serialize format for particular employee
	**/
	private function Insert1095details($arrformdata, $xml_data, $form_id, $created_by) {
		if (! empty ( $arrformdata )) {
			/**
			 * Declaring variables***
			 */
			$employee_ssn = '';
			$arr_part1 = array ();
			$arr_part2 = array ();
			$arr_part3 = array ();
			$result = array ();
			
			$model_aca_1095 = new TblAca1095 ();
			
			$serialize_part1 = '';
			$serialize_part2 = '';
			$serialize_part3 = '';
			
			// getting ssn
			$employee_ssn = key ( $arrformdata );
			
			// assigning variable and serializing data
			if (! empty ( $arrformdata [$employee_ssn] ['1'] )) {
				$arr_part1 = $arrformdata [$employee_ssn] ['1'];
				$part1_json = json_encode ( $arr_part1 );
				$serialize_part1 = serialize ( $part1_json );
			}
			
			if (! empty ( $arrformdata [$employee_ssn] ['2'] )) {
				$arr_part2 = $arrformdata [$employee_ssn] ['2'];
				$part2_json = json_encode ( $arr_part2 );
				$serialize_part2 = serialize ( $part2_json );
			}
			
			if (! empty ( $arrformdata [$employee_ssn] ['3'] )) {
				$arr_part3 = $arrformdata [$employee_ssn] ['3'];
				$part3_json = json_encode ( $arr_part3 );
				$serialize_part3 = serialize ( $part3_json );
			}
			
			$serialize_xml_data = serialize ( json_encode ( $xml_data ) );
			
			// begin transaction
			$transaction = \Yii::$app->db->beginTransaction ();
			try {
				$model_aca_1095->form_id = $form_id;
				$model_aca_1095->ssn = $employee_ssn;
				$model_aca_1095->serialise_data1 = $serialize_part1;
				$model_aca_1095->serialise_data2 = $serialize_part2;
				$model_aca_1095->serialise_data3 = $serialize_part3;
				$model_aca_1095->xml_data=$serialize_xml_data;
				$model_aca_1095->created_by = $created_by;
				$model_aca_1095->created_date = date ( 'Y-m-d H:i:s' );
				
				if ($model_aca_1095->save () && $model_aca_1095->validate ()) {
					$transaction->commit ();
					$result ['success'] = 'success';
				} else {
					$arrerrors = $model_aca_1095->getFirstErrors ();
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
				
				$result ['error'] = $e->getMessage ();
				// rollback transaction
				$transaction->rollback ();
			}
		}
		
		return $result;
	}
	/**
	 * *****This function calculates month code for section 14 in 1095C form
	 * ******
	 *
	 * @param array $month_flags        	
	 */
	private function GetmonthCode($month_flags) {
		
		$code = '';
		// if (3.2 =Ã¯Â¿Â½Ã¯Â¿Â½) and ( 10.1.1 !=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.2.1 !=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.3 =yes) and (10.3.1 = yes) and (10.4 =yes)
		if (empty ( $month_flags ['3.2'] ) && ! empty ( $month_flags ['10.1.1'] ) && ! empty ( $month_flags ['10.2.1'] ) && (! empty ( $month_flags ['10.3'] ) && $month_flags ['10.3'] == 1) && (! empty ( $month_flags ['10.3.1'] ) && $month_flags ['10.3.1'] == 1) && (! empty ( $month_flags ['10.4'] ) && $month_flags ['10.4'] == 1) && (! empty ( $month_flags ['9.3'] ) && $month_flags ['9.3'] != 4) ) {
			
			$code = '1k';
		} 	// if (3.2 !=Ã¯Â¿Â½Ã¯Â¿Â½ ) and ( 10.1.1 !=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.2.1 !=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.3 =yes) and (10.3.1 = no) and (10.4 =yes)
		elseif (! empty ( $month_flags ['3.2'] ) && ! empty ( $month_flags ['10.1.1'] ) && ! empty ( $month_flags ['10.2.1'] ) && (! empty ( $month_flags ['10.3'] ) && $month_flags ['10.3'] == 1) && (! empty ( $month_flags ['10.3.1'] ) && $month_flags ['10.3.1'] == 2) && (! empty ( $month_flags ['10.4'] ) && $month_flags ['10.4'] == 1) && (! empty ( $month_flags ['9.3'] ) && $month_flags ['9.3'] != 4)) {
			
			$code = '1A';
		} 		// if (3.2 = Ã¯Â¿Â½Ã¯Â¿Â½) and ( 10.1.1 !=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.2.1!=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.3 =yes) and (10.3.1 = no) and (10.4 =yes
		elseif (empty ( $month_flags ['3.2'] ) && ! empty ( $month_flags ['10.1.1'] ) && ! empty ( $month_flags ['10.2.1'] ) && (! empty ( $month_flags ['10.3'] ) && $month_flags ['10.3'] == 1) && (! empty ( $month_flags ['10.3.1'] ) && $month_flags ['10.3.1'] == 2) && (! empty ( $month_flags ['10.4'] ) && $month_flags ['10.4'] == 1) && (! empty ( $month_flags ['9.3'] ) && $month_flags ['9.3'] != 4)) {
			
			$code = '1E';
		} 		// if (3.2 = Ã¯Â¿Â½Ã¯Â¿Â½) and ( 10.1.1 = Ã¯Â¿Â½Ã¯Â¿Â½) and (10.2.1!=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.3 =yes) and (10.3.1 = yes) and (10.4 =yes)
		elseif (empty ( $month_flags ['3.2'] ) && empty ( $month_flags ['10.1.1'] ) && ! empty ( $month_flags ['10.2.1'] ) && (! empty ( $month_flags ['10.3'] ) && $month_flags ['10.3'] == 1) && (! empty ( $month_flags ['10.3.1'] ) && $month_flags ['10.3.1'] == 1) && (! empty ( $month_flags ['10.4'] ) && $month_flags ['10.4'] == 1) && (! empty ( $month_flags ['9.3'] ) && $month_flags ['9.3'] != 4)) {
			
			$code = '1F';
		} 		// if (3.2 = Ã¯Â¿Â½Ã¯Â¿Â½) and ( 10.1.1!=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.2.1!=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.3 =no) and (10.4 =yes)
		elseif (empty ( $month_flags ['3.2'] ) && ! empty ( $month_flags ['10.1.1'] ) && ! empty ( $month_flags ['10.2.1'] ) && (! empty ( $month_flags ['10.3'] ) && $month_flags ['10.3'] == 2) && (! empty ( $month_flags ['10.4'] ) && $month_flags ['10.4'] == 1) && (! empty ( $month_flags ['9.3'] ) && $month_flags ['9.3'] != 4)) {
			
			$code = '1C';
		} 		// if (3.2 = Ã¯Â¿Â½Ã¯Â¿Â½) and ( 10.1.1!=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.2.1!=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.3 =no) and (10.4 =no)
		elseif (empty ( $month_flags ['3.2'] ) && ! empty ( $month_flags ['10.1.1'] ) && ! empty ( $month_flags ['10.2.1'] ) && (! empty ( $month_flags ['10.3'] ) && $month_flags ['10.3'] == 2)  && (! empty ( $month_flags ['10.4'] ) && $month_flags ['10.4'] == 2) && (! empty ( $month_flags ['9.3'] ) && $month_flags ['9.3'] != 4)) {
			
			$code = '1B';
		} 		// if (3.2 = Ã¯Â¿Â½Ã¯Â¿Â½) and ( 10.1.1!=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.2.1!=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.3 =yes) and (10.3.1 = yes) and (10.4 =no)
		elseif (empty ( $month_flags ['3.2'] ) && ! empty ( $month_flags ['10.1.1'] ) && ! empty ( $month_flags ['10.2.1'] ) && (! empty ( $month_flags ['10.3'] ) && $month_flags ['10.3'] == 1) && (! empty ( $month_flags ['10.3.1'] ) && $month_flags ['10.3.1'] == 1) && (! empty ( $month_flags ['10.4'] ) && $month_flags ['10.4'] == 2) && (! empty ( $month_flags ['9.3'] ) && $month_flags ['9.3'] != 4)) {
			
			$code = '1J';
		} 		// if (3.2 = Ã¯Â¿Â½Ã¯Â¿Â½) and ( 10.1.1!=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.2.1!=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.3 =yes) and (10.3.1 = no) and (10.4 =no)
		elseif (empty ( $month_flags ['3.2'] ) && ! empty ( $month_flags ['10.1.1'] ) && ! empty ( $month_flags ['10.2.1'] ) && (! empty ( $month_flags ['10.3'] ) && $month_flags ['10.3'] == 1) && (! empty ( $month_flags ['10.3.1'] ) && $month_flags ['10.3.1'] == 2) && (! empty ( $month_flags ['10.4'] ) && $month_flags ['10.4'] == 2) && (! empty ( $month_flags ['9.3'] ) && $month_flags ['9.3'] != 4)) {
			
			$code = '1D';
		} 		// if (3.2 = Ã¯Â¿Â½Ã¯Â¿Â½) and ( 10.1.1!=Ã¯Â¿Â½Ã¯Â¿Â½) and (10.2.1 =Ã¯Â¿Â½Ã¯Â¿Â½) and (10.3 =yes) and (10.3.1 = yes) and (10.4 =yes)
		elseif (empty ( $month_flags ['3.2'] ) && ! empty ( $month_flags ['10.1.1'] ) && empty ( $month_flags ['10.2.1'] ) && (! empty ( $month_flags ['10.3'] ) && $month_flags ['10.3'] == 1) && (! empty ( $month_flags ['10.3.1'] ) && $month_flags ['10.3.1'] == 1) && (! empty ( $month_flags ['10.4'] ) && $month_flags ['10.4'] == 1)) {
			
			$code = '1H';
		}else{
			$code = '1H';
		} 		
	
		
		return $code;
	}
	
	/***
	*Function is used for saving errors if any occurred in form creation, pdf generation, print & mail
	**/
	private function Saveerrors($arrerror) {
		//print_r($arrerror); die();
		$model_form_errors = new TblAcaFormErrors ();
		
		try {
			
			$model_form_errors->error_desc = $arrerror ['error_desc'];
			$model_form_errors->error_type = $arrerror ['error_type']; // error_type 1= 1094, 2=1095, 3=pdf generation, 4= print & mail
			$model_form_errors->created_date = date ( 'Y-m-d H:i:s' );

			if(!empty($arrerror ['company_id'])){
			$model_form_errors->company_id = $arrerror ['company_id'];
			}
			
			if ($model_form_errors->validate () && $model_form_errors->save ()) {
				//echo 'hi'; die();
			}
		} catch ( \Exception $e ) { // catching the exception
			//print_r($e); die();
			$e->getMessage ();
			// rollback transaction
		//	$transaction->rollback ();
		}
	}
	
	/***
	*Function is used for generating 1094 and 1095c pdf
	**/
	
	public function actionGeneratepdf() {
		
			ini_set ( 'memory_limit', '1024M' );
		ini_set ( 'max_execution_time', 3600 );
		ini_set ( 'max_input_time', 3600 );
		
		//Initializing
		$encrypt_decrypt_component = new EncryptDecryptComponent();
		$model_aca_pdf_forms = new TblAcaPdfForms();
		$model_companies = new TblAcaCompanies();
		
		try{
		/**
		 * ********Getting all refrence file location********
		 */
		$filepath = '/files/1094.pdf';
		$filepath_1095 = '/files/1095.pdf';
		$single_page_filepath_1095 = '/files/onepage1095.pdf';
		$address_1095_filepath = '/files/1095Address.pdf';
		
		/**
		 * ******Query from DB*********
		 */
		
		// get all 1094 fields
		$arr_1094_pdf_fields = Tbl1094PdfFields::find ()->select ( 'field_label, field_name, field_type, field_value' )->asArray ()->All ();
		
		// get all 1095 fields
		$arr_1095_pdf_fields = Tbl1095PdfFields::find ()->select ( 'field_label, field_name, field_type, field_value, is_ssn' )->asArray ()->All ();
		
		// Check if cron is already started
		$check_cron = TblAcaPdfGenerate::find ()->select ( 'form_id' )->where ( [ 
				'status' => 1 
		] )->asArray ()->One ();
		
		if (empty ( $check_cron )) {
			// get all form were status = 0
			$forms = TblAcaPdfGenerate::find ()->select ( 'id, form_id, created_by, status' )->where ( [ 
					'status' => 0 
			] )->All ();
			
			if (! empty ( $forms )) {
				foreach ( $forms as $form ) {
					
					

					
					$form_id = $form->form_id;
					$created_by = $form->created_by;
					
					$form_details = TblAcaForms::find ()->select ( 'company_id,version' )->where ( [ 
							'id' => $form_id 
					] )->One ();
					$company_id = $form_details->company_id;
					$clean_version = floatval($form_details->version);
					
					//Update form status to started
					$generate_model = TblAcaPdfGenerate::find()->where(['form_id'=>$form_id])->One();
					$generate_model->status = 1;
					
					if($generate_model->validate() && $generate_model->save())
					{
					$company_name = '';
					$clean_company_name = '';
					
					//Encrypting ids for creating folders
					$encrypt_form_id = $encrypt_decrypt_component->encrytedUser($form_id);
					$encrypt_company_id = $encrypt_decrypt_component->encrytedUser($company_id);
					
					//getting company_details 
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
					$company_name = $check_company_details->company_name;
					$clean_company_name = preg_replace('/[^A-Za-z0-9]/', "_", $company_name); //cleaning company name
					/**
					 * ******Creating directories*************
					 */
					 
					 if (! is_dir (  getcwd () . '/files/pdf')) {
						 mkdir (  getcwd () . '/files/pdf', 0777);
						}
					
					 if (! is_dir (  getcwd () . '/files/temp_pdf')) {
						 mkdir ( getcwd () . '/files/temp_pdf', 0777);
						}
					
					if (! is_dir ( getcwd () . '/files/pdf/' . $encrypt_company_id)) {
						 mkdir ( getcwd () . '/files/pdf/' . $encrypt_company_id, 0777);
						}
				
					if (! is_dir ( getcwd () . '/files/pdf/' . $encrypt_company_id . '/' . $encrypt_form_id)) {
						 mkdir (  getcwd () . '/files/pdf/' . $encrypt_company_id . '/' . $encrypt_form_id, 0777);
						}
					
					$save_file_1094 = 'files/pdf/' . $encrypt_company_id . '/' . $encrypt_form_id . '/' . $company_id . '_' . $form_id . '_1094_filled.pdf';
					$save_file_1095 = 'files/pdf/' . $encrypt_company_id . '/' . $encrypt_form_id . '/' . $company_id . '_' . $form_id . '_consolidate_1095.pdf';
					$save_masked_file_1095 = 'files/pdf/' . $encrypt_company_id . '/' . $encrypt_form_id . '/' . $company_id . '_' . $form_id . '_consolidate_masked_1095.pdf';
					
					// Check if file exists with same names
					if (file_exists ( $save_file_1094 )) {
						unlink ( $save_file_1094 );
					}
					
					if (file_exists ( $save_file_1095 )) {
						unlink ( $save_file_1095 );
					}
					
					if (file_exists ( $save_masked_file_1095 )) {
						unlink ( $save_masked_file_1095 );
					}
					
					/**
					 * block to create 1094 pdf
					 */
					$arr_1094_pdf_data = TblAca1094::find ()->where ( [ 
							'form_id' => $form_id 
					] )->one ();
					
					if (! empty ( $arr_1094_pdf_data )) {
						
						$part4 =  array ();
						$part3 =  array ();
						$part2 =  array ();
						$part1 =  array ();
						$each_form = array ();
						
						if(!empty($arr_1094_pdf_data->serialise_data1))
								{
						$part1 = json_decode ( unserialize ( $arr_1094_pdf_data->serialise_data1 ), true );
								}
								
								if(!empty($arr_1094_pdf_data->serialise_data2))
								{
						$part2 = json_decode ( unserialize ( $arr_1094_pdf_data->serialise_data2 ), true );
								}
								
								if(!empty($arr_1094_pdf_data->serialise_data3))
								{
						$part3 = json_decode ( unserialize ( $arr_1094_pdf_data->serialise_data3 ), true );
								}
								
								if(!empty($arr_1094_pdf_data->serialise_data4))
								{
						$part4 = json_decode ( unserialize ( $arr_1094_pdf_data->serialise_data4 ), true );
								}
								
						$each_form = array_merge_recursive ( $part1, $part2, $part3, $part4 );
						
						$arr_full_ssn_data = array ();
						
						foreach ( $arr_1094_pdf_fields as $pdf_field ) {
							
							$label = $pdf_field ['field_label'];
							$column = $pdf_field ['field_name'];
							
							if (isset ( $each_form [$label] )) {
								if ($pdf_field ['field_type'] == '' || $pdf_field ['field_type'] == 'checkbox') {
									if ($each_form [$label] == 1) {
										$arr_full_ssn_data [$column] = $pdf_field ['field_value'];
									}
								} else {
									$arr_full_ssn_data [$column] = $each_form [$label];
								}
							}
						}
						
						/**
						 * end block to create 1094 pdf
						 */
						
						/*
						 * pdf ssaving for 1094
						 */
						$pdf = new Pdf ( $filepath,['command' => '/usr/local/bin/pdftk','useExec' => true,]);
						$pdf->fillForm ( $arr_full_ssn_data )->compress()->flatten()->saveAs ( $save_file_1094 );
						
						/**
						 * block to create 1095 pdf
						 */
						$arr_1095_pdf_data = array ();
						
						$arr_1095_pdf_data = TblAca1095::find ()->where ( [ 
								'form_id' => $form_id 
						] )->all ();
						
						$i = 0;
						
						if (! empty ( $arr_1095_pdf_data )) {
							foreach ( $arr_1095_pdf_data as $each_pdf_form ) {
								
								$i ++;
								$part3 = array ();
								$part2 = array ();
								$part1 = array ();
								$each_form = array ();
								
								if(!empty($each_pdf_form->serialise_data1))
								{
								$part1 = json_decode ( unserialize ( $each_pdf_form->serialise_data1 ), true );
								}
								
								if(!empty($each_pdf_form->serialise_data2))
								{
								$part2 = json_decode ( unserialize ( $each_pdf_form->serialise_data2 ), true );
								}
								
								if(!empty($each_pdf_form->serialise_data3))
								{
								$part3 = json_decode ( unserialize ( $each_pdf_form->serialise_data3 ), true );
								}
								
								$each_form = array_merge_recursive ( $part1, $part2, $part3 );
								
								$arr_full_ssn_data = array ();//array for unmasked data
								$arr_masked_ssn_data = array (); //array for masked data
								
								foreach ( $arr_1095_pdf_fields as $pdf_field ) {
									
									$label = $pdf_field ['field_label'];
									$column = preg_replace("/[\n\r]/","",$pdf_field ['field_name']);
									$is_ssn = $pdf_field ['is_ssn'];
									
									
									if (isset ( $each_form [$label] ) && $each_form [$label] != '') {
										if ($pdf_field ['field_type'] == 'checkbox') {
											if ($each_form [$label] == 1) {
												$arr_masked_ssn_data [$column] = $pdf_field ['field_value'];
											}
										} else {
											// code for masking ssn
											if ($is_ssn == 1) {
												$arr_masked_ssn_data [$column] = str_pad ( substr ( $each_form [$label], - 4 ), strlen ( $each_form [$label] ), '*', STR_PAD_LEFT );
											} else {
												$arr_masked_ssn_data [$column] = $each_form [$label];
											}
											
										}
									}
								}
								
								
								$masked_ssn_file_1095 = 'files/temp_pdf/' . $company_id . '_' . $form_id . '_1095_masked_data_filled.pdf';
								
								if (isset ( $part3 ['name_23_ssn__III'] ) && $part3 ['name_23_ssn__III'] != '') {
									$pdf = new Pdf ( $filepath_1095,['command' => '/usr/local/bin/pdftk','useExec' => true,] );
									$pdf->fillForm ( $arr_masked_ssn_data )->compress()->flatten()->saveAs ( $masked_ssn_file_1095 );
								} else {
									$pdf = new Pdf ( $single_page_filepath_1095,['command' => '/usr/local/bin/pdftk','useExec' => true,] );
									$pdf->fillForm ( $arr_masked_ssn_data )->compress()->flatten()->saveAs ( $masked_ssn_file_1095 );
								}
								
								$file_address_name = 'files/temp_pdf/' . $i . '_1095_filled.pdf';
								
								$masked_file_address_name = 'files/temp_pdf/' . $i . '_1095_masked_filled.pdf';
								
								// creating 1095 address pdf file
								$pdf = new Pdf ( $address_1095_filepath,['command' => '/usr/local/bin/pdftk','useExec' => true,] );
								$pdf->fillForm ( [ 
										'Company Name' => $part1 ['employer_name__I'],
										'Employee Name' => $part1 ['employee_name__I'],
										'Employee Address' => $part1 ['employee_street_Address__I'],
										'Company Address' => $part1 ['employer_street_address__I'],
										'Company City, ST, ZIP' => $part1 ['employer_city_town__I'] . ', ' . $part1 ['employer_state_province__I'] . ', ' . $part1 ['employer_country_and_zip__I'],
										'Employee City, ST, ZIP' => $part1 ['employee_city_or_town__I'] . ', ' . $part1 ['employee_state_province__I'] . ', ' . $part1 ['employee_country_and_zip_code__I'] 
								] )->compress()->flatten()->saveAs ( $file_address_name );
								
								// creating 1095 with address pdf file
								$pdf = new Pdf ( [$file_address_name,$masked_ssn_file_1095],['command' => '/usr/local/bin/pdftk','useExec' => true,] );
								$pdf->compress()->flatten()->saveAs ( $masked_file_address_name );
								
							
								// deleting the file
								if (file_exists ( $file_address_name )) {
									unlink ( $file_address_name );
								}
								
								
								if (file_exists ( $masked_ssn_file_1095 )) {
									unlink ( $masked_ssn_file_1095 );
								}
							}
							
							/**
							 * end block to create 1095 pdf
							 */
							
							$arr_1095_pdfs = array ();
							$arr_1095_masked_pdfs = array ();
							
							$arr_1095_merge_pdfs = array();
							$arr_1095_partial_merged_pdfs = array();
							
							$z=0;
							for($j=1,$k=1; $j <= $i; $j++,$k++) {
								//array_push ( $arr_1095_pdfs, 'files/temp_pdf/' . $j . '_1095_filled.pdf' );
								array_push ( $arr_1095_masked_pdfs, 'files/temp_pdf/' . $j . '_1095_masked_filled.pdf' );
								array_push ( $arr_1095_merge_pdfs, 'files/temp_pdf/' . $j . '_1095_masked_filled.pdf' );
								
								if($k==50){
									$k=0;
									$z++;
									
									$pdf = new Pdf ( $arr_1095_merge_pdfs,['command' => '/usr/local/bin/pdftk','useExec' => true,] );
									$pdf->compress()->flatten()->saveAs('files/temp_pdf/' . $z . '_1095_merge_filled.pdf' );
									
									array_push ( $arr_1095_partial_merged_pdfs, 'files/temp_pdf/' . $z . '_1095_merge_filled.pdf' );
									
									$arr_1095_merge_pdfs=array();
								}
								
							}
							
														
							$arr_complete_merge_data=array_merge ( $arr_1095_partial_merged_pdfs,$arr_1095_merge_pdfs );
							
							$pdf = new Pdf ( $arr_complete_merge_data,['command' => '/usr/local/bin/pdftk','useExec' => true,] );
							$pdf->saveAs ( $save_masked_file_1095 );
							
							for($j = 1; $j <= $i; $j ++) {
								//for($j = 1; $j <= 10; $j ++) {
								if (file_exists ( 'files/temp_pdf/' . $j . '_1095_filled.pdf' )) {
									unlink ( 'files/temp_pdf/' . $j . '_1095_filled.pdf' );
								}
								
							
							if (file_exists ( 'files/temp_pdf/' . $j . '_1095_masked_filled.pdf' )) {
									unlink ( 'files/temp_pdf/' . $j . '_1095_masked_filled.pdf' );
								}
								
							
								if (file_exists ( 'files/temp_pdf/' . $j . '_1095_merge_filled.pdf' )) {
									unlink ( 'files/temp_pdf/' . $j . '_1095_merge_filled.pdf' );
								}
								
							}
						}
					}
					
					
					//Creating file zip
					if (file_exists ( 'files/pdf/' . $encrypt_company_id . '/' . $encrypt_form_id )) {
						
						$zip_time = time();
						//check if zip file exists or not
						if (file_exists ( 'files/pdf/' . $encrypt_company_id . '/' . $clean_company_name.'_'.$clean_version.'_'.$zip_time. '.zip'  )) {
							
								unlink ( 'files/pdf/' . $encrypt_company_id . '/' . $clean_company_name.'_'.$clean_version.'_'.$zip_time.'.zip' );
								
						}
								
						$result_zip = \Yii::$app->Sharefile->zipaDirectory ( getcwd () . '/files/pdf/' . $encrypt_company_id . '/' . $encrypt_form_id . '/', getcwd () . '/files/pdf/' . $encrypt_company_id . '/' . $clean_company_name.'_'.$clean_version .'_'.$zip_time. '.zip' );
					
						if(!empty($result_zip) && $result_zip == 'success')
						{
							//deleting all record if exists
							
							TblAcaPdfForms::deleteAll ( 'form_id = :form_id ', [
								':form_id' => $form_id
								] );
								
							$model_aca_pdf_forms->form_id =  $form_id;
							$model_aca_pdf_forms->pdf_zip_name =  $clean_company_name.'_'.$clean_version.'_'.$zip_time;
							$model_aca_pdf_forms->is_changed =  0;
							$model_aca_pdf_forms->created_by =  $created_by;
							$model_aca_pdf_forms->created_date =  date('Y-m-d H:i:s');
							$model_aca_pdf_forms->isNewRecord = True;
							$model_aca_pdf_forms->id = null;
								
							if($model_aca_pdf_forms->validate() && $model_aca_pdf_forms->save()){
					
								TblAcaPdfGenerate::deleteAll ( 'form_id = :form_id AND status = 1 ', [
								':form_id' => $form_id
								] );
								
								//check if form is ready for print and mail
								$check_print = TblAcaPrintAndMail::find()->where(['form_id'=>$form_id,'is_printed'=>0])->One();
								
								if(!empty($check_print))
								{
									$filepath= '';
									$file_name = '';
									
									
									$check_company_details = $model_companies->Companyuniquedetails ( $company_id ); // Company details
									$company_name = $check_company_details->company_name;
									$clean_company_name = preg_replace('/[^A-Za-z0-9]/', "_", $company_name); //cleaning company name
									
									//encrypt company and form id
									
									//creating local file path
									$filepath = getcwd () . '/files/pdf/' . $encrypt_company_id . '/'.$encrypt_form_id.'/'.$company_id.'_'.$form_id.'_consolidate_masked_1095.pdf' ;
									$file_name = $clean_company_name.'_'.time().'.pdf';
									//check if file exists in location
						
									if(file_exists($filepath)){
										/*********details for mail***************/
										$bulk_mail_fee = '';
										$packaging_shipping_cost = '';
										$forms_amount = $check_print->total_processing_amount;
										if($check_print->person_type == 1){
											$type = 'Employer';
											
											//get form pricing
											$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>[9,18],'type'=>1])->asArray()->all();
											
											$packaging_shipping_cost = $model_formpricing[0]['value'];
											$bulk_mail_fee = $model_formpricing[1]['value'];
											
										}elseif($check_print->person_type == 2){
											$type = 'Employee';
											
											//get form pricing
											$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>[19],'type'=>2])->asArray()->all();
											
											$bulk_mail_fee = $model_formpricing[0]['value'];
											
										}else{
											
											$type='';
											$model_formpricing = '';
											$bulk_mail_fee = '';
											$packaging_shipping_cost = '';
										}
										$model_globalsettings = TblAcaGlobalSettings::find()->select(['value'])->where(['setting_id'=>[1,5]])->asArray()->all();
										
										$from_email = $model_globalsettings[0]['value'];
										
										$to_email = $model_globalsettings[1]['value'];
										
										
										
										
										$clients_details = TblAcaClients::Clientuniquedetails($check_company_details->client_id);
										$model_brands = TblAcaBrands::Branduniquedetails ( $clients_details->brand_id );
										$brand_emailid=$model_brands->support_email;
										
										
										$print_details = array(
												'company_name'=>$check_print->form->company->company_name,
												'client_name'=>$check_print->form->company->client->client_name,
												'printed_by'=>$check_print->username->first_name.' '.$check_print->username->last_name,
												'print_date'=>$check_print->form->modified_date_print,
												'no_form_print'=>$check_print->no_of_forms,
												'amount'=>$forms_amount,
												'sent_to'=>$type,
												'expedite_fee'=>$check_print->expedite_processing_fee,
												'to'=>$to_email,
												'from'=>$brand_emailid,
												'price_per_form'=>$check_print->price_per_form,
												'bulk_mailing_fee'=>$bulk_mail_fee,
												'packaging_shipping_cost'=>$packaging_shipping_cost
												
										);
						
										$upload_result = $this->uploadpdffiles($filepath,$file_name,$check_print->person_type,$print_details);
										
										if(!empty($upload_result['error']))
										{
											throw new \Exception ($upload_result['error']);
										}
										else
										{
											$check_print->is_printed = 1;
											$check_print->save();
										}
										
									}
									
								}
								else{
									// sending mail
									$model_globalsettings = TblAcaGlobalSettings::find()->select(['value'])->where(['setting_id'=>[1]])->asArray()->all();
									
									$from_email = $model_globalsettings[0]['value'];
									
									$to = $forms->username->email;
									\Yii::$app->CustomMail->GeneratepdfMail ( $to, $from_email, $form_details ); 
									
								}
					
							}
								
								
						}
					}
					
				}
				
					
				}
			}
		}
		
		} catch ( \Exception $e ) { // catching the exception
				
			$msg = $e->getMessage ().' at line no '.$e->getLine();
			
			$arrerror ['error_desc'] = $msg;
			$arrerror ['error_type'] = 3;

			if(!empty($company_id)){
				$arrerror ['company_id'] = $company_id;
			}
				
			// Below function saves exceptions if occurs
			$this->Saveerrors ( $arrerror );
		}
		
	}
	
	
	
	/*
	 * action used for for expedite type
	*/
	public function actionPersontypedetails(){
	
		  if (\Yii::$app->SessionCheck->isclientLogged () == true) { // checking logged session
 
   $session = \Yii::$app->session; // declaring session
   $logged_user_id = $session ['client_user_id'];
   $array_printvalues=array();
   $encrypt_component = new EncryptDecryptComponent ();
   $post_values = \yii::$app->request->post (); // getting post values
    
   if($post_values){
 
   $encrypt_company_id = $post_values['company_id'];
      $encrpypt_form_id = $post_values['form_id'];
      $company_id = $encrypt_component->decryptUser ( $encrypt_company_id );
   $form_id = $encrypt_component->decryptUser ( $encrpypt_form_id );
   //$approved_form = TblAcaForms::find()->select('id')->where(['company_id'=>$company_id,'is_approved'=>1])->One();
   $model_1095c_ssn = TblAca1095::find ()->select('ssn')->where(['form_id'=>$form_id])->count(); 
    
             $model_employer_package_cost = TblAcaFormPricing::find()->select('value')->where(['price_id'=>9])->one();
    //for employer
    if($post_values['value'] ==1 ){
      
      $arrtotvalues = $this->Getpricevalues(1 ,$model_1095c_ssn);
      $arrtotvalues['package_cost'] =$model_employer_package_cost->value;
    
      array_push($array_printvalues,$arrtotvalues);
     
     
     //for employee
    }else if($post_values['value'] ==2){
     
     $arrtotvalues = $this->Getpricevalues(2 ,$model_1095c_ssn);
     $arrtotvalues['package_cost'] =$model_employer_package_cost->value;
      array_push($array_printvalues,$arrtotvalues);
    }else{
     $array_printvalues['error']='some error occured';
    }
   }else{
    $array_printvalues['error']='Some Error Occured, Please try again';
   }
    
    
   return json_encode($array_printvalues);
    
  } else {
   \Yii::$app->SessionCheck->clientlogout (); // session expires then logouts
 
   return $this->goHome ();
  }
	}
	
	
	
	/***
	 *Function is used for getting price amount for printing forms
	 *@param $type INT value employee or employer
	 *@param $model_1095c_ssn INT count of SSN to be printed
	**/
	private function Getpricevalues($type ,$model_1095c_ssn) {

	
		$arrtotvalues= array();
		
		//for employer
		if($type ==1 ){
		
			switch ($model_1095c_ssn) {
				case ($model_1095c_ssn >0 && $model_1095c_ssn < 1000 ):
					$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>1])->one();
					$price_value =$model_formpricing->value;
					break;
				case ($model_1095c_ssn >1001 && $model_1095c_ssn < 5000 ):
					$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>2])->one();
					$price_value =$model_formpricing->value;
					break;
				case ($model_1095c_ssn >5001 && $model_1095c_ssn < 10000 ):
					$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>3])->one();
					$price_value =$model_formpricing->value;
					break;
				case ($model_1095c_ssn >10001 && $model_1095c_ssn < 25000 ):
					$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>4])->one();
					$price_value =$model_formpricing->value;
					break;
				case ($model_1095c_ssn >25001 && $model_1095c_ssn < 50000 ):
					$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>5])->one();
					$price_value =$model_formpricing->value;
					break;
				case ($model_1095c_ssn >50001 && $model_1095c_ssn < 75000 ):
					$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>6])->one();
					$price_value =$model_formpricing->value;
					break;
				case ($model_1095c_ssn >75000 && $model_1095c_ssn < 100000 ):
					$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>7])->one();
					$price_value =$model_formpricing->value;
					break;
				case ($model_1095c_ssn >100000  ):
					$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>8])->one();
					$price_value = $model_formpricing->value;
					break;
		
				default:
					$price_value = 50;
					break;
						
					
			}
				$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>18])->one();
				
				$arrtotvalues= array ('expedite_value' =>$model_formpricing->value,
						'price_value'=>$price_value);
				
				
				
				
			
	          }else if($type ==2){
					
					
						switch ($model_1095c_ssn) {
					case ($model_1095c_ssn >0 && $model_1095c_ssn < 1000 ):
						$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>10])->one();
						$price_value =$model_formpricing->value;
						break;
					case ($model_1095c_ssn >1001 && $model_1095c_ssn < 5000 ):
						$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>11])->one();
						$price_value =$model_formpricing->value;
						break;
					case ($model_1095c_ssn >5001 && $model_1095c_ssn < 10000 ):
						 $model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>12])->one();
						 $price_value =$model_formpricing->value;
						break;
					case ($model_1095c_ssn >10001 && $model_1095c_ssn < 25000 ):
						$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>13])->one();
						$price_value =$model_formpricing->value;
						break;
					 case ($model_1095c_ssn >25001 && $model_1095c_ssn < 50000 ):
						$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>14])->one();
						$price_value =$model_formpricing->value;
						break;
					 case ($model_1095c_ssn >50001 && $model_1095c_ssn < 75000 ):
						$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>15])->one();
						$price_value =$model_formpricing->value;
						break;
					 case ($model_1095c_ssn >75000 && $model_1095c_ssn < 100000 ):
						$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>16])->one();
						$price_value =$model_formpricing->value;
						break;
					 case ($model_1095c_ssn >100000  ):
						$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>17])->one();
						$price_value = $model_formpricing->value;
						break;  

						default:
							$price_value = 50;
							break;
							
						
				} 
				
				$model_formpricing = TblAcaFormPricing::find()->select('value')->where(['price_id'=>19])->one();
					
				$arrtotvalues= array ('expedite_value' =>$model_formpricing->value,
						'price_value'=>$price_value);
	
				
	}
	
	return $arrtotvalues;
	}
	
	
}
