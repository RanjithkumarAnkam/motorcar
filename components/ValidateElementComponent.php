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
use app\models\TblAcaElementMaster;
use app\models\TblAcaValidationRules;
use yii\helpers\ArrayHelper;
use app\models\TblAcaMedicalData;
use app\models\TblAcaValidationLog;
use app\models\TblAcaMedicalValidationLog;
use app\models\TblAcaMedicalEnrollmentPeriod;
use app\models\TblAcaPlanCoverageType;
use app\models\TblAcaPlanClassValidationLog;
use app\models\TblAcaPayrollValidationLog;
use app\models\TblAcaPayrollData;
use app\models\TblAcaEmpContributions;
use app\models\TblUsaStates;
use app\models\TblAcaPayrollEmploymentPeriodValidationLog;
use app\models\TblAcaMedicalEnrollmentPeriodValidationLog;
use app\models\TblAcaPayrollEmploymentPeriod;

class ValidateElementComponent extends Component {
	public $arrinvalid_ssn = [ 
			'000000000',
			'111111111',
			'222222222',
			'333333333',
			'444444444',
			'555555555',
			'666666666',
			'777777777',
			'888888888',
			'999999999' 
	];
	public function validustates() {
		$usStates = ArrayHelper::map ( TblUsaStates::find ()->All (), 'state_code', 'state_code' );
		return $usStates;
	}
	/**
	 * *****Validate all elements*************
	 */
	public function Validateelement($company_id) {
		$validate_individual_element = new ValidateindividualElementComponent ();
		$insert_element_validation = new InsertElementValidation ();
		$arrelemnt = array ();
		$arrrule_ids = array ();
		$result = array ();
		$arrvalidate_results = array ();
		$validation_rule_ids = array ();
		
		try {
			/**
			 * *****Get all element ids to be validated*************
			 */
			$all_validation_element_id = TblAcaValidationRules::find ()->select ( 'element_id,rule_id' )->where ( [ 
					'element_type' => 1 
			] )->asArray ()->all ();
			
			foreach ( $all_validation_element_id as $key => $item ) {
				if (array_key_exists ( 'element_id', $item ))
					$arrelemnt [$item ['element_id']] [$key] = $item;
			}
			
			ksort ( $arrelemnt, SORT_NUMERIC );
			
			foreach ( $all_validation_element_id as $key => $value ) {
				
				$arrrule_ids [] = $value ['rule_id'];
			}
			
			TblAcaValidationLog::deleteAll ( [ 
					'and',
					'company_id  = :company_id',
					[ 
							'in',
							'validation_rule_id',
							$arrrule_ids 
					] 
			], [ 
					':company_id' => $company_id 
			] );
			
			foreach ( array_keys ( $arrelemnt ) as $key => $value ) {
				
				$validation_result = array ();
				switch ($value) {
					case '1' :
						$validation_result = $validate_individual_element->Validatebasicinfo ( $company_id, $value );
						
						if (! empty ( $validation_result ['success'] )) {
							
							$arrvalidate_results [] = $validation_result ['success'];
							
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						
						break;
					
					case '2' :
						$validation_result = $validate_individual_element->Validatebasicinfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						
						break;
					
					case '4' :
						$validation_result = $validate_individual_element->Validatebasicinfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '6' :
						$validation_result = $validate_individual_element->Validatebasicinfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '8' :
						$validation_result = $validate_individual_element->Validatebasicinfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '9' :
						$validation_result = $validate_individual_element->Validatebasicinfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '10' :
						$validation_result = $validate_individual_element->Validatebasicinfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '11' :
						$validation_result = $validate_individual_element->Validatebasicinfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '15' :
						$validation_result = $validate_individual_element->Validatebasicinfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '16' :
						$validation_result = $validate_individual_element->Validatebasicinfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '17' :
						$validation_result = $validate_individual_element->Validatebasicinfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '18' :
						$validation_result = $validate_individual_element->Validatebasicinfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '22' :
						$validation_result = $validate_individual_element->Validateale ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '23' :
						$validation_result = $validate_individual_element->Validateale ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '24' :
						$validation_result = $validate_individual_element->Validateale ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '25' :
						$validation_result = $validate_individual_element->Validateplanofferingcriteria ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '26' :
						$validation_result = $validate_individual_element->Validateplanofferingcriteria ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '27' :
						$validation_result = $validate_individual_element->Validateplanofferingcriteria ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '38' :
						$validation_result = $validate_individual_element->Validateplanofferingcriteria ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '42' :
						$validation_result = $validate_individual_element->Validatedge ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '43' :
						$validation_result = $validate_individual_element->Validatedge ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '44' :
						$validation_result = $validate_individual_element->Validatedge ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '45' :
						$validation_result = $validate_individual_element->Validatedge ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '47' :
						$validation_result = $validate_individual_element->Validatedge ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '48' :
						$validation_result = $validate_individual_element->Validatedge ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '49' :
						$validation_result = $validate_individual_element->Validatedge ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '50' :
						$validation_result = $validate_individual_element->Validatedge ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '52' :
						$validation_result = $validate_individual_element->Validatedge ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '54' :
						$validation_result = $validate_individual_element->Validatedge ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '55' :
						$validation_result = $validate_individual_element->Validatedge ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '56' :
						$validation_result = $validate_individual_element->Validateaggreagate ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '57' :
						$validation_result = $validate_individual_element->Validateaggreagate ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '58' :
						$validation_result = $validate_individual_element->Validateaggreagate ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '59' :
						$validation_result = $validate_individual_element->Validateaggreagate ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '60' :
						$validation_result = $validate_individual_element->Validateaggreagate ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '61' :
						$validation_result = $validate_individual_element->Validateaggreagate ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					/*case '62' :
						$validation_result = $validate_individual_element->Validatemec ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;*/
					
					case '64' :
						$validation_result = $validate_individual_element->ValidateGeneralplaninfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '65' :
						$validation_result = $validate_individual_element->ValidateGeneralplaninfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '68' :
						$validation_result = $validate_individual_element->ValidateGeneralplaninfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '69' :
						$validation_result = $validate_individual_element->ValidateGeneralplaninfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '70' :
						$validation_result = $validate_individual_element->ValidateGeneralplaninfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					case '72' :
						$validation_result = $validate_individual_element->ValidateGeneralplaninfo ( $company_id, $value );
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;
					
					/*case '73' :
						
						$validation_result = $validate_individual_element->ValidateMec ( $company_id, $value );
						//print_r($validation_result);die();
						if (! empty ( $validation_result ['success'] )) {
							$arrvalidate_results [] = $validation_result ['success'];
						} elseif (! empty ( $validation_result ['error'] )) {
							throw new \Exception ( $validation_result ['error'] );
						}
						break;*/
				}
				
			}
			
			foreach ( $arrvalidate_results as $array ) {
				foreach ( $array as $k => $v ) {
					$validation_rule_ids [$k] = $v;
				}
			}
			
			$insert_result = $insert_element_validation->Insertvalidationlog ( $validation_rule_ids, $company_id );
			
			if (! empty ( $insert_result ['success'] )) {
				$result ['success'] = 'success';
			} elseif (! empty ( $insert_result ['error'] )) {
				throw new \Exception ( $insert_result ['error'] );
				//throw new \Exception (serialize($insert_result));
			}
		} catch ( \Exception $e ) { // catching the exception
			
			$msg = $e->getMessage ();
		
			$result ['error'] = $msg;
			//$result ['error'] = serialize($e);
		}
		
		return $result;
	}
	
	/**
	 * *****Validate medical elements*************
	 */
	public function ValidateMedical($company_id) {
		$validate_individual_element = new ValidateindividualElementComponent ();
		$insert_element_validation = new InsertElementValidation ();
		$arrelemnt = array ();
		$result = array ();
		$arrrule_ids = array ();
		$arrvalidation = array ();
		$arrinsertvalidation = array ();
		$employee_employment_periods = array ();
		$arrperiodinsertvalidation = array ();
		try {
			/**
			 * *
			 * Check if Medical data is present
			 *
			 * **
			 */
			$medical_data = TblAcaMedicalData::find ()->select ( 'employee_id' )->where ( [ 
					'company_id' => $company_id 
			] )->One ();
			
			$arrrule_ids = [ 
					'142' 
			];
			
			TblAcaValidationLog::deleteAll ( [ 
					'and',
					'company_id  = :company_id',
					[ 
							'in',
							'validation_rule_id',
							$arrrule_ids 
					] 
			], [ 
					':company_id' => $company_id 
			] );
			
			$plan_class_data = TblAcaPlanCoverageType::find ()->select ( 'plan_class_id' )->where ( [ 
					'company_id' => $company_id 
			] )->andWhere ( [ 
					'not in',
					'plan_offer_type',
					[ 
							1,
							4 
					] 
			] )->One ();
			// print_r($plan_class_data);die();
			
			if (! empty ( $medical_data )) {
				
				// Insert in validation log that medical data is present
				$arrvalidation ['142'] = 1; // Key shows medical_data rule_id value shows Medical data is present
				$insert_result = $insert_element_validation->Insertvalidationlog ( $arrvalidation, $company_id );
				
				if (! empty ( $insert_result ['success'] )) {
					
					/**
					 * *****Get all element ids to be validated*************
					 */
					$all_validation_element_id = TblAcaValidationRules::find ()->select ( 'element_id' )->where ( [ 
							'element_type' => 3 
					] )->groupBy ( 'element_id' )->asArray ()->all ();
					
					/**
					 * Get all employee of the company
					 *
					 * **
					 */
					/*
					 * $all_employees = TblAcaMedicalData::find ()->select ( 'employee_id, first_name, last_name, ssn, address1, city, state, zip, dob' )->where ( [ 'company_id' => $company_id ] )->All ();
					 */
					$sql = 'SELECT `employee_id`, `first_name`, `last_name`, `ssn`, `address1`, `city`, `state`, `zip`, `dob` FROM `tbl_aca_medical_data` WHERE `company_id`=' . $company_id . '';
					$all_employees = \Yii::$app->db->createCommand ( $sql )->queryAll ();
					
					foreach ( $all_validation_element_id as $key => $value ) {
						
						$arrelemnt [$key] = $value ['element_id'];
					}
					
					/**
					 * *Delete all previous validations from DB**
					 */
					
					TblAcaMedicalValidationLog::deleteAll ( 'company_id = :company_id', [ 
							':company_id' => $company_id 
					] );
					
					TblAcaMedicalEnrollmentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
							':company_id' => $company_id 
					] );
					
					$i = 0;
					if (! empty ( $plan_class_data )) {
						
						foreach ( $all_employees as $employee ) {
							
							/**
							 * Get employee employment period
							 *
							 * **
							 */
							$employee_id = $employee ['employee_id'];
							
							$sql_periods = 'SELECT period_id, person_type, coverage_start_date ,coverage_end_date, dob, dependent_dob, ssn FROM tbl_aca_medical_enrollment_period WHERE employee_id = ' . $employee_id . '';
							$employee_emrollment_periods = \Yii::$app->db->createCommand ( $sql_periods )->queryAll ();
							
							
							// $employee_emrollment_periods = $employee->tblAcaMedicalEnrollmentPeriods;
							
							$arrinsertvalidation [$i] ['employee_id'] = $employee_id;
							$arrperiodinsertvalidation [$i] ['employee_id'] = $employee_id;
							
							foreach ( $arrelemnt as $key => $value ) {
								
								switch ($value) {
									case '1' :
										/**
										 * ********Can not be empty value***********
										 */
										
										if (empty ( $employee ['first_name'] )) {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['104'] = 0; // key represents rule_id value represents is_validated;
										} else {
											
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['104'] = 1;
											
											/**
											 * ***Can not be "."****
											 */
											
											if ($employee ['first_name'] == '.') {
												
												$arrinsertvalidation [$i] ['validation_rule_id'] ['105'] = 0; // key represents rule_id value represents is_validated;
											} else {
												
												// $arrinsertvalidation [$i] ['validation_rule_id'] ['105'] = 1;
												
												/**
												 * Should be atleast 2 characters
												 */
												if (strlen ( $employee ['first_name'] ) < 2) {
													
													$arrinsertvalidation [$i] ['validation_rule_id'] ['106'] = 0;
												} else {
													
													// $arrinsertvalidation [$i] ['validation_rule_id'] ['106'] = 1;
												}
											}
										}
										
										break;
									
									case '2' :
										
										/**
										 * ********Can not be empty value***********
										 */
										
										if (empty ( $employee ['last_name'] )) {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['107'] = 0; // key represents rule_id value represents is_validated;
										} else {
											
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['107'] = 1;
											
											/**
											 * ***Can not be "."****
											 */
											
											if ($employee ['last_name'] == '.') {
												
												$arrinsertvalidation [$i] ['validation_rule_id'] ['108'] = 0; // key represents rule_id value represents is_validated;
											} else {
												
												// $arrinsertvalidation [$i] ['validation_rule_id'] ['108'] = 1;
												
												/**
												 * Should be atleast 2 characters
												 */
												if (strlen ( $employee ['last_name'] ) < 2) {
													
													$arrinsertvalidation [$i] ['validation_rule_id'] ['109'] = 0;
												} else {
													
													// $arrinsertvalidation [$i] ['validation_rule_id'] ['109'] = 1;
												}
											}
										}
										
										break;
									
									case '3' :
										
										/**
										 * ********Can not be empty value***********
										 */
										
										if (empty ( $employee ['ssn'] )) {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['110'] = 0; // key represents rule_id value represents is_validated;
										} else {
											
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['110'] = 1;
											
											/**
											 * ***SSN has to be a 9 digit number****
											 */
											// Replacing special characters from EIN
											$clean_ssn = preg_replace ( '/[^0-9]/s', '', $employee ['ssn'] );
											if (strlen ( $clean_ssn ) == 9) {
												
												// $arrinsertvalidation [$i] ['validation_rule_id'] ['111'] = 1; // key represents rule_id value represents is_validated;
												
												/**
												 * ***SSN can not have all numbers same
												 * ( eg.
												 * 000-00-0000, 111-11-1111 etc)
												 * ****
												 */
												
												if (in_array ( $clean_ssn, $this->arrinvalid_ssn )) {
													
													$arrinsertvalidation [$i] ['validation_rule_id'] ['112'] = 0;
												} else {
													
													// $arrinsertvalidation [$i] ['validation_rule_id'] ['112'] = 1;
												}
											} else {
												
												$arrinsertvalidation [$i] ['validation_rule_id'] ['111'] = 0;
											}
										}
										
										break;
									
									case '4' :
										
										/**
										 * ********Can not be empty value***********
										 */
										
										if (empty ( $employee ['address1'] )) {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['113'] = 0; // key represents rule_id value represents is_validated;
										} else {
											
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['113'] = 1;
											
											/**
											 * ***Can not be "."****
											 */
											
											if ($employee ['address1'] == '.') {
												
												$arrinsertvalidation [$i] ['validation_rule_id'] ['114'] = 0; // key represents rule_id value represents is_validated;
											} else {
												
												// $arrinsertvalidation [$i] ['validation_rule_id'] ['114'] = 1;
												
												/**
												 * Should be atleast 2 characters
												 */
												if (strlen ( $employee ['address1'] ) < 2) {
													
													$arrinsertvalidation [$i] ['validation_rule_id'] ['115'] = 0;
												} else {
													
													// $arrinsertvalidation [$i] ['validation_rule_id'] ['115'] = 1;
												}
											}
										}
										
										break;
									
									case '5' :
										
										/**
										 * ********Can not be empty value***********
										 */
										
										if (empty ( $employee ['city'] )) {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['116'] = 0; // key represents rule_id value represents is_validated;
										} else {
											
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['116'] = 1;
											
											/**
											 * ***Can not be "."****
											 */
											
											if ($employee ['city'] == '.') {
												
												$arrinsertvalidation [$i] ['validation_rule_id'] ['117'] = 0; // key represents rule_id value represents is_validated;
											} else {
												
												// $arrinsertvalidation [$i] ['validation_rule_id'] ['117'] = 1;
												
												/**
												 * Should be atleast 2 characters
												 */
												if (strlen ( $employee ['city'] ) < 2) {
													
													$arrinsertvalidation [$i] ['validation_rule_id'] ['118'] = 0;
												} else {
													
													// $arrinsertvalidation [$i] ['validation_rule_id'] ['118'] = 1;
													
													if (preg_match ( '/[^a-zA-Z ]+/i', $employee ['city'] ) == 1) {
														
														$arrinsertvalidation [$i] ['validation_rule_id'] ['119'] = 0;
													} else {
														
														// $arrinsertvalidation [$i] ['validation_rule_id'] ['119'] = 0;
													}
												}
											}
										}
										
										break;
									
									case '6' :
										
										/**
										 * ********Can not be empty value***********
										 */
										
										if (empty ( $employee ['state'] )) {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['120'] = 0; // key represents rule_id value represents is_validated;
										} else {
											
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['120'] = 1;
											
											/**
											 * Only can be 2 character state
											 */
											
											if (strlen ( $employee ['state'] ) == 2) {
												
												// $arrinsertvalidation [$i] ['validation_rule_id'] ['121'] = 1;
												if (! in_array ( strtoupper ( $employee ['state'] ), $this->validustates () )) {
													
													$arrinsertvalidation [$i] ['validation_rule_id'] ['122'] = 0;
												}
											} else {
												
												$arrinsertvalidation [$i] ['validation_rule_id'] ['121'] = 0;
											}
										}
										
										break;
									
									case '7' :
										
										/**
										 * ********Can not be empty value***********
										 */
										
										if (empty ( $employee ['zip'] )) {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['123'] = 0; // key represents rule_id value represents is_validated;
										} else {
											
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['123'] = 1;
											
											/**
											 * ********Cannot be < 5 digits***********
											 */
											if (strlen ( $employee ['zip'] ) < 5) {
												
												$arrinsertvalidation [$i] ['validation_rule_id'] ['124'] = 0;
											} else {
												
												// $arrinsertvalidation [$i] ['validation_rule_id'] ['124'] = 1;
											}
										}
										break;
									
									case '8' :
										
										/**
										 * ********Can not be empty value***********
										 */
										
										if (empty ( $employee ['dob'] )) {
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['125'] = 0; // key represents rule_id value represents is_validated;
										} else {
											// return $employee->dob;
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['125'] = 1;
											
											/**
											 * ********Cannot be < 5 digits***********
											 */
											if (date ( 'Y-m-d', strtotime ( $employee ['dob'] ) ) > date ( 'Y-m-d' )) {
												
												$arrinsertvalidation [$i] ['validation_rule_id'] ['126'] = 0;
											} else {
												
												// $arrinsertvalidation [$i] ['validation_rule_id'] ['126'] = 1;
											}
										}
										break;
									
									case '9' :
										if (! empty ( $employee_emrollment_periods )) {
											
											foreach ( $employee_emrollment_periods as $enrollment_period ) {
												$coverage_start_date = '';
												$period_id = $enrollment_period ['period_id'];
												/**
												 * ******Get all other
												 * enrollment period other
												 * than this period of particular employee********
												 */
												
												if (! empty ( $enrollment_period ['coverage_start_date'] )) {
													
													$coverage_start_date = $enrollment_period ['coverage_start_date'];
												}
												
												/**
												 * ********Can not be empty value***********
												 */
												
												if (empty ( $coverage_start_date ) || $coverage_start_date == '0000-00-00') {
													
													$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['127'] = 0;
												} else {
													
													/**
													 * ********Coverage start date can not be
													 * greater than 31st dec of the current year***********
													 */
													
													$year_end = date ( 'Y-m-d', strtotime ( 'Dec 31' ) );
													
													if ($coverage_start_date > $year_end) {
														
														$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['128'] = 0;
													}
													
													/**
													 * ********can not be greater than coverage end date***********
													 */
													
													if (! empty ( $enrollment_period ['coverage_end_date'] )) {
														if ($coverage_start_date > $enrollment_period ['coverage_end_date']) {
															$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['129'] = 0;
														}
													}
													
													/**
													 * *additional coverage start date can not be between a enrollment Period
													 * *
													 */
													
													$check_between_period = TblAcaMedicalEnrollmentPeriod::find ()->select ( 'period_id' )->where ( '"' . $coverage_start_date . '" between coverage_start_date and coverage_end_date' )->andWhere ( 'period_id <> ' . $period_id )->andWhere ( 'employee_id=' . $arrinsertvalidation [$i] ['employee_id'] )->Count ();
													
													if (! empty ( $check_between_period )) {
														
														$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['130'] = 0;
													}
													
													/**
													 * ***** checking for duplicate coverage_start_date
													 */
													$duplicate = TblAcaMedicalEnrollmentPeriod::find ()->select ( 'coverage_start_date' )->where ( [ 
															'employee_id' => $arrinsertvalidation [$i] ['employee_id'] 
													] )->andWhere ( [ 
															'coverage_start_date' => $coverage_start_date 
													] )->Count ();
													
													/**
													 * *** if there is duplicate coverage_start_date ******
													 */
													if ($duplicate > 1) {
														$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['153'] = 0;
													}
												}
											}
										}
										
										break;
									
									case '10' :
										if (! empty ( $employee_emrollment_periods )) {
											foreach ( $employee_emrollment_periods as $enrollment_period ) {
												$coverage_end_date = '';
												$period_id = $enrollment_period ['period_id'];
												
												if (! empty ( $enrollment_period ['coverage_end_date'] )) {
													$coverage_end_date = $enrollment_period ['coverage_end_date'];
												}
												
												if (empty ( $coverage_end_date ) || $coverage_end_date == '0000-00-00') {
												} else {
													
													/**
													 * *A coverage end date can not be between a enrollement period
													 * *
													 */
													
													$check_end_between_period = TblAcaMedicalEnrollmentPeriod::find ()->select ( 'period_id' )->where ( '"' . $coverage_end_date . '" between coverage_start_date and coverage_end_date' )->andWhere ( 'period_id != ' . $period_id )->andWhere ( 'employee_id=' . $arrinsertvalidation [$i] ['employee_id'] )->Count ();
													
													if (! empty ( $check_end_between_period )) {
														
														$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['131'] = 0;
													}
													
													/**
													 * ***** checking for duplicate coverage_end_date
													 */
													$duplicate = TblAcaMedicalEnrollmentPeriod::find ()->select ( 'coverage_end_date' )->where ( [ 
															'employee_id' => $arrinsertvalidation [$i] ['employee_id'] 
													] )->andWhere ( [ 
															'coverage_end_date' => $coverage_end_date 
													] )->Count ();
													
													/**
													 * *** if there is duplicate coverage_end_date ******
													 */
													if ($duplicate > 1) {
														$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['154'] = 0;
													}
												}
											}
										}
										break;
									
									case '11' :
										
										if (! empty ( $employee_emrollment_periods )) {
											foreach ( $employee_emrollment_periods as $enrollment_period ) {
												$person_type = '';
												$period_id = $enrollment_period ['period_id'];
												
												if (! empty ( $enrollment_period ['person_type'] )) {
													$person_type = $enrollment_period ['person_type'];
												}
												
												/**
												 * *Need to be one of "Employee" or
												 * "Dependent of Employee" or
												 * "Non Employee enrolled", or
												 * "Dependent of non employee enrolled"
												 * *
												 */
												
												if (empty ( $person_type )) {
													$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['132'] = 0;
												}
											}
										}
										break;
									
									case '12' :
										
										if (! empty ( $employee_emrollment_periods )) {
											foreach ( $employee_emrollment_periods as $enrollment_period ) {
												$person_type = '';
												$dependent_dob = '';
												$period_id = $enrollment_period ['period_id'];
												if (! empty ( $enrollment_period ['dependent_dob'] )) {
													$dependent_dob = $enrollment_period ['dependent_dob'];
												}
												
												if (! empty ( $enrollment_period ['person_type'] )) {
													$person_type = $enrollment_period ['person_type'];
												}
												
												if (! empty ( $person_type ) && $person_type != 84 && $person_type != 87) {
													
													if (empty ( $dependent_dob ))
													{
													/**
													 * ********Can not be empty value***********
													 */
													if (empty ( $enrollment_period ['ssn'] )) {
														
														$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['134'] = 0;
													} else {
														
														/**
														 * ***SSN has to be a 9 digit number****
														 */
														// Replacing special characters from EIN
														$enrollment_period_clean_ssn = preg_replace ( '/[^0-9]/s', '', $enrollment_period ['ssn'] );
														if (strlen ( $enrollment_period_clean_ssn ) == 9) {
															
															/**
															 * ***SSN can not have all numbers same
															 * ( eg.
															 * 000-00-0000, 111-11-1111 etc)
															 * ****
															 */
															
															if (in_array ( $enrollment_period_clean_ssn, $this->arrinvalid_ssn )) {
																
																$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['136'] = 0;
															}
														} else {
															
															$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['135'] = 0;
														}
													}
													
													}
												}
											}
										}
										
										break;
									
									case '13' :
										if (! empty ( $employee_emrollment_periods )) {
											foreach ( $employee_emrollment_periods as $enrollment_period ) {
												$person_type = '';
												$period_id = $enrollment_period ['period_id'];
												
												if (! empty ( $enrollment_period ['person_type'] )) {
													$person_type = $enrollment_period ['person_type'];
												}
												
												if (! empty ( $person_type ) && $person_type != 84 && $person_type != 87) {
													/**
													 * ********If person type is not
													 * employee and social
													 * is not entered
													 * this is required***********
													 */
													if (empty ( $enrollment_period ['ssn'] )) {
														
														if (empty ( $enrollment_period ['dependent_dob'] )) {
															
															$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['137'] = 0;
														}
													}
												}
											}
										}
										
										break;
									
									case '14' :
										
										if (! empty ( $employee_emrollment_periods )) {
											foreach ( $employee_emrollment_periods as $enrollment_period ) {
												$dependent_dob = '';
												$person_type = '';
												$period_id = $enrollment_period ['period_id'];
												
												if (! empty ( $enrollment_period ['dependent_dob'] )) {
													$dependent_dob = $enrollment_period ['dependent_dob'];
												}
												
												if (! empty ( $enrollment_period ['person_type'] )) {
													$person_type = $enrollment_period ['person_type'];
												}
												
												/**
												 * *If use dependent dob
												 * is selected then DOB
												 * cannot be blank, can not
												 * give a future date
												 * *
												 */
												
												if (! empty ( $dependent_dob ) && $dependent_dob == 1 && (! empty ( $person_type )) && $person_type != 84 && $person_type != 87) {
													if (empty ( $enrollment_period['dob'] )) {
														
														$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['138'] = 0;
													} else {
														
														/**
														 * ********Cannot be a future date***********
														 */
														if (date ( 'Y-m-d', strtotime ( $enrollment_period['dob'] ) ) > date ( 'Y-m-d' )) {
															
															$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['139'] = 0;
														} else {
														}
													}
												}
											}
										}
										break;
										case '15' :
									
										if (empty ( $employee_emrollment_periods )) {
											
											$arrinsertvalidation [$i] ['validation_rule_id'] ['156'] = 0;
										}
										break;
								}
							}
							$i ++;
						}
					}
					$result = $insert_element_validation->Insertmedicalvalidationlog ( $arrperiodinsertvalidation, $arrinsertvalidation, $company_id );
				} elseif (! empty ( $insert_result ['error'] )) {
					throw new \Exception ( $insert_result ['error'] );
				}
			} else {
				
				if (! empty ( $plan_class_data )) {
					$arrvalidation ['142'] = 0; // Key shows medical_data rule_id value shows Medical data is present when any of the plan class have no qualifying plan
				} else {
					
					// Insert in validation log that no medical data is present
					$arrvalidation ['142'] = 1; // Key shows medical_data rule_id value shows Medical data is not present
				}
				$insert_result = $insert_element_validation->Insertvalidationlog ( $arrvalidation, $company_id );
				
				if (! empty ( $insert_result ['error'] )) {
					throw new \Exception ( $insert_result ['error'] );
				}
			}
		} catch ( \Exception $e ) { // catching the exception
			
			$msg = $e->getMessage ();
			$result ['error'] = $msg;
		}
		
		return $result;
	}
	
	/**
	 * *****Validate plan class elements*************
	 */
	public function ValidatePlanclass($company_id) {
		$validate_individual_element = new ValidateindividualElementComponent ();
		$insert_element_validation = new InsertElementValidation ();
		$arrelemnt = array ();
		$result = array ();
		$arrrule_ids = array ();
		$arrvalidation = array ();
		$arrinsertvalidation = array ();
		$plan_emp_contributions = array ();
		
		try {
			/**
			 * *
			 * Check if Plan class data is present
			 *
			 * **
			 */
			$plan_class_data = TblAcaPlanCoverageType::find ()->select ( 'plan_class_id' )->where ( [ 
					'company_id' => $company_id 
			] )->One ();
			
			$arrrule_ids = [ 
					'140' 
			];
			
			TblAcaValidationLog::deleteAll ( [ 
					'and',
					'company_id  = :company_id',
					[ 
							'in',
							'validation_rule_id',
							$arrrule_ids 
					] 
			], [ 
					':company_id' => $company_id 
			] );
			
			if (! empty ( $plan_class_data )) {
				
				// Insert in validation log that medical data is present
				$arrvalidation ['140'] = 1; // Key shows medical_data rule_id value shows Medical data is present
				$insert_result = $insert_element_validation->Insertvalidationlog ( $arrvalidation, $company_id );
				
				if (! empty ( $insert_result ['success'] )) {
					
					/**
					 * *****Get all element ids to be validated*************
					 */
					$all_validation_element_id = TblAcaValidationRules::find ()->select ( 'element_id' )->where ( [ 
							'element_type' => 1 
					] )->groupBy ( 'element_id' )->asArray ()->all ();
					
					/**
					 * Get all plan class of the company
					 *
					 * **
					 */
					$all_plan_class = TblAcaPlanCoverageType::find ()->select ( 'plan_class_id, plan_offer_type, plan_type_doh, employee_medical_plan' )->where ( [ 
							'company_id' => $company_id 
					] )->All ();
					
					foreach ( $all_validation_element_id as $key => $value ) {
						
						$arrelemnt [$key] = $value ['element_id'];
					}
					
					/**
					 * *Delete all previous validations from DB**
					 */
					
					TblAcaPlanClassValidationLog::deleteAll ( 'company_id = :company_id', [ 
							':company_id' => $company_id 
					] );
					
					$i = 0;
					foreach ( $all_plan_class as $plan_class ) {
						
						/**
						 * *Plan class coverage offered***
						 */
						$plan_class_offered = $plan_class->tblAcaPlanCoverageTypeOffereds;
						
						if (! empty ( $plan_class_offered )) {
							
							$coverage_type_id = $plan_class_offered->coverage_type_id;
							$plan_emp_contributions = TblAcaEmpContributions::find ()->where ( [ 
									'coverage_type_id' => $coverage_type_id 
							] )->One ();
						}
						
						$arrinsertvalidation [$i] ['plan_class_id'] = $plan_class->plan_class_id;
						
						foreach ( $arrelemnt as $key => $value ) {
							
							switch ($value) {
								
								case '76' :
									/**
									 * ********A value should have been selected*****
									 */
									if (! empty ( $plan_class->plan_offer_type )) {
										$arrinsertvalidation [$i] ['validation_rule_id'] ['63'] = 1; // key represents rule_id value represents is_validated;
										if($plan_class->plan_offer_type == 1 || $plan_class->plan_offer_type == 4 || $plan_class->plan_offer_type == 5)
										{
											
											$arrinsertvalidation[$i] ['validation_rule_id']['148'] = 1; // key represents rule_id value represents is_validated;
										}
										else
										{
										if(!empty($plan_class->plan_type_doh))
										{
											
											$arrinsertvalidation [$i] ['validation_rule_id']['148'] = 1; // key represents rule_id value represents is_validated;
										}	
										else
										{
											$arrinsertvalidation [$i] ['validation_rule_id']['148'] = 0;// key represents rule_id value represents is_validated;
											
										}
										
										
									}
									
									} else {
										$arrinsertvalidation [$i] ['validation_rule_id'] ['63'] = 0; // key represents rule_id value represents is_validated;
									}
									
									break;
								
								case '77' :
									if ( $plan_class->plan_offer_type != 1 ) {
										/**
										 * ********A value should have been selected*****
										 */
										if (! empty ( $plan_class->employee_medical_plan )) {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['64'] = 1; // key represents rule_id value represents is_validated;
										} else {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['64'] = 0; // key represents rule_id value represents is_validated;
										}
									}
									
									break;
								case '78' :
									if ( $plan_class->plan_offer_type != 1 ) {
										/**
										 * ********A value should have been selected*****
										 */
										if (! empty ( $plan_class_offered->employee_mv_coverage )) {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['65'] = 1; // key represents rule_id value represents is_validated;
										} else {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['65'] = 0; // key represents rule_id value represents is_validated;
										}
									}
									break;
								
								case '79' :
									if ( $plan_class->plan_offer_type != 1 ) {
										/**
										 * ********Atleast one month or entire year should be selected*****
										 */
										if (! empty ( $plan_class_offered->employee_mv_coverage ) && $plan_class_offered->employee_mv_coverage == 1) {
											if (! empty ( $plan_class_offered->mv_coverage_months )) {
												$arrinsertvalidation [$i] ['validation_rule_id'] ['66'] = 1; // key represents rule_id value represents is_validated;
											} else {
												$arrinsertvalidation [$i] ['validation_rule_id'] ['66'] = 0; // key represents rule_id value represents is_validated;
											}
										}
									}
									break;
								case '80' :
									if ( $plan_class->plan_offer_type != 1 ) {
										/**
										 * ********A value should have been selected*****
										 */
										
										if (! empty ( $plan_class_offered->employee_essential_coverage )) {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['67'] = 1; // key represents rule_id value represents is_validated;
										} else {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['67'] = 0; // key represents rule_id value represents is_validated;
										}
									}
									break;
								
								case '81' :
									if ( $plan_class->plan_offer_type != 1 ) {
										/**
										 * ********Atleast one month or entire year should be selected*****
										 */
										if (! empty ( $plan_class_offered->employee_essential_coverage ) && $plan_class_offered->employee_essential_coverage == 1) {
											if (! empty ( $plan_class_offered->essential_coverage_months )) {
												$arrinsertvalidation [$i] ['validation_rule_id'] ['68'] = 1; // key represents rule_id value represents is_validated;
											} else {
												$arrinsertvalidation [$i] ['validation_rule_id'] ['68'] = 0; // key represents rule_id value represents is_validated;
											}
										}
									}
									break;
								
								case '82' :
									if ( $plan_class->plan_offer_type != 1 ) {
										/**
										 * ********A value should have been selected*****
										 */
										
										if (! empty ( $plan_class_offered->spouse_essential_coverage )) {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['69'] = 1; // key represents rule_id value represents is_validated;
										} else {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['69'] = 0; // key represents rule_id value represents is_validated;
										}
									}
									break;
								
								case '83' :
									if ( $plan_class->plan_offer_type != 1 ) {
										/**
										 * ********if for 10.3 a yes was
										 * selected then a value
										 * for 10.3.1 should
										 * have been selected*****
										 */
										
										if (! empty ( $plan_class_offered->spouse_essential_coverage ) && $plan_class_offered->spouse_essential_coverage == 1) {
											
											if (! empty ( $plan_class_offered->spouse_conditional_coverage )) {
												$arrinsertvalidation [$i] ['validation_rule_id'] ['70'] = 1; // key represents rule_id value represents is_validated;
											} else {
												$arrinsertvalidation [$i] ['validation_rule_id'] ['70'] = 0; // key represents rule_id value represents is_validated;
											}
										}
									}
									break;
								
								case '84' :
									if ( $plan_class->plan_offer_type != 1 ) {
										/**
										 * ********A value should have been selected*****
										 */
										
										if (! empty ( $plan_class_offered->dependent_essential_coverage )) {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['71'] = 1; // key represents rule_id value represents is_validated;
										} else {
											$arrinsertvalidation [$i] ['validation_rule_id'] ['71'] = 0; // key represents rule_id value represents is_validated;
										}
									}
									break;
								
								case '85' :
									if ( $plan_class->plan_offer_type != 1 ) {
										/**
										 * ********A value should have been selected*****
										 */
										if (! empty ( $coverage_type_id )) {
											if (! empty ( $plan_emp_contributions->safe_harbor )) {
												$arrinsertvalidation [$i] ['validation_rule_id'] ['72'] = 1; // key represents rule_id value represents is_validated;
											} else {
												$arrinsertvalidation [$i] ['validation_rule_id'] ['72'] = 0; // key represents rule_id value represents is_validated;
											}
										}
									}
									break;
								
								case '86' :
									if ( $plan_class->plan_offer_type != 1 ) {
										/**
										 * ********A value should have been selected*****
										 */
										if (! empty ( $coverage_type_id )) {
											if (! empty ( $plan_emp_contributions->employee_plan_contribution )) {
												$arrinsertvalidation [$i] ['validation_rule_id'] ['73'] = 1; // key represents rule_id value represents is_validated;
											} else {
												$arrinsertvalidation [$i] ['validation_rule_id'] ['73'] = 0; // key represents rule_id value represents is_validated;
											}
										}
									}
									break;
							}
						}
						
						$i ++;
					}
					
					$result = $insert_element_validation->Insertplanvalidationlog ( $arrinsertvalidation, $company_id );
				} elseif (! empty ( $insert_result ['error'] )) {
					throw new \Exception ( $insert_result ['error'] );
				}
			} else {
				// Insert in validation log that no medical data is present
				$arrvalidation ['140'] = 0; // Key shows medical_data rule_id value shows Medical data is not present
				$insert_result = $insert_element_validation->Insertvalidationlog ( $arrvalidation, $company_id );
				
				if (! empty ( $insert_result ['error'] )) {
					throw new \Exception ( $insert_result ['error'] );
				}
			}
		} catch ( \Exception $e ) { // catching the exception
			
			$msg = $e->getMessage ();
			$result ['error'] = $msg;
		}
		
		return $result;
	}
	
	/**
	 * *****Validate payroll elements*************
	 */
	public function ValidatePayroll($company_id) {
		$validate_individual_element = new ValidateindividualElementComponent ();
		$insert_element_validation = new InsertElementValidation ();
		$arrelemnt = array ();
		$result = array ();
		$arrrule_ids = array ();
		$arrvalidation = array ();
		$arrinsertvalidation = array ();
		$employee_employment_periods = array ();
		$arrperiodinsertvalidation = array ();
		
		try {
			/**
			 * *
			 * Check if Payroll data is present
			 *
			 * **
			 */
			$payroll_data = TblAcaPayrollData::find ()->select ( 'employee_id' )->where ( [ 
					'company_id' => $company_id 
			] )->One ();
			
			$arrrule_ids = [ 
					'141' 
			];
			
			TblAcaValidationLog::deleteAll ( [ 
					'and',
					'company_id  = :company_id',
					[ 
							'in',
							'validation_rule_id',
							$arrrule_ids 
					] 
			], [ 
					':company_id' => $company_id 
			] );
			
			if (! empty ( $payroll_data )) {
				
				// Insert in validation log that medical data is present
				$arrvalidation ['141'] = 1; // Key shows medical_data rule_id value shows Medical data is present
				$insert_result = $insert_element_validation->Insertvalidationlog ( $arrvalidation, $company_id );
				
				if (! empty ( $insert_result ['success'] )) {
					
					/**
					 * *****Get all element ids to be validated*************
					 */
					$all_validation_element_id = TblAcaValidationRules::find ()->select ( 'element_id' )->where ( [ 
							'element_type' => 2 
					] )->groupBy ( 'element_id' )->asArray ()->all ();
					
					/**
					 * Get all employee of the company
					 *
					 * **
					 */
					
					$sql = 'SELECT `employee_id`, `first_name`, `last_name`, `ssn`, `address1`, `city`, `state`, `zip`, `dob` FROM `tbl_aca_payroll_data` WHERE `company_id`=' . $company_id . '';
					$all_employees = \Yii::$app->db->createCommand ( $sql )->queryAll ();
					/*
					 * $all_employees = TblAcaPayrollData::find ()->select ( 'employee_id, first_name, last_name, ssn, address1, city, state, zip, dob' )->where ( [ 'company_id' => $company_id ] )->asArray ()->All ();
					 */
					foreach ( $all_validation_element_id as $key => $value ) {
						
						$arrelemnt [$key] = $value ['element_id'];
					}
					
					/**
					 * *Delete all previous validations from DB**
					 */
					
					TblAcaPayrollValidationLog::deleteAll ( 'company_id = :company_id', [ 
							':company_id' => $company_id 
					] );
					
					TblAcaPayrollEmploymentPeriodValidationLog::deleteAll ( 'company_id = :company_id', [ 
							':company_id' => $company_id 
					] );
					
					$i = 0;
					foreach ( $all_employees as $employee ) {
						
						/**
						 * Get employee employment period
						 *
						 * **
						 */
						$employee_id = $employee ['employee_id'];
						$sql_periods = 'SELECT period_id, hire_date, plan_class ,termination_date, status FROM tbl_aca_payroll_employment_period WHERE employee_id = ' . $employee_id . '';
						$employee_employment_periods = \Yii::$app->db->createCommand ( $sql_periods )->queryAll ();
						
						// $employee_employment_periods = $employee->tblAcaPayrollEmploymentPeriods;
						
						$arrinsertvalidation [$i] ['employee_id'] = $employee_id;
						$arrperiodinsertvalidation [$i] ['employee_id'] = $employee_id;
						foreach ( $arrelemnt as $key => $value ) {
							
							switch ($value) {
								case '1' :
									/**
									 * ********Can not be empty value***********
									 */
									
									if (empty ( $employee ['first_name'] )) {
										$arrinsertvalidation [$i] ['validation_rule_id'] ['75'] = 0; // key represents rule_id value represents is_validated;
									} else {
										
										// $arrinsertvalidation [$i] ['validation_rule_id'] ['75'] = 1;
										
										/**
										 * ***Can not be "."****
										 */
										
										if ($employee ['first_name'] == '.') {
											
											$arrinsertvalidation [$i] ['validation_rule_id'] ['76'] = 0; // key represents rule_id value represents is_validated;
										} else {
											
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['76'] = 1;
											
											/**
											 * Should be atleast 2 characters
											 */
											if (strlen ( $employee ['first_name'] ) < 2) {
												
												$arrinsertvalidation [$i] ['validation_rule_id'] ['77'] = 0;
											} else {
												
												// $arrinsertvalidation [$i] ['validation_rule_id'] ['77'] = 1;
											}
										}
									}
									
									break;
								
								case '2' :
									
									/**
									 * ********Can not be empty value***********
									 */
									
									if (empty ( $employee ['last_name'] )) {
										$arrinsertvalidation [$i] ['validation_rule_id'] ['78'] = 0; // key represents rule_id value represents is_validated;
									} else {
										
										// $arrinsertvalidation [$i] ['validation_rule_id'] ['78'] = 1;
										
										/**
										 * ***Can not be "."****
										 */
										
										if ($employee ['last_name'] == '.') {
											
											$arrinsertvalidation [$i] ['validation_rule_id'] ['79'] = 0; // key represents rule_id value represents is_validated;
										} else {
											
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['79'] = 1;
											
											/**
											 * Should be atleast 2 characters
											 */
											if (strlen ( $employee ['last_name'] ) < 2) {
												
												$arrinsertvalidation [$i] ['validation_rule_id'] ['80'] = 0;
											} else {
												
												// $arrinsertvalidation [$i] ['validation_rule_id'] ['80'] = 1;
											}
										}
									}
									
									break;
								
								case '3' :
									
									/**
									 * ********Can not be empty value***********
									 */
									
									if (empty ( $employee ['ssn'] )) {
										$arrinsertvalidation [$i] ['validation_rule_id'] ['81'] = 0; // key represents rule_id value represents is_validated;
									} else {
										
										// $arrinsertvalidation [$i] ['validation_rule_id'] ['81'] = 1;
										
										/**
										 * ***SSN has to be a 9 digit number****
										 */
										// Replacing special characters from EIN
										$clean_ssn = preg_replace ( '/[^0-9]/s', '', $employee ['ssn'] );
										
										if (strlen ( $clean_ssn ) == 9) {
											
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['82'] = 1; // key represents rule_id value represents is_validated;
											
											/**
											 * ***SSN can not have all numbers same
											 * ( eg.
											 * 000-00-0000, 111-11-1111 etc)
											 * ****
											 */
											
											if (in_array ( $clean_ssn, $this->arrinvalid_ssn )) {
												
												$arrinsertvalidation [$i] ['validation_rule_id'] ['83'] = 0;
											} else {
												
												// $arrinsertvalidation [$i] ['validation_rule_id'] ['83'] = 1;
											}
										} else {
											
											$arrinsertvalidation [$i] ['validation_rule_id'] ['82'] = 0;
										}
									}
									
									break;
								
								case '4' :
									
									/**
									 * ********Can not be empty value***********
									 */
									
									if (empty ( $employee ['address1'] )) {
										$arrinsertvalidation [$i] ['validation_rule_id'] ['84'] = 0; // key represents rule_id value represents is_validated;
									} else {
										
										// $arrinsertvalidation [$i] ['validation_rule_id'] ['84'] = 1;
										
										/**
										 * ***Can not be "."****
										 */
										
										if ($employee ['address1'] == '.') {
											
											$arrinsertvalidation [$i] ['validation_rule_id'] ['85'] = 0; // key represents rule_id value represents is_validated;
										} else {
											
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['85'] = 1;
											
											/**
											 * Should be atleast 2 characters
											 */
											if (strlen ( $employee ['address1'] ) < 2) {
												
												$arrinsertvalidation [$i] ['validation_rule_id'] ['86'] = 0;
											} else {
												
												// $arrinsertvalidation [$i] ['validation_rule_id'] ['86'] = 1;
											}
										}
									}
									
									break;
								
								case '5' :
									
									/**
									 * ********Can not be empty value***********
									 */
									
									if (empty ( $employee ['city'] )) {
										$arrinsertvalidation [$i] ['validation_rule_id'] ['87'] = 0; // key represents rule_id value represents is_validated;
									} else {
										
										// $arrinsertvalidation [$i] ['validation_rule_id'] ['87'] = 1;
										
										/**
										 * ***Can not be "."****
										 */
										
										if ($employee ['city'] == '.') {
											
											$arrinsertvalidation [$i] ['validation_rule_id'] ['88'] = 0; // key represents rule_id value represents is_validated;
										} else {
											
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['88'] = 1;
											
											/**
											 * Should be atleast 2 characters
											 */
											if (strlen ( $employee ['city'] ) < 2) {
												
												$arrinsertvalidation [$i] ['validation_rule_id'] ['89'] = 0;
											} else {
												
												// $arrinsertvalidation [$i] ['validation_rule_id'] ['89'] = 1;
												
												if (preg_match ( '/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $employee ['city'] )) {
													
													$arrinsertvalidation [$i] ['validation_rule_id'] ['90'] = 0;
												} else {
													
													$arrinsertvalidation [$i] ['validation_rule_id'] ['90'] = 1;
												}
											}
										}
									}
									
									break;
								
								case '6' :
									
									/**
									 * ********Can not be empty value***********
									 */
									
									if (empty ( $employee ['state'] )) {
										$arrinsertvalidation [$i] ['validation_rule_id'] ['91'] = 0; // key represents rule_id value represents is_validated;
									} else {
										
										// $arrinsertvalidation [$i] ['validation_rule_id'] ['91'] = 1;
										
										/**
										 * Only can be 2 character state
										 */
										
										if (strlen ( $employee ['state'] ) == 2) {
											
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['92'] = 1;
											if (! in_array ( strtoupper ( $employee ['state'] ), $this->validustates () )) {
												
												$arrinsertvalidation [$i] ['validation_rule_id'] ['93'] = 0;
											}
										} else {
											
											$arrinsertvalidation [$i] ['validation_rule_id'] ['92'] = 0;
										}
									}
									
									break;
								
								case '7' :
									
									/**
									 * ********Can not be empty value***********
									 */
									
									if (empty ( $employee ['zip'] )) {
										$arrinsertvalidation [$i] ['validation_rule_id'] ['94'] = 0; // key represents rule_id value represents is_validated;
									} else {
										
										// $arrinsertvalidation [$i] ['validation_rule_id'] ['94'] = 1;
										
										/**
										 * ********Cannot be < 5 digits***********
										 */
										if (strlen ( $employee ['zip'] ) < 5) {
											
											$arrinsertvalidation [$i] ['validation_rule_id'] ['95'] = 0;
										} else {
											
											// $arrinsertvalidation [$i] ['validation_rule_id'] ['95'] = 1;
										}
									}
									break;
								
								case '8' :
									
									/**
									 * ********Can not be empty value***********
									 */
									
									if (empty ( $employee ['dob'] )) {
										// $arrinsertvalidation [$i] ['validation_rule_id'] ['96'] = 0; // key represents rule_id value represents is_validated;
									} else {
										
										// $arrinsertvalidation [$i] ['validation_rule_id'] ['96'] = 1;
										
										/**
										 * ********Cannot be a future date***********
										 */
										if ($employee ['dob'] > date ( 'Y-m-d' )) {
											
											$arrinsertvalidation [$i] ['validation_rule_id'] ['97'] = 0;
										} /*
										   * else { // $arrinsertvalidation [$i] ['validation_rule_id'] ['97'] = 1; $diff = date_diff ( date_create ( $employee->dob ), date_create ( date ( 'Y-m-d' ) ) ); if ($diff->format ( '%y' ) < 15) { $arrinsertvalidation [$i] ['validation_rule_id'] ['98'] = 0; } else { // $arrinsertvalidation [$i] ['validation_rule_id'] ['98'] = 1; } }
										   */
									}
									break;
								
								case '9' :
									if (! empty ( $employee_employment_periods )) {
										$empty_hire_count = 1;
										$end_date_count = 1;
										
										foreach ( $employee_employment_periods as $employment_period ) {
											$hire_date = '';
											$period_id = $employment_period ['period_id'];
											/**
											 * ******Get all other
											 * enrollment period other
											 * than this period of particular employee********
											 */
											if (! empty ( $employment_period ['hire_date'] )) {
												$hire_date = $employment_period ['hire_date'];
											}
											
											/**
											 * ********Can not be empty value***********
											 */
											
											if (empty ( $hire_date ) || $hire_date == '0000-00-00') {
												
												$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['99'] = 0;
												$empty_hire_count ++;
											} else {
												
												/**
												 * ********Coverage start date can not be
												 * greater than 31st dec of the current year***********
												 */
												
												$year_end = date ( 'Y-m-d', strtotime ( 'Dec 31' ) );
												
												if ($hire_date > $year_end) {
													
													$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['100'] = 0;
													$end_date_count ++;
												}
												
												/**
												 * ***** checking for duplicate hire date
												 */
												$duplicate = TblAcaPayrollEmploymentPeriod::find ()->select ( 'hire_date' )->where ( [ 
														'employee_id' => $employee_id 
												] )->andWhere ( [ 
														'hire_date' => $hire_date 
												] )->Count ();
												
												/**
												 * *** if there is duplicate hire date ******
												 */
												if ($duplicate > 1) {
													$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['149'] = 0;
												}
												
												/**
												 * *additional coverage start date can not be between a enrollment Period
												 * *
												 */
												
												$check_between_period = TblAcaPayrollEmploymentPeriod::find ()->select ( 'period_id' )->where ( '"' . $hire_date . '" between hire_date and termination_date' )->andWhere ( 'period_id <> ' . $period_id )->andWhere ( 'employee_id=' . $employee_id )->Count ();
												
												if (! empty ( $check_between_period )) {
													
													$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['151'] = 0;
												}
											}
										}
									}
									
									break;
								
								case '10' :
									if (! empty ( $employee_employment_periods )) {
										foreach ( $employee_employment_periods as $employment_period ) {
											
											$termination_date = '';
											$hire_date = '';
											
											$period_id = $employment_period ['period_id'];
											if (! empty ( $employment_period ['termination_date'] )) {
												$termination_date = $employment_period ['termination_date'];
											}
											if (! empty ( $employment_period ['hire_date'] )) {
												$hire_date = $employment_period ['hire_date'];
											}
											
											$check_coverage_termination_date_count = 1;
											$empty_end_count = 1;
											
											if (empty ( $termination_date ) || $termination_date == '0000-00-00') {
												$empty_end_count ++;
											} else {
												
												/**
												 * *Cannot be lesser than HireDate
												 * *
												 */
												if (empty ( $hire_date ) || $hire_date == '0000-00-00') {
												} else {
													
													if ($termination_date < $hire_date) {
														$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['101'] = 0;
														$check_coverage_termination_date_count ++;
													}
												}
												
												/**
												 * ***** checking for duplicate termination_date
												 */
												$duplicate = TblAcaPayrollEmploymentPeriod::find ()->select ( 'termination_date' )->where ( [ 
														'employee_id' => $employee_id 
												] )->andWhere ( [ 
														'termination_date' => $termination_date 
												] )->Count ();
												
												/**
												 * *** if there is duplicate termination_date ******
												 */
												if ($duplicate > 1) {
													$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['150'] = 0;
												}
												
												/**
												 * *additional coverage start date can not be between a enrollment Period
												 * *
												 */
												
												$check_between_period = TblAcaPayrollEmploymentPeriod::find ()->select ( 'period_id' )->where ( '"' . $termination_date . '" between hire_date and termination_date' )->andWhere ( 'period_id <> ' . $period_id )->andWhere ( 'employee_id=' . $employee_id )->Count ();
												
												if (! empty ( $check_between_period )) {
													
													$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['152'] = 0;
												}
											}
										}
									}
									break;
								
								case '11' :
									
									if (! empty ( $employee_employment_periods )) {
										foreach ( $employee_employment_periods as $employment_period ) {
											
											$medical_plan_class = '';
											$period_id = $employment_period ['period_id'];
											
											if (! empty ( $employment_period ['plan_class'] )) {
												$medical_plan_class = $employment_period ['plan_class'];
											}
											
											$plan_class_count = 1;
											
											/**
											 * Cannot be empty * *
											 */
											
											if (empty ( $medical_plan_class )) {
												$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['102'] = 0;
												$plan_class_count ++;
											}
										}
									}
									break;
								
								case '12' :
									
									if (! empty ( $employee_employment_periods )) {
										foreach ( $employee_employment_periods as $employment_period ) {
											
											$status = '';
											$period_id = $employment_period ['period_id'];
											
											if (! empty ( $employment_period ['status'] )) {
												$status = $employment_period ['status'];
											}
											
											$status_count = 1;
											
											/**
											 * Cannot be empty and valid values are PT/FT * *
											 */
											
											if (empty ( $status )) {
												$arrperiodinsertvalidation [$i] ['period_id'] [$period_id] ['103'] = 0;
												$status_count ++;
											}
										}
									}
								
								case '13' :
									
									if (empty ( $employee_employment_periods )) {
										
										$arrinsertvalidation [$i] ['validation_rule_id'] ['147'] = 0;
									}
									break;
							}
						}
						$i ++;
					}
					
					$result = $insert_element_validation->Insertpayrollvalidationlog ( $arrperiodinsertvalidation, $arrinsertvalidation, $company_id );
					// print_r($result);die();
				} elseif (! empty ( $insert_result ['error'] )) {
					throw new \Exception ( $insert_result ['error'] );
				}
			} else {
				// Insert in validation log that no medical data is present
				$arrvalidation ['142'] = 0; // Key shows medical_data rule_id value shows Medical data is not present
				$insert_result = $insert_element_validation->Insertvalidationlog ( $arrvalidation, $company_id );
				
				if (! empty ( $insert_result ['error'] )) {
					throw new \Exception ( $insert_result ['error'] );
				}
			}
		} catch ( \Exception $e ) { // catching the exception
			//print_r ( $e );
			//die ();
			$msg = $e->getMessage ();
			$result ['error'] = $msg;
		}
		
		return $result;
	}
}