<?php

/**
 * 
 * @author PRAVEEN
 * @date 18-08-2016
 */
namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\models\TblAcaUsers;
use app\models\TblAcaStaffUsers;
use yii\web\UploadedFile;
use app\models\TblAcaStaffRightsMaster;
use app\models\TblAcaStaffUserPermission;
use app\models\TblAcaStaffUsersSearch;
use app\components\EncryptDecryptComponent;

/**
 * Default controller for the `admin` module
 */
class UsersController extends Controller {
	/**
	 * Renders the index view for the module
	 *
	 * @return string
	 */
	public function actionIndex() {
		\Yii::$app->view->title = 'ACA Reporting Service | Manage Users';
		$this->layout = 'main';
		$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];
		if (\Yii::$app->SessionCheck->isLogged () == true && in_array("5", $admin_permissions)) 		// checking logged session
		{
			/*if(\Yii::$app->Permission->CheckAdminactionpermission ( '5' ) == true)
                  {*/
					  
			$model_permissions = new TblAcaStaffUserPermission ();      // initialising model 
			
			$searchModel = new TblAcaStaffUsersSearch();               // initialising model 
			$dataProvider = $searchModel->search( \Yii::$app->request->queryParams);
			
			return $this->render ( 'index', [                        // Rendering to index view
					
					'model_permissions' => $model_permissions ,
					'searchModel' => $searchModel,
					'dataProvider' => $dataProvider,
			] );
			
		/*	}else{
					\Yii::$app->session->setFlash ( 'error', 'Permission denied' );
							return $this->redirect ( array (
									'/admin' 
							) );  
				  }*/
				  
		} else {
			\Yii::$app->SessionCheck->adminlogout ();              // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	/*
	 * Add users function is used for adding admin users
	 */
	public function actionAddusers() {
		\Yii::$app->view->title = 'ACA Reporting Service | Add Users';
		$this->layout = 'main';
		
		$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];
		if (\Yii::$app->SessionCheck->isLogged () == true && in_array("5", $admin_permissions)) 		// checking logged session
		{
			$logged_user_id = $session ['admin_user_id'];
			$to = '';
			$name = '';
			$link = '';
			$staff_permissions_details = array ();
			// Assigning Models
			$model_users = new TblAcaUsers ();                              // initialising models
			$model_staff_users = new TblAcaStaffUsers ();
			$model_staff_rights = new TblAcaStaffRightsMaster ();
			$model_permissions = new TblAcaStaffUserPermission ();
			
			// get all staff rights from DB
			
			$staff_rights_details = $model_staff_rights->getAllpermissions ();
			
			// begin transaction
			$transaction = \Yii::$app->db->beginTransaction ();                // begining the transaction
			
			try {
				if ($model_users->load ( \Yii::$app->request->post () ) && $model_staff_users->load ( \Yii::$app->request->post () )) {      //checking the post values
					
					// To get all post details
					$staff_details = \Yii::$app->request->post ();                                  //assigning the post values to variable
					
					$random_salt = $model_users->generatePasswordResetToken ();
					
					$model_users->attributes = $staff_details ['TblAcaUsers'];                      //assigning values to model
					$model_users->usertype = 1; // 1 Denotes Admin User
					$model_users->created_date = date ( 'Y-m-d H:i:s' );
					$model_users->modified_date = date ( 'Y-m-d H:i:s' );
					$model_users->created_by = $logged_user_id;
					$model_users->modified_by = $logged_user_id;
					$model_users->random_salt = $random_salt;
					$model_users->is_verified = 0;
					$model_users->is_deleted = 0;
					$model_users->is_active = 0;
					
					
					
					if ($model_users->save () && $model_users->validate ()) {                    // validating model and saving it(server side validation)
						$user_id = $model_users->user_id;
						$model_staff_users->attributes = $staff_details ['TblAcaStaffUsers'];      //assigning values to model
						$model_staff_users->user_id = $user_id;
						
						if (! empty ( $staff_details ['TblAcaStaffUsers'] ['phone'] )) {
							$phone = preg_replace ( '/[^A-Za-z0-9\']/', '', $staff_details ['TblAcaStaffUsers'] ['phone'] ); // escape apostraphe
							$model_staff_users->phone = $phone;
						}
						
						$image = UploadedFile::getInstance ( $model_staff_users, 'profile_pic' );
						if ($image) {                    //checking for image instance
							$ext = explode ( ".", $image->name );
							$model_staff_users->profile_pic = $ext [0] . '_1_' . md5 ( $user_id ) . '.' . $ext [1];
							$path = \Yii::$app->basePath . '/Images/profile_image/' . $model_staff_users->profile_pic;
						}
						
						$model_staff_users->created_date = date ( 'Y-m-d H:i:s' );           //assigning values to model
						$model_staff_users->modified_date = date ( 'Y-m-d H:i:s' );
						$model_staff_users->created_by = $logged_user_id;
						$model_staff_users->modified_by = $logged_user_id;
						
						if ($model_staff_users->save () && $model_staff_users->validate ()) {                         // validating model and saving it(server side validation)
							
							$staff_id = $model_staff_users->staff_id;
							// moving image file to particular path
							if ($image) {
								$image->saveAs ( $path );                                 //saving the image in the path
								chmod ( $path, 0755 );
							}
							
							/*
							 * User Permissions
							 */
							
							if (! empty ( $staff_details ['staffpermissions'] )) {
								$permissions = $staff_details ['staffpermissions'];
								
								\Yii::$app->Permission->Adminstaffpermissions ( $staff_id, $permissions );            
							}
							/*
							 * Mail function
							 */
							
							// assigning mail variables
							$to = $staff_details ['TblAcaUsers'] ['useremail'];
							$name = $staff_details ['TblAcaStaffUsers'] ['first_name'];
							$link = \Yii::$app->urlManager->createAbsoluteUrl ( '/setaccount' ) . '?random_salt=' . $random_salt . '&id=' . md5 ( $user_id );
							$picture = 'ACA-Reporting-Logo.png';
							
					//$email_logo_link = (new MailComponent())->Custombrandemaillogo(1);
					$email_logo_link = \Yii::$app->CustomMail->Custombrandemaillogo(1);
			 		
					if($email_logo_link==''){
						$picture=$email_logo_link;
					}
					
					$link_brandimage = \Yii::$app->urlManager->createAbsoluteUrl ( '/Images' ).'/'. $picture;
					
							
							$from = 'admin@acareportingservice.com';
							
							
						//	\Yii::$app->CustomMail->Createadminusermail ( $to,$from, $name, $link );            //sending mail
							
							\Yii::$app->CustomMail->Createusermail ( $to,$from,$name,$link ,$link_brandimage );//, sending mail

														
							// end transaction
							$transaction->commit ();                         // commiting the transaction
							
							
							\Yii::$app->session->setFlash ( 'success', 'User added successfully' );
							return $this->redirect ( array (                 // Redirecting if added successfully
									'/admin/users' 
							) );
						}
					}
				}
			} catch ( Exception $e ) {                                   // catching the exception
				
				$msg = $e->getMessage ();
				\Yii::$app->session->setFlash ( 'error', $msg );
				
				// rollback transaction
				$transaction->rollback ();
			}
			return $this->render ( 'adduser', [                          // Rendering to adduser view
					'model_users' => $model_users,
					'model_staff_users' => $model_staff_users,
					'staff_rights_details' => $staff_rights_details,
					'staff_permissions_details' => $staff_permissions_details 
			] );
		} else {
			
			\Yii::$app->SessionCheck->adminlogout ();               // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	/*
	 * Add users function is used for updating particular admin users
	 */
	public function actionUpdateusers() {
		\Yii::$app->view->title = 'ACA Reporting Service | Update Users';
		$this->layout = 'main';
		$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];
		if (\Yii::$app->SessionCheck->isLogged () == true  && in_array("5", $admin_permissions)) 		// checking logged session
		{
			$get = \Yii::$app->request->get ();                     //grtting values 
			if (! empty ( $get ['id'] )) { 
				$id = $get ['id'];
				
				$encrypt_component = new EncryptDecryptComponent();  //decrypt the user id
				$id = $encrypt_component->decryptUser($id);
				
				$logged_user_id = $session ['admin_user_id'];
				
				 if($id !=1 || $logged_user_id==1){
				// Assigning Models
				$model_users = new TblAcaUsers ();                            // initialising models
				$model_staff_users = new TblAcaStaffUsers ();
				$model_staff_rights = new TblAcaStaffRightsMaster ();
				$model_permissions = new TblAcaStaffUserPermission ();
				
				$staff_rights_details = $model_staff_rights->getAllpermissions ();        //getting all permissions for the user
				$user_details = $model_users->findById ( $id );                            //getting unique details of user
				$staff_user_details = $model_staff_users->findById ( $id );
				
				if(!empty($staff_user_details)){
				$staff_id = $staff_user_details->staff_id; // staff Id
				$user_id =  $staff_user_details->user_id; // user Id  
				$profile_pic =  $staff_user_details->profile_pic;
				// returns all permissions as array
				$staff_permissions_details = $model_permissions->findpermissionsById ( $staff_id );
				
				$transaction = \Yii::$app->db->beginTransaction ();               // begining the transaction
				
				try {
					if ($staff_user_details->load ( \Yii::$app->request->post () )) {                      //checking the post values
						
						$staff_details = \Yii::$app->request->post ();
						
							$staff_user_details->attributes = $staff_details ['TblAcaStaffUsers'];
							
							
							if (! empty ( $staff_details ['TblAcaStaffUsers'] ['phone'] )) {
								$phone = preg_replace ( '/[^A-Za-z0-9\']/', '', $staff_details ['TblAcaStaffUsers'] ['phone'] ); // escape apostraphe
								$staff_user_details->phone = $phone;
							}
							
							$image = UploadedFile::getInstance ( $staff_user_details, 'profile_pic' );        //getting instance of image upload
							if (!empty($image)) {                             //checking for image 
								$ext = explode ( ".", $image->name );
								$staff_user_details->profile_pic = $ext [0] . '_1_' . md5 ( $user_id ) . '.' . $ext [1];
								$path = \Yii::$app->basePath . '/Images/profile_image/' . $staff_user_details->profile_pic;    //path for image to upload
							}else{
								$staff_user_details->profile_pic=$profile_pic;                   //assigning values
							}
							
							$staff_user_details->modified_date = date ( 'Y-m-d H:i:s' );
							$staff_user_details->modified_by = $logged_user_id;
							
							if ($staff_user_details->save () && $staff_user_details->validate ()) {                    // validating model and saving it(server side validation)
								
								// moving image file to particular path
								if (!empty($image)) {
									$image->saveAs ( $path );
									chmod ( $path, 0755 );
								}
								
								/*
								 * User Permissions
								 */
								
								if($id != $logged_user_id)             //checking for logged userid and updating user id 
								{
							
								
								if (! empty ( $staff_details ['staffpermissions'] )) {
									$permissions = $staff_details ['staffpermissions'];
									
									\Yii::$app->Permission->Adminstaffpermissions ( $staff_id, $permissions );   //saving the permissions using function
								}else {
									$permissions = '';
									
									\Yii::$app->Permission->Adminstaffpermissions ( $staff_id, $permissions );
								} 
								
								}
								
								$transaction->commit ();                         // commiting the transaction
								\Yii::$app->session->setFlash ( 'success', 'User updated successfully' );
								return $this->redirect ( array (                                             //redirecting to users grid with success message
										'/admin/users' 
								) );
							}
						
					}
				} catch ( Exception $e ) {                  // catching the exception
					
					$msg = $e->getMessage ();
					\Yii::$app->session->setFlash ( 'error', $msg );
					
					$transaction->rollback ();           //if exception occurs transaction rollbacks
				}
				 }else{
					 return $this->redirect ( array (                      //redirecting to users grid
						'/admin/users' 
				) );
				 }
			}else{
				
				\Yii::$app->session->setFlash ( 'error', 'Permision denied' );
				return $this->redirect ( array (                                             //redirecting to users grid with success message
						'/admin/users'
				) );
				
			}
					
				return $this->render ( 'updateuser', [                //render the values to update user view
						'model_users' => $user_details,
						'model_staff_users' => $staff_user_details,
						'staff_rights_details' => $staff_rights_details,
						'staff_permissions_details' => $staff_permissions_details 
				] );
			} else {
				return $this->redirect ( array (                      //redirecting to users grid
						'/admin/users' 
				) );
			}
		} else {
			
			\Yii::$app->SessionCheck->adminlogout ();         // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	/*
	 * Activate User
	 */
	
		public function actionUseractivate() {
		
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			
		$post=\Yii::$app->request->post ();                      //getting the values through post
		$id = $post ['id'];
		$is_active = $post ['is_active'];
		$transaction = \Yii::$app->db->beginTransaction ();      // begining the transaction
		$model_users = new TblAcaUsers ();                       // initialising model 
		try {
			$user_details = $model_users->findById ( $id );
			
			if ($is_active == 1) {                              //assigning values to model
				$user_details->is_active = 0;
			} elseif ($is_active == 0) {
				$user_details->is_active = 1;
			}
			
			if ($user_details->save () && $user_details->validate ())     // validating model and saving it(server side validation)

			{
				echo 'success';                                 // sending response to ajax
				$transaction->commit ();                        // commiting the transaction
			} else {
				
				echo 'fail';                                  // sending response to ajax
			}
		} catch ( Exception $e ) {                              // catching the exception
			
			$msg = $e->getMessage ();
			\Yii::$app->session->setFlash ( 'error', $msg );
    		 
    		$transaction->rollback ();                      //if exception occurs transaction rollbacks
    	}
		
		} else {
			\Yii::$app->SessionCheck->adminlogout ();             // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
		
		  }   
		  
	/*
	 * Assign permissions to the user
	 */
	public function actionPermission() {
		$this->layout = 'main';
		$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];               //getting the session variables
		$logged_user_id = $session ['admin_user_id'];
		$model_staff_users = new TblAcaStaffUsers ();                       // initialising models
		$model_permissions = new TblAcaStaffUserPermission ();
		$model_staff_rights = new TblAcaStaffRightsMaster ();
		
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$get = \Yii::$app->request->get ();
			if (! empty ( $get ['id'] )) {
				
				
				$id = $get ['id'];
				$encrypt_component = new EncryptDecryptComponent();                //component to decrpt id
				$id = $encrypt_component->decryptUser($id);
				
				$staff_user_details = $model_staff_users->findById ( $id );          //finding unique details of id
				if(!empty($staff_user_details)){
				$user_id= $staff_user_details->user_id; //User Id
				$staff_id = $staff_user_details->staff_id; // staff Id
				$staff_name = $staff_user_details->first_name; // staff name
				
				$staff_rights_details = $model_staff_rights->getAllpermissions ();               
				// returns all permissions as array
				$staff_permissions_details = $model_permissions->findpermissionsById ( $staff_id );
				
				if($user_id != $logged_user_id && $user_id!=1)
				{
				if ( \Yii::$app->request->post () != null) {                       //checking the post values
					$transaction = \Yii::$app->db->beginTransaction ();            // begining the transaction
					try {
						$staff_details = \Yii::$app->request->post ();
						/*
						 * User Permissions
						 */
						if (! empty ( $staff_details ['staffpermissions'] )) {         //saving the permissions of user
							$permissions = $staff_details ['staffpermissions'];
							
							\Yii::$app->Permission->Adminstaffpermissions ( $staff_id, $permissions );
						} else {
							$permissions = '';
							
							\Yii::$app->Permission->Adminstaffpermissions ( $staff_id, $permissions );
						}
						
						$transaction->commit ();                               // commiting the transaction
						\Yii::$app->session->setFlash ( 'success', 'User permissions updated successfully' );
						return $this->redirect ( array (
								'/admin/users' 
						) );
					} catch ( Exception $e ) {                              // catching the exception
						
						$msg = $e->getMessage ();
						\Yii::$app->session->setFlash ( 'error', $msg );
						
						$transaction->rollback ();                         //if exception occurs transaction rollbacks
					}
				}
				
				return $this->render ( 'permission', [                    //rendering the values to permission view
						'staff_permissions_details' => $staff_permissions_details,
						'staff_rights_details' => $staff_rights_details,
						'staff_name'=>$staff_name
				] );
				
				}
				else {
					\Yii::$app->session->setFlash ( 'error', 'Permission Denied' );   //error msg for user who doesnt have permission
						
					return $this->redirect ( array (
							'/admin/users'
					) );
				}
				
			}
				
			} else {
				return $this->redirect ( array (              //redirecting to users grid if id is not defined
						'/admin/users' 
				) );
			}
		} else {
			
			\Yii::$app->SessionCheck->adminlogout ();          // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
	}
}
