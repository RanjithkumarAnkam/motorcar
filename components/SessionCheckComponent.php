<?php

namespace app\components;

use Yii;
use yii\base\Component;
use app\controllers\SiteController;

/*
 * SessionCheckComponent is used for checking session variables is login or logout
 */
class SessionCheckComponent extends Component {
	
	
	//Function is used for checking if admin or admin staff user is logged
	public function isLogged() {
		if (Yii::$app->session ['logged_status'] == true && Yii::$app->session ['is_admin'] == 'admin') {
			
			return true;
		} else {
			return false;
		}
	}
	
	//Function is used for checking if client or client company user is logged
	public function isclientLogged() {
		if (Yii::$app->session ['logged_status'] == true && (Yii::$app->session ['is_client'] == 'client' || Yii::$app->session ['is_client'] == 'companyuser' )) {
				
			return true;
		} else {
			return false;
		}
	}
	
	//Function is used for destroying all admin sessions 
	public function Adminlogout() {
		$session = \Yii::$app->session;
		unset ( $session ['is_admin'] );
		unset ( $session ['admin_user_id'] );
		unset ( $session ['admin_email'] );
		unset ( $session ['admin_permissions'] );
		
		if(!empty($session['shadow_login_id'])) //logout client if shadow login
		{
		unset ( $session ['is_client'] );
		unset ( $session ['client_ids'] );
		unset ( $session ['company_ids'] );
		unset ( $session ['client_user_id'] );
		unset ( $session ['client_email'] );
		unset ( $session ['client_permissions'] );
		unset ( $session ['shadow_login_id'] );
		}
	}
	
	
	//Function is used for destroying all client sessions 
	public function Clientlogout() {
		$session = \Yii::$app->session;
		unset ( $session ['is_client'] );
		unset ( $session ['client_ids'] );
		unset ( $session ['company_ids'] );
		unset ( $session ['client_user_id'] );
		unset ( $session ['client_email'] );
		unset ( $session ['client_permissions'] );
		unset ( $session ['shadow_login_id'] );
		
	
	
	
	}
}