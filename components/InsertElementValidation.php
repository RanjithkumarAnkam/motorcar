<?php
/**
 * Helper class to save in validation log
 * @author PRAVEEN
 * Date Created : 03 October 2016
 * Date Modified : 13 October 2016
 */


namespace app\components;

use Yii;
use yii\base\Component;
use app\controllers\SiteController;
use app\models\TblAcaElementMaster;
use app\models\TblAcaValidationRules;
use yii\helpers\ArrayHelper;
use app\models\TblAcaValidationLog;
use app\models\TblAcaMedicalValidationLog;
use app\models\TblAcaPlanClassValidationLog;
use app\models\TblAcaPayrollValidationLog;
use app\models\TblAcaPayrollEmploymentPeriodValidationLog;
use app\models\TblAcaMedicalEnrollmentPeriodValidationLog;

class InsertElementValidation extends Component {
	
	
	/**
	 * ***Function Inserts validated results in vaidation log******
	 */
	public function Insertvalidationlog($arrvalidation, $company_id) {
		$arrrule_ids = array ();
		$result = array ();
		$model_validation_log = new TblAcaValidationLog();
		
	
		// begin transaction
		$transaction = \Yii::$app->db->beginTransaction ();
	
		try {
				
			$count = 0;
			$arrvalidation_count = count ( $arrvalidation );
				
			foreach ( $arrvalidation as $key => $value ) {
	
				$model_validation_log->company_id = $company_id;
				$model_validation_log->validation_rule_id = $key;
				$model_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
				$model_validation_log->is_validated = $value;
				$model_validation_log->isNewRecord = True;
				$model_validation_log->log_id = NULL;
	
				if ($model_validation_log->validate () && $model_validation_log->save ()) {
						
					$count ++;
				} else {
					$arrerrors = $model_validation_log->getFirstErrors ();
					$errorstring = '';
					/**
					 * *****Converting error into string*******
					 */
					foreach ( $arrerrors as $key => $value ) {
						$errorstring .= $value . '<br>';
					}
						
					throw new \Exception ( $errorstring );
				}
			}
				
			if ($arrvalidation_count == $count) {
				$result ['success'] = 'success';
				$transaction->commit ();
			}
		} catch ( \Exception $e ) { // catching the exception
				
			$result ['error'] = $e->getMessage ();
			// rollback transaction
			$transaction->rollback ();
		}
	
		return $result;
	}
	
	
	
	
	/**
	 * ***Function Inserts validated results in vaidation log******
	 */
	public function Insertmedicalvalidationlog($arrperiodinsertvalidation, $arrinsertvalidation, $company_id) {
		
		
		ini_set ( 'memory_limit', '1024M' );
		ini_set ( 'max_execution_time', 3600 );
		ini_set ( 'max_input_time', 3600 );
		
		$arrrule_ids = array ();
		$result = array ();
		$model_medical_validation_log = new TblAcaMedicalValidationLog ();
		
		// begin transaction
		$transaction = \Yii::$app->db->beginTransaction ();
		
		try {
			
			$count = 0;
			$arrinsertvalidation_count = 0;
			
			foreach ( $arrinsertvalidation as $key => $value ) {
				
				$employee_id = $value ['employee_id'];
				if (! empty ( $value ['validation_rule_id'] )) {
				
				$validation_rule_ids = $value ['validation_rule_id'];
				
				$arrinsertvalidation_count += count ( $validation_rule_ids );
				
				foreach ( $validation_rule_ids as $rule_id => $validation ) {
					
					if ($validation == 0) {
						
						$model_medical_validation_log->employee_id = $employee_id;
						$model_medical_validation_log->validation_rule_id = $rule_id;
						$model_medical_validation_log->company_id = $company_id;
						$model_medical_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
						$model_medical_validation_log->is_validated = $validation;
						$model_medical_validation_log->isNewRecord = True;
						$model_medical_validation_log->log_id = NULL;
						
						if ($model_medical_validation_log->validate () && $model_medical_validation_log->save ()) {
							
							$count ++;
						} else {
							$arrerrors = $model_medical_validation_log->getFirstErrors ();
							$errorstring = '';
							/**
							 * *****Converting error into string*******
							 */
							foreach ( $arrerrors as $key => $value ) {
								$errorstring .= $value . '<br>';
							}
							
							throw new \Exception ( $errorstring );
						}
					}
				}
			}
			}
			
			
			$this->Insertmedicalenrollmentperiodvalidationlog($arrperiodinsertvalidation, $company_id);
			$result ['success'] = 'success';
			$transaction->commit ();
		} catch ( \Exception $e ) { // catching the exception
			
			$result ['error'] = $e->getMessage ();
			// rollback transaction
			$transaction->rollback ();
		}
		
		return $result;
	
	}
	
	
	

	/**
	 * ***Function Inserts validated results in vaidation log******
	 */
	public function Insertpayrollvalidationlog($arrperiodinsertvalidation, $arrinsertvalidation, $company_id) {
		
		ini_set('memory_limit','-1');
		ini_set('max_execution_time', 3600);
		ini_set('max_input_time',3600);
		
		$arrrule_ids = array ();
		$result = array ();
		$model_payroll_validation_log = new TblAcaPayrollValidationLog();
	
	
	
	
	
		// begin transaction
		$transaction = \Yii::$app->db->beginTransaction ();
	
		try {
	
			$count = 0;
			$arrinsertvalidation_count = 0;
	
			foreach ( $arrinsertvalidation as $key => $value ) {
	
				$employee_id = $value['employee_id'];
				
				if (! empty ( $value ['validation_rule_id'] )) {
				$validation_rule_ids = $value['validation_rule_id'];
	
				$arrinsertvalidation_count += count($validation_rule_ids);
	
				foreach($validation_rule_ids as $rule_id => $validation){
						
					if($validation == 0){
					$model_payroll_validation_log->employee_id = $employee_id;
					$model_payroll_validation_log->validation_rule_id = $rule_id;
					$model_payroll_validation_log->company_id = $company_id;
					$model_payroll_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
					$model_payroll_validation_log->is_validated = $validation;
					$model_payroll_validation_log->isNewRecord = True;
					$model_payroll_validation_log->log_id = NULL;
						
					if ($model_payroll_validation_log->validate () && $model_payroll_validation_log->save ()) {
							
						$count ++;
					} else {
						$arrerrors = $model_payroll_validation_log->getFirstErrors ();
						$errorstring = '';
						/**
						 * *****Converting error into string*******
						 */
						foreach ( $arrerrors as $key => $value ) {
							$errorstring .= $value . '<br>';
						}
							
						throw new \Exception ( $errorstring );
					}
				}
				}
			}
			}	
				
				$asd = $this->Insertpayrollemployeeperiodvalidationlog($arrperiodinsertvalidation, $company_id);
				if (! empty ( $asd ['error'] )) {
					throw new \Exception ( 'payroll-' . $asd ['error'] );
				}
				else
				{
					$result ['success'] = 'success';
					$transaction->commit ();
				}
				//print_r($asd);die();
				
			
		} catch ( \Exception $e ) { // catching the exception
	
			$result ['error'] = $e->getMessage ();
			// rollback transaction
			$transaction->rollback ();
		}
	
		return $result;
	}
	
	
	
	
	/**
	 * ***Function Inserts plan class validated results in vaidation log******
	 */
	public function Insertplanvalidationlog($arrinsertvalidation, $company_id) {
		
		
		ini_set('memory_limit','1024M');
		ini_set('max_execution_time', 3600);
		ini_set('max_input_time',3600);
		
		
		$arrrule_ids = array ();
		$result = array ();
		$model_plan_validation_log = new TblAcaPlanClassValidationLog();
	
	
	
	
	
		// begin transaction
		$transaction = \Yii::$app->db->beginTransaction ();
	
		try {
	
			$count = 0;
			$arrinsertvalidation_count = 0;
	
			foreach ( $arrinsertvalidation as $key => $value ) {
	
				$plan_class_id = $value['plan_class_id'];
				$validation_rule_ids = $value['validation_rule_id'];
	
				$arrinsertvalidation_count += count($validation_rule_ids);
	
				foreach($validation_rule_ids as $rule_id => $validation){
					if($validation == 0){	
	
					$model_plan_validation_log->plan_class_id = $plan_class_id;
					$model_plan_validation_log->validation_rule_id = $rule_id;
					$model_plan_validation_log->company_id = $company_id;
					$model_plan_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
					$model_plan_validation_log->is_validated = $validation;
					$model_plan_validation_log->isNewRecord = True;
					$model_plan_validation_log->log_id = NULL;
						
					if ($model_plan_validation_log->validate () && $model_plan_validation_log->save ()) {
							
						$count ++;
					} else {
						$arrerrors = $model_plan_validation_log->getFirstErrors ();
						$errorstring = '';
						/**
						 * *****Converting error into string*******
						 */
						foreach ( $arrerrors as $key => $value ) {
							$errorstring .= $value . '<br>';
						}
							
						throw new \Exception ( $errorstring );
					}
				}
				}
			}
				
				
			
				$result ['success'] = 'success';
				$transaction->commit ();
			
		} catch ( \Exception $e ) { // catching the exception
	
			$result ['error'] = $e->getMessage ();
			// rollback transaction
			$transaction->rollback ();
		}
	
		return $result;
	}
	
	
	/**
	 * ***Function Inserts Payroll employee period validation log results in vaidation log******
	 */
	public function Insertpayrollemployeeperiodvalidationlog($arrperiodinsertvalidation, $company_id) {
		ini_set ( 'memory_limit', '1024M' );
		ini_set ( 'max_execution_time', 3600 );
		ini_set ( 'max_input_time', 3600 );
		
		$arrrule_ids = array ();
		$result = array ();
		$model_payroll_period_validation_log = new TblAcaPayrollEmploymentPeriodValidationLog();
		
		
		if(!empty($arrperiodinsertvalidation))
		{
		
		// begin transaction
		$transactions = \Yii::$app->db->beginTransaction ();
	
		try {
				
			$count = 0;
			$arrinsertvalidation_count = 0;
			
			foreach ( $arrperiodinsertvalidation as $key => $employees ) {
				
				$employee_id = $employees ['employee_id'];
				
				if(!empty($employees ['period_id'])){
				
					$period_ids = $employees ['period_id'];
					
					foreach ( $period_ids as $period_id => $validation_rule_ids ) {
						//print_r($validation_rule_ids);
						foreach ( $validation_rule_ids as $validation_rule_id => $is_validated ) {
							if ($is_validated == 0) {
			
								$model_payroll_period_validation_log->period_id = $period_id;
								$model_payroll_period_validation_log->employee_id = $employee_id;
								$model_payroll_period_validation_log->company_id = $company_id;
								$model_payroll_period_validation_log->validation_rule_id = $validation_rule_id;
								$model_payroll_period_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
								$model_payroll_period_validation_log->is_validated = $is_validated;
								$model_payroll_period_validation_log->isNewRecord = True;
								$model_payroll_period_validation_log->log_id = NULL;
			
								if ($model_payroll_period_validation_log->validate () && $model_payroll_period_validation_log->save ()) {
										
									$count ++;
								} else {
									$arrerrors = $model_payroll_period_validation_log->getFirstErrors ();
									$errorstring = '';
									/**
									 * *****Converting error into string*******
									 */
									foreach ( $arrerrors as $key => $value ) {
										$errorstring .= $value . '<br>';
									}
										
									throw new \Exception ( $errorstring );
								}
							}							
						}
					}
				}
			}
				//die();
			$result ['success'] = 'success';
			$transactions->commit ();
		} catch ( \Exception $e ) { // catching the exception
				
			$result ['error'] = $e->getMessage ();
			// rollback transaction
			$transactions->rollback ();
		}
	}
		return $result;
	}
	
	
	
	
	
	/**
	 * ***Function Inserts medical enrollment period validation log results in vaidation log******
	 */
	public function Insertmedicalenrollmentperiodvalidationlog($arrperiodinsertvalidation, $company_id) {
		ini_set ( 'memory_limit', '1024M' );
		ini_set ( 'max_execution_time', 3600 );
		ini_set ( 'max_input_time', 3600 );
	
		$arrrule_ids = array ();
		$result = array ();
		$model_medical_period_validation_log = new TblAcaMedicalEnrollmentPeriodValidationLog();
	
	
		if(!empty($arrperiodinsertvalidation))
		{
	
			// begin transaction
			$transaction = \Yii::$app->db->beginTransaction ();
	
			try {
	
				$count = 0;
				$arrinsertvalidation_count = 0;
	
				foreach ( $arrperiodinsertvalidation as $key => $employees ) {
	
					$employee_id = $employees ['employee_id'];
	
					if(!empty($employees ['period_id'])){
	
						$period_ids = $employees ['period_id'];
	
						foreach ( $period_ids as $period_id => $validation_rule_ids ) {
								
							foreach ( $validation_rule_ids as $validation_rule_id => $is_validated ) {
								if ($is_validated == 0) {
	
									$model_medical_period_validation_log->period_id = $period_id;
									$model_medical_period_validation_log->employee_id = $employee_id;
									$model_medical_period_validation_log->company_id = $company_id;
									$model_medical_period_validation_log->validation_rule_id = $validation_rule_id;
									$model_medical_period_validation_log->modified_date = date ( 'Y-m-d H:i:s' );
									$model_medical_period_validation_log->is_validated = $is_validated;
									$model_medical_period_validation_log->isNewRecord = True;
									$model_medical_period_validation_log->log_id = NULL;
	
									if ($model_medical_period_validation_log->validate () && $model_medical_period_validation_log->save ()) {
	
										$count ++;
									} else {
										$arrerrors = $model_medical_period_validation_log->getFirstErrors ();
										$errorstring = '';
										/**
										 * *****Converting error into string*******
										 */
										foreach ( $arrerrors as $key => $value ) {
											$errorstring .= $value . '<br>';
										}
	
										throw new \Exception ( $errorstring );
									}
								}
									
							}
						}
					}
				}
	
				$result ['success'] = 'success';
				$transaction->commit ();
			} catch ( \Exception $e ) { // catching the exception
				print_R($e);
				die();
				$result ['error'] = $e->getMessage ();
				// rollback transaction
				$transaction->rollback ();
			}
		}
		return $result;
	}
}