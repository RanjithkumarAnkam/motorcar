<?php

namespace app\modules\admin\controllers;

use yii;
use yii\web\Controller;
use app\models\Clients;
use app\models\TblAcaClients;
use app\models\TblAcaUsers;
use app\models\TblAcaStaffUsers;
use app\models\TblAcaBrands;
use yii\base\ErrorException;
use yii\base\Exception;
use app\models\TblAcaCompanies;
use app\models\TblAcaCompanyReportingPeriod;
use app\models\TblAcaSharefileEmployees;
use app\models\TblAcaClientsSearch;
use yii\db\Query;
use app\components\EncryptDecryptComponent;
use app\models\TblAcaSharefileFolders;
use app\models\TblAcaCompanyUsers;
use app\models\TblAcaCompanyUserPermission;
use app\components\MailComponent;
/**
 * Default controller for the `admin` module
 */
class ClientsController extends Controller {
	/**
	 * Renders the index view for the module
	 *
	 * @return string
	 */
	public function actionIndex() {
		$this->layout = 'main'; 
		$session = \Yii::$app->session;
		$admin_permissions = array();
		
		if(!empty($session ['admin_permissions'])){
		$admin_permissions = $session ['admin_permissions'];
		}
		
		if (\Yii::$app->SessionCheck->isLogged () == true && in_array ( '3', $admin_permissions ) == true) 		// checking logged session
		{
			/*
			 * Query to get all the client records
			 */
			$searchModel = new TblAcaClientsSearch ();
			$dataProvider = $searchModel->search ( \Yii::$app->request->queryParams );
			
			return $this->render ( 'index', [ 
					'dataProvider' => $dataProvider,
					'searchModel' => $searchModel 
			] );
			
		} else {
			
			\Yii::$app->SessionCheck->adminlogout ();
			
			return $this->goHome ();
		}
	}
	public function actionGetbrandthree() {
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$get = \Yii::$app->request->get ();
			$id = $get ['value'];
			$clientid = null;
			if (! empty ( $get ['clientid'] )) {
				$clientid = $get ['clientid'];
			}
			$model = TblAcaBrands::Branduniquedetails ( $id );
			$myBrand = $model->brand_name;
			$result = substr ( $myBrand, 0, 3 );
			return $result . '' . '-' . '' . $clientid;
		} else {
			
			\Yii::$app->SessionCheck->adminlogout ();
			
			return $this->goHome ();
		}
	}
	
	/*
	 * This function is used to add a new client and also provides the login access to the client base on the email id and also adds the companies based on the sub ein count
	 */
	public function actionAddform() {
		\Yii::$app->view->title = 'ACA Reporting Service | Add Clients';
		$this->layout = 'main';
		$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];
		if (\Yii::$app->SessionCheck->isLogged () == true && in_array ( "3", $admin_permissions )) 		// checking logged session
		{
			$logged_user_id = $session ['admin_user_id'];
			/* Intializing an object */
			$new_client = new TblAcaClients ();
			$new_staff_user = new TblAcaStaffUsers ();
			$model_user = new TblAcaUsers ();
			$client_mail_details = array ();
			$client_mail_details['client_name']='';
			$client_mail_details['client_brand']='';
			
			$new_client->ein_count = 1;
			/* Check for post variables */
			if ($new_client->load ( \Yii::$app->request->post () )) {
				
				/* begining the db transaction */
				$transaction = \Yii::$app->db->beginTransaction ();
				try {
					
					/* collecting the post variables */
					$post = \Yii::$app->request->post ();
					
					/* Assiging the values */
					$new_client->attributes = $post ['TblAcaClients'];
					$new_client->client_number = $post ['TblAcaClients'] ['client_name'];
					
					/* Checking for client name unique */
					
					$old_year = $post ['TblAcaClients'] ['aca_year'];
					$client_name = $post ['TblAcaClients'] ['client_name'];
					$name_email = $post ['TblAcaClients'] ['contact_first_name'];
					$model_check = $new_client->checkduplicatename ( $client_name, $old_year );
					
					if (empty ( $model_check )) {
						
						/* Reporting Structure */
						$reporting_structure = $post ['TblAcaClients'] ['reporting_structure'];
						if ($reporting_structure == 15) 						// 15 Denotes Single EIN
						{
							$new_client->ein_count = 1;
							/* Sub EIN Count */
							$ein_count = 1;
						} else {
							$ein_count = $post ['TblAcaClients'] ['ein_count'];
						}
						
						$client_name = $post ['TblAcaClients'] ['client_name'];
						/* Reporting Year */
						$reporting_year = $post ['TblAcaClients'] ['aca_year'];
						
						/* Contact person email */
						$email_id = $post ['TblAcaClients'] ['email'];
						$check_email = $this->checkemailid ( $email_id ); // check email exists or not
						
						if ($check_email ['result'] == 0 || $check_email ['result'] == 2 || $check_email ['result'] == 3) {
							
							if ($check_email ['result'] == 0) 							// new user
							{
								$user_details = $this->addclientuser ( $email_id ); // adding new user
								$user_id = $user_details ['user_id'];
								$random_salt = $user_details ['random_salt'];
							} elseif ($check_email ['result'] == 2 || $check_email ['result'] == 3) 							// old client user
							{
								$user_id = $check_email ['user_id'];
							}
							
							$new_client->user_id = $user_id;
							$new_client->created_by = $logged_user_id;
							
							/* validating and saving the model */
							if ($new_client->validate () && $new_client->save ()) {
								
								/* collecting the last inserted id */
								$insert_id = $new_client->client_id;
								
								/* Collecting the first three charecters of the brand and saving it as client number */
								$model = TblAcaBrands::Branduniquedetails ( $new_client->brand_id );
								$brand_emailid = $model->support_email;
								$brand_phonenumber = $model->support_number;
								if (! empty ( $model->brand_logo )) {
									$picture = 'profile_image/brand_logo/' . $model->brand_logo;
								} else {
									$picture = 'ACA-Reporting-Logo.png';
								}
								$brand_name = substr ( $model->brand_name, 0, 3 );
								$new_client->client_number = $brand_name . '-' . $insert_id;
								
								/* saving the model */
								if ($new_client->save ()) {
									
									$client_number = $new_client->client_number;
									
									/**
									 * client company user details*
									 */
									$companyuser_details ['first_name'] = $new_client->contact_first_name;
									$companyuser_details ['last_name'] = $new_client->contact_last_name;
									$companyuser_details ['phone'] = $new_client->phone;
									$companyuser_details ['email'] = $new_client->email;
									$companyuser_details ['address_1'] = '';
									$companyuser_details ['address_2'] = '';
									$companyuser_details ['state'] = '';
									$companyuser_details ['city'] = '';
									$companyuser_details ['zip'] = '';
									$companyuser_details ['role_notes'] = 'Company Admin';
									/* Add company to client */
									
									$client_company = $this->addclientcompany ( $insert_id, $user_id, $client_number, $reporting_year, $ein_count, $client_name, $companyuser_details );
									
									/**
									 * * creating sharefile account **
									 */
									$client_details = $new_client->Clientuniquedetails ( $insert_id );
									$firstname = $client_details->contact_first_name;
									$lastname = $client_details->contact_last_name;
									$email = $client_details->email;
									
									/**
									 * * getting sharefile credentials **
									 */
									$share_file = json_decode ( file_get_contents ( getcwd () . '/config/sharefile-credentials.json' ) );
									
									$hostname = $share_file->hostname;
									$username = $share_file->username;
									$password = $share_file->password;
									$client_api_id = $share_file->client_api_id;
									$client_secret = $share_file->client_secret;
									if ($check_email ['result'] == 0) 									// new user
									{
										// $instance = \Yii::$app->Sharefile->create_employee($hostname, $client_api_id, $client_secret, $username, $password, $insert_id, $user_id, $email_id, $firstname, $lastname);
										$instance = \Yii::$app->Sharefile->create_sharefile_folder ( $hostname, $client_api_id, $client_secret, $user_id, $insert_id, $username, $password );
										
										// / creating sharefile client ////
										if ($instance == 'success') {
											$client_instance = \Yii::$app->Sharefile->create_client ( $hostname, $client_api_id, $client_secret, $username, $password, $email, $firstname, $lastname, $insert_id, $user_id );
											$response = json_decode ( $client_instance );
											if ($response->result == 'success') {
												$sharefile_client_id = $response->id;
												// / getting the list of availble folders ///
												$sharefile_folders = TblAcaSharefileFolders::find ()->where ( [ 
														'user_id' => $user_id 
												] )->All ();
												$count = count ( $sharefile_folders );
												$i = 0;
												foreach ( $sharefile_folders as $folders ) {
													$sharefile_folder_id = $folders->sharefile_folder_id;
													// / assigning permission of folders
													$access_control = \Yii::$app->Sharefile->access_control ( $hostname, $client_api_id, $client_secret, $username, $password, $sharefile_folder_id, $sharefile_client_id );
													if ($access_control != '') {
														$i ++;
													}
												}
												if ($count == $i) {
													/* commiting the values to the db */
													$transaction->commit ();
													/*** trigger emails ***/
													$to = $email_id;
										
													$link = \Yii::$app->urlManager->createAbsoluteUrl ( '/setaccount' ) . '?random_salt=' . $random_salt . '&id=' . md5 ( $user_id );
													
													
													$email_logo_link = (new MailComponent())->Custombrandemaillogo($new_client->brand_id);
													
													if($email_logo_link!=''){
														$picture=$email_logo_link;
													}
													
													
													$link_brandimage = \Yii::$app->urlManager->createAbsoluteUrl ( '/Images' ) . '/' . $picture;
													
													
													\Yii::$app->CustomMail->Createadminusermail ( $to, $brand_emailid, $name_email, $link, $brand_phonenumber, $link_brandimage ); // , $brand_emailid
																
													
													\Yii::$app->session->setFlash ( 'success', 'Client successfully added' );
												} else {
													$transaction->rollback ();
													\Yii::$app->session->setFlash ( 'error', 'Client unable to add. Please try again (Error Code: A001)' );
												}
											} else {
												$transaction->rollback ();
												\Yii::$app->session->setFlash ( 'error', 'Client unable to add. Please try again (Error Code: C001)' );
												//print_r($response);die();
											}
										} else {
											$transaction->rollback ();
											\Yii::$app->session->setFlash ( 'error', 'Client unable to add. Please try again (Error Code: F001)' );
											//print_r($instance);die();
										}
									} elseif ($check_email ['result'] == 2 || $check_email ['result'] == 3) 									// old client user
									{
										$new_company_details = TblAcaCompanies::find ()->where ( [ 
												'client_id' => $insert_id 
										] )->All ();
										$sharefile_login_deails = TblAcaSharefileEmployees::find ()->where ( [ 
												'username' => $email_id 
										] )->One ();
										if (! empty ( $sharefile_login_deails )) {
											$sharefile_client_id = $sharefile_login_deails->sharefile_employee_id;
											if (! empty ( $new_company_details )) {
												$count = count ( $new_company_details );
												$i = 0;
												foreach ( $new_company_details as $company_details ) {
													$name = $company_details->company_client_number;
													$company_id = $company_details->company_id;
													$instance = \Yii::$app->Sharefile->create_extra_sharefile_folder ( $hostname, $client_api_id, $client_secret, $user_id, $insert_id, $username, $password, $name, $company_id );
													
													$response = json_decode ( $instance );
													// / giving access to exra created folders ////
													if ($response->result == 'success') {
														$sharefile_folder_id = $response->id;
														// / assigning permission of folders
														$access_control = \Yii::$app->Sharefile->access_control ( $hostname, $client_api_id, $client_secret, $username, $password, $sharefile_folder_id, $sharefile_client_id );
														if ($access_control != '') {
															$i ++;
														}
													}
												}
												if ($count == $i) {
													/* commiting the values to the db */
													$transaction->commit ();
													/*** trigger emails ***/
													$old_user_details = $new_client->Findbyuserid ( $user_id );
													$to = $old_user_details->user->useremail;
													$name = $old_user_details->contact_first_name . ' ' . $old_user_details->contact_last_name;
													
													
													$client_mail_details ['client_name'] = $new_client->client_name;
													$client_mail_details ['client_brand'] = $model->brand_name;
													
													$result = \Yii::$app->CustomMail->Assignclientmail ( $to, $brand_emailid, $name, $client_mail_details );
													\Yii::$app->session->setFlash ( 'success', 'Client successfully added' );
												} else {
													$transaction->rollback ();
													\Yii::$app->session->setFlash ( 'error', 'Client unable to add. Please try again (Error Code: A001)' );
												}
											}
										} 
										else{
											// $instance = \Yii::$app->Sharefile->create_employee($hostname, $client_api_id, $client_secret, $username, $password, $insert_id, $user_id, $email_id, $firstname, $lastname);
											$instance = \Yii::$app->Sharefile->create_sharefile_folder ( $hostname, $client_api_id, $client_secret, $user_id, $insert_id, $username, $password );
											
											// / creating sharefile client ////
											if ($instance == 'success') {
												$client_instance = \Yii::$app->Sharefile->create_client ( $hostname, $client_api_id, $client_secret, $username, $password, $email, $firstname, $lastname, $insert_id, $user_id );
												$response = json_decode ( $client_instance );
												if ($response->result == 'success') {
													$sharefile_client_id = $response->id;
													// / getting the list of availble folders ///
													$sharefile_folders = TblAcaSharefileFolders::find ()->where ( [ 
															'user_id' => $user_id 
													] )->All ();
													$count = count ( $sharefile_folders );
													$i = 0;
													foreach ( $sharefile_folders as $folders ) {
														$sharefile_folder_id = $folders->sharefile_folder_id;
														// / assigning permission of folders
														$access_control = \Yii::$app->Sharefile->access_control ( $hostname, $client_api_id, $client_secret, $username, $password, $sharefile_folder_id, $sharefile_client_id );
														if ($access_control != '') {
															$i ++;
														}
													}
													if ($count == $i) {
														/* commiting the values to the db */
														$transaction->commit ();
														/*** trigger emails ***/
														$old_user_details = $new_client->Findbyuserid ( $user_id );
														$to = $old_user_details->user->useremail;
														$name = $old_user_details->contact_first_name . ' ' . $old_user_details->contact_last_name;
														
														
														$client_mail_details ['client_name'] = $new_client->client_name;
														$client_mail_details ['client_brand'] = $model->brand_name;
														
														$result = \Yii::$app->CustomMail->Assignclientmail ( $to, $brand_emailid, $name, $client_mail_details );
														\Yii::$app->session->setFlash ( 'success', 'Client successfully added' );
													} else {
														$transaction->rollback ();
														\Yii::$app->session->setFlash ( 'error', 'Client unable to add. Please try again (Error Code: A001)' );
													}
												} else {
													$transaction->rollback ();
													\Yii::$app->session->setFlash ( 'error', 'Client unable to add. Please try again (Error Code: C001)' );
													//print_r($response);die();
												}
											} else {
												$transaction->rollback ();
												\Yii::$app->session->setFlash ( 'error', 'Client unable to add. Please try again (Error Code: F001)' );
												//print_r($instance);die();
											}
										}
									} else {
										$transaction->rollback ();
										\Yii::$app->session->setFlash ( 'error', 'Client unable to add. Please try again (Error Code: B001)' );
									}
									/**
									 * * END creating sharefile account **
									 */
									
									return $this->redirect ( array (
											'/admin/clients' 
									) );
								}
							} else {
								\Yii::$app->session->setFlash ( 'error', 'Client unable to add. Please try again (Error Code: D001)' );
							}
						} else {
							if ($check_email ['result'] == 1) {
								$new_client->addError ( 'email', 'Email address is already used as a admin user.' );
							} 
						}
					} else {
						$new_client->addError ( 'client_name', 'Client name already exist with this reporting year.' );
					}
				} catch ( \Exception $e ) {
					
					$msg = $e->getMessage ();
					\Yii::$app->session->setFlash ( 'error', $msg );
					
					$transaction->rollback ();
				}
			}
			
			/* calling the function to collect all the admin users as a managers */
			$manager = $new_staff_user->getadminusers ();
			
			/* rendering the data to the view */
			return $this->render ( 'addform', [ 
					'new_client' => $new_client,
					'manager' => $manager 
			] );
		} else {
			
			\Yii::$app->SessionCheck->adminlogout ();
			
			return $this->goHome ();
		}
	}
	public function actionSubscription() {
		$this->layout = 'main';
		return $this->render ( 'subscription' );
	}
	public function actionAddsubscription() {
		$this->layout = 'main';
		return $this->render ( 'addsubscription' );
	}
	public function actionEditclient() {
		\Yii::$app->view->title = 'ACA Reporting Service | Edit Clients';
		$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];
		if (\Yii::$app->SessionCheck->isLogged () == true && in_array ( "3", $admin_permissions )) 		// checking logged session
		{
			$get = \Yii::$app->request->get ();
			
			if (! empty ( $get ['id'] )) {
				$id = $get ['id'];
				$encrypt_component = new EncryptDecryptComponent ();
				$model_clients = new TblAcaClients ();
				$id = $encrypt_component->decryptUser ( $id );
				
				$this->layout = 'main';
				
				$logged_user_id = $session ['admin_user_id'];
				
				$new_client = $model_clients->Clientuniquedetails ( $id );
				if(!empty($new_client))
				{
					
				$package = $new_client->package_type;
				$old_ein_count = $new_client->ein_count;
				$year = $new_client->aca_year;
				$to = $new_client->email;
				$old_brand_id = $new_client->brand_id;
				$old_client_name = $new_client->client_name;
				$old_order_number = $new_client->order_number;
				$old_product = $new_client->product;
				$name = $new_client->contact_first_name;
				$new_staff_user = new TblAcaStaffUsers ();
				$manager = $new_staff_user->getadminusers ();
				
				$transaction = \Yii::$app->db->beginTransaction ();
				try {
					
					if ($new_client->load ( \Yii::$app->request->post () )) {
						
						$post = \Yii::$app->request->post ();
						
						$new_client->attributes = $post ['TblAcaClients'];
						
						/* Reporting Structure */
						$reporting_structure = $post ['TblAcaClients'] ['reporting_structure'];
						if ($reporting_structure == 15) 						// 15 Denotes Single EIN
						{
							$new_client->ein_count = 1;
							$new_ein_count = 1;
						} else {
							$new_ein_count = $post ['TblAcaClients'] ['ein_count'];
						}
						
						$new_client->aca_year = $year;
						$new_client->brand_id = $old_brand_id;
						$new_client->client_name = $old_client_name;
						$new_client->email = $to;
						// $new_client->order_number=$old_order_number;
						// $new_client->product=$old_product;
						
						$new_client->modified_by = $logged_user_id;
						$new_client->modified_date = date ( 'Y-m-d H:i:s' );
						$reporting_year = $year;
						$client_name = $old_client_name;
						/* Collecting the first three charecters of the brand and saving it as client number */
						$model = TblAcaBrands::Branduniquedetails ( $new_client->brand_id );
						$brand_emailid = $model->support_email;
						$brand_phonenumber=$model->support_number;
						if(!empty($model->brand_logo)){
							$picture = 'profile_image/brand_logo/'.$model->brand_logo;
						}else{
							$picture = 'ACA-Reporting-Logo.png';
						}
						$brand_name = substr ( $model->brand_name, 0, 3 );
						$new_client->client_number = $brand_name . '-' . $id;
						
						if ($new_ein_count >= $old_ein_count) {
							
							if ($new_client->save () && $new_client->validate ()) {
								$client_number = $new_client->client_number;
								$user_id = $new_client->user_id;
								/**
								 * client company user details*
								 */
								$companyuser_details ['first_name'] = $new_client->contact_first_name;
								$companyuser_details ['last_name'] = $new_client->contact_last_name;
								$companyuser_details ['phone'] = $new_client->phone;
								$companyuser_details ['email'] = $to;
								$companyuser_details ['address_1'] = '';
								$companyuser_details ['address_2'] = '';
								$companyuser_details ['state'] = '';
								$companyuser_details ['city'] = '';
								$companyuser_details ['zip'] = '';
								$companyuser_details ['role_notes'] = 'Company Admin';
								
								$ein_count = $new_ein_count - $old_ein_count;
								if ($ein_count > 0) {
									$client_company = $this->updateclientcompany ( $id, $user_id, $client_number, $reporting_year, $ein_count, $companyuser_details );
									
									/**
									 * Mail function for notifying user about additional EINs added.
									 * *
									 */
						//$client_company = $this->updateclientcompany($id,$user_id, $client_number, $reporting_year, $ein_count, $companyuser_details);
									
									
					$email_logo_link = (new MailComponent())->Custombrandemaillogo($new_client->brand_id);
					
					if($email_logo_link!=''){
						$picture=$email_logo_link;
					}
					
					$link_brandimage = \Yii::$app->urlManager->createAbsoluteUrl ( '/Images' ).'/'. $picture;
					
									
									
									/**Mail function for notifying user about additional EINs added. **/
									\Yii::$app->CustomMail->Additionaleins ( $to,$brand_emailid,$name,$ein_count ,$brand_phonenumber,$link_brandimage);
											}
								
								$transaction->commit ();
								
								\Yii::$app->session->setFlash ( 'success', 'Client successfully updated' );
								return $this->redirect ( array (
										'/admin/clients' 
								) );
							} else {
								return $this->render ( 'editclient', [ 
										'new_client' => $new_client,
										'manager' => $manager,
										'old_ein_count' => $old_ein_count 
								] );
							}
						} else {
							
							$new_client->addError ( 'ein_count', 'Ein count is less than old Ein count.' );
						}
					}
				} catch ( \Exception $e ) {
				//	print_r($e);die();
					$msg = $e->getMessage ();
					\Yii::$app->session->setFlash ( 'error', $msg );
					
					$transaction->rollback ();
				}
				
				return $this->render ( 'editclient', [ 
						'new_client' => $new_client,
						'manager' => $manager,
						'old_ein_count' => $old_ein_count 
				] );
				}else{
				\Yii::$app->SessionCheck->adminlogout ();
			
			return $this->goHome ();
			}
			}else{
				\Yii::$app->SessionCheck->adminlogout ();
			
			return $this->goHome ();
			}
		} else {
			
			\Yii::$app->SessionCheck->adminlogout ();
			
			return $this->goHome ();
		}
	}
	public function actionUpdatesubscription() {
		$this->layout = 'main';
		return $this->render ( 'updatesubscription' );
	}
	protected function checkemailid($email_id) {
		$session = \Yii::$app->session;
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$result = array ();
			$new_user = 0;
			$admin_user = 1;
			$client_user = 2;
			$company_user = 3;
			
			if ($email_id) {
				$model_users = new TblAcaUsers ();
				
				$is_user = $model_users->findByUsername ( $email_id );
				
				if (! empty ( $is_user )) {
					if ($is_user->usertype == 1) {
						$result ['result'] = $admin_user;
					} else if ($is_user->usertype == 2) {
						$result ['result'] = $client_user;
					} else if ($is_user->usertype == 3) {
						$result ['result'] = $company_user;
					}
					
					$result ['user_id'] = $is_user->user_id;
				} else {
					$result ['result'] = $new_user;
				}
			}
			
			return $result;
		} else {
			
			\Yii::$app->SessionCheck->adminlogout ();
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Function used for adding new client user
	 *
	 * @param unknown $email_id        	
	 * @return multitype:NULL number
	 */
	protected function addclientuser($email_id) {
		$session = \Yii::$app->session;
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$user_details = array ();
			$logged_user_id = $session ['admin_user_id'];
			if ($email_id) {
				$model_users = new TblAcaUsers ();
				
				$random_salt = $model_users->generatePasswordResetToken ();
				$model_users->useremail = $email_id;
				$model_users->usertype = 2; // 1 Denotes Client User
				$model_users->created_date = date ( 'Y-m-d H:i:s' );
				$model_users->modified_date = date ( 'Y-m-d H:i:s' );
				$model_users->created_by = $logged_user_id;
				$model_users->modified_by = $logged_user_id;
				$model_users->random_salt = $random_salt;
				$model_users->is_verified = 0;
				$model_users->is_deleted = 0;
				$model_users->is_active = 0;
				
				if ($model_users->save ()) {
					$user_details ['user_id'] = $model_users->user_id;
					$user_details ['random_salt'] = $model_users->random_salt;
				}
			}
			
			return $user_details;
		} else {
			
			\Yii::$app->SessionCheck->adminlogout ();
			
			return $this->goHome ();
		}
	}
	protected function addclientcompany($client_id, $user_id, $client_number, $reporting_year, $ein_count, $client_name, $companyuser_details) {
		$session = \Yii::$app->session;
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$logged_user_id = $session ['admin_user_id'];
			
			$model_clients = new TblAcaClients();
			$model_brands = new TblAcaBrands();
			$str_company_numbers = ''; //string for company numbers
			if (! empty ( $client_id ) && ! empty ( $ein_count )) {
				$model_company = new TblAcaCompanies ();
				$model_company_reporting_period = new TblAcaCompanyReportingPeriod ();
				
				$save_company_user = $this->Addcompanyuser ( $companyuser_details, $user_id, $client_id );
				
				for($i = 1; $i <= $ein_count; $i ++) {
					
					$str_company_numbers .= $client_number . '-' . $i.', '; //string for company numbers
					$model_company->client_id = $client_id;
					$model_company->created_by = $logged_user_id;
					$model_company->created_date = date ( 'Y-m-d H:i:s' );
					$model_company->company_client_number = $client_number . '-' . $i;
					$model_company->reporting_status = 23; // denotes new company in look up options
					if ($i === 1) {
						
						$model_company->company_name = preg_replace ( "/[^a-zA-Z0-9& \'\-\.\(\)&-]/s", '', $client_name );
					} else {
						$model_company->company_name = '';
					}
					$model_company->isNewRecord = true;
					$model_company->company_id = NULL;
					
					if ($model_company->save ()) {
						$company_id = $model_company->company_id;
						$model_company_reporting_period->company_id = $company_id;
						$model_company_reporting_period->reporting_year = $reporting_year;
						$model_company_reporting_period->created_by = $logged_user_id;
						$model_company_reporting_period->created_date = date ( 'Y-m-d H:i:s' );
						$model_company_reporting_period->isNewRecord = true;
						$model_company_reporting_period->period_id = NULL;
						
						$model_company_reporting_period->save ();
						
						if (! empty ( $save_company_user ['company_user_id'] )) {
							/**
							 * Add company user permission*
							 */
							$company_user_id = $save_company_user ['company_user_id'];
							$permissions = array ();
							$assign_permissions = $this->Assigncompanyuserpermissions ( $company_id, $permissions, $company_user_id, $companyuser_details,$user_id  );
						}
					}
				}
				
				//Send mail for adding multiple company with company names
				
				
				$client_details=$model_clients->Clientuniquedetails($client_id);
				
				if(!empty($client_details)){
					$brand_model=$model_brands->Branduniquedetails($client_details->brand_id);
					$picture = 'profile_image/brand_logo/'.$brand_model->brand_logo;
					$brand_email = $brand_model->support_email;
					$brand_phone = $brand_model->support_number;
				}else{
					$picture = 'ACA-Reporting-Logo.png';
					$brand_email = 'admin@acareportingservice.com';
					$brand_phone = '999999999';
				}
				
					$link = \Yii::$app->urlManager->createAbsoluteUrl ( '/login' );
					
					
					$email_logo_link = (new MailComponent())->Custombrandemaillogo($client_details->brand_id);
					if($email_logo_link!=''){
						$picture=$email_logo_link;
					}
					
					$link_brandimage = \Yii::$app->urlManager->createAbsoluteUrl ( '/Images' ).'/'. $picture;
					
					\Yii::$app->CustomMail->Addedtocompanymail ( $companyuser_details['email'], $companyuser_details['first_name'], $link ,$link_brandimage,$brand_email,$brand_phone,$ein_count,$str_company_numbers);
					
				return 'success';
			}
		} else {
			
			\Yii::$app->SessionCheck->adminlogout ();
			
			return $this->goHome ();
		}
	}
	/**
	 * Function is used for updating client companies .
	 *
	 * This function adds extra companies to the client account
	 * if EIN Count is greater than the last EIN Count.
	 */
	protected function updateclientcompany($client_id, $user_id, $client_number, $reporting_year, $ein_count, $companyuser_details) {
		$session = \Yii::$app->session;
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$logged_user_id = $session ['admin_user_id'];
			if (! empty ( $client_id ) && ! empty ( $ein_count )) {
				
				$model_company_status = TblAcaCompanies::find()->where(['client_id'=>$client_id])->andWhere('reporting_status > 23')->One();
				$model_company = new TblAcaCompanies ();
				$model_clients = new TblAcaClients ();
				$model_company_reporting_period = new TblAcaCompanyReportingPeriod ();
				$model_company_user = new TblAcaCompanyUsers ();
				$model_company_count = $model_company->companiesCount ( $client_id );
				
				$str_company_numbers = '';
				$ein_count1 = $ein_count + $model_company_count;
				
				for($i = $model_company_count + 1; $i <= $ein_count1; $i ++) {
					
					$str_company_numbers .= $client_number . '-' . $i.',';
					$model_company->client_id = $client_id;
					$model_company->created_by = $logged_user_id;
					$model_company->created_date = date ( 'Y-m-d H:i:s' );
					$model_company->company_client_number = $client_number . '-' . $i;
					if(!empty($model_company_status)){
						$model_company->reporting_status = 24; // denotes new company in look up options
					}else{
						 $model_company->reporting_status = 23; // denotes new company in look up options
					}
					$model_company->isNewRecord = true;
					$model_company->company_id = NULL;
					
					if ($model_company->save ()) {
						$company_id = $model_company->company_id;
						$model_company_reporting_period->company_id = $company_id;
						$model_company_reporting_period->reporting_year = $reporting_year;
						$model_company_reporting_period->created_by = $logged_user_id;
						$model_company_reporting_period->created_date = date ( 'Y-m-d H:i:s' );
						$model_company_reporting_period->isNewRecord = true;
						$model_company_reporting_period->period_id = NULL;
						
						if ($model_company_reporting_period->save ()) {
							
							$company_user = TblAcaCompanyUsers::find ()->where ( [ 
									'user_id' => $user_id,
									'client_id' => $client_id 
							] )->One ();
							
							
							if (! empty ( $company_user->company_user_id )) {
								/**
								 * Add company user permission*
								 */
								$company_user_id = $company_user->company_user_id;
								$permissions = array ();
								$assign_permissions = $this->Assigncompanyuserpermissions ( $company_id, $permissions, $company_user_id, $companyuser_details,$user_id  );
							}
							
							/**
							 * * getting sharefile account details **
							 */
							$client_details = $model_clients->Clientuniquedetails ( $client_id );
							$client_logged_id = $client_details->user_id;
							
							$sharefile_details = TblAcaSharefileEmployees::find ()->where ( [ 
									'user_id' => $client_logged_id 
							] )->One ();
							// $new_username = $sharefile_details->username;
							// $new_password = $sharefile_details->password;
							if (! empty ( $sharefile_details )) {
								$sharefile_client_id = $sharefile_details->sharefile_employee_id;
								
								/**
								 * * getting sharefile credentials **
								 */
								$share_file = json_decode ( file_get_contents ( getcwd () . '/config/sharefile-credentials.json' ) );
								
								$hostname = $share_file->hostname;
								$username = $share_file->username;
								$password = $share_file->password;
								
								$client_api_id = $share_file->client_api_id;
								$client_secret = $share_file->client_secret;
								$name = $client_number . '-' . $i;
								
								$instance = \Yii::$app->Sharefile->create_extra_sharefile_folder ( $hostname, $client_api_id, $client_secret, $client_logged_id, $client_id, $username, $password, $name, $company_id );
								$response = json_decode ( $instance );
								// / giving access to exra created folders ////
								if ($response->result == 'success') {
									$sharefile_folder_id = $response->id;
									// / assigning permission of folders
									$access_control = \Yii::$app->Sharefile->access_control ( $hostname, $client_api_id, $client_secret, $username, $password, $sharefile_folder_id, $sharefile_client_id );
								}
							}
						}
					}
				}
				
				return 'success';
			}
		} else {
			
			\Yii::$app->SessionCheck->adminlogout ();
			
			return $this->goHome ();
		}
	}
	/**
	 * Function is used for adding client as a company user for a particular company*
	 */
	protected function Addcompanyuser($companyuser_details, $company_user_id, $client_id) {
		$session = \Yii::$app->session;
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$logged_user_id = $session ['admin_user_id'];
			
			$model_companies = new TblAcaCompanies ();
			$model_company_users = new TblAcaCompanyUsers ();
			
			/**
			 * *Assigning variables*
			 */
			$permissions = array ();
			
			$model_company_users->client_id = $client_id;
			$model_company_users->user_id = $company_user_id;
			$model_company_users->first_name = $companyuser_details ['first_name'];
			$model_company_users->last_name = $companyuser_details ['last_name'];
			$model_company_users->phone = $companyuser_details ['phone'];
			$model_company_users->email = $companyuser_details ['email'];
			$model_company_users->address_1 = $companyuser_details ['address_1'];
			$model_company_users->address_2 = $companyuser_details ['address_2'];
			$model_company_users->state = $companyuser_details ['state'];
			$model_company_users->city = $companyuser_details ['city'];
			$model_company_users->zip = $companyuser_details ['zip'];
			$model_company_users->role_notes = $companyuser_details ['role_notes'];
			$model_company_users->is_admin = 1;
			$model_company_users->created_by = $logged_user_id;
			$model_company_users->created_date = date ( 'Y-m-d H:i:s' );
			$model_company_users->modified_by = $logged_user_id;
			$model_company_users->modified_date = date ( 'Y-m-d H:i:s' );
			
			if ($model_company_users->save () && $model_company_users->validate ()) {
				$company_user_id = $model_company_users->company_user_id;
				$result ['output'] = 'success';
				$result ['company_user_id'] = $company_user_id;
			} else {
				
				$result ['error'] = $model_company_users->errors;
			}
			
			return $result;
		} else {
			
			\Yii::$app->SessionCheck->adminlogout ();
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Add permission to the company user*
	 */
	protected function Assigncompanyuserpermissions($company_id, $permissions = NULL, $company_user_id, $user_details = NULL,$user_id) {
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			
			$session = \Yii::$app->session;
			$logged_user_id = $session ['admin_user_id'];
			$model_company_user_permissions = new TblAcaCompanyUserPermission ();
			$model_company_users = new TblAcaCompanyUsers();
			$model_clients = new TblAcaClients();
			$model_brands = new TblAcaBrands();
			$result = '';
			
			$firstname = $user_details['first_name'];
			$lastname = $user_details['last_name'];
			$email = $user_details['email'];
			$name = $firstname;
			
			
			
			
			
			$check_all_permissions = $model_company_user_permissions->FindallbycompanyuserId ( $company_user_id );
			if (! empty ( $check_all_permissions )) {
				TblAcaCompanyUserPermission::deleteAll ( [ 
						'company_user_id' => $company_user_id,
						'company_id' => $company_id 
				] );
				/*
					$company_user_details = $model_company_users->FindByuserId($user_id); //finding details of user
				$client_details=$model_clients->Clientuniquedetails($company_user_details->client_id);
				
				if(!empty($client_details)){
					$brand_model=$model_brands->Branduniquedetails($client_details->brand_id);
					$picture = 'profile_image/brand_logo/'.$brand_model->brand_logo;
					$brand_email = $brand_model->support_email;
					$brand_phone = $brand_model->support_number;
				}else{
					$picture = 'ACA-Reporting-Logo.png';
					$brand_email = 'admin@acareportingservice.com';
					$brand_phone = '999999999';
				}
				
					$link = \Yii::$app->urlManager->createAbsoluteUrl ( '/login' );
					
					
					$email_logo_link = (new MailComponent())->Custombrandemaillogo($client_details->brand_id);
					if($email_logo_link!=''){
						$picture=$email_logo_link;
					}
					
					$link_brandimage = \Yii::$app->urlManager->createAbsoluteUrl ( '/Images' ).'/'. $picture;
					
					\Yii::$app->CustomMail->Permissionmail ( $email, $name, $link ,$link_brandimage,$brand_email,$brand_phone);

*/

					//sending mail for permission change
			}
			$count = 0;
			for($i = 1; $i <= 10; $i ++) {
				
				$model_company_user_permissions->company_user_id = $company_user_id;
				$model_company_user_permissions->client_permission_id = $i;
				$model_company_user_permissions->company_id = $company_id;
				$model_company_user_permissions->created_by = $logged_user_id;
				$model_company_user_permissions->created_date = date ( 'Y-m-d H:i:s' );
				$model_company_user_permissions->modified_by = $logged_user_id;
				$model_company_user_permissions->modified_date = date ( 'Y-m-d H:i:s' );
				$model_company_user_permissions->isNewRecord = true;
				$model_company_user_permissions->company_permission_id = null;
				$model_company_user_permissions->save ();
				
				if ($i == 9 || $i == 10) {
					$count ++;
				}
			}
			/**
			 * if($count == 2)
			 * {
			 *
			 * /******** get company user details
			 * $company_user_details = TblAcaCompanyUsers::find()->where(['company_user_id' => $company_user_id])->One();
			 * $companyuser_user_id = $company_user_details->user_id;
			 *
			 * /*** get sharefile folder details
			 * $folder_details = TblAcaSharefileFolders::find()->where(['company_id' => $company_id])->One();
			 * //$folder_name = $folder_details->folder_name;
			 * $sharefile_folder_id = $folder_details->sharefile_folder_id;
			 * $client_id = $folder_details->client_id;
			 * $client_user_id = $folder_details->user_id;
			 *
			 * /*** get sharefile account details
			 * $sharefile_details = TblAcaSharefileEmployees::find()->where(['user_id' => $client_user_id])->One();
			 *
			 * $new_username = $sharefile_details->username;
			 * $new_password = $sharefile_details->password;
			 * $client_logged_id = $sharefile_details->user_id;
			 *
			 * /******* getting the sharefile credentials
			 * $share_file = json_decode(file_get_contents(getcwd().'/config/sharefile-credentials.json'));
			 *
			 * $hostname = $share_file->hostname;
			 * $client_api_id = $share_file->client_api_id;
			 * $client_secret = $share_file->client_secret;
			 *
			 *
			 * /*** get sharefile account details
			 * $sharefile_account_details = TblAcaSharefileEmployees::find()->where(['username' => $email])->One();
			 *
			 * if(!empty($sharefile_account_details)){
			 * $sharefile_employee_id = $sharefile_account_details->sharefile_employee_id;
			 * $result = \Yii::$app->Sharefile->access_control($hostname, $client_api_id, $client_secret, $new_username, $new_password, $sharefile_folder_id, $sharefile_employee_id);
			 * //print_r($result);
			 * //die();
			 * }
			 * else{
			 * $result = \Yii::$app->Sharefile->create_client($hostname, $client_api_id, $client_secret, $new_username, $new_password, $email, $firstname, $lastname, $client_id, $companyuser_user_id, $sharefile_folder_id);
			 * }
			 *
			 *
			 * }
			 */
			
			return 'success';
		} else {
			\Yii::$app->SessionCheck->adminlogout ();
			
			return $this->goHome ();
		}
	}
	
	
}
