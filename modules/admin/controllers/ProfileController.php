<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\models\Clients;
use app\models\TblAcaClients;
use app\models\TblAcaUsers;
use app\models\TblAcaStaffUsers;
use app\models\TblAcaBrands;
use yii\base\ErrorException;
use yii\base\Exception;
use app\models\TblAcaCompanies;
use yii\web\UploadedFile;
use app\models\TblAcaCompanyReportingPeriod;
use app\models\TblAcaClientsSearch;
use yii\db\Query;
use app\components\EncryptDecryptComponent;
use app\models\TblAcaStaffRightsMaster;
use app\models\TblAcaStaffUserPermission;

/**
 * Default controller for the `admin` module
 */
class ProfileController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$this->layout = 'main';
		$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];
		
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$get = \Yii::$app->request->get ();                 //getting the values 
			if (! empty ( $get ['id'] )) {                     //checking for null
				$id = $get ['id'];
				
				$encrypt_component = new EncryptDecryptComponent();  //component for decrypt the id
				$id = $encrypt_component->decryptUser($id);
				
				$logged_user_id = $session ['admin_user_id'];
				
				// Assigning Models
				$model_users = new TblAcaUsers ();                  //initialising the model
				$model_staff_users = new TblAcaStaffUsers ();
				$model_staff_rights = new TblAcaStaffRightsMaster() ;
				$model_permissions = new TblAcaStaffUserPermission();
				
				$staff_rights_details = $model_staff_rights->getAllpermissions ();    //getting all the permissions
				$user_details = $model_users->findById ( $id );                       //finding the user by id
				$staff_user_details = $model_staff_users->findById ( $id );
				
				if(!empty($staff_user_details)){
				
				$staff_id = $staff_user_details->staff_id; // staff Id
				$user_id =  $staff_user_details->user_id; // user Id  
				$profile_pic =  $staff_user_details->profile_pic;
				// returns all permissions as array
				$staff_permissions_details = $model_permissions->findpermissionsById ( $staff_id );
				
				$transaction = \Yii::$app->db->beginTransaction ();             // begining the transaction
				
				try {
					
					if ($staff_user_details->load ( \Yii::$app->request->post () )) {           //checking for post values
						
						$staff_details = \Yii::$app->request->post ();
						
							$staff_user_details->attributes = $staff_details ['TblAcaStaffUsers'];   //assigning values
							
							
							if (! empty ( $staff_details ['TblAcaStaffUsers'] ['phone'] )) {
								$phone = preg_replace ( '/[^A-Za-z0-9\']/', '', $staff_details ['TblAcaStaffUsers'] ['phone'] ); // escape apostraphe
								$staff_user_details->phone = $phone;
							}
							
							$image = UploadedFile::getInstance ( $staff_user_details, 'profile_pic' );  //getting for image instance
							if ($image) {                                                              //checking for image
								$ext = explode ( ".", $image->name );
								$staff_user_details->profile_pic = $ext [0] . '_1_' . md5 ( $user_id ) . '.' . $ext [1];
								$path = \Yii::$app->basePath . '/Images/profile_image/' . $staff_user_details->profile_pic; //providing path for image
							
							}else{
								$staff_user_details->profile_pic=$profile_pic;         //assigning values
							}
							
							$staff_user_details->modified_date = date ( 'Y-m-d H:i:s' );
							$staff_user_details->modified_by = $logged_user_id;
							
							if ($staff_user_details->save () && $staff_user_details->validate ()) {      //validating and saving the model
								
								// moving image file to particular path
								if ($image) {
									$image->saveAs ( $path );
									chmod ( $path, 0755 );
								}
								
								/*
								 * User Permissions
								 */
								
								if($id != $logged_user_id)      //checking for logged user and updating user here
								{
							
								
								if (! empty ( $staff_details ['staffpermissions'] )) {
									$permissions = $staff_details ['staffpermissions'];
									
									\Yii::$app->Permission->Adminstaffpermissions ( $staff_id, $permissions );
								} 
								
								}
								
								$transaction->commit ();           //commiting the transaction
								\Yii::$app->session->setFlash ( 'success', 'User updated successfully' );
							                                     //redirecct the values to view
						return $this->redirect ( array (
    							'/admin'
    					) );
							}
						
					}
				} catch ( Exception $e ) {                             //catches the exception
					
					$msg = $e->getMessage ();
					\Yii::$app->session->setFlash ( 'error', $msg );
					
					$transaction->rollback ();                  //if exception occurs transaction rollbacks
				}
				
				return $this->render ( 'profile', [           //render the values to profile view
						'model_users' => $user_details,
						'model_staff_users' => $staff_user_details,
						'staff_rights_details' => $staff_rights_details,
						'staff_permissions_details' => $staff_permissions_details 
				] );
				}else {
				\Yii::$app->SessionCheck->adminlogout ();          // Redirecting to home page if session destroyed
			
			return $this->goHome ();
			}
			} else {
				\Yii::$app->SessionCheck->adminlogout ();          // Redirecting to home page if session destroyed
			
			return $this->goHome ();
			}
		} else {
			
			\Yii::$app->SessionCheck->adminlogout ();          // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
    }
	
    
}
