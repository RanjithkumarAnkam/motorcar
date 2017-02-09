<?php

namespace app\modules\client\controllers;

use yii\web\Controller;
use app\models\PasswordForm;
use app\models\TblAcaUsers;
use app\models\TblAcaClients;
use yii\web\UploadedFile;
use app\models\TblAcaStaffUsers;
use app\models\TblAcaCompanyUsers;
use app\models\TblAcaVideoLinks;
use app\models\TblCityStatesUnitedStates;

/**
 * Default controller for the `agent` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
    	{
    	$this->layout='main';
		
		return $this->redirect ( array (
										'/client/companies'
								) );
								
       
		} else {
        	\Yii::$app->SessionCheck->clientlogout ();
        		
        	return $this->goHome ();
        }
    }
    
    public function actionProfile()
    {
    	$this->layout='main';
    	return $this->render('profile');
    }
    
	/*
	**Action for getting cities 
	*/
	    public function actionGetcities()
    {
			 if(\Yii::$app->request->get ()){
				$post_values = \Yii::$app->request->get ();
			  }
		

		$result=array();   
		$output=array();                                         //initialising array
		if(!empty($post_values)){
			
		$value=$post_values['value'];                //assigning the values
	
		try {
			
			
		$model = TblCityStatesUnitedStates::find()->where(['state' => $value])->all();  //getting the array
		$i=0;
		foreach($model as $a){
			$output[$i]['LocationId']=$a->locationID;
			$output[$i]['Cities']=$a->city;
			$i++;
		}
		
		
				if(!empty($output))
				{
		 
					$result['success']=$output;                         //assigning to array
				}
				else
				{
					
					$result['fail']='No cities found';
				}
		
			} catch ( \Exception $e ) {                      //catch the exceptions
			
				$msg = $e->getMessage ();
				$result ['fail'] = $msg;
			
			}
		}else{
			
			$result['fail']='No citiese exist screen';            //on fail send this message
		}
	    
		return json_encode ( $result );
    }
	
	
	  public function actionUpdateprofilename()
    {
    $this->layout = 'main';
		$session = \Yii::$app->session;
		if (\Yii::$app->SessionCheck->isclientLogged () == true)  		// checking logged session
		{
			
		$logged_user_id = $session ['client_user_id'];
		
		
		
		$transaction = \Yii::$app->db->beginTransaction ();
		try {
			
			if($session['is_client'] == 'client')
			{
				$modelclients = TblAcaClients::Findbyuserid($logged_user_id);
				$old_image = $modelclients->profile_image;
				if ($modelclients->load ( \Yii::$app->request->post () )) {
			
				$client_details = \Yii::$app->request->post ();
				
			
			
				$modelclients->attributes = $client_details ['TblAcaClients'];
				
				
				$image = UploadedFile::getInstance ( $modelclients, 'profile_image' );
				$rnd = rand ( 0, 99999 );
				if (!empty($image)) {
					$ext = explode ( ".", $image->name );
					$modelclients->profile_image = $ext [0] . '_1_' . md5 ( $logged_user_id ) . '.' . $ext [1];
					
					$path = \Yii::$app->basePath . '/Images/profile_image/' . $modelclients->profile_image;
				}else{
						$modelclients->profile_image = $old_image;
					}
				if ($modelclients->save () && $modelclients->validate ()) {
					if (!empty($image)) {
						$image->saveAs ( $path );
						chmod ( $path, 0755 );
					}
					
					$transaction->commit ();
					
					\Yii::$app->session->setFlash ( 'success', 'Profile details updated successfully' );
					
					
				
				
				} else {
					
					\Yii::$app->session->setFlash ( 'error', 'Profile details cannot be updated' );
				
				}
		
			}
				
			}
			else
			{
				$modelcompanyuser = TblAcaCompanyUsers::FindByuserId($logged_user_id);
				$old_image = $modelcompanyuser->profile_image;
				if ($modelcompanyuser->load ( \Yii::$app->request->post () )) {
			
				$companyuser_details = \Yii::$app->request->post ();
				
			
			
				$modelcompanyuser->attributes = $companyuser_details ['TblAcaCompanyUsers'];
				
				
				$image = UploadedFile::getInstance ( $modelcompanyuser, 'profile_image' );
				$rnd = rand ( 0, 99999 );
				if (!empty($image)) {
					$ext = explode ( ".", $image->name );
					$modelcompanyuser->profile_image = $ext [0] . '_1_' . md5 ( $logged_user_id ) . '.' . $ext [1];
					
					$path = \Yii::$app->basePath . '/Images/profile_image/' . $modelcompanyuser->profile_image;
				}else{
						$modelcompanyuser->profile_image = $old_image;
					}
				if ($modelcompanyuser->save () && $modelcompanyuser->validate ()) {
					if (!empty($image)) {
						$image->saveAs ( $path );
						chmod ( $path, 0755 );
					}
					
					$transaction->commit ();
					
					\Yii::$app->session->setFlash ( 'success', 'Profile details updated successfully' );
					
					
				
				
				} else {
					
					\Yii::$app->session->setFlash ( 'error', 'Profile details cannot be updated' );
				
				}
		
			}
				
			
				
				
				
			}
			
		} catch ( \Exception $e ) {
			
			$msg = $e->getMessage ();
			\Yii::$app->session->setFlash ( 'error', $msg );
			
			$transaction->rollback ();
		}
		return $this->redirect ( array (
							'/client'
					) );
		
		} else {
		
			\Yii::$app->SessionCheck->clientlogout ();
        		
        	return $this->goHome ();
		}
	     
    }
	
	  public function actionClientprofile()
    {
    
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
		{
			
		
		$model_clients = new TblAcaClients();
		$model_company_users = new TblAcaCompanyUsers ();
		
		$session = \Yii::$app->session;
		$get=\Yii::$app->request->get ();
		$id= $logged_id = $session['client_user_id'];
		if($session['is_client'] == 'client')
		{
		$client_details = $model_clients->findbyuserid($id);
		
		$name = $client_details->contact_first_name;
		$lastname = $client_details->contact_last_name;
		$id = $client_details->client_id;
		$email = $client_details->email;
		$member_since = date ( "j M Y", strtotime ( $client_details->created_date ) );
		}
		else 
		{
			$company_user_details = $model_company_users->FindByuserId($id);
			$name = $company_user_details->first_name;
			$lastname = $company_user_details->last_name;
			$email =$company_user_details->email;
			$id =$company_user_details->client_id;
			$member_since = date ( "j M Y", strtotime ( $company_user_details->created_date ) );
		}
		
		
		$arrProfile=array("name"=>$name,
				"lastname"=>$lastname,
				"email"=>$email
			);
		
		echo json_encode($arrProfile);
		
		} else {
			\Yii::$app->SessionCheck->clientlogout ();
        		
        	return $this->goHome ();
		}
		
    }
	
    public function actionChangepassword() {
		if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
    	{
    	$get_details = \Yii::$app->request->get ();
    	$model_password = new PasswordForm ();
    	$model_users = new TblAcaUsers ();
    	$output = array ();
    
    	$session = \Yii::$app->session;
    	$logged_user_id = $session ['client_user_id'];
    	if (! empty ( $get_details ['oldpass'] ) && ! empty ( $get_details ['newpass'] ) && ! empty ( $get_details ['repeatnewpass'] )) {
    		$oldpass = $get_details ['oldpass'];
    		$newpass = $get_details ['newpass'];
    		$repeatnewpass = $get_details ['repeatnewpass'];
    			
    		$model_password->oldpass = $oldpass;
    		$model_password->newpass = $newpass;
    		$model_password->repeatnewpass = $repeatnewpass;
    			
    		$transaction = \Yii::$app->db->beginTransaction ();
    		try {
    			if ($model_password->validate ()) {
    				$user_details = $model_users->findById ( $logged_user_id );
    				$user_details->setPassword ( $newpass );
    					
    				if ($user_details->save ()) {
    					$transaction->commit();
    					$output ['success'] = 'success';
    
    				}
    			} else {
    				$output ['fail'] = $model_password->errors;
    			}
    		} catch ( \Exception $e ) {
    
    			$msg = $e->getMessage ();
    			$output ['fail'] = $msg;
    
    			$transaction->rollback ();
    		}
    		return json_encode ( $output );
    	}
		} else {
        	\Yii::$app->SessionCheck->clientlogout ();
        		
        	return $this->goHome ();
        }
    }
    
	
	/**
	 * Action for getting video links 
	 */
	public function actionGettingvideolink() {
		
	if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
	{
		
		$post_values = \Yii::$app->request->post ();

		$result=array();                                            //initialising array
		if(!empty($post_values)){
			
		$screen_id=$post_values['screen_id'];                //assigning the values
	
		try {
			
			
		    $model = TblAcaVideoLinks::find()->where(['vedio_uid' => $screen_id])->one();  //getting the array
		
		
				if(!empty($model->url))
				{
		 
					$result['success']=$model->url;                          //assigning to array
				}
				else
				{
					
					$result['success']='https://www.youtube.com/embed/vFIy7wSAnHg';
				}
		
			} catch ( \Exception $e ) {                      //catch the exceptions
			
				$msg = $e->getMessage ();
				$result ['fail'] = $msg;
			
			}
		}else{
			
			$result['fail']='No link exist for this screen';            //on fail send this message
		}
	    return json_encode ( $result );
	} else {
		\Yii::$app->SessionCheck->clientlogout (); // Redirecting to home page if session destroyed
	
		return $this->goHome ();
	}
}
	
    public function actionProjects()
    {
    	$this->layout='main';
    	return $this->render('projects');
    }
}
