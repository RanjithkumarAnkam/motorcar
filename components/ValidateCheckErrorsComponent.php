<?php

/**
 * Helper class for getting all the elements with element_id for validation 
 * @author PRAVEEN
 * Date Created : 03 October 2016
 * Date Modified : 13 October 2016
 */
namespace app\components;

use Yii;
use yii\base\Component;
use app\controllers\SiteController;
use yii\helpers\ArrayHelper;
use app\models\TblAcaPlanClassValidationLog;
use app\models\TblAcaPlanCoverageType;
use app\models\TblAcaPayrollValidationLog;
use app\models\TblAcaPayrollEmploymentPeriodValidationLog;
use app\models\TblAcaMedicalValidationLog;
use app\models\TblAcaMedicalEnrollmentPeriodValidationLog;

class ValidateCheckErrorsComponent extends Component {
	
	public function CheckErrors($validation_results,$company_id) {
		
		$arr_validations = array();
		$arr_plan_class_individual_issues = array();
		
		// collecting the company id from the url and decoding it
		$encrypt_component = new EncryptDecryptComponent();
		
		$arr_validations ['basic_info'] = 0;
		$arr_validations ['basic_information'] = 0;
		$arr_validations ['large_emp_status'] = 0;
		$arr_validations ['plan_offering_criteria'] = 0;
		$arr_validations ['dge'] = 0;
		$arr_validations ['aggregate_group'] = 0;
		
		$arr_validations ['benefit_plan'] = 0;
		$arr_validations ['general_plan_info'] = 0;
		$arr_validations ['mec'] = 0;
		
		$arr_validations ['plan_class'] = 0;
		$arr_validations ['payroll_data'] = 0;
		$arr_validations ['medical_data'] = 0;
		
		$arr_validations ['plan_class_validation'] = 0;
		$arr_validations ['payroll_data_validation'] = 0;
		$arr_validations ['medical_data_validation'] = 0;
		
		foreach ( $validation_results as $results ) {
			// Basic information
			if (($results->is_validated == 0) && ($results->validation_rule_id <= 54 || $results->validation_rule_id == 143 || $results->validation_rule_id == 144 || $results->validation_rule_id == 145)) {
				$arr_validations ['basic_info'] ++;
				
				if ($results->validation_rule_id <= 23) {
					$arr_validations ['basic_information'] ++;
				}
				
				if ($results->validation_rule_id > 23 && $results->validation_rule_id <= 26) {
					$arr_validations ['large_emp_status'] ++;
				}
				
				if ($results->validation_rule_id > 26 && $results->validation_rule_id <= 30) {
					$arr_validations ['plan_offering_criteria'] ++;
				}
				
				if (($results->validation_rule_id > 30 && $results->validation_rule_id <= 48) || $results->validation_rule_id == 143 || $results->validation_rule_id == 144 || $results->validation_rule_id == 145) {
					$arr_validations ['dge'] ++;
				}
				
				if ($results->validation_rule_id > 48 && $results->validation_rule_id <= 54) {
					$arr_validations ['aggregate_group'] ++;
				}
			}
			
			// Benefit Plan Info
			if (($results->is_validated == 0) && ($results->validation_rule_id > 54) && ($results->validation_rule_id <= 62)) {
				$arr_validations ['benefit_plan'] ++;
				
				if ($results->validation_rule_id > 54 && $results->validation_rule_id <= 61) {
					$arr_validations ['general_plan_info'] ++;
				}
				
				if ($results->validation_rule_id == 62) {
					$arr_validations ['mec'] ++;
				}
			}
			
			// plan class
			if (($results->is_validated == 1) && ($results->validation_rule_id == 140)) {
				$arr_validations ['plan_class'] = 1;
			}
			
			// payroll data
			if (($results->is_validated == 1) && ($results->validation_rule_id == 141)) {
				$arr_validations ['payroll_data'] = 1;
			}
			
			// medical data
			if (($results->is_validated == 1) && ($results->validation_rule_id == 142)) {
				$arr_validations ['medical_data'] = 1;
			}
		}
		
		if ($arr_validations ['plan_class'] == 1) {
			$plan_class_validation = TblAcaPlanClassValidationLog::find ()->select ( 'is_validated' )->where ( [ 
					'company_id' => $company_id 
			] )->All ();
			
			if (! empty ( $plan_class_validation )) {
				foreach ( $plan_class_validation as $validations ) {
					if (($validations->is_validated == 0)) {
						$arr_validations ['plan_class_validation'] ++;
					}
				}
			}
			
			/**
			 * *** getting individual plan classes validation *******
			 */
			$error_plan_classes = TblAcaPlanClassValidationLog::find ()->where ( [ 
					'company_id' => $company_id 
			] )->andWhere ( [ 
					'<>',
					'is_validated',
					1 
			] )->groupBy ( [ 
					'plan_class_id' 
			] )->All ();
			
			// get the plan class name
			foreach ( $error_plan_classes as $error_plan_class ) {
				
				$plan_class_details = TblAcaPlanCoverageType::find ()->where ( [ 
						'plan_class_id' => $error_plan_class->plan_class_id 
				] )->One ();
				
				// get the number of issues for individual plan classes
				$error_individual_plan_classes = TblAcaPlanClassValidationLog::find ()->where ( [ 
						'company_id' => $company_id 
				] )->andWhere ( [ 
						'<>',
						'is_validated',
						1 
				] )->andWhere ( [ 
						'plan_class_id' => $error_plan_class->plan_class_id 
				] )->All ();
				
				$issue_count = count ( $error_individual_plan_classes );
				
				$hased_plan_class_id = $encrypt_component->encrytedUser ( $error_plan_class->plan_class_id );
				$arr_plan_class_individual_issues [] = array (
						'plan_class' => $plan_class_details->plan_class_number,
						'issue_count' => $issue_count,
						'plan_class_id' => $hased_plan_class_id 
				);
			}
		}
		
		if ($arr_validations ['payroll_data'] == 1) {
			
			$payroll_validation = TblAcaPayrollValidationLog::find ()->select ( 'is_validated, validation_rule_id' )->where ( [ 
					'company_id' => $company_id 
			] )->Count ();
			
			$arr_validations ['payroll_data_validation'] = $payroll_validation;
			
			$payroll_period = TblAcaPayrollEmploymentPeriodValidationLog::find ()->select ( 'is_validated, validation_rule_id' )->where ( [ 
					'company_id' => $company_id 
			] )->Count ();
			
			$arr_validations ['payroll_data_validation'] += $payroll_period;
		}
		
		if ($arr_validations ['medical_data'] == 1) {
			$medical_validation = TblAcaMedicalValidationLog::find ()->select ( 'is_validated' )->where ( [ 
					'company_id' => $company_id 
			] )->count ();
			
			$arr_validations ['medical_data_validation'] = $medical_validation;
			
			$medical_period = TblAcaMedicalEnrollmentPeriodValidationLog::find ()->select ( 'is_validated, validation_rule_id' )->where ( [ 
					'company_id' => $company_id 
			] )->Count ();
			
			$arr_validations ['medical_data_validation'] += $medical_period;
		}
		$arr_validations['arr_plan_class_individual_issues'] = $arr_plan_class_individual_issues;
		return $arr_validations;
	}
}