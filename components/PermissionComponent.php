<?php

namespace app\components;

use Yii;
use yii\base\Component;
use app\controllers\SiteController;
use app\models\TblAcaStaffUserPermission;
use app\models\TblAcaStaffUsers;
use app\models\TblAcaClients;
use app\models\TblAcaElementMaster;
use app\models\TblAcaCompanyUsers;
use app\models\TblAcaCompanyUserPermission;
use app\models\TblAcaCompanies;
use app\models\TblAcaPayrollElementMaster;
use app\models\TblAcaMedicalElementMaster;

class PermissionComponent extends Component {
	
	/**
	 *
	 * @param id $staff_id        	
	 * @param array $permissions
	 *        	Adminstaffpermissions assigns permissions to the Admin users
	 */
	public function Adminstaffpermissions($staff_id, $permissions = null) {
		$model_permissions = new TblAcaStaffUserPermission ();
		$staff_permissions_details = $model_permissions->findById ( $staff_id );
		
		$session = \Yii::$app->session;
		$logged_user_id = $session ['admin_user_id'];
		
		if (! empty ( $staff_permissions_details )) {
			TblAcaStaffUserPermission::deleteAll (['staff_id'=>$staff_id]);
		}
		
		if (! empty ( $permissions )) {
			foreach ( $permissions as $key => $value ) {
				
				$model_permissions->staff_id = $staff_id;
				$model_permissions->staff_permission_id = $value;
				$model_permissions->created_by = $logged_user_id;
				$model_permissions->created_date = date ( 'Y-m-d H:i:s' );
				$model_permissions->isNewRecord = true;
				$model_permissions->admin_staff_permission_id = null;
				$model_permissions->save ();
			}
		}
		
		return 'success';
	}
	
	//Function is used to get all assigned permissions of the particular Admin User.
	public function Getloggeduserpermission($user_id)
	{
		$permissions = array();
		$model_staff_users = new TblAcaStaffUsers();
		$model_permissions = new TblAcaStaffUserPermission ();
		
		$staff_user_details = $model_staff_users->findById ( $user_id );
		$staff_id = $staff_user_details->staff_id; // staff Id
		
		$staff_permissions_details = $model_permissions->findById ( $staff_id );
		
		if (! empty ( $staff_permissions_details )) {
			
			foreach($staff_permissions_details as $permission)
			{
				$permissions[] = $permission->staff_permission_id;
			}
			
		}
		
		return $permissions;
	}
	
	public function Profileimage($user_id)
	{
	
		$model = TblAcaClients::find()->where(['user_id' => $user_id])->one();
	
		if(!empty($model->profile_image))
		{
			return $model->profile_image;
		}
		else
		{
			return 'report_1_28146_default.png';
		}
	}
	
	public function CheckAdminactionpermission($action_permission_id)
		 {
		  $session = \Yii::$app->session;
		  $admin_permissions = $session['admin_permissions'];
		  
		  if(in_array ( $action_permission_id, $admin_permissions ) == true)
		  {
		   $is_permission = true;
		  }
		  else 
		  {
		   $is_permission = false;
		  }
		  
		  
		  return $is_permission; 
		  
		 }
		 
		 
		 
		public function Checkclientpermission($logged_user_id, $company_id, $permission_name) {
		
		$session = \Yii::$app->session;
		$shadow_login_id = $session['shadow_login_id'];
		  
		$model_companies = new TblAcaCompanies ();
		$model_company_user = new TblAcaCompanyUsers ();
		$model_client = new TblAcaClients ();
		$model_company_user_permission = new TblAcaCompanyUserPermission ();
		$arrpermissions = array ();
		$arrassigned_permission = array();
		$result = '';
		
		$check_company_details = $model_companies->Companyuniquedetails ( $company_id );
		$client_id = $check_company_details->client_id;
		$package_type = $check_company_details->client->package_type;
		$reporting_status = $check_company_details->reporting_status;
		
		$get_company_user_details = $model_company_user->FindbyuserIdclientID ( $logged_user_id, $client_id );
		if (! empty ( $get_company_user_details )) {
			$company_user_id = $get_company_user_details->company_user_id;
			
			$get_all_permission = $model_company_user_permission->FindBycompanyuserIdcompanyId ( $company_user_id, $company_id );
			
			foreach ( $get_all_permission as $permission ) {
				$client_permission_id = $permission->client_permission_id;
				$arrpermissions [] = $client_permission_id;
			}
			
			if (! empty ( $arrpermissions )) {
				
				//if($package_type == 12) //Budget
				//{
					if(in_array ( 1, $arrpermissions, TRUE )){
						
							
						$arrassigned_permission[] = 'all';
						
					}
					else 
					{
						$arrassigned_permission[] = 'dashboard';
						foreach ($arrpermissions as $key => $value)
						{
							switch ($value){
							case '2' :
								
								
								$arrassigned_permission[] = 'basicreportinginfo';
								$arrassigned_permission[] = 'benefitplaninfo';
								
								break;
							case '3' :
								
								$arrassigned_permission[] = 'signdocument';
								break;
							
							case '4' :
								
								
								$arrassigned_permission[] = 'viewpayroll';
								
							break;
							
							case '5' :
								
								
								$arrassigned_permission[] = 'editpayroll';
								
							break;
							
							case '7' :
								
								
								$arrassigned_permission[] = 'editmedical';
								
								break;
								
							case '6' :
								
								
								$arrassigned_permission[] = 'viewmedical';
								
								break;
								
							case '8' :
								
								
								$arrassigned_permission[] = 'e-file';
								
								break;
							case '9' :
								
								
								$arrassigned_permission[] = 'uploaddocument';
								
								break;
									
							case '10' :
								
								
								$arrassigned_permission[] = 'downloaddocument';
								
								break;
							default :
								$arrassigned_permission[] = 'all';
								break;
							
							}
							
						}
						
					}
					
				//}
				/*else // Full or Enhanced
				{
					if(in_array ( 1, $arrpermissions, TRUE ))
					{
						
							if($reporting_status < 26)
							{
							$arrassigned_permission[] = 'dashboard';
							$arrassigned_permission[] = 'signdocument';
							$arrassigned_permission[] = 'uploaddocument';
							$arrassigned_permission[] = 'downloaddocument';
							$arrassigned_permission[] = 'companyuser';
							}
							else 
							{
								$arrassigned_permission[] = 'all';
								
							}
						
					}
					else 
					{
						if($reporting_status < 26)
						{
							$arrassigned_permission[] = 'dashboard';
							
						}
						else 
						{
						$arrassigned_permission[] = 'dashboard';
						foreach ($arrpermissions as $key => $value)
						{
							switch ($value){
							case '2' :
								
								$arrassigned_permission[] = 'basicreportinginfo';
								$arrassigned_permission[] = 'benefitplaninfo';
								break;
							case '3' :
								
								$arrassigned_permission[] = 'signdocument';
								break;
							
							case '4' :
								
								$arrassigned_permission[] = 'viewpayroll';
							break;
							
							case '5' :
								
								$arrassigned_permission[] = 'editpayroll';
							break;
							
							case '6' :
								
								$arrassigned_permission[] = 'editmedical';
								break;
								
							case '7' :
								
								$arrassigned_permission[] = 'viewmedical';
								break;
								
							case '8' :
								
								$arrassigned_permission[] = 'e-file';
								break;
							case '9' :
								
								$arrassigned_permission[] = 'uploaddocument';
								break;
									
							case '10' :
								
								$arrassigned_permission[] = 'downloaddocument';
								break;
							default :
								$arrassigned_permission[] = 'all';
								break;
							
							}
							
						}
						
					}
						
					}
					
					
					
				}*/
				
				
			}
			else {
					
				$arrassigned_permission[] = 'dashboard';
			}
			
		} else {
			
			$arrassigned_permission[] = 'dashboard';
		}
		
		//check for shadow login
		if(!empty($shadow_login_id))
		{
			$result = true;
			
		}
		elseif(in_array ( 'all', $arrassigned_permission, TRUE ))
		{
			$result = true;
		}
		elseif(in_array ($permission_name, $arrassigned_permission, TRUE ))
		{
			$result = true;
		}
		else 
		{
			
			$result = false;
			
		}
		
		
		return $result;
	}
	
	
	
	
	public function Checkclientallpermission($logged_user_id, $company_id) {
		
		$session = \Yii::$app->session;
		$shadow_login_id = $session['shadow_login_id'];
		  
		$model_companies = new TblAcaCompanies ();
		$model_company_user = new TblAcaCompanyUsers ();
		$model_client = new TblAcaClients ();
		$model_company_user_permission = new TblAcaCompanyUserPermission ();
		$arrpermissions = array ();
		$arrassigned_permission = array();
		$result = '';
		
		$check_company_details = $model_companies->Companyuniquedetails ( $company_id );
		$client_id = $check_company_details->client_id;
		$package_type = $check_company_details->client->package_type;
		$reporting_status = $check_company_details->reporting_status;
		
		$get_company_user_details = $model_company_user->FindbyuserIdclientID ( $logged_user_id, $client_id );
		if (! empty ( $get_company_user_details )) {
			$company_user_id = $get_company_user_details->company_user_id;
			
			$get_all_permission = $model_company_user_permission->FindBycompanyuserIdcompanyId ( $company_user_id, $company_id );
			
			foreach ( $get_all_permission as $permission ) {
				$client_permission_id = $permission->client_permission_id;
				$arrpermissions [] = $client_permission_id;
			}
			
			if (! empty ( $arrpermissions )) {
				
				//if($package_type == 12) //Budget
				//{
					if(in_array ( 1, $arrpermissions, TRUE )){
						
							
						$arrassigned_permission[] = 'all';
						
					}
					else 
					{
						$arrassigned_permission[] = 'dashboard';
						foreach ($arrpermissions as $key => $value)
						{
							switch ($value){
							case '2' :
								
								
								$arrassigned_permission[] = 'basicreportinginfo';
								$arrassigned_permission[] = 'benefitplaninfo';
								
								break;
							case '3' :
								
								$arrassigned_permission[] = 'signdocument';
								break;
							
							case '4' :
								
								
								$arrassigned_permission[] = 'viewpayroll';
								
							break;
							
							case '5' :
								
								
								$arrassigned_permission[] = 'editpayroll';
								
							break;
							
							case '7' :
								
								
								$arrassigned_permission[] = 'editmedical';
								
								break;
								
							case '6' :
								
								
								$arrassigned_permission[] = 'viewmedical';
								
								break;
								
							case '8' :
								
								
								$arrassigned_permission[] = 'e-file';
								
								break;
							case '9' :
								
								
								$arrassigned_permission[] = 'uploaddocument';
								
								break;
									
							case '10' :
								
								
								$arrassigned_permission[] = 'downloaddocument';
								
								break;
							default :
								$arrassigned_permission[] = 'all';
								break;
							
							}
							
						}
						
					}
					
				//}
				/*else // Full or Enhanced
				{
					if(in_array ( 1, $arrpermissions, TRUE ))
					{
						
							if($reporting_status < 26)
							{
							$arrassigned_permission[] = 'dashboard';
							$arrassigned_permission[] = 'signdocument';
							$arrassigned_permission[] = 'uploaddocument';
							$arrassigned_permission[] = 'downloaddocument';
							$arrassigned_permission[] = 'companyuser';
							}
							else 
							{
								$arrassigned_permission[] = 'all';
								
							}
						
					}
					else 
					{
						if($reporting_status < 26)
						{
							$arrassigned_permission[] = 'dashboard';
							
						}
						else 
						{
						$arrassigned_permission[] = 'dashboard';
						foreach ($arrpermissions as $key => $value)
						{
							switch ($value){
							case '2' :
								
								$arrassigned_permission[] = 'basicreportinginfo';
								$arrassigned_permission[] = 'benefitplaninfo';
								break;
							case '3' :
								
								$arrassigned_permission[] = 'signdocument';
								break;
							
							case '4' :
								
								$arrassigned_permission[] = 'viewpayroll';
							break;
							
							case '5' :
								
								$arrassigned_permission[] = 'editpayroll';
							break;
							
							case '6' :
								
								$arrassigned_permission[] = 'editmedical';
								break;
								
							case '7' :
								
								$arrassigned_permission[] = 'viewmedical';
								break;
								
							case '8' :
								
								$arrassigned_permission[] = 'e-file';
								break;
							case '9' :
								
								$arrassigned_permission[] = 'uploaddocument';
								break;
									
							case '10' :
								
								$arrassigned_permission[] = 'downloaddocument';
								break;
							default :
								$arrassigned_permission[] = 'all';
								break;
							
							}
							
						}
						
					}
						
					}
					
					
					
				}
				*/
				
			}
			else {
					
				$arrassigned_permission[] = 'dashboard';
			}
			
		} else {
			
			$arrassigned_permission[] = 'dashboard';
		} 
		
		//check for shadow login
		if(!empty($shadow_login_id))
		{
			$arrassigned_permission[] = 'all';
			
		}
		
		// check if document is signed or not
		if($reporting_status < 24)
		{
			$arrassigned_permission[] = 'notsigned';
		}
		
		return $arrassigned_permission;
	}
	
	/********* function to get the element names *******/
	
	public function Getelement($element_id,$type) {
		
		if($type == 'basic'){
				$model_element_master = TblAcaElementMaster::find()->where(['master_id' => $element_id])->one();
				$result = $model_element_master->element_label;
		}
		else if($type == 'payroll'){
			$model_payroll_element_master = TblAcaPayrollElementMaster::find()->where(['element_id' => $element_id])->one();
				$result = $model_payroll_element_master->element_name;
		}
		else if($type == 'medical'){
			$model_medical_element_master = TblAcaMedicalElementMaster::find()->where(['element_id' => $element_id])->one();
				$result = $model_medical_element_master->element_name;
		}
		return $result;
	}
	
}