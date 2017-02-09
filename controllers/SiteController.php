<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SetPasswordForm;
use app\models\TblAcaStaffUsers;
use app\models\TblAcaUsers;
use app\models\ForgotPasswordForm;
use app\components\EncryptDecryptComponent;
use app\models\TblAcaClients;
use app\models\TblAcaBrands;
use app\models\TblAcaCompanyUsers;
use app\models\TblAcaCompanies;
use app\models\TblAcaCompanyUserPermission;
use yii\web\HttpException;
use app\components\MailComponent;
use app\models\TblAcaManageCodes;

class SiteController extends Controller {
	/**
	 * @inheritdoc
	 */
	/**
	 * @var string the view file to be rendered. If not set, it will take the value of [[id]].
	 * That means, if you name the action as "error" in "SiteController", then the view name
	 * would be "error", and the corresponding view file would be "views/site/error.php".
	 */
	public $view;
	/**
	 * @var string the name of the error when the exception name cannot be determined.
	 * Defaults to "Error".
	 */
	public $defaultName;
	/**
	 * @var string the message to be displayed when the exception message contains sensitive information.
	 * Defaults to "An internal server error occurred.".
	 */
	public $defaultMessage;
	
	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [ 
				'err' => [ 
						'class' => 'yii\web\ErrorAction' 
				],
				'captcha' => [ 
						'class' => 'yii\captcha\CaptchaAction',
						'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null 
				] 
		];
	}
	
	public function behaviors()
	{
		return [
		'access' => [
		'class' => \yii\filters\AccessControl::className(),
		'only' => ['create', 'update'],
		'rules' => [
		// deny all POST requests
		[
		'allow' => false,
		'verbs' => ['GET']
		],
		// allow authenticated users
		[
		'allow' => true,
		'roles' => ['@'],
		],
		// everything else is denied
		],
		],
		];
	}
	
	
	
	/*
	 * this function is used to manage custom errors
	 */
	public function actionError(){
		
		//echo "as"; die();
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            // action has been invoked not from error handler, but by direct route, so we display '404 Not Found'
            $exception = new HttpException(404, Yii::t('yii', 'Page not found.'));
        }
        
       
       
        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }
       // print_r($code); die();
        if ($exception instanceof Exception) {
            $name = $exception->getName();
        } else {
            $name = $this->defaultName ?: Yii::t('yii', 'Error');
        }
        if ($code) {
            $name .= " (#$code)";
        }
        
        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message = $this->defaultMessage ?: Yii::t('yii', 'An internal server error occurred.');
        }
//        print_r($message); die();
        if (Yii::$app->getRequest()->getIsAjax()) {
            return "$name: $message";
        } else {
            return $this->render('error', [
                'name' => $name,
                'message' => $message,
                'exception' => $exception,
            ]);
        }
    }
	
	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex() {
      
		header("Location: ".Yii::$app->getUrlManager()->getBaseUrl()."/login");
        exit();

	}
	
	/**
	 * Login action.
	 *
	 * @return string
	 */
	public function actionLogin() {
		$this->layout = 'login';
		
		
		$model = new LoginForm ();                        //intialising models
		$model_clients = new TblAcaClients();
		$model_company_users = new TblAcaCompanyUsers();
		$client_ids = array();                            //initialising arrays
		$company_ids = array();
		$company_user_id = '';
		
		if ($model->load ( \Yii::$app->request->post () ) && $model->login ()) {      //checking for post values and validating login function
			session_regenerate_id(true);
			$session = \Yii::$app->session;                     //initialising session
			$usertype = $session ['logged_usertype'];           
			$logged_id = $session ['logged_id'];
			$useremail = $session ['logged_username'];
			$permissions = $session ['logged_permissions'];
			
			if ($usertype == 1) {
				$session['is_admin'] = 'admin';               //checking for admin 
				$session['admin_user_id'] = $logged_id;        //storing the values in session
				$session['admin_email'] = $useremail;
				$session['admin_permissions'] = $permissions;
				
				unset($session['logged_usertype']);             
				unset($session['logged_username']);
				unset($session['logged_id']);
				unset($session['logged_permissions']);
				unset ( $session ['shadow_login_id'] ); 
				return $this->redirect ( array (                  //redirecting to admin page
						'/admin' 
				) );
			} elseif ($usertype == 2) {
				
				
				
				$session['is_client'] = 'client';        //checking for client
				$session['client_user_id'] = $logged_id;
				// get all related client
    			/*$client_details =  TblAcaClients::FindallclientsbyId($logged_id);     
    			if(!empty($client_details))
    			{
    				foreach ($client_details as $details)
    				{
    				$client_id = $details->client_id;
    				$company_details = TblAcaCompanies::GetallcompaniesbyclientId($client_id);  //getting details of company which client has
    				$client_ids[] = $client_id;
    				
    				if(!empty($company_details))
    				{
    					foreach($company_details as $company)
    					{
    						$company_ids[] = $company->company_id;            //storing values in array
    					}
    					
    				}
    				}
    			}
    			*/
				
				$company_user_details = TblAcaCompanyUsers::FindByuserIds($logged_id);    
				
				if(!empty($company_user_details))
    			{
    				foreach ($company_user_details as $details)
    				{
    					$company_user_id = $details->company_user_id;
    					$assigned_company_details = TblAcaCompanyUserPermission::GetallcompaniesbycompanyuserId($company_user_id); //checking for assigned companies
    					
    					if(!empty($assigned_company_details))
    					{
    						foreach ($assigned_company_details as $company_details)
    						{
    							$company_ids[] = $company_details->company_id;       //storing values in array
    						}
    					
    					}
    				$client_ids[] = $details->client_id;
    				}
    			}
    			
    			$session['client_ids'] = $client_ids;                     //storing the values in session
    			$session['company_ids'] = $company_ids;
				$session['client_email'] = $useremail;
				$session['client_permissions'] = $permissions;
				
				unset($session['logged_usertype']);
				unset($session['logged_username']);
				unset($session['logged_id']);
				unset($session['logged_permissions']); 							//destroying sessions
				unset ( $session ['shadow_login_id'] ); 
				return $this->redirect ( array (                     //redirecting to admin page
						'/client/companies' 
				) );
				
			}
			elseif($usertype == 3)
			{
				
				$session['is_client'] = 'companyuser';                 //checking for company user
				$session['client_user_id'] = $logged_id;
				
				$company_user_details = TblAcaCompanyUsers::FindByuserIds($logged_id);    
				
				if(!empty($company_user_details))
    			{
    				foreach ($company_user_details as $details)
    				{
    					$company_user_id = $details->company_user_id;
    					$assigned_company_details = TblAcaCompanyUserPermission::GetallcompaniesbycompanyuserId($company_user_id); //checking for assigned companies
    					
    					if(!empty($assigned_company_details))
    					{
    						foreach ($assigned_company_details as $company_details)
    						{
    							$company_ids[] = $company_details->company_id;       //storing values in array
    						}
    					
    					}
    				$client_ids[] = $details->client_id;
    				}
    			}
    			
    			
    			$session['client_ids'] = $client_ids;         //storing the values in the session
    			$session['company_ids'] = $company_ids;
				$session['client_email'] = $useremail;
				$session['client_permissions'] = $permissions;
				
				unset($session['logged_usertype']);
				unset($session['logged_username']);
				unset($session['logged_id']);
				unset($session['logged_permissions']); //destroying sessions
				unset ( $session ['shadow_login_id'] ); 
				return $this->redirect ( array (      //redirecting to company user page
						'/client/companies'
				) );
			}
		} else {
			
			return $this->render ( 'login', [             //if invalid user redirects to login page
					
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Shadow Login action for admin.
	 */
	public function actionShadowlogin()
	{
		$get_user_id = \Yii::$app->request->get ();          //getting the values through get method
		$encrypted_user_id = $get_user_id['id'];
		$model_users =  new TblAcaUsers();                   //initialising models
		$encrypt_component = new EncryptDecryptComponent();  //component for encrypt and decrypt user id
		$model_clients = new TblAcaClients();
		$model_companies = new TblAcaCompanies();
		$model_company_users = new TblAcaCompanyUsers();
		$client_ids = array();                               //initialising array
		$company_ids = array();
		
		if(!empty($encrypted_user_id))
		{
			$session = \Yii::$app->session;                  //initialising session
		
			unset ( $session ['is_client'] );
			unset ( $session ['client_ids'] );
			unset ( $session ['company_ids'] );
			unset ( $session ['client_user_id'] );
			unset ( $session ['client_email'] );
			unset ( $session ['client_permissions'] );
			unset ( $session ['shadow_login_id'] ); 
			
			if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
    	{
			
    		$user_id = $encrypt_component->decryptUser($encrypted_user_id);
			
    		$user_details = $model_users->findById($user_id);
    		$permissions = '';
    		
    		if(!empty($user_details))
    		{
    			$session['is_client'] = 'client';
    			$session['client_user_id'] = $user_id;
    			$session['shadow_login_id'] = $session['admin_user_id'];
    			// get all related client
    			
				/*$client_details =  $model_clients->FindallclientsbyId($user_id);
    			if(!empty($client_details))
    			{
    				foreach ($client_details as $details)
    				{
    				$client_id = $details->client_id;
    				$company_details = $model_companies->GetallcompaniesbyclientId($client_id); //getting company details
    			
    				$client_ids[] = $client_id;
    				
    				if(!empty($company_details))
    				{
    					foreach($company_details as $company)
    					{
    						$company_ids[] = $company->company_id;     //storing company values in array
    					}
    					
    				}
    				}
    			}
    			*/
				
				$company_user_details = TblAcaCompanyUsers::FindByuserIds($user_id);    
				
				if(!empty($company_user_details))
    			{
    				foreach ($company_user_details as $details)
    				{
    					$company_user_id = $details->company_user_id;
    					$assigned_company_details = TblAcaCompanyUserPermission::GetallcompaniesbycompanyuserId($company_user_id); //checking for assigned companies
    					
    					if(!empty($assigned_company_details))
    					{
    						foreach ($assigned_company_details as $company_details)
    						{
    							$company_ids[] = $company_details->company_id;       //storing values in array
    						}
    					
    					}
    				$client_ids[] = $details->client_id;
    				}
    			}
				
    			$session['client_ids'] = $client_ids;                 //storing the values in the session
    			$session['company_ids'] = $company_ids;
    			$session['client_email'] = $user_details->useremail;
    			$session['client_permissions'] = $permissions;
    			
    			return $this->redirect ( array (                      //redirecting to client page
    					'/client/companies'
    			) );
    		}
    		else 
    		{
    			Yii::$app->session->setFlash('error', 'User does not exists');     //if invalid user redirects with error msg
    		}
    		
    		
    		
    		
    	}else {
        
        	\Yii::$app->SessionCheck->adminlogout ();
        
        	return $this->goHome ();
        }
		}
		
	}
	/**
	* action to set password
	 */
	public function actionSetaccount() {
		$this->layout = 'login';                        //using login layout
		$model = new SetPasswordForm ();                //initialising model         
		$model_users = new TblAcaUsers ();
		$get_user_details = \Yii::$app->request->get ();
		$session = \Yii::$app->session;                  //initialising session
		if (! empty ( $get_user_details ['random_salt'] ) && ! empty ( $get_user_details ['id'] )) {
			
			$id = $get_user_details ['id'];
			$random_salt = $get_user_details ['random_salt'];
			
			$user_details = $model_users->setPasswordIdentity ( $id, $random_salt );
		
			if (!empty($user_details['success'])) {
				$users = $user_details['success'];
				$client_model=TblAcaClients::Findbyuserid($users->user_id);		
				if(!empty($client_model)){
					$brand_model=TblAcaBrands::Branduniquedetails($client_model->brand_id);
					$link = $brand_model->brand_url;
				}else{
					$link = 'https://acareportingservice.com/terms-and-conditions/';
				}
				if ($model->load ( \Yii::$app->request->post () ) && $model->validate()) {     //checking for values and validating model
					
					$transaction = \Yii::$app->db->beginTransaction ();             //beginning the transaction
					try {
						
						$password_post = \Yii::$app->request->post () ;              //checking for post values
						
						$password = $password_post['SetPasswordForm']['password'];
						$users->setPassword($password);                              //assigning values to model
						$users->random_salt = '';
						$users->is_active = 1;
						$users->is_verified = 1;
						
						if($users->save())                                           //saving the model
						{
						$transaction->commit ();                                     //commiting the transaction
						\Yii::$app->session->setFlash ( 'success', 'Password is set successfully. You can now login to your account.' );
						return $this->redirect ( array (                             //redirect to login page
								'/login'
						) );
						}
					} catch (Exception $e) {                                     //catch the exception
						$msg = $e->getMessage ();
						\Yii::$app->session->setFlash ( 'error', $msg );
							
						$transaction->rollback ();                               //transaction rollback
						
					}
					
				}
				
			} else {
				\Yii::$app->session->setFlash   ( 'error', $user_details['fail'] );
				return $this->redirect ( array (                         //redirect to login page with error
						'/login' 
				) );
			}
			
			return $this->render ( 'setaccount', [                       //render to setaccount page
					
					'model' => $model ,'link'=>$link
			] );
		} else {
			return $this->redirect ( array (                           //redirect to index page
					'/index' 
			) );
		}
	}
	
	/**
	* action for forgot password
	 */
	 
	public function actionForgotpassword()
	{
		$get_details = \Yii::$app->request->get();                       //getting the values
		$output = array();                                                    //intialising array
		
		if(!empty($get_details))                           //checking for details
		{
		$model_forgot_password = new ForgotPasswordForm(); //initialising models
		$model_users = new TblAcaUsers();
		$model_staff_users = new TblAcaStaffUsers ();
		$model_clients = new TblAcaClients();
		$model_company_users = new TblAcaCompanyUsers();
		$email = $get_details['email'];
		
		$model_forgot_password->email = $email;
		if($model_forgot_password->validate())                          //validating model
		{
			$user_details = $model_users->findByUsername($email);       //finding the user by email
			$user_id = $user_details->user_id;
			
			if($user_details->usertype == 1)                                         //if user is admin
			{
				$staff_user_details = $model_staff_users->findById ( $user_id );     //finding details of user
				$full_name = $staff_user_details->first_name;
			}
			elseif($user_details->usertype == 2){                        //if user is client
				$client_details = $model_clients->findbyuserid($user_id);//finding details of user

				$full_name = $client_details->contact_first_name;
				
			}elseif($user_details->usertype == 3)                                     //if user is company user
			{
				$company_user_details = $model_company_users->FindByuserId($user_id); //finding details of user
				$full_name = $company_user_details->first_name;
				$client_details=TblAcaClients::Clientuniquedetails($company_user_details->client_id);
			}
			
			if(!empty($client_details)){
					$brand_model=TblAcaBrands::Branduniquedetails($client_details->brand_id);
					$picture = (new MailComponent())->Custombrandemaillogo($client_details->brand_id);
					if($picture==''){
						$picture = 'profile_image/brand_logo/'.$brand_model->brand_logo;
					}
					$brand_email = $brand_model->support_email;
					$brand_phone = $brand_model->support_number;
				}else{
					$picture = 'ACA-Reporting-Logo.png';
					$brand_email = 'admin@acareportingservice.com';
					$brand_phone = '';
				}
			
			
			
			$random_salt = $model_users->generatePasswordResetToken ();      //generating token
			$user_details->random_salt = $random_salt;
			
			if($user_details->save())                         //saving the model
			{
			// assigning mail variables
			$to = $user_details->useremail;
			$name = $full_name;
			//creating link
		//	$link = \Yii::$app->urlManager->createAbsoluteUrl ( '/setaccount' ) . '?random_salt=' . $random_salt . '&id=' . md5 ( $user_id );
			
		//	\Yii::$app->CustomMail->Forgotpasswordmail ( $to, $name, $link );     //sending mail for forgot password
						

			//creating link
			$link = \Yii::$app->urlManager->createAbsoluteUrl ( '/setaccount' ) . '?random_salt=' . $random_salt . '&id=' . md5 ( $user_id );
			
			$link_brandimage = \Yii::$app->urlManager->createAbsoluteUrl ( '/Images' ).'/'. $picture;
			\Yii::$app->CustomMail->Forgotpasswordmail ( $to, $name, $link ,$link_brandimage,$brand_email,$brand_phone);     //sending mail for forgot password
													
			$output['success'] = 'success';
			
			}
			
		}
		else 
		{
			$output['fail'] = $model_forgot_password->errors; //sending the error msg to ajax
		}
		
		}
		
		return json_encode($output);             //sending object to ajax
	}
	
	/**
	* action for resetpassword
	 */
	
	public function actionResetlink()
	{
		$get_details = \Yii::$app->request->get();         //getting the values
		$output = array();                                //initialising array
	
		if(!empty($get_details))                           //checking for details
		{
			$model_forgot_password = new ForgotPasswordForm(); //initialising models
			$model_users = new TblAcaUsers();
			//$model_staff_users = new TblAcaStaffUsers ();
			$email = $get_details['email'];
	
			$model_forgot_password->email = $email;
			if($model_forgot_password->validate())              //validating model
			{
				$user_details = $model_users->findByUsername($email);        //finding the details of user
				$user_id = $user_details->user_id;
					
				//	$staff_user_details = $model_staff_users->findById ( $user_id );
					
				$random_salt = $model_users->generatePasswordResetToken (); //generate token
				$user_details->random_salt = $random_salt;                  //assigning the values
					
				if($user_details->save())                 //saving the values
				{
					// assigning mail variables
					$to = $user_details->useremail;
					$name =  $user_details->useremail;
					$link = \Yii::$app->urlManager->createAbsoluteUrl ( '/setaccount' ) . '?random_salt=' . $random_salt . '&id=' . md5 ( $user_id );
						
					\Yii::$app->CustomMail->Resetlink ( $to, $name, $link ); //sending mail
						
					$output['success'] = 'success';    //response to ajax
						
				}
					
			}
			else
			{
				$output['fail'] = $model_forgot_password->errors; //response to ajax
			}
	
		}
	
		return json_encode($output);              //returning a json object
	}
	/**
	 * Logout action.
	 *
	 * @return string
	 */
	public function actionAdminlogout() {
		\Yii::$app->SessionCheck->Adminlogout ();  //component for logout
		
		return $this->goHome ();
	}
	
	/**
	 * Logout action.
	 *
	 * @return string
	 */
	public function actionClientlogout() {
		\Yii::$app->SessionCheck->Clientlogout ();
	
		return $this->goHome ();
	}
	
	/**
	 * Displays contact page.
	 *
	 * @return string
	 */
	public function actionContact() {
		$model = new ContactForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->contact ( Yii::$app->params ['adminEmail'] )) {
			Yii::$app->session->setFlash ( 'contactFormSubmitted' );
			
			return $this->refresh ();
		}
		return $this->render ( 'contact', [ 
				'model' => $model 
		] );
	}
	
	/**
	 * Displays about page.
	 *
	 * @return string
	 */
	public function actionAbout() {
		return $this->render ( 'about' );
	}

	/**
	 * Displays code combination results.
	 *
	 * @returns jason encrypted data
	 */
	public function actionSearchcodecombination(){
	
	
		$modelmanagecode =new TblAcaManageCodes();
	
		$allline14=$modelmanagecode->line14();
		$allline16=$modelmanagecode->line16();
	
		return $this->render ( 'codecalculator', [
				'allline14' => $allline14,
				'allline16' => $allline16
				]
		);
	
	}
	
	/**
	 * ajax request to respond with code combination
	 *
	 * @return string
	 */
	public function actionGetcodecombination(){
	
		$result= array();
		$post_values = \yii::$app->request->get (); // getting post values
	
		if(!empty($post_values)){
			$line14 = $post_values['line14'];
			if(!empty($post_values['line16'])){
				$line16 = $post_values['line16'];
			}else{
				$line16 = null;
			}
			
	
			$model_managecode = TblAcaManageCodes::find()->where(['line_14'=>$line14])
			->andwhere(['line_16'=>$line16])->one();
	
			if(!empty($model_managecode)){
				$line14 = $model_managecode->line14->lookup_value;
				if(!empty($line16)){
				$line16 = $model_managecode->line16->lookup_value;
				}else{
				$line16 = 'Blank';
				}
				$arrValues = array(
						'line_16'=>$line16,
						'line_14'=>$line14,
						'code_combination'=>$model_managecode->code_combination,
						'employers_organizations'=>$model_managecode->employers_organizations,
						'individuals_families'=>$model_managecode->individuals_families,
				);
				$result['success'] = $arrValues;
			}else{
				$result['error']='Record doesnt exist for this combination';
			}
	
	
		}else{
			$result['error']='Some Error Occured, Please try again';
		}
	
		return json_encode($result);
	
	}
}
