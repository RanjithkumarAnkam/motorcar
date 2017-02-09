<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\models\TblAcaBrands;
use app\models\TblAcaClients;
use yii\web\UploadedFile;
use app\models\TblAcaElementMaster;
use app\models\TblAcaLookupOptions;
use app\models\TblAcaCodeMaster;
use yii\base\Exception;
use app\components\EncryptDecryptComponent;
use app\models\TblAcaGlobalSettings;
use app\models\TblAcaValidationRules;
use app\models\TblAcaFormPricing;
use app\models\TblAcaManageCodes;
use yii\helpers\Json;

/**
 * Default controller for the `admin` module
 */
class MasterdataController extends Controller {
	/**
	 * Renders the index view for the module
	 * 
	 * @return string
	 */
	
	/**
	 * Renders the grid with all brands
	 */
	public function actionIndex() {
		\Yii::$app->view->title = 'ACA Reporting Service | Manage Brands';
		$this->layout = 'main';
		$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];
		if (\Yii::$app->SessionCheck->isLogged () == true && in_array("6", $admin_permissions)) 		// checking logged session
		{
			
			
			$model=new TblAcaBrands();
			$model_acabrands = $model->Brandalldetails (); // Retriving Brand details
			
			return $this->render ( 'index', [  // Rendering to index view
					'model' => $model_acabrands 
			] );
			
		
				  
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Renders the grid with all lookupoptions
	 */
	public function actionLookupoptions() {
		\Yii::$app->view->title = 'ACA Reporting Service | Lookup Options';
		$this->layout = 'main';
		$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];
		if (\Yii::$app->SessionCheck->isLogged () == true && in_array("7", $admin_permissions)) 		// checking logged session
		{
		/*	if(\Yii::$app->Permission->CheckAdminactionpermission ( '7' ) == true)
                  {*/
			
			$model_codemaster = new TblAcaCodeMaster (); // initialising model TblAcaCodeMaster
			$model_lookupoptions_modal = new TblAcaLookupOptions (); // initialising model TblAcaLookupOptions
			
			$model_lookupoptions = $model_lookupoptions_modal->lookupoptionsalldetails (); // Retriving Lookupoptions details
			$this->layout = 'main'; // rendering the layout
			return $this->render ( 'lookupoptions', [  // Rendering to index view
					'model' => $model_lookupoptions,
					'model_codemaster' => $model_codemaster,
					'model_lookupoptions_modal' => $model_lookupoptions_modal 
			] );
			
		/*	}else{
					\Yii::$app->session->setFlash ( 'error', 'Permission denied' );
							return $this->redirect ( array (
									'/admin' 
							) );  
				  }*/
				  
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Action for modal popup values for edit lookup options
	 */
	public function actionEditlookupoptions() {
		
		$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];
		
		if (\Yii::$app->SessionCheck->isLogged () == true && in_array("7", $admin_permissions)) 		// checking logged session
		{
			
			$model_codemaster = new TblAcaCodeMaster (); // initialising models
			$model_lookupoptions_modal = new TblAcaLookupOptions ();
			
			$post = \Yii::$app->request->post ();
			if (! empty ( $post )) { // getting the values through post
				$id = $post ['id'];
				
				$model_lookupoptions = $model_lookupoptions_modal->editlookupoptionsalldetails ( $id ); // Retriving Lookupoptions details for particular id
				
				$lookup_id = $model_lookupoptions->lookup_id; // assigning values to model
				$code_id = $model_lookupoptions->code_id;
				$lookup_value = $model_lookupoptions->lookup_value;
				$lookup_element = $model_lookupoptions ['code']->lookup_code;
				
				$arrEditvalues = array (
						"lookup_value" => $lookup_value, // preparing array to send in response for ajax
						"lookup_element" => $lookup_element,
						"lookup_id" => $lookup_id,
						"code_id" => $code_id 
				);
				
				echo json_encode ( $arrEditvalues ); // sending as a object
			}
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Action for updating lookupoptions
	 */
	public function actionUpdatelookupoptions() {
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			
			$post = \Yii::$app->request->post ();
			if (! empty ( $post )) { // checking the values
				$value_name = $post ['TblAcaLookupOptions'] ['lookup_value']; // assigining them to variables
				$lookup_id = $post ['lookupid'];
				$code_id = $post ['codeid'];
				$model_lookup = new TblAcaLookupOptions();
				
				if (! empty ( $code_id )) {
					
					$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
					try {
						
						$model_lookup = $model_lookup->lookupuniquedetails ( $lookup_id ); // Retriving Lookupoptions details for particular id
						$model_findoption = $model_lookup->lookupfindoption ( $value_name ,$code_id ,$lookup_id );
						
						if ($value_name != $model_lookup->lookup_value) { // Checking for unique
							
							if (! empty ( $model_findoption )) {
								throw new Exception ( 'lookup value already exist.' ); // throw a exception
							} else {
								$model_lookup->lookup_value = strip_tags ( $value_name ); // assiging the values to model
							}
						} else {
							$model_lookup->lookup_value = strip_tags ( $value_name ); // assiging the values to model
						}
						
						if ($model_lookup->validate () && $model_lookup->save ()) 						// validating model and saving it(server side validation)
						{
							echo 'success';
							$transaction->commit (); // commiting the transaction
						} else {
							
							echo 'fail';
						}
					} catch ( \Exception $e ) { // catching the \Exception
						
						$msg = $e->getMessage ();
						\Yii::$app->session->setFlash ( 'error', $msg );
						
						$transaction->rollback ();                                       //if \Exception occurs transaction rollbacks
						
					echo 'fail'; // sending response to ajax
					}
				} else {
					echo 'fail'; // sending response to ajax
				}
			} else {
				echo 'fail'; // sending response to ajax
			}
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Action for activate or deactivate lookup option
	 */
	public function actionLookupstatusactivate() {
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			
			$post = \Yii::$app->request->post ();
			if (! empty ( $post )) { // checking values
				$model_lookup = new TblAcaLookupOptions();
				$id = $post ['id'];
				$is_active = $post ['is_active'];
				$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
				try {
					$model = $model_lookup->lookupuniquedetails ( $id ); // checking for unique details
					if ($is_active == 1) {
						$model->lookup_status = 2;
					} elseif ($is_active == 2) {
						$model->lookup_status = 1;
					}
					
					if ($model->save () && $model->validate ()) 					// model saving and validating
					
					{
						echo 'success';
						$transaction->commit (); // commit the transaction
					} else {
						
						echo 'fail'; // sending response to ajax
					}
				} catch ( \Exception $e ) { // catching block for throwing \Exception
					
					$msg = $e->getMessage ();
					\Yii::$app->session->setFlash ( 'error', $msg );
					
					$transaction->rollback ();                       //if \Exception occurs transaction rollbacks
				}
			} else {
				
				echo 'fail'; // sending response to ajax
			}
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // user logout if session expires
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Action for deletion of lookup option
	 */
	public function actionDeletelookupoptions() {
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$post = \Yii::$app->request->post ();
			
			if (! empty ( $post ['id'] )) {
				
				$id = $post ['id'];
				
				$model_lookup = new TblAcaLookupOptions();
				$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
				try {
					$model = $model_lookup->lookupuniquedetails ( $id ); // checking for particular id
					if (! empty ( $id )) {
						$modelfindsectionid = $model_lookup->lookupfindsectionid ( $id ); // finding the usage of option
						
						if (empty ( $modelfindsectionid )) {
							
							if(TblAcaLookupOptions::findOne ( $id )->delete ()){
								
								echo 'success'; // sending response to ajax
							
								$transaction->commit (); // commit the transaction	
								
							} // model query for deleting option
							
							
						} 

						else {
							
							echo 'fail'; // sending response to ajax
						}
					}
				} catch ( \Exception $e ) { // catching the \Exception
					
					$msg = $e->getMessage ();
					\Yii::$app->session->setFlash ( 'error', $msg );
					
					$transaction->rollback ();                                //if \Exception occurs transaction rollbacks
				}
			}
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // redirects if session expired
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Action for adding lookup option
	 */
	public function actionAddlookupoptions() {
		// rendering the main layout
		$this->layout = 'main';
		
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			
			$lookup_options = \Yii::$app->request->post ();
			
			
			$model_lookupoptions = new TblAcaLookupOptions ();      //initialising the model
			
			
			$session = \Yii::$app->session;                         // collecting variables from session
			$user_id = $session ['admin_user_id'];
			
			// begining the transaction
			$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
			try {
				
				if ($model_lookupoptions->load ( \Yii::$app->request->post () )) {
					
					$lookup_options = \Yii::$app->request->post (); // putting the post values in a variable
					$code_id = $lookup_options ['TblAcaLookupOptions'] ['code_id'];
					$optionString = $lookup_options ['TblAcaLookupOptions'] ['lookup_value'];
					$arrOptions = explode ( ',', $optionString ); // making string to array
					
					$x = 0;
					$erroroptions = '';
				
					foreach ( $arrOptions as $key => $value ) {
						$lookup_id='';
						$model_findoption = $model_lookupoptions->lookupfindoption ( $value , $code_id,$lookup_id); // checking for unique
						
						if (! empty ( $model_findoption )) {	
							throw new Exception ( 'Lookup option already exists.' ); // if duplicate entry throws a \Exception
						} else {
								
							// assigning values to model
							$model_lookupoptions->lookup_value = $value;
							$model_lookupoptions->code_id = $code_id;
							$model_lookupoptions->lookup_status = 1;
							$model_lookupoptions->created_by = $user_id;
							$model_lookupoptions->created_date = date ( 'Y-m-d H:i:s' );
							$model_lookupoptions->modified_date = date ( 'Y-m-d H:i:s' );
							$model_lookupoptions->lookup_id = NULL;
							$model_lookupoptions->isNewRecord = TRUE;
							if ($model_lookupoptions->validate () && $model_lookupoptions->save ()) { // validating and saving for each record
								$x ++;
							}
						}
					}
					
					// validating the
					if ($x > 0) {
						
						$transaction->commit (); // commit the transaction
						
						\Yii::$app->session->setFlash ( 'success', 'Lookup option added successfully' );
						return $this->redirect ( array ( // redirecting with success message
								'/admin/masterdata/lookupoptions' 
						) );
					} else {
						
						return $this->redirect ( array (
								'/admin/masterdata/lookupoptions' 
						) );
					}
				}
			} catch ( \Exception $e ) { // display error messages if \Exception occurs
				
				$msg = $e->getMessage ();
				\Yii::$app->session->setFlash ( 'error', $msg );
				
				$transaction->rollback ();                          //if \Exception occurs transaction rollbacks
				
				return $this->redirect ( array (
						'/admin/masterdata/lookupoptions' 
				) );
			}
			
			return $this->render ( 'lookupoptions', [ 
					'$model_lookupoptions' => $model_lookupoptions 
			] );
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // if session destroyed user gets logout
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Action for adding lookup name
	 */
	public function actionAddlookupname() {
		$this->layout = 'main';
		
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$session = \Yii::$app->session;                     // collecting variables from session
			$user_id = $session ['admin_user_id'];
			$lookup_options = \Yii::$app->request->post ();
			
			$model_codemaster = new TblAcaCodeMaster ();
			
			$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
			try {
				
				if ($model_codemaster->load ( \Yii::$app->request->post () )) {
					
					$lookup_name = \Yii::$app->request->post ();
					
					$lookup_code = $lookup_name ['TblAcaCodeMaster'] ['lookup_code'];
					$model_findcode = $model_codemaster->codemasterfindcode ( $lookup_code );
					
					if (! empty ( $model_findcode )) 					// checking for unique lookup code
					{
						throw new Exception ( 'Lookup name already exist.' ); // throws a \Exception
					} else {
						$model_codemaster->attributes = $lookup_name ['TblAcaCodeMaster'];
						$model_codemaster->code_type = 1;
						$model_codemaster->created_by = $user_id;
					}
					
					if ($model_codemaster->validate () && $model_codemaster->save ()) { // model validation happens
						
						$transaction->commit (); // commit the transaction
						
						\Yii::$app->session->setFlash ( 'success', 'Lookup Name added successfully' );
						return $this->redirect ( array ( // if added redirecting with success msg
								'/admin/masterdata/lookupoptions' 
						) );
					} else {
						
						\Yii::$app->session->setFlash ( 'error', 'lookup name cannot be added' );
						return $this->redirect ( array ( // if not added redirecting with success msg
								'/admin/masterdata/lookupoptions' 
						) );
					}
				}
			} catch ( \Exception $e ) { // any \Exceptions catch throws error msg
				
				$msg = $e->getMessage ();
				\Yii::$app->session->setFlash ( 'error', $msg );
				
				$transaction->rollback ();                   //if \Exception occurs transaction rollbacks
				
				return $this->redirect ( array (
						'/admin/masterdata/lookupoptions'  // any \Exception redirecting with error msg
								) );
			}
			
			return $this->redirect ( array (
					'/admin/masterdata/lookupoptions' 
			) );
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
			
			return $this->goHome ();
		}
	}
		/**
	 * Action for rendering account settings in the grid
	 */
	public function actionAccountsettings() {
		\Yii::$app->view->title = 'ACA Reporting Service | Account Settings';
		$this->layout = 'main';
		$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];
		if (\Yii::$app->SessionCheck->isLogged () == true && in_array("8", $admin_permissions)) 		// checking logged session
		{
			
			$model_global =new TblAcaGlobalSettings();
			$model_settings=$model_global->Findemailsettings(); //getting  data
	
			
		
			return $this->render('accountsettings'            //render the values to screen
					 ,[
					'model_settings'=>$model_settings]);
			
		
		} else {
			\Yii::$app->SessionCheck->adminlogout ();    // Redirecting to login page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Action for updating account settings
	 */
	public function actionUpdateaccountsetting()
	{
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$post = \Yii::$app->request->post ();
			$result = array();
	
			if (! empty ( $post )) { // checking the values
	
				$value=$post['value'];
				$id=$post['setting_id'];
	
				if (! empty ( $id )) {
	
					$model_setting_global = new TblAcaGlobalSettings();
					
					$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
					try {
	
						$model_setting = $model_setting_global->settinguniquedetails ( $id ); // Retriving video link screen details for particular id
	
						 
						$model_setting->value =   strip_tags($value); // assiging the values to model
	
							
						if ($model_setting->validate () && $model_setting->save ()) 						// validating model and saving it(server side validation)
						{
							$result['success'] = 'Account setting has been updated successfully';
							$transaction->commit (); // commiting the transaction
						} else {
								
							$result['fail'] = $model_setting->errors;
						}
					} catch ( \Exception $e ) { // catching the \Exception
	
						$msg = $e->getMessage ();
						\Yii::$app->session->setFlash ( 'error', $msg );
	
						$transaction->rollback ();                                       //if \Exception occurs transaction rollbacks
	
						$result['fail'] = 'some error occured'; // sending response to ajax
					}
						
				} else {
					$result['fail'] = 'some error occured'; // sending response to ajax
				}
			} else {
				$result['fail'] = 'some error occured'; // sending response to ajax
			}
	
			return json_encode($result);
	
	         
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to home page if session destroyed
	
			return $this->goHome ();
		}
	}
	
	/**
	 * Action for rendering elements in the grid
	 */
	public function actionElements() {
		\Yii::$app->view->title = 'ACA Reporting Service | Elements';
		$this->layout = 'main';
			$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];
		if (\Yii::$app->SessionCheck->isLogged () == true && in_array("9", $admin_permissions)) 		// checking logged session
		{
			/*if(\Yii::$app->Permission->CheckAdminactionpermission ( '9' ) == true)
                  {*/
			
			$model_lookupoptions = new TblAcaLookupOptions ();
			$model_acaelement = new TblAcaElementMaster ();
			
			$limit = $url = '';
			$filter ['filter_keyword'] = ''; // initialising filter for search
			
			$get = \Yii::$app->request->get ();
			
			if (isset ( $get ['keyword'] ) && $get ['keyword'] != '') {
				$encrypt_component = new EncryptDecryptComponent (); // decrypting the id
				$id = $encrypt_component->decryptUser ( htmlentities($get ['keyword']) );
				$get ['keyword'] = htmlentities($id);
				$filter ['filter_keyword'] = $get ['keyword'];
				
				$filter_elements = htmlentities($get ['keyword']);
				$url .= '&keyword=' . htmlentities($get ['keyword']);
				
				
			} else {
				$filter_elements = '';
				$url .= '&keyword=' . '';
			}
			
			$model_acaelements = $model_acaelement->Elementalldetails ( $filter_elements ); // retriving values for grid
			
			return $this->render ( 'element', [  // render values to element view page
					'model' => $model_acaelements,
					'model_lookupoptions' => $model_lookupoptions 
			] );
			
		/*	}else{
					\Yii::$app->session->setFlash ( 'error', 'Permission denied' );
							return $this->redirect ( array (
									'/admin' 
							) );  
				  }*/
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Action for updating element label
	 */
	public function actionUpdateelementlabel() {
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			
			$post = \Yii::$app->request->post ();
			
			$elementid = $post ['elementid'];
			
			if (! empty ( $post ['id'] )) {
				$id = $post ['id'];
				$model_element = new TblAcaElementMaster();
				
				$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
				try {
					
					$model = $model_element->Elementuniquedetails ( $id );
					$model->element_label = strip_tags ( $elementid );
					
					if ($model->save () && $model->validate ()) {
						echo 'success'; // sending response to ajax
						$transaction->commit (); // commit the transaction
					} else {
						
						echo 'fail'; // sending response to ajax
					}
				} catch ( \Exception $e ) { // catching the \Exception
					
					$msg = $e->getMessage ();
					\Yii::$app->session->setFlash ( 'error', $msg );
					
					$transaction->rollback ();                //if \Exception occurs transaction rollbacks
					echo 'fail'; // sending response to ajax
				}
			} else {
				echo 'fail'; // sending response to ajax
			}
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Action for adding brand details
	 */
	public function actionAddbrand() {
		\Yii::$app->view->title = 'ACA Reporting Service | Add Brand';
		$this->layout = 'main';
		$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];
		if (\Yii::$app->SessionCheck->isLogged () == true && in_array("6", $admin_permissions)) 		// checking logged session
		{
			
			$logged_user_id = $session ['admin_user_id'];       // collecting variables from session
			$model_acabrands = new TblAcaBrands ();
			$model_acabrands->scenario = 'save'; // model scenario for validating
			
			$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
			try {
				if ($model_acabrands->load ( \Yii::$app->request->post () )) {
					
					$brand_details = \Yii::$app->request->post ();
					$name = $brand_details ['TblAcaBrands'] ['brand_name'];
					
					$checkmodel = $model_acabrands->Checkbrandname ( $name ); // checking for particular brand name
					
					if (empty ( $checkmodel )) {
						$model_acabrands->attributes = $brand_details ['TblAcaBrands'];
						$model_acabrands->created_date = date ( 'Y-m-d H:i:s' );
						$model_acabrands->modified_date = date ( 'Y-m-d H:i:s' );
						$model_acabrands->created_by = $logged_user_id;
						$model_acabrands->is_deleted = 1;
						
						$image = UploadedFile::getInstance ( $model_acabrands, 'brand_logo' ); // getting instance of a uploaded file
						$rnd = rand ( 0, 99999 );
						if ($image) {
							$ext = explode ( ".", $image->name );
							
							$model_acabrands->brand_logo = $ext [0] . '_1_' . $rnd . '.' . $ext [1];
							
							$path = \Yii::$app->basePath . '/Images/profile_image/brand_logo/' . $model_acabrands->brand_logo;
						}
						if ($model_acabrands->save () && $model_acabrands->validate ()) { // model validated(server side validation)
							if ($image) {
								$image->saveAs ( $path );
								chmod ( $path, 0755 );
							}
							
							$transaction->commit (); // commit the transaction
							
							\Yii::$app->session->setFlash ( 'success', 'Brand added successfully' );
							return $this->redirect ( array (
									'/admin/masterdata'  // redirecting to grid if brand is added
														) );
						} else {
							
							return $this->render ( 'addbrand', [  // render the array to addbrand view file
									'model' => $model_acabrands 
							] );
						}
					} else {
						$model_acabrands->addError ( 'brand_name', 'Brand name address is already exist.' ); // model adding error
					}
				}
			} catch ( \Exception $e ) { // any \Exceptions catch throws error msg
				
				$msg = $e->getMessage ();
				\Yii::$app->session->setFlash ( 'error', $msg );
				
				$transaction->rollback ();             //if \Exception occurs transaction rollbacks
			}
			return $this->render ( 'addbrand', [  // render the array to addbrand view file
					'model' => $model_acabrands 
			] );
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Action for updating brand details
	 */
	public function actionEditbrand() {
		\Yii::$app->view->title = 'ACA Reporting Service | Edit Brand';
		$this->layout = 'main';
		$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];
		if (\Yii::$app->SessionCheck->isLogged () == true && in_array("6", $admin_permissions)) 		// checking logged session
		{
			$logged_user_id = $session ['admin_user_id'];      // collecting variables from session
			$get = \Yii::$app->request->get ();
			
			if (! empty ( $get ['id'] )) {
				
			$id = $get ['id'];
			$encrypt_component = new EncryptDecryptComponent ();
			$model_acabrand=new TblAcaBrands();
			$id = $encrypt_component->decryptUser ( $id ); // decrypting id
			
			
				$model_acabrands = $model_acabrand->Branduniquedetails ( $id );
				
				if(!empty($model_acabrands)){
				
				$old_image = $model_acabrands ['brand_logo'];
				$old_brandname = $model_acabrands ['brand_name'];
				$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
				try {
					if ($model_acabrands->load ( \Yii::$app->request->post () )) {
						$brand_details = \Yii::$app->request->post ();
						$name = $brand_details ['TblAcaBrands'] ['brand_name'];
						
						if ($old_brandname == $name) { // checking for particular brand name
							$checkmodel = '';
						} else {
							$checkmodel = $model_acabrand->Checkbrandname ( $name );
						}
						
						if (empty ( $checkmodel )) { // adding brand if brand name is not exist
							$model_acabrands->attributes = $brand_details ['TblAcaBrands'];
							$model_acabrands->support_email = $brand_details ['TblAcaBrands'] ['support_email'];
							$model_acabrands->support_number = $brand_details ['TblAcaBrands'] ['support_number'];
							$model_acabrands->modified_date = date ( 'Y-m-d H:i:s' );
							$model_acabrands->modified_by = $logged_user_id;
							$model_acabrands->is_deleted = 1;
							
							$image = UploadedFile::getInstance ( $model_acabrands, 'brand_logo' ); // getting instance of a uploaded file
							$rnd = rand ( 0, 99999 );
							
							if (! empty ( $image )) { // checking for image
								$ext = explode ( ".", $image->name );
								
								$model_acabrands->brand_logo = $ext [0] . '_1_' . $rnd . '.' . $ext [1];
								
								$path = \Yii::$app->basePath . '/Images/profile_image/brand_logo/' . $model_acabrands->brand_logo;
							} else {
								$model_acabrands->brand_logo = $old_image;
							}
							
							if ($model_acabrands->save () && $model_acabrands->validate ()) { // model validated(server side validation)
								if (! empty ( $image )) { // saving path for image
									$image->saveAs ( $path );
									chmod ( $path, 0755 );
								}
								$transaction->commit (); // commit the transaction
								
								\Yii::$app->session->setFlash ( 'success', 'Brand updated successfully' );
								return $this->redirect ( array ( // redirecting to grid if brand is updated
										'/admin/masterdata' 
								) );
							} else {
								
								return $this->render ( 'editbrand', [  // render the array to editbrand view file
										'model' => $model_acabrands 
								] );
							}
						} else {
							$model_acabrands->addError ( 'brand_name', 'Brand name is already exist.' ); // model adding error
						}
					}
				} catch ( \Exception $e ) { // any \Exceptions catch throws error msg
					
					$msg = $e->getMessage ();
					\Yii::$app->session->setFlash ( 'error', $msg );
					
					$transaction->rollback ();             //if \Exception occurs transaction rollbacks
				}
				return $this->render ( 'editbrand', [  // render the array to editbrand view file
						'model' => $model_acabrands 
				] );
			}else{
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
			
			return $this->goHome ();
			}
			}else{
				\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
			
			return $this->goHome ();
			}
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Action for deletion brand details
	 */
	public function actionDeletebrand() {
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			
			$post = \Yii::$app->request->post (); // getting values by post method
			
			if (! empty ( $post ['id'] )) {
				$id = $post ['id'];
				$model_client = new TblAcaClients (); // initialising model tblacaclients
				$model_brands = new TblAcaBrands();
				$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
				try {
					
					$model = $model_brands->Branduniquedetails ( $id ); // Retriving the values of particular brand
					
					$check_brand = $model_client->findBybrandId ( $id ); // Retriving the values of particular brand which is used
					if (empty ( $check_brand )) {
						
						$model->is_deleted = 0;
						
						if ($model->save () && $model->validate ()) 						// model validated(server side validation)
						
						{
							echo 'success'; // sending response to ajax
							$transaction->commit (); // commit the transaction
						} else {
							
							echo 'Some error occurred';
						}
					} else {
						echo 'Brand cannot be deleted as it is already associated to a client.';
					}
				} catch ( \Exception $e ) { // any \Exceptions throws error msg
					
					$msg = $e->getMessage ();
					$transaction->rollback ();                         //if \Exception occurs transaction rollbacks
				}
			} else {
				echo 'fail'; // sending response to ajax
			}
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Action for activate/deactive brand
	 */
	public function actionBrandactivate() {
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			
			$post = \Yii::$app->request->post (); // getting values by post method
			$id = $post ['id'];
			$is_active = $post ['is_active'];
			$result = array();
			$model_brands = new TblAcaBrands();
			$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
			try {
				$model = $model_brands->Branduniquedetails ( $id ); // Retriving the values of particular brand
				
				$check_client_brand = TblAcaClients::find()->select('client_id')->where(['brand_id'=>$id])->andWhere(['is_deleted'=>0])->All();
				
				if ($is_active == 1) {
					
					if(empty($check_client_brand))
					{
						$model->brand_status = 2;
					}
					else
					{
						throw new \Exception ('Brand is already in use'); 
					}
					
					
				} elseif ($is_active == 2) {
					$model->brand_status = 1;
				}
				
				if ($model->save () && $model->validate ()) 				// model validated(server side validation)
				
				{
					
					$transaction->commit (); // commit the transaction
					$result['success']= 'success';
					
				} else {
					
					throw new \Exception ('Some error occured'); // sending response to ajax
				}
			} catch ( \Exception $e ) { // any \Exceptions throws error msg
				
				$msg = $e->getMessage ();
				$result['error'] = $msg;
				$transaction->rollback ();                        //if \Exception occurs transaction rollbacks
			}
			
			return json_encode($result);
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
			
			return $this->goHome ();
		}
	}
	public function actionVideos() {
		$this->layout = 'main';
		
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			
			return $this->render ( 'videos' );
		} else {
			\Yii::$app->SessionCheck->adminlogout ();
			
			return $this->goHome ();
		}
	}
	
	/**
	 * Action for rendering elements in the grid
	 */
	public function actionErrors() {
		\Yii::$app->view->title = 'ACA Reporting Service | Errors';
		$this->layout = 'main';
			$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];
		if (\Yii::$app->SessionCheck->isLogged () == true && in_array("12", $admin_permissions)) 		// checking logged session
		{
			$basic_report_rule_ids = array();
			$benefit_plan_rule_ids = array();
			$planclass_rule_ids = array();
			
			for($i=1;$i<=54;$i++)
			{
				$basic_report_rule_ids[] = $i;
			}
			$basic_report_rule_ids[] = 143;
			$basic_report_rule_ids[] = 144;
			$basic_report_rule_ids[] = 145;
			
			
			for($i=55;$i<=62;$i++)
			{
				$benefit_plan_rule_ids[] = $i;
			
			}
			
			for($i=63;$i<=74;$i++)
			{
				$planclass_rule_ids[] = $i;
			}
			$planclass_rule_ids[] = 148;
			/*if(\Yii::$app->Permission->CheckAdminactionpermission ( '9' ) == true)
                  {*/
			
			$basic_report_errors = TblAcaValidationRules::find()->where(['in', 'rule_id', $basic_report_rule_ids ])->all();
			$benefit_plan_errors = TblAcaValidationRules::find()->where(['in', 'rule_id', $benefit_plan_rule_ids])->all();
			$planclass_errors = TblAcaValidationRules::find()->where(['in', 'rule_id', $planclass_rule_ids ])->all();

			$payroll_errors = TblAcaValidationRules::find()->where(['element_type'=>2])->groupBy('error_code')->orderBy('error_code ASC')->All();
			$medical_errors = TblAcaValidationRules::find()->where(['element_type'=>3])->groupBy('error_code')->orderBy('error_code ASC')->All();
			
			return $this->render ( 'errors', [  // render values to element view page
					'payroll_errors' => $payroll_errors,
					'medical_errors' => $medical_errors,
					'planclass_errors' => $planclass_errors,
					'basic_report_errors' => $basic_report_errors,
					'benefit_plan_errors' => $benefit_plan_errors
			] );
			
		/*	}else{
					\Yii::$app->session->setFlash ( 'error', 'Permission denied' );
							return $this->redirect ( array (
									'/admin' 
							) );  
				  }*/
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
			
			return $this->goHome ();
		}
	}
	
		/**
	 * Action for update element label
	 */
	public function actionUpdateerrormessage() {
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			
			$post = \Yii::$app->request->get (); // getting values by post method
			$id = $post ['id'];
			$value = $post ['value'];
			
			$result = array();
			 
			$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
			try {
			
				$model_validation_rules = TblAcaValidationRules::find()->where(['rule_id'=>$id])->one(); // Retriving the values of particular element
				
				$model_validation_rules->error_message=$value;
				
				
			
				if ($model_validation_rules->save () && $model_validation_rules->validate ()) 				// model validated(server side validation)
				
				{
					
					$transaction->commit (); // commit the transaction
					$result['success']= 'success';
					
				} else {
					
					throw new \Exception ('Some error occured'); // sending response to ajax
				}
			} catch ( \Exception $e ) { // any \Exceptions throws error msg
				
				$msg = $e->getMessage ();
				$result['error'] = $msg;
				$transaction->rollback ();                        //if \Exception occurs transaction rollbacks
			}
			
			return json_encode($result);
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	/*
	*action for form pricing
	*/
	public function actionFormpricing(){
		\Yii::$app->view->title = 'ACA Reporting Service | Form pricing';
		$this->layout = 'main';
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$model_employer = TblAcaFormPricing::find()
			->where(['type'=>1])
			->orderBy([
			'price_id'=>SORT_ASC,
               ])
			->all();
			
			$model_employee = TblAcaFormPricing::find()
			->where(['type'=>2])
			->orderBy([
			'price_id'=>SORT_ASC,
               ])
			->all();
			return $this->render ( 'formpricing',[
			'model_employer'=>$model_employer,
			'model_employee'=>$model_employee
			]);
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	/* 
	*action for update pricing
	*/
	
		/**
	 * Action for update element label
	 */
	public function actionUpdatepricing() {
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$session = \Yii::$app->session;
	    	$logged_user_id = $session ['admin_user_id'];  
			$post = \Yii::$app->request->get (); // getting values by post method
			$id = $post ['id'];
			$value = $post ['value'];
			
			$result = array();
			 
			$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
			try {
			
				$model_pricing = TblAcaFormPricing::find()->where(['price_id'=>$id])->one(); // Retriving the values of particular element
				
				$model_pricing->value=abs($value);
				$model_pricing->modified_by=$logged_user_id;
				
				
			
				if ($model_pricing->save () && $model_pricing->validate ()) 				// model validated(server side validation)
				
				{
					
					$transaction->commit (); // commit the transaction
					$result['success']= 'success';
					
				} else {
					$error = $model_pricing->errors;
				
					throw new \Exception ($error['value'][0]); // sending response to ajax
				}
			} catch ( \Exception $e ) { // any \Exceptions throws error msg
				
				$msg = $e->getMessage ();
				$result['error'] = $msg;
				$transaction->rollback ();                        //if \Exception occurs transaction rollbacks
			}
			
			return json_encode($result);
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
			
			return $this->goHome ();
		}
	}

	/*
	 * action for manage 1095c codes
	*/
	public function actionManage1095c() {
		\Yii::$app->view->title = 'ACA Reporting Service | Manage 1095 Codes';
		$this->layout = 'main';
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$model_manage_codes = TblAcaManageCodes::find ()->all ();
			return $this->render ( 'manage1095c', [
					'model_manage_codes' => $model_manage_codes
					]
			);
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
				
			return $this->goHome ();
		}
	}
	
	/*
	 * action for fetch all function in js
	*/
	public function actionGetcodedata() {
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$model_manage_codes = new TblAcaManageCodes();
			$all_code_data = array ();
			$status = array ();
			$get_manage_codes = TblAcaManageCodes::find ()->asArray ()->all ();
				
			$line16 = $model_manage_codes->line16 ();
			$line14 = $model_manage_codes->line14 ();
		
				
			$all_code_data ['line14'] = $line14;
			$all_code_data ['line16'] = $line16;
			$all_code_data ['codedata'] = $get_manage_codes;
				
			return Json::encode ( $all_code_data );
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
				
			return $this->goHome ();
		}
	}
	
	/*
	 * action for save new record
	*/
	public function actionSavecodedata() {
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
	
			// check for the data post
			if (! empty ( $_POST ['newdata'] )) {
	
				// assiging Posted values to the variables
				$newdata = $_POST ['newdata'];
	
				if (isset ( $newdata ['line_16'] ) && $newdata ['line_16'] != ''){
					$line16 =  (int)($newdata ['line_16']) ;
				}else{
					$line16 =  null ;
				}
				if (isset ( $newdata ['line_14'] ) && $newdata ['line_14'] != ''){
					$line14 = (int)($newdata ['line_14']);
				}
	
				// check for existing combination
	
				$existing_combination = TblAcaManageCodes::find()->where(['line_14'=>$line14])->andWhere(['line_16'=>$line16])->one();
	
				if(empty($existing_combination)){
					$session = \Yii::$app->session;
					$logged_user_id = $session ['admin_user_id'];
						
					$response = array ();
						
					// initialising the model
					$model = new TblAcaManageCodes ();
						
					if (isset ( $newdata ['line_14'] ) && $newdata ['line_14'] != '')
						$model->line_14 =  $newdata ['line_14'] ;
						
						
					$model->line_16 =  $line16 ;
						
						
					
					if (isset ( $newdata ['code_combination'] ) && $newdata ['code_combination'] != ''){
						$code_combination =  preg_replace('/[^A-Za-z0-9 !@^&().]/u','', strip_tags($newdata ['code_combination']));
						$model->code_combination = $code_combination ;
					}

					if (isset ( $newdata ['employers_organizations'] ) && $newdata ['employers_organizations'] != ''){
						$employers_organizations =  preg_replace('/[^A-Za-z0-9 !@^&().]/u','', strip_tags($newdata ['employers_organizations']));
						$model->employers_organizations = $employers_organizations;
					}

					if (isset ( $newdata ['individuals_families'] ) && $newdata ['individuals_families'] != ''){
						$individuals_families =  preg_replace('/[^A-Za-z0-9 !@^&().]/u','', strip_tags($newdata ['individuals_families']));
						$model->individuals_families = $individuals_families;
					}
						
					if (isset ( $newdata ['status'] ) && $newdata ['status'] != '')
						$model->status = $newdata ['status'];
						
					$model->created_date = date('Y-m-d H:i:s');
					$model->created_by = $logged_user_id;
						
						
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
				}else{
					$response ['status'] = 2;
					$response ['message'] = 'This combination exist already';
				}
	
			} else {
				$response ['status'] = 2;
				$response ['message'] = 'Error Occured,while saving';
			}
			
			// returning the response
			echo json_encode ( $response );
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
				
			return $this->goHome ();
		}
	}
	
	
	/*
	 * action for update existing record
	*/
	public function actionUpdatecodedata() {
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
	
			// initialising
			$response = array ();
			$olddata = $_POST ['olddata'];
			// initialising the model
			$model = TblAcaManageCodes::findOne ( [
					'uid' => $olddata ['uid']
					] );
				
			// check for the data post
			if (! empty ( $_POST ['newdata'] )) {
	
				// assiging Posted values to the variables
				$newdata = $_POST ['newdata'];
	
				$session = \Yii::$app->session;
				$logged_user_id = $session ['admin_user_id'];
	
				$response = array ();
	
	
				if ((isset ( $newdata ['line_16'] ) && $newdata ['line_16'] != '') || (isset ( $newdata ['line_16'] ) && $newdata ['line_16'] == '')){
					
					if(isset ( $newdata ['line_16'] ) && $newdata ['line_16'] == ''){
					$line16 = null;
					}else{
					$line16 =  (int)($newdata ['line_16']) ;
						}
	 
				}else if(!empty($olddata ['line_16'])){
					$line16 =  (int)($olddata ['line_16']) ;
				}else{
					$line16 = null;
				}
				if (isset ( $newdata ['line_14'] ) && $newdata ['line_14'] != ''){
					$line14 = (int)($newdata ['line_14']);
				}else if(!empty($olddata ['line_14'])){
					$line14 = (int)($olddata ['line_14']);
				}
				
				//checking for existing codes
				if((isset ( $newdata ['line_14'] ) && $newdata ['line_14'] != '')  || (isset ( $newdata ['line_16'] ) && $newdata ['line_16'] != '') || (isset ( $newdata ['line_16'] ) && $newdata ['line_16'] == '')){
					$existing_combination = TblAcaManageCodes::find()->where(['line_14'=>$line14])->andWhere(['line_16'=>$line16])->one();
				
					if(!empty($existing_combination)){
						throw new \Exception ( 'Code combination exist' ); 	
					
					}
				}
		
					// assiging the values to the model based on the condition
					if (isset ( $newdata ['line_14'] ) && $newdata ['line_14'] != '')
						$model->line_14 =  $newdata ['line_14'] ;
					
					if ((isset ( $newdata ['line_16'] ) && $newdata ['line_16'] != '') || (isset ( $newdata ['line_16'] ) && $newdata ['line_16'] == ''))
						$model->line_16 =  $newdata ['line_16'] ;
					
					
					if ((isset ( $newdata ['code_combination'] ) && $newdata ['code_combination'] != '') || (isset ( $newdata ['code_combination'] ) && $newdata ['code_combination'] == '')){
						$code_combination =  preg_replace('/[^A-Za-z0-9 !@^&().]/u','', strip_tags($newdata ['code_combination']));
						$model->code_combination = $code_combination ;
		         	}

					if ((isset ( $newdata ['employers_organizations'] ) && $newdata ['employers_organizations'] != '' ) || (isset ( $newdata ['employers_organizations'] ) && $newdata ['employers_organizations'] == '')){
						$employers_organizations =  preg_replace('/[^A-Za-z0-9 !@^&().]/u','', strip_tags($newdata ['employers_organizations']));
						$model->employers_organizations = $employers_organizations;
			         }

					if ((isset ( $newdata ['individuals_families'] ) && $newdata ['individuals_families'] != '') || (isset ( $newdata ['individuals_families'] ) && $newdata ['individuals_families'] == '')){
						$individuals_families =  preg_replace('/[^A-Za-z0-9 !@^&().]/u','', strip_tags($newdata ['individuals_families']));
						$model->individuals_families = $individuals_families;
					}
					
					if (isset ( $newdata ['status'] ) && $newdata ['status'] != '')
						$model->status = $newdata ['status'];
					
					$model->modified_date = date('Y-m-d H:i:s');
					$model->modified_by = $logged_user_id;
					
					
					
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
					
							// commiting the model
							$transaction->commit ();
					
							$response ['status'] = 1;
							$response ['message'] = 'success';
						}
					} catch ( \Exception $e ) {
						$msg = $e->getMessage ();
						
						$response ['status'] = 0;
						$response ['message'] = $msg;
						// rollbacking the transaction
						$transaction->rollback ();
					}
						
			/*	}else{
					$response ['status'] = 2;
					$response ['message'] = 'This combination exist already';
				}
	*/
			
			} else {
				$response ['status'] = 2;
				$response ['message'] = 'Error occured while saving';
			}
	
			// returning the response
			echo json_encode ( $response );
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
	
			return $this->goHome ();
		}
	}
}
