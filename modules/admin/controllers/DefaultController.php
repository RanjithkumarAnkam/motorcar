<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\models\PasswordForm;
use app\models\TblAcaUsers;
use app\models\TblAcaClients;
use app\models\TblAcaCompanies;
use app\models\TblAcaCompanyUsers;
use app\models\TblAcaStaffUsers;
use app\models\TblAcaVideoLinks;
/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller {
	/**
	 * Renders the index view for the module
	 * 
	 * @return string
	 */
	public function actionIndex() {
		
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
    	{
			\Yii::$app->view->title = 'ACA Reporting Service | Dashboard';
		$this->layout = 'main';
		/**Checking if the logged in user has permission to the particular action**/
		
			$model_clients = new TblAcaClients();
			$model_companies = new TblAcaCompanies();
			$model_company_users = new TblAcaCompanyUsers();
			$model_staff_users = new TblAcaStaffUsers();
			$dashboard_counts  = array();
			
			/**Get count of number of active clients**/
			$count_clients = $model_clients->Getactiveclientcount();
			
			/**Get count of all active companies**/
			$count_companies = $model_companies->Getallactiveclientcompaniescount();
			
			/**Get count of number of forms bought**/
			$count_forms_bought = $model_clients->Getformscount();
			
			/**Get count of all active company users**/
			$count_company_users = $model_company_users->Getactivecompanyusercount();
			
			//**Get count of all admin users**/
			$company_admin_users = $model_staff_users->Findallmanagerscount();
			
			//**All admin users**/
			$all_users = $model_staff_users->Topfiveusers();
			
			//**All client **/
			$all_client_users = $model_clients->Topfiveclients();
			
			//**All companies**/
			$all_companies = $model_companies->Topfivecompanies();
			
			
			$dashboard_counts['count_clients']=  $count_clients;
			$dashboard_counts['count_companies']=  $count_companies;
			$dashboard_counts['count_forms_bought']=  $count_forms_bought;
			$dashboard_counts['count_company_users']=  $count_company_users;
			$dashboard_counts['company_admin_users']=  $company_admin_users;
			$dashboard_counts['all_users']=  $all_users;
			$dashboard_counts['all_client_users']=  $all_client_users;
			$dashboard_counts['all_companies']=  $all_companies;
		
		return $this->render ( 'index' ,['dashboard_counts'=>$dashboard_counts]);
		
		
		 } else {
        	\Yii::$app->SessionCheck->adminlogout ();
        		
        	return $this->goHome ();
        }
	}
	public function actionDashboardold() {
		$this->layout = 'main';
		return $this->render ( 'indexold' );
	}
	
	/**
	 * Action for change password
	 */
	public function actionChangepassword() {
		
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			
		$get_details = \Yii::$app->request->get ();          //getting the details 
		$model_password = new PasswordForm ();                //initialising model
		$model_users = new TblAcaUsers ();
		$output = array ();                                   //initialising array
		
		$session = \Yii::$app->session;                        //initialising session
		$logged_user_id = $session ['admin_user_id'];            //getting session variables
		if (! empty ( $get_details ['oldpass'] ) && ! empty ( $get_details ['newpass'] ) && ! empty ( $get_details ['repeatnewpass'] )) {
			$oldpass = $get_details ['oldpass'];
			$newpass = $get_details ['newpass'];
			$repeatnewpass = $get_details ['repeatnewpass'];
			
			$model_password->oldpass = $oldpass;
			$model_password->newpass = $newpass;
			$model_password->repeatnewpass = $repeatnewpass;
			
			$transaction = \Yii::$app->db->beginTransaction ();     //begin the transaction
			try {
				if ($model_password->validate ()) {                 //validating the model
					$user_details = $model_users->findById ( $logged_user_id ); //finding for the user
					$user_details->setPassword ( $newpass );
					
					if ($user_details->save ()) {                     //saving the model
						$transaction->commit();                       //commiting the transaction
						$output ['success'] = 'success';
						
					}
				} else {
					$output ['fail'] = $model_password->errors;           //sending response to ajax in array
				}
			} catch ( Exception $e ) {                      //catch the exceptions
				
				$msg = $e->getMessage ();
				$output ['fail'] = $msg;
				
				$transaction->rollback ();                  //if exception occurs transaction rollbacks
			}
			return json_encode ( $output );                 //returning the object to ajax
		}
	} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to home page if session destroyed
	
			return $this->goHome ();
		}
	}

	
}
