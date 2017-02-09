<?php

namespace app\components;

use Yii;
use yii\base\Component;
use app\controllers\SiteController;
use app\models\TblAcaGeneralPlanInfo;
use app\models\TblAcaGeneralPlanMonths;
use app\models\TblAcaPlanCriteria;
use app\models\TblAcaEmpStatusTrack;
use app\models\TblAcaAggregatedGroup;
use app\models\TblAcaAggregatedGroupList;
use app\models\TblAcaCompanies;
use app\models\TblAcaBasicInformation;
use yii\validators\EmailValidator;
use app\models\TblAcaDesignatedGovtEntity;
use app\models\TblAcaPlanCoverageType;
use app\models\TblAcaEmpContributions;
use app\models\TblAcaPayrollEmploymentPeriod;
use app\models\TblAcaPayrollData;
use yii\helpers\ArrayHelper;
use app\models\TblUsaStates;
use app\models\TblAcaMedicalEnrollmentPeriod;
use app\models\TblAcaMedicalData;
use app\models\TblCityStatesUnitedStates;


class CommonValidationsComponent extends Component {
	public $ein_regex = '/^\d{2}[-]\d{7}$/';
	public $phone_regex = '/^\[(]\d{3}[)] \d{3}[-]\d{4}$/';
	public $arrinvalid_ein = [ 
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
	 * ***Function validates General Plan Information******
	 */
	public function ValidateGeneralplaninfo($company_id, $element_ids) {
		$insert_result = array ();
		$result = array ();
		$plan_info_months = array ();
		$arrmonths = array ();
		
		$general_plan_info = TblAcaGeneralPlanInfo::find ()->select ( 'general_plan_id, is_first_year, renewal_month, is_multiple_waiting_periods, multiple_description, is_employees_hra, offer_type' )->where ( [ 
				'company_id' => $company_id 
		] )->One ();
		
		if (! empty ( $general_plan_info )) {
			
			$plan_info_months = TblAcaGeneralPlanMonths::find ()->select ( 'plan_value' )->where ( [ 
					'general_plan_id' => $general_plan_info->general_plan_id 
			] )->All ();
			
			foreach ( $plan_info_months as $months ) {
				$arrmonths [] = $months->plan_value;
			}
		}
		
		try {
			$arrvalidation = array ();
			
			foreach ( $element_ids as $element_id ) {
				switch ($element_id) {
					
					/**
					 * ***********Case 64 Starts********************
					 */
					case '64' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (! empty ( $general_plan_info->is_first_year )) {
							$arrvalidation ['55'] = 1; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['55'] = 0;
						}
						
						break;
					
					/**
					 * ***********Case 64 Ends********************
					 */
					
					/**
					 * ***********Case 65 Starts********************
					 */
					case '65' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (! empty ( $general_plan_info->renewal_month )) {
							$arrvalidation ['56'] = 1; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['56'] = 0;
						}
						
						break;
					
					/**
					 * ***********Case 65 Ends********************
					 */
					
					/**
					 * ***********Case 68 Starts********************
					 */
					case '68' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (! empty ( $general_plan_info->is_multiple_waiting_periods )) {
							$arrvalidation ['57'] = 1; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['57'] = 0;
						}
						
						break;
					
					/**
					 * ***********Case 68 Ends********************
					 */
					
					/**
					 * ***********Case 69 Starts********************
					 */
					case '69' :
						
						/**
						 * ********Can not be empty value***********
						 */
						if (! empty ( $general_plan_info->is_multiple_waiting_periods ) && $general_plan_info->is_multiple_waiting_periods == 1) {
							
							if (! empty ( $general_plan_info->multiple_description ) && (preg_match ( '/^[a-zA-Z0-9 ]+/i', $general_plan_info->multiple_description ) == 1)) {
								
								$arrvalidation ['58'] = 1; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['58'] = 0;
							}
							
							break;
						}
					
					/**
					 * ***********Case 69 Ends********************
					 */
					
					/**
					 * ***********Case 70 Starts********************
					 */
					case '70' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (! empty ( $general_plan_info->is_employees_hra )) {
							
							$arrvalidation ['59'] = 1; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['59'] = 0;
						}
						
						break;
					
					/**
					 * ***********Case 70 Ends********************
					 */
					
					/**
					 * ***********Case 72 Starts********************
					 */
					case '72' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (! empty ( $general_plan_info->offer_type )) {
							
							$arrvalidation ['60'] = 1; // key represents rule_id value represents is_validated;
							
							if ($general_plan_info->offer_type == 1) {
								
								/**
								 * **If the answer is yes,
								 * then atleast a value must be selected for
								 * atleast one month
								 * **
								 */
								if (! empty ( $arrmonths )) {
									
									$arrvalidation ['61'] = 0;
									foreach ( $arrmonths as $key => $value ) {
										if ($value != 0) {
											$arrvalidation ['61'] = 1;
											break;
										}
									}
								} else {
									$arrvalidation ['61'] = 0;
								}
							}
						} else {
							
							$arrvalidation ['60'] = 0;
						}
						
						break;
				
				/**
				 * ***********Case 72 Ends********************
				 */
				}
			}
			
			$result ['success'] = $arrvalidation;
		} catch ( \Exception $e ) { // catching the exception
			
			$result ['error'] = $e->getMessage ();
		}
		
		return $result;
	}
	
	/**
	 * ***Function validates Plan Offering Criteria******
	 */
	public function Validateplanofferingcriteria($company_id, $element_ids) {
		$insert_result = array ();
		$result = array ();
		$arrvalidation = array ();
		
		$plan_offering_criteria_details = TblAcaPlanCriteria::find ()->select ( 'hours_tracking_method, initial_measurement_period, initial_measurment_period_begin, company_certification_workforce, company_certification_medical_eligibility, company_certification_employer_contribution' )->where ( [ 
				'company_id' => $company_id 
		] )->One ();
		
		try {
			foreach ( $element_ids as $element_id ) {
				switch ($element_id) {
					
					/**
					 * ***********Case 25 Starts********************
					 */
					case '25' :
						
						/**
						 * ********Can not be empty value***********
						 */
						if (! empty ( $plan_offering_criteria_details->hours_tracking_method )) {
							$arrvalidation ['27'] = 1; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['27'] = 0;
						}
						
						break;
					
					/**
					 * ***********Case 25 Ends********************
					 */
					
					/**
					 * ***********Case 26 Starts********************
					 */
					case '26' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (! empty ( $plan_offering_criteria_details->hours_tracking_method ) && $plan_offering_criteria_details->hours_tracking_method == 1) {
							
							if (! empty ( $plan_offering_criteria_details->initial_measurement_period )) {
								
								if (($plan_offering_criteria_details->initial_measurement_period >= 30) && ($plan_offering_criteria_details->initial_measurement_period <= 365)) {
									
									$arrvalidation ['28'] = 1;
								} else {
									$arrvalidation ['28'] = 0; // key represents rule_id value represents is_validated;
								}
							} else {
								$arrvalidation ['28'] = 0; // key represents rule_id value represents is_validated;
							}
						} else {
							
							$arrvalidation ['28'] = 1;
						}
						
						break;
					
					/**
					 * ***********Case 26 Ends********************
					 */
					
					/**
					 * ***********Case 27 Starts********************
					 */
					case '27' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (! empty ( $plan_offering_criteria_details->hours_tracking_method ) && $plan_offering_criteria_details->hours_tracking_method == 1) {
							
							if (! empty ( $plan_offering_criteria_details->initial_measurment_period_begin )) {
								
								$arrvalidation ['29'] = 1; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['29'] = 0; // key represents rule_id value represents is_validated;
							}
						} else {
							
							$arrvalidation ['29'] = 1;
						}
						
						break;
					
					/**
					 * ***********Case 27 Ends********************
					 */
					
					/**
					 * ***********Case 38 Starts********************
					 */
					case '38' :
						
						/**
						 * ********atleast one value must be selected ( for 3.3 a, 3.3 b, 3.3 c)***********
						 */
						
						if (! empty ( $plan_offering_criteria_details->company_certification_workforce ) && ! empty ( $plan_offering_criteria_details->company_certification_medical_eligibility ) && ! empty ( $plan_offering_criteria_details->company_certification_employer_contribution )) {
							$arrvalidation ['30'] = 1; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['30'] = 0;
						}
						
						break;
				
				/**
				 * ***********Case 38 Ends********************
				 */
				}
			}
			
			$result ['success'] = $arrvalidation;
		} catch ( \Exception $e ) { // catching the exception
			
			$result ['error'] = $e->getMessage ();
		}
		
		return $result;
	}
	
	/**
	 * ***Function validates Large Employer Status & Tracking******
	 */
	public function Validateale($company_id, $element_ids) {
		$insert_result = array ();
		$result = array ();
		$arrvalidation = array ();
		
		$ale_details = TblAcaEmpStatusTrack::find ()->select ( 'ale_applicable, ale_first_applicable, ale_category' )->where ( [ 
				'company_id' => $company_id 
		] )->One ();
		
		try {
			foreach ( $element_ids as $element_id ) {
				switch ($element_id) {
					/**
					 * ***********Case 22 Starts********************
					 */
					case '22' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $ale_details->ale_applicable )) {
							$arrvalidation ['24'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['24'] = 1;
						}
						
						break;
					
					/**
					 * ***********Case 22 Ends********************
					 */
					
					/**
					 * ***********Case 23 Starts********************
					 */
					case '23' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $ale_details->ale_first_applicable )) {
							$arrvalidation ['25'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['25'] = 1;
						}
						
						break;
					
					/**
					 * ***********Case 23 Ends********************
					 */
					
					/**
					 * ***********Case 24 Starts********************
					 */
					case '24' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $ale_details->ale_category )) {
							$arrvalidation ['26'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['26'] = 1;
						}
						
						break;
				
				/**
				 * ***********Case 24 Ends********************
				 */
				}
			}
			$result ['success'] = $arrvalidation;
		} catch ( \Exception $e ) { // catching the exception
			
			$result ['error'] = $e->getMessage ();
		}
		return $result;
	}
	
	/**
	 * ***Function validates Aggregated Group******
	 */
	public function Validateaggreagate($company_id, $element_ids) {
		$insert_result = array ();
		$result = array ();
		$arrvalidation = array ();
		
		$aggregate_details = TblAcaAggregatedGroup::find ()->select ( 'aggregated_grp_id,is_authoritative_transmittal, is_ale_member, is_other_entity, total_1095_forms, total_aggregated_grp_months, ' )->where ( [ 
				'company_id' => $company_id 
		] )->One ();
		
		if (! empty ( $aggregate_details )) {
			$aggregrate_group_details = TblAcaAggregatedGroupList::find ()->select ( 'group_name, group_ein' )->where ( [ 
					'aggregated_grp_id' => $aggregate_details->aggregated_grp_id 
			] )->All ();
		}
		
		try {
			foreach ( $element_ids as $element_id ) {
				switch ($element_id) {
					/**
					 * ***********Case 56 Starts********************
					 */
					case '56' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $aggregate_details->is_authoritative_transmittal )) {
							$arrvalidation ['49'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['49'] = 1;
						}
						
						break;
					
					/**
					 * ***********Case 56 Ends********************
					 */
					
					/**
					 * ***********Case 57 Starts********************
					 */
					case '57' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $aggregate_details->is_ale_member )) {
							$arrvalidation ['50'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['50'] = 1;
						}
						
						break;
					
					/**
					 * ***********Case 57 Ends********************
					 */
					
					/**
					 * ***********Case 58 Starts********************
					 */
					case '58' :
						
						/**
						 * ********If answer to 5.2 was yes then a value must be selected***********
						 */
						if (! empty ( $aggregate_details->is_ale_member ) && $aggregate_details->is_ale_member == 1) {
							/**
							 * ********Can not be empty value***********
							 */
							
							if (empty ( $aggregate_details->is_other_entity )) {
								$arrvalidation ['51'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['51'] = 1;
							}
						}
						
						break;
					
					/**
					 * ***********Case 58 Ends********************
					 */
					
					/**
					 * ***********Case 59 Starts********************
					 */
					case '59' :
						
						/**
						 * ********If answer to 5.2 was yes then a value must be selected***********
						 */
						if (! empty ( $aggregate_details->is_other_entity ) && $aggregate_details->is_other_entity == 1) {
							/**
							 * ********Can not be empty value***********
							 */
							
							if (! empty ( $aggregate_details->total_1095_forms )) {
								
								if ($aggregate_details->total_1095_forms > 1000000) {
									
									$arrvalidation ['52'] = 0; // key represents rule_id value represents is_validated;
								} else {
									$arrvalidation ['52'] = 1; // key represents rule_id value represents is_validated;
								}
							} else {
								
								$arrvalidation ['52'] = 0;
							}
						}
						
						break;
					
					/**
					 * ***********Case 59 Ends********************
					 */
					
					/**
					 * ***********Case 60 Starts********************
					 */
					case '60' :
						
						/**
						 * ********If answer to 5.2 was yes then a value must be selected***********
						 */
						if (! empty ( $aggregate_details->is_ale_member ) && $aggregate_details->is_ale_member == 1) {
							/**
							 * ********Can not be empty value***********
							 */
							
							if (empty ( $aggregate_details->total_aggregated_grp_months )) {
								$arrvalidation ['53'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['53'] = 1;
							}
						}
						
						break;
					
					/**
					 * ***********Case 60 Ends********************
					 */
					
					/**
					 * ***********Case 61 Starts********************
					 */
					case '61' :
						
						/**
						 * ********If answer to 5.2 was yes then a value must be selected***********
						 */
						if (! empty ( $aggregate_details->is_ale_member ) && $aggregate_details->is_ale_member == 1) {
							
							if (! empty ( $aggregrate_group_details )) {
								foreach ( $aggregrate_group_details as $details ) {
									
									/**
									 * *
									 * If the values are entered for company and EIN,
									 * then the company name can not be "." or special
									 * character other than & and EIN has to be 9 digit
									 * XX-XXXXXXX and should have same validations as other
									 * EIN place
									 * *
									 */
									
									if (! empty ( $details->group_name ) && ! empty ( $details->group_ein )) {
										
										// Replacing special characters from EIN
										$clean_ein = preg_replace ( '/[^0-9]/s', '', $details->group_ein );
										
										if (preg_match ( $this->ein_regex, $details->group_ein ) && strlen ( $clean_ein ) == 9) {
											
											//$arrvalidation ['54'] = 1; // key represents rule_id value represents is_validated;
											
											/**
											 * ***Can not be NN-NNNNNNN
											 * EIN Can not be all N ( where N = 0..9)
											 * ****
											 */
											
											if (in_array ( $clean_ein, $this->arrinvalid_ein)) {
												
												$arrvalidation ['54'] = 0;
											} else {
												
												$arrvalidation ['54'] = 1;
											}
										} else {
											
											$arrvalidation ['54'] = 0;
										}
									} else {
										$arrvalidation ['54'] = 0; // key represents rule_id value represents is_validated;
									}
								}
							}
							else{
								$arrvalidation ['54'] = 0;
							}
						}
						break;
				
				/**
				 * ***********Case 61 Ends********************
				 */
				}
			}
			
			$result ['success'] = $arrvalidation;
		} catch ( \Exception $e ) { // catching the exception
			
			$result ['error'] = $e->getMessage ();
		}
		return $result;
	}
	
	/**
	 * ***Function validates basic info******
	 */
	public function Validatebasicinfo($company_id, $element_ids) {
		$insert_result = array ();
		$result = array ();
		$arrvalidation = array ();
		
		try {
			/**
			 * ********Get company details***********
			 */
			$company_details = TblAcaCompanies::find ()->select ( 'company_ein , company_name' )->where ( [ 
					'company_id' => $company_id 
			] )->One ();
			
			/**
			 * ********Get basic info details***********
			 */
			$basic_info_details = TblAcaBasicInformation::find ()->select ( 'contact_first_name,contact_last_name,contact_person_title,contact_person_email,contact_phone_number,street_address_1,contact_country,contact_state,contact_city,contact_zip' )->where ( [ 
					'company_id' => $company_id 
			] )->One ();
			foreach ( $element_ids as $element_id ) {
				switch ($element_id) {
					
					/**
					 * ***********Case 1 Starts********************
					 */
					case '1' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $company_details->company_name )) {
							$arrvalidation ['1'] = 0; // key represents rule_id value represents is_validated;
						} else {
							$arrvalidation ['1'] = 1;
							/**
							 * ***Name should be at least 1 char and do not allow special char as 1 char like ($,#,@,% etc)****
							 */
							if (strlen ( $company_details->company_name ) == 1 && (preg_match ( '/[^a-zA-Z0-9 ]+/i', $company_details->company_name ) == 1)) {
								$arrvalidation ['2'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['2'] = 1;
							}
						}
						
						break;
					
					/**
					 * ***********Case 1 Ends********************
					 */
					/**
					 * ***********Case 2 Starts********************
					 */
					
					case '2' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $company_details->company_ein )) {
							$arrvalidation ['4'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['4'] = 1;
							
							/**
							 * ***it shold be 9 digit number with format NN-NNNNNNN****
							 */
							// Replacing special characters from EIN
							$clean_ein = preg_replace ( '/[^0-9]/s', '', $company_details->company_ein );
							
							if (preg_match ( $this->ein_regex, $company_details->company_ein ) && strlen ( $clean_ein ) == 9) {
								
								$arrvalidation ['3'] = 1; // key represents rule_id value represents is_validated;
								
								/**
								 * ***Can not be NN-NNNNNNN
								 * EIN Can not be all N ( where N = 0..9)
								 * ****
								 */
								
								if (in_array ( $clean_ein, $this->arrinvalid_ein )) {
									
									$arrvalidation ['5'] = 0;
								} else {
									
									$arrvalidation ['5'] = 1;
								}
							} else {
								
								$arrvalidation ['3'] = 0;
							}
						}
						
						break;
					
					/**
					 * ***********Case 2 Ends********************
					 */
					/**
					 * ***********Case 4 Starts********************
					 */
					case '4' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $basic_info_details->contact_first_name )) {
							$arrvalidation ['6'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['6'] = 1;
							
							/**
							 * ***Can not be "."****
							 */
							
							if ($basic_info_details->contact_first_name == '.') {
								
								$arrvalidation ['7'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['7'] = 1;
								
								/**
								 * Should be atleast 2 characters
								 */
								if (strlen ( $basic_info_details->contact_first_name ) < 2) {
									
									$arrvalidation ['8'] = 0;
								} else {
									
									$arrvalidation ['8'] = 1;
								}
							}
						}
						
						break;
					
					/**
					 * ***********Case 4 Ends********************
					 */
					
					/**
					 * ***********Case 6 Starts********************
					 */
					case '6' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $basic_info_details->contact_last_name )) {
							$arrvalidation ['9'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['9'] = 1;
							
							/**
							 * ***Can not be "."****
							 */
							
							if ($basic_info_details->contact_last_name == '.') {
								
								$arrvalidation ['10'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['10'] = 1;
								
								/**
								 * Should be atleast 2 characters
								 */
								if (strlen ( $basic_info_details->contact_last_name ) < 2) {
									
									$arrvalidation ['11'] = 0;
								} else {
									
									$arrvalidation ['11'] = 1;
								}
							}
						}
						
						break;
					
					/**
					 * ***********Case 6 Ends********************
					 */
					
					/**
					 * ***********Case 8 Starts********************
					 */
					case '8' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $basic_info_details->contact_person_title )) {
							$arrvalidation ['12'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['12'] = 1;
							
							/**
							 * ***Can not be "."****
							 */
							
							if ($basic_info_details->contact_person_title == '.') {
								
								$arrvalidation ['13'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['13'] = 1;
							}
						}
						
						break;
					
					/**
					 * ***********Case 8 Ends********************
					 */
					
					/**
					 * ***********Case 9 Starts********************
					 */
					case '9' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $basic_info_details->contact_person_email )) {
							$arrvalidation ['14'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['14'] = 1;
							
							/**
							 * ***should be a valid email format****
							 */
							$validator = new EmailValidator ();
							
							if ($validator->validate ( $basic_info_details->contact_person_email )) {
								
								$arrvalidation ['15'] = 1;
							} else {
								
								$arrvalidation ['15'] = 0;
							}
						}
						
						break;
					
					/**
					 * ***********Case 9 Ends********************
					 */
					
					/**
					 * ***********Case 10 Starts********************
					 */
					case '10' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $basic_info_details->contact_phone_number )) {
							$arrvalidation ['16'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['16'] = 1;
							
							/**
							 * ****To be done yet*********
							 */
							if (strlen ( $basic_info_details->contact_phone_number ) == 10) {
								
								$arrvalidation ['17'] = 1;
							} else {
								$arrvalidation ['17'] = 0;
							}
						}
						
						break;
					
					/**
					 * ***********Case 10 Ends********************
					 */
					
					/**
					 * ***********Case 11 Starts********************
					 */
					case '11' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $basic_info_details->street_address_1 )) {
							$arrvalidation ['18'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['18'] = 1;
							
							/**
							 * ***Can not be "."****
							 */
							
							if ($basic_info_details->street_address_1 == '.') {
								
								$arrvalidation ['19'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['19'] = 1;
							}
						}
						
						break;
					
					/**
					 * ***********Case 11 Ends********************
					 */
					
					/**
					 * ***********Case 15 Starts********************
					 */
					case '15' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $basic_info_details->contact_country )) {
							$arrvalidation ['20'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['20'] = 1;
						}
						
						break;
					
					/**
					 * ***********Case 15 Ends********************
					 */
					
					/**
					 * ***********Case 16 Starts********************
					 */
					case '16' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $basic_info_details->contact_state )) {
							$arrvalidation ['21'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['21'] = 1;
						}
						
						break;
					
					/**
					 * ***********Case 16 Ends********************
					 */
					
					/**
					 * ***********Case 17 Starts********************
					 */
					case '17' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $basic_info_details->contact_city )) {
							$arrvalidation ['22'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['22'] = 1;
						}
						
						break;
					
					/**
					 * ***********Case 17 Ends********************
					 */
					
					/**
					 * ***********Case 18 Starts********************
					 */
					case '18' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $basic_info_details->contact_zip )) {
							$arrvalidation ['23'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							if (! empty ( $basic_info_details->contact_country ) && $basic_info_details->contact_country == 'US') {
								if (strlen ( $basic_info_details->contact_zip ) == 5) {
									
									$arrvalidation ['23'] = 1;
								} else {
									
									$arrvalidation ['23'] = 0;
								}
							} else {
								$arrvalidation ['23'] = 1;
							}
						}
						
						break;
				
				/**
				 * ***********Case 18 Ends********************
				 */
				}
			}
			$result ['success'] = $arrvalidation;
		} catch ( \Exception $e ) { // catching the exception
			
			$result ['error'] = $e->getMessage ();
		}
		
		return $result;
	}
	
	/**
	 * ***Function validates Designated Government Entity******
	 */
	public function Validatedge($company_id, $element_ids) {
		$result = array ();
		$insert_result = array ();
		$arrvalidation = array ();
		
		try {
			$dge_details = TblAcaDesignatedGovtEntity::find ()->select ( 'assign_dge, dge_name, dge_ein, street_address_1, dge_state, dge_city, dge_zip, dge_contact_first_name, dge_contact_last_name, dge_contact_phone_number, dge_reporting' )->where ( [ 
					'company_id' => $company_id 
			] )->One ();
			
			foreach ( $element_ids as $element_id ) {
				switch ($element_id) {
					/**
					 * ***********Case 42 Starts********************
					 */
					case '42' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (! empty ( $dge_details->assign_dge )) {
							$arrvalidation ['31'] = 1; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['31'] = 0;
						}
						
						break;
					
					/**
					 * ***********Case 42 Ends********************
					 */
					
					/**
					 * ***********Case 43 Starts********************
					 */
					case '43' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (! empty ( $dge_details->assign_dge ) && $dge_details->assign_dge == 1) {
							
							if (! empty ( $dge_details->dge_name )) {
								
								$arrvalidation ['32'] = 1; // key represents rule_id value represents is_validated;
								
								/**
								 * ***Name should be atleast 2 char and do not allow special char as 1 char like ($,#,@,% etc)****
								 */
								
								if (strlen ( $dge_details->dge_name ) < 2 && (preg_match ( '/[^a-zA-Z0-9 ]+/i', $dge_details->dge_name ) == 1)) {
									
									$arrvalidation ['33'] = 0; // key represents rule_id value represents is_validated;
								} else {
									
									$arrvalidation ['33'] = 1;
									
									/**
									 * ***Allow the pattern ([A?Za?z0?9\?\(\)&amp;&apos;] ?)*[A?Za?z0?9\?\(\)&amp;&apos;] and max length 75 chars****
									 */
									
									if (preg_match ( "/[^a-zA-Z0-9&.'()\-\ ]+/i", $dge_details->dge_name ) == 1 || strlen ( $dge_details->dge_name ) > 75) {
										
										$arrvalidation ['34'] = 0;
									} else {
										$arrvalidation ['34'] = 1;
									}
								}
							} else {
								$arrvalidation ['32'] = 0; // key represents rule_id value represents is_validated;
							}
						}
						
						break;
					
					/**
					 * ***********Case 43 Ends********************
					 */
					
					/**
					 * ***********Case 44 Starts********************
					 */
					
					case '44' :
						
						if (! empty ( $dge_details->assign_dge ) && $dge_details->assign_dge == 1) {
							/**
							 * ********Can not be empty value***********
							 */
							
							if (empty ( $dge_details->dge_ein )) {
								$arrvalidation ['36'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								$clean_ein = preg_replace ( '/[^0-9]/s', '', $dge_details->dge_ein );
								
								if ($clean_ein == '') {
									$arrvalidation ['36'] = 0; // key represents rule_id value represents is_validated;
								} else {
									$arrvalidation ['36'] = 1;
									
									/**
									 * ***it shold be 9 digit number with format NN-NNNNNNN****
									 */
									
									if (preg_match ( $this->ein_regex, $dge_details->dge_ein )) {
										
										$arrvalidation ['35'] = 1; // key represents rule_id value represents is_validated;
										
										/**
										 * ***Can not be NN-NNNNNNN
										 * EIN Can not be all N ( where N = 0..9)
										 * ****
										 */
										
										if (in_array ( $clean_ein, $this->arrinvalid_ein )) {
											
											$arrvalidation ['37'] = 0;
										} else {
											
											$arrvalidation ['37'] = 1;
										}
									} else {
										
										$arrvalidation ['35'] = 0;
									}
								}
							}
						}
						
						break;
					
					/**
					 * ***********Case 44 Ends********************
					 */
					
					/**
					 * ***********Case 45 Starts********************
					 */
					case '45' :
						
						if (! empty ( $dge_details->assign_dge ) && $dge_details->assign_dge == 1) {
							/**
							 * ********Can not be empty value***********
							 */
							
							if (empty ( $dge_details->street_address_1 )) {
								$arrvalidation ['38'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['38'] = 1;
								
								/**
								 * ***Can not be "."****
								 */
								
								if ($dge_details->street_address_1 == '.') {
									
									$arrvalidation ['39'] = 0; // key represents rule_id value represents is_validated;
								} else {
									
									$arrvalidation ['39'] = 1;
								}
							}
						}
						break;
					
					/**
					 * ***********Case 45 Ends********************
					 */
					
					/**
					 * ***********Case 47 Starts********************
					 */
					case '47' :
						
						if (! empty ( $dge_details->assign_dge ) && $dge_details->assign_dge == 1) {
							/**
							 * ********Can not be empty or Select state string***********
							 */
							
							if (empty ( $dge_details->dge_state )) {
								$arrvalidation ['40'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['40'] = 1;
							}
						}
						
						break;
					
					/**
					 * ***********Case 47 Ends********************
					 */
					
					/**
					 * ***********Case 48 Starts********************
					 */
					case '48' :
						
						if (! empty ( $dge_details->assign_dge ) && $dge_details->assign_dge == 1) {
							/**
							 * ********Can not be empty or Select City string***********
							 */
							
							if (empty ( $dge_details->dge_city )) {
								$arrvalidation ['41'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['41'] = 1;
							}
						}
						
						break;
					
					/**
					 * ***********Case 48 Ends********************
					 */
					
					/**
					 * ***********Case 49 Starts********************
					 */
					case '49' :
						
						if (! empty ( $dge_details->assign_dge ) && $dge_details->assign_dge == 1) {
							/**
							 * ********Can not be empty value***********
							 */
							
							if (empty ( $dge_details->dge_zip )) {
								$arrvalidation ['42'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								/**
								 * Can not be empty and has to be 5 digits
								 *
								 * *
								 */
								
								if (strlen ( $dge_details->dge_zip ) == 5) {
									
									$arrvalidation ['42'] = 1;
								} else {
									
									$arrvalidation ['42'] = 0;
								}
							}
						}
						
						break;
					
					/**
					 * ***********Case 49 Ends********************
					 */
					
					/**
					 * ***********Case 50 Starts********************
					 */
					case '50' :
						
						if (! empty ( $dge_details->assign_dge ) && $dge_details->assign_dge == 1) {
							/**
							 * ********Can not be empty value***********
							 */
							
							if (empty ( $dge_details->dge_contact_first_name )) {
								$arrvalidation ['43'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['43'] = 1;
								
								/**
								 * ***Can not be "."****
								 */
								
								if ($dge_details->dge_contact_first_name == '.') {
									
									$arrvalidation ['44'] = 0; // key represents rule_id value represents is_validated;
								} else {
									
									$arrvalidation ['44'] = 1;
									
									/**
									 * Should be atleast 2 characters
									 */
									if (strlen ( $dge_details->dge_contact_first_name ) < 2) {
										
										$arrvalidation ['45'] = 0;
									} else {
										
										$arrvalidation ['45'] = 1;
									}
								}
							}
						}
						
						break;
					
					/**
					 * ***********Case 50 Ends********************
					 */
					 
					 	/**
					 * ***********Case 52 Starts********************
					 */
					case '52' :
						
						if (! empty ( $dge_details->assign_dge ) && $dge_details->assign_dge == 1) {
							/**
							 * ********Can not be empty value***********
							 */
							
							if (empty ( $dge_details->dge_contact_last_name )) {
								$arrvalidation ['143'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['143'] = 1;
								
								/**
								 * ***Can not be "."****
								 */
								
								if ($dge_details->dge_contact_last_name == '.') {
									
									$arrvalidation ['144'] = 0; // key represents rule_id value represents is_validated;
								} else {
									
									$arrvalidation ['144'] = 1;
									
									/**
									 * Should be atleast 2 characters
									 */
									if (strlen ( $dge_details->dge_contact_last_name ) <2) {
										
										$arrvalidation ['145'] = 0;
									} else {
										
										$arrvalidation ['145'] = 1;
									}
								}
							}
						}
						
						break;
					
					/**
					 * ***********Case 52 Ends********************
					 */
					 
					
					/**
					 * ***********Case 54 Starts********************
					 */
					case '54' :
						
						if (! empty ( $dge_details->assign_dge ) && $dge_details->assign_dge == 1) {
							/**
							 * ********Can not be empty value***********
							 */
							
							if (empty ( $dge_details->dge_contact_phone_number )) {
								$arrvalidation ['46'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['46'] = 1;
								
								if (strlen ( $dge_details->dge_contact_phone_number ) == 10) {
									
									$arrvalidation ['47'] = 1;
								} else {
									$arrvalidation ['47'] = 0;
								}
							}
						}
						
						break;
					
					/**
					 * ***********Case 54 Ends********************
					 */
					
					/**
					 * ***********Case 55 Starts********************
					 */
					case '55' :
						
						if (! empty ( $dge_details->assign_dge ) && $dge_details->assign_dge == 1) {
							/**
							 * ********Can not be empty or Select state string***********
							 */
							
							if (empty ( $dge_details->dge_reporting )) {
								$arrvalidation ['48'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								$arrvalidation ['48'] = 1;
							}
						}
						
						break;
				
				/**
				 * ***********Case 55 Ends********************
				 */
				}
			}
			$result ['success'] = $arrvalidation;
		} catch ( \Exception $e ) { // catching the exception
			
			$result ['error'] = $e->getMessage ();
		}
		
		return $result;
	}
	
	/**
	 * *****Validate plan class elements*************
	 */
	public function ValidateindividualPlanclass($company_id, $plan_class_id, $element_ids) {
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
			 * Get all plan class of the company
			 *
			 * **
			 */
			$plan_class = TblAcaPlanCoverageType::find ()->select ( 'plan_class_id, plan_offer_type, plan_type_doh, employee_medical_plan' )->where ( [ 
					'company_id' => $company_id,
					'plan_class_id' => $plan_class_id 
			] )->One ();
			
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
			
			foreach ( $element_ids as $element_id ) {
				
				switch ($element_id) {
					
					case '76' :
						/**
						 * ********A value should have been selected*****
						 */
						if (! empty ( $plan_class->plan_offer_type )) {
							$arrinsertvalidation ['63'] = 1; // key represents rule_id value represents is_validated;
							
							if($plan_class->plan_offer_type == 1 || $plan_class->plan_offer_type == 4 || $plan_class->plan_offer_type == 5)
							{
								
								$arrinsertvalidation ['148'] = 1; // key represents rule_id value represents is_validated;
							}
							else
							{
								if(!empty($plan_class->plan_type_doh))
								{
									
									$arrinsertvalidation ['148'] = 1; // key represents rule_id value represents is_validated;
								}	
								else
								{
									$arrinsertvalidation ['148'] = 0;// key represents rule_id value represents is_validated;
									
								}
								
								
							}
							
						} else {
							$arrinsertvalidation ['63'] = 0; // key represents rule_id value represents is_validated;
						}
						
						break;
					
					case '77' :
						if ( $plan_class->plan_offer_type != 1 ) {
							/**
							 * ********A value should have been selected*****
							 */
							if (! empty ( $plan_class->employee_medical_plan )) {
								$arrinsertvalidation ['64'] = 1; // key represents rule_id value represents is_validated;
							} else {
								$arrinsertvalidation ['64'] = 0; // key represents rule_id value represents is_validated;
							}
						}
						break;
					case '78' :
						if ( $plan_class->plan_offer_type != 1 ) {
							/**
							 * ********A value should have been selected*****
							 */
							if (! empty ( $plan_class_offered->employee_mv_coverage )) {
								$arrinsertvalidation ['65'] = 1; // key represents rule_id value represents is_validated;
							} else {
								$arrinsertvalidation ['65'] = 0; // key represents rule_id value represents is_validated;
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
									$arrinsertvalidation ['66'] = 1; // key represents rule_id value represents is_validated;
								} else {
									$arrinsertvalidation ['66'] = 0; // key represents rule_id value represents is_validated;
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
								$arrinsertvalidation ['67'] = 1; // key represents rule_id value represents is_validated;
							} else {
								$arrinsertvalidation ['67'] = 0; // key represents rule_id value represents is_validated;
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
									$arrinsertvalidation ['68'] = 1; // key represents rule_id value represents is_validated;
								} else {
									$arrinsertvalidation ['68'] = 0; // key represents rule_id value represents is_validated;
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
								$arrinsertvalidation ['69'] = 1; // key represents rule_id value represents is_validated;
							} else {
								$arrinsertvalidation ['69'] = 0; // key represents rule_id value represents is_validated;
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
									$arrinsertvalidation ['70'] = 1; // key represents rule_id value represents is_validated;
								} else {
									$arrinsertvalidation ['70'] = 0; // key represents rule_id value represents is_validated;
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
								$arrinsertvalidation ['71'] = 1; // key represents rule_id value represents is_validated;
							} else {
								$arrinsertvalidation ['71'] = 0; // key represents rule_id value represents is_validated;
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
									$arrinsertvalidation ['72'] = 1; // key represents rule_id value represents is_validated;
								} else {
									$arrinsertvalidation ['72'] = 0; // key represents rule_id value represents is_validated;
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
									$arrinsertvalidation ['73'] = 1; // key represents rule_id value represents is_validated;
								} else {
									$arrinsertvalidation ['73'] = 0; // key represents rule_id value represents is_validated;
								}
							}
						}
						break;
				}
			}
			
			$result ['success'] = $arrinsertvalidation;
			
			
		} catch ( \Exception $e ) { // catching the exception
			
			$msg = $e->getMessage ();
			$result ['error'] = $msg;
		}
		
		return $result;
	}
	
	/**
	 * *****Validate payroll elements*************
	 */
	public function ValidatePayroll($company_id, $employee_id, $element_ids) {
		$validate_individual_element = new ValidateindividualElementComponent ();
		$arrelemnt = array ();
		$result = array ();
		$arrrule_ids = array ();
		$arrvalidation = array ();
		$arrinsertvalidation = array ();
		$employee_employment_periods = array ();
		$arrperiodinsertvalidation = array ();
		
		try {
			
			/**
			 * Get employee detail of the company
			 *
			 * **
			 */
			$employee = TblAcaPayrollData::find ()->select ( 'employee_id, first_name, last_name, ssn, address1, city, state, zip, dob' )->where ( [ 
					'company_id' => $company_id,
					'employee_id' => $employee_id 
			] )->One ();
			
			/**
			 * Get employee employment period
			 *
			 * **
			 */
			
			$employee_employment_periods = TblAcaPayrollEmploymentPeriod::find ()->where ( [ 
					'employee_id' => $employee_id 
			] )->All ();
			//return($employee_employment_periods);die();
			foreach ( $element_ids as $element_id ) {
				
				switch ($element_id) {
					case '1' :
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $employee->first_name )) {
							$arrinsertvalidation ['75'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							// $arrinsertvalidation [$i] ['validation_rule_id'] ['75'] = 1;
							
							/**
							 * ***Can not be "."****
							 */
							
							if ($employee->first_name == '.') {
								
								$arrinsertvalidation ['76'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['76'] = 1;
								
								/**
								 * Should be atleast 2 characters
								 */
								if (strlen ( $employee->first_name ) < 2) {
									
									$arrinsertvalidation ['77'] = 0;
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
						
						if (empty ( $employee->last_name )) {
							$arrinsertvalidation ['78'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							// $arrinsertvalidation [$i] ['validation_rule_id'] ['78'] = 1;
							
							/**
							 * ***Can not be "."****
							 */
							
							if ($employee->last_name == '.') {
								
								$arrinsertvalidation ['79'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['79'] = 1;
								
								/**
								 * Should be atleast 2 characters
								 */
								if (strlen ( $employee->last_name ) < 2) {
									
									$arrinsertvalidation ['80'] = 0;
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
						
						if (empty ( $employee->ssn )) {
							$arrinsertvalidation ['81'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							// $arrinsertvalidation [$i] ['validation_rule_id'] ['81'] = 1;
							
							/**
							 * ***SSN has to be a 9 digit number****
							 */
							// Replacing special characters from EIN
							$clean_ssn = preg_replace ( '/[^0-9]/s', '', $employee->ssn );
							
							if (strlen ( $clean_ssn ) == 9) {
								
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['82'] = 1; // key represents rule_id value represents is_validated;
								
								/**
								 * ***SSN can not have all numbers same
								 * ( eg.
								 * 000-00-0000, 111-11-1111 etc)
								 * ****
								 */
								
								if (in_array ( $clean_ssn, $this->arrinvalid_ssn )) {
									
									$arrinsertvalidation ['83'] = 0;
								} else {
									
									// $arrinsertvalidation [$i] ['validation_rule_id'] ['83'] = 1;
								}
							} else {
								
								$arrinsertvalidation ['82'] = 0;
							}
						}
						
						break;
					
					case '4' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $employee->address1 )) {
							$arrinsertvalidation ['84'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							// $arrinsertvalidation [$i] ['validation_rule_id'] ['84'] = 1;
							
							/**
							 * ***Can not be "."****
							 */
							
							if ($employee->address1 == '.') {
								
								$arrinsertvalidation ['85'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['85'] = 1;
								
								/**
								 * Should be atleast 2 characters
								 */
								if (strlen ( $employee->address1 ) < 2) {
									
									$arrinsertvalidation ['86'] = 0;
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
						
						if (empty ( $employee->city )) {
							$arrinsertvalidation ['87'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							// $arrinsertvalidation [$i] ['validation_rule_id'] ['87'] = 1;
							
							/**
							 * ***Can not be "."****
							 */
							
							if ($employee->city == '.') {
								
								$arrinsertvalidation ['88'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['88'] = 1;
								
								/**
								 * Should be atleast 2 characters
								 */
								if (strlen ( $employee->city ) < 2) {
									
									$arrinsertvalidation ['89'] = 0;
								} else {
									
									// $arrinsertvalidation [$i] ['validation_rule_id'] ['89'] = 1;
									
									if (preg_match ( '/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $employee->city )) {
										
										$arrinsertvalidation ['90'] = 0;
									} else{
										
										$model_cities = TblCityStatesUnitedStates::find()->where(['state'=>$employee->state])
										->andwhere(['city'=>$employee->city])->one();
											
										if (empty($model_cities))
										{
											$arrinsertvalidation ['146'] = 0;
										}
										
									}
								}
							}
						}
						
						break;
					
					case '6' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $employee->state )) {
							$arrinsertvalidation ['91'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							// $arrinsertvalidation [$i] ['validation_rule_id'] ['91'] = 1;
							
							/**
							 * Only can be 2 character state
							 */
							
							if (strlen ( $employee->state ) == 2) {
								
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['92'] = 1;
								if (! in_array ( strtoupper($employee->state), $this->validustates () )) {
									
									$arrinsertvalidation ['93'] = 0;
								}
							} else {
								
								$arrinsertvalidation ['92'] = 0;
							}
						}
						
						break;
					
					case '7' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $employee->zip )) {
							$arrinsertvalidation ['94'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							// $arrinsertvalidation [$i] ['validation_rule_id'] ['94'] = 1;
							
							/**
							 * ********Cannot be < 5 digits***********
							 */
							if (strlen ( $employee->zip ) < 5) {
								
								$arrinsertvalidation ['95'] = 0;
							} else {
								
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['95'] = 1;
							}
						}
						break;
					
					case '8' :
						
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $employee->dob )) {
							//$arrinsertvalidation ['96'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							// $arrinsertvalidation [$i] ['validation_rule_id'] ['96'] = 1;
							
							/**
							 * ********Cannot be a future date***********
							 */
							if ($employee->dob > date ( 'Y-m-d' )) {	
								$arrinsertvalidation ['97'] = 0;
							} /*else {
								
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['97'] = 1;
								
								$diff = date_diff ( date_create ( $employee->dob ), date_create ( date ( 'Y-m-d' ) ) );
								
								if ($diff->format ( '%y' ) < 15) {
									$arrinsertvalidation ['98'] = 0;
								} else {
									// $arrinsertvalidation [$i] ['validation_rule_id'] ['98'] = 1;
								}
							}*/
						}
						break;
					
					case '9' :
						if (! empty ( $employee_employment_periods )) {
							$empty_hire_count = 1;
							$end_date_count = 1;
							
							foreach ( $employee_employment_periods as $employment_period ) {
								
								$period_id = $employment_period->period_id;
								/**
								 * ******Get all other
								 * enrollment period other
								 * than this period of particular employee********
								 */
								$hire_date = $employment_period->hire_date;
								
								/**
								 * ********Can not be empty value***********
								 */
								
								if (empty ( $hire_date ) || $hire_date == '0000-00-00') {
									
									$arrperiodinsertvalidation [$period_id] ['99'] = 0;
									$empty_hire_count ++;
								} else {
									
									/**
									 * ********Coverage start date can not be
									 * greater than 31st dec of the current year***********
									 */
									
									$year_end = date ( 'Y-m-d', strtotime ( 'Dec 31' ) );
									
									if ($hire_date > $year_end) {
										
										$arrperiodinsertvalidation [$period_id] ['100'] = 0;
										$end_date_count ++;
									}
									
									/**
										 ****** checking for duplicate hire date 
									*/ 
									$duplicate = TblAcaPayrollEmploymentPeriod::find ()->select ( 'hire_date' )->where ( [ 
														'employee_id' => $employee_id 
									] )->andWhere ( [ 
														'hire_date' => $hire_date 
												] )->Count ();
												
									/***** if there is duplicate hire date *******/
									if($duplicate>1){
										$arrperiodinsertvalidation [$period_id] ['149'] = 0;
									}

									/**
										* *additional coverage start date can not be between a enrollment Period
										* *
									*/
												
									$check_between_period = TblAcaPayrollEmploymentPeriod::find ()->select ( 'period_id' )->where ('"'.$hire_date .'" between hire_date and termination_date' )->andWhere ( 'period_id <> ' . $period_id )->andWhere ( 'employee_id='.$employee_id )->All ();
									//print_r($period_id);die();			
									if (! empty ( $check_between_period )) {													
										$arrperiodinsertvalidation [$period_id] ['151'] = 0;
									}			
									
								}
							}
						}
						
						break;
					
					case '10' :
						if (! empty ( $employee_employment_periods )) {
							foreach ( $employee_employment_periods as $employment_period ) {
								
								$period_id = $employment_period->period_id;
								$termination_date = $employment_period->termination_date;
								$hire_date = $employment_period->hire_date;
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
											$arrperiodinsertvalidation [$period_id] ['101'] = 0;
											$check_coverage_termination_date_count ++;
										}
									}
										
									/**
										****** checking for duplicate termination_date 
									*/ 
									$duplicate = TblAcaPayrollEmploymentPeriod::find ()->select ( 'termination_date' )->where ( [ 
													'employee_id' => $employee_id 
									] )->andWhere ( [ 
														'termination_date' => $termination_date 
												] )->Count ();
												
									/***** if there is duplicate termination_date *******/
									if($duplicate>1){
										$arrperiodinsertvalidation [$period_id] ['150'] = 0;
									}	
												
									/**
									 * *additional coverage start date can not be between a enrollment Period
									 * *
									 */
											
									$check_between_period = TblAcaPayrollEmploymentPeriod::find ()->select ( 'period_id' )->where ( '"'.$termination_date .'" between hire_date and termination_date' )->andWhere ( 'period_id <> ' . $period_id )->andWhere ( 'employee_id='.$employee_id )->All ();
												
									if (! empty ( $check_between_period )) {													
										$arrperiodinsertvalidation [$period_id] ['152'] = 0;
									}
									
								}
							}
						}
						break;
					
					case '11' :
						
						if (! empty ( $employee_employment_periods )) {
							foreach ( $employee_employment_periods as $employment_period ) {
								
								$period_id = $employment_period->period_id;
								$medical_plan_class = $employment_period->plan_class;
								$plan_class_count = 1;
								
								/**
								 * Cannot be empty * *
								 */
								
								if (empty ( $medical_plan_class )) {
									$arrperiodinsertvalidation [$period_id] ['102'] = 0;
									$plan_class_count ++;
								}
							}
						}
						break;
					
					case '12' :
						
						if (! empty ( $employee_employment_periods )) {
							foreach ( $employee_employment_periods as $employment_period ) {
								
								$period_id = $employment_period->period_id;
								$status = $employment_period->status;
								$status_count = 1;
								
								/**
								 * Cannot be empty and valid values are PT/FT * *
								 */
								
								if (empty ( $status )) {
									$arrperiodinsertvalidation [$period_id] ['103'] = 0;
									$status_count ++;
								}
							}
						}
						break;
						
						case '13' :
									
									if (empty ( $employee_employment_periods )) {
										
										$arrinsertvalidation['147'] = 0;
										
									}
									
						break;
				}
			}
			
			$result ['success'] = $arrinsertvalidation;
			$result ['period_success'] = $arrperiodinsertvalidation;
		} catch ( \Exception $e ) { // catching the exception
			
			$msg = $e->getMessage ();
			$result ['error'] = $msg;
		}
		
		return $result;
	}
	
	/**
	 * *****Validate medical elements*************
	 */
	public function ValidateMedical($company_id, $employee_id, $element_ids) {
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
			 * Get all employee of the company
			 *
			 * **
			 */
			$employee = TblAcaMedicalData::find ()->select ( 'employee_id, first_name, last_name, ssn, address1, city, state, zip, dob' )->where ( [ 
					'company_id' => $company_id,
					'employee_id' => $employee_id 
			] )->One ();
			
			$plan_class_data = TblAcaPlanCoverageType::find ()->select ( 'plan_class_id' )->where ( [ 
					'company_id' => $company_id,
				] )->andWhere( [ 'not in',
					'plan_offer_type',[1,4],
				] )->One ();
			
			/**
			 * Get employee employment period
			 *
			 * **
			 */
			
			$employee_emrollment_periods = TblAcaMedicalEnrollmentPeriod::find ()->where ( [ 
					'employee_id' => $employee_id 
			] )->All ();
			//print_r($employee_emrollment_periods);die();
			if(!empty($plan_class_data )){
				foreach ( $element_ids as $element_id ) {
					
					switch ($element_id) {
						case '1' :
							/**
							 * ********Can not be empty value***********
							 */
							
							if (empty ( $employee->first_name )) {
								$arrinsertvalidation ['104'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['104'] = 1;
								
								/**
								 * ***Can not be "."****
								 */
								
								if ($employee->first_name == '.') {
									
									$arrinsertvalidation ['105'] = 0; // key represents rule_id value represents is_validated;
								} else {
									
									// $arrinsertvalidation [$i] ['validation_rule_id'] ['105'] = 1;
									
									/**
									 * Should be atleast 2 characters
									 */
									if (strlen ( $employee->first_name ) < 2) {
										
										$arrinsertvalidation ['106'] = 0;
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
							
							if (empty ( $employee->last_name )) {
								$arrinsertvalidation ['107'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['107'] = 1;
								
								/**
								 * ***Can not be "."****
								 */
								
								if ($employee->last_name == '.') {
									
									$arrinsertvalidation ['108'] = 0; // key represents rule_id value represents is_validated;
								} else {
									
									// $arrinsertvalidation [$i] ['validation_rule_id'] ['108'] = 1;
									
									/**
									 * Should be atleast 2 characters
									 */
									if (strlen ( $employee->last_name ) < 2) {
										
										$arrinsertvalidation ['109'] = 0;
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
							
							if (empty ( $employee->ssn )) {
								$arrinsertvalidation ['110'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['110'] = 1;
								// Replacing special characters from EIN
								$clean_ssn = preg_replace ( '/[^0-9]/s', '', $employee->ssn );
								
								/**
								 * ***SSN has to be a 9 digit number****
								 */
								
								if (strlen ( $clean_ssn ) == 9) {
									
									// $arrinsertvalidation [$i] ['validation_rule_id'] ['111'] = 1; // key represents rule_id value represents is_validated;
									
									/**
									 * ***SSN can not have all numbers same
									 * ( eg.
									 * 000-00-0000, 111-11-1111 etc)
									 * ****
									 */
									
									if (in_array ( $clean_ssn, $this->arrinvalid_ssn )) {
										
										$arrinsertvalidation ['112'] = 0;
									} else {
										
										// $arrinsertvalidation [$i] ['validation_rule_id'] ['112'] = 1;
									}
								} else {
									
									$arrinsertvalidation ['111'] = 0;
								}
							}
							
							break;
						
						case '4' :
							
							/**
							 * ********Can not be empty value***********
							 */
							
							if (empty ( $employee->address1 )) {
								$arrinsertvalidation ['113'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['113'] = 1;
								
								/**
								 * ***Can not be "."****
								 */
								
								if ($employee->address1 == '.') {
									
									$arrinsertvalidation ['114'] = 0; // key represents rule_id value represents is_validated;
								} else {
									
									// $arrinsertvalidation [$i] ['validation_rule_id'] ['114'] = 1;
									
									/**
									 * Should be atleast 2 characters
									 */
									if (strlen ( $employee->address1 ) < 2) {
										
										$arrinsertvalidation ['115'] = 0;
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
							
							if (empty ( $employee->city )) {
								$arrinsertvalidation ['116'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['116'] = 1;
								
								/**
								 * ***Can not be "."****
								 */
								
								if ($employee->city == '.') {
									
									$arrinsertvalidation ['117'] = 0; // key represents rule_id value represents is_validated;
								} else {
									
									// $arrinsertvalidation [$i] ['validation_rule_id'] ['117'] = 1;
									
									/**
									 * Should be atleast 2 characters
									 */
									if (strlen ( $employee->city ) < 2) {
										
										$arrinsertvalidation ['118'] = 0;
									} else {
										
										// $arrinsertvalidation [$i] ['validation_rule_id'] ['118'] = 1;
										
										if (preg_match ( '/[^a-zA-Z ]+/i', $employee->city ) == 1) {
											
											$arrinsertvalidation ['119'] = 0;
										} else {
											
											$model_cities = TblCityStatesUnitedStates::find()->where(['state'=>$employee->state])
											->andwhere(['city'=>$employee->city])->one();
												
											if (empty($model_cities))
											{
												$arrinsertvalidation ['155'] = 0;
											}
										}
									}
								}
							}
							
							break;
						
						case '6' :
							
							/**
							 * ********Can not be empty value***********
							 */
							
							if (empty ( $employee->state )) {
								$arrinsertvalidation ['120'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['120'] = 1;
								
								/**
								 * Only can be 2 character state
								 */
								
								if (strlen ( $employee->state ) == 2) {
									
									// $arrinsertvalidation [$i] ['validation_rule_id'] ['121'] = 1;
									if (! in_array ( strtoupper($employee->state), $this->validustates () )) {
										
										$arrinsertvalidation ['122'] = 0;
									}
								} else {
									
									$arrinsertvalidation ['121'] = 0;
								}
							}
							
							break;
						
						case '7' :
							
							/**
							 * ********Can not be empty value***********
							 */
							
							if (empty ( $employee->zip )) {
								$arrinsertvalidation ['123'] = 0; // key represents rule_id value represents is_validated;
							} else {
								
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['123'] = 1;
								
								/**
								 * ********Cannot be < 5 digits***********
								 */
								if (strlen ( $employee->zip ) < 5) {
									
									$arrinsertvalidation ['124'] = 0;
								} else {
									
									// $arrinsertvalidation [$i] ['validation_rule_id'] ['124'] = 1;
								}
							}
							break;
						
						case '8' :
							
							/**
							 * ********Can not be empty value***********
							 */
							
							if (empty ( $employee->dob )) {
								//$arrinsertvalidation ['125'] = 0; // key represents rule_id value represents is_validated;
							} else {
								//return $employee->dob;
								// $arrinsertvalidation [$i] ['validation_rule_id'] ['125'] = 1;
								
								/**
								 * ********Cannot be < 5 digits***********
								 */
								if ($employee->dob > date ( 'Y-m-d' )) {
									
									$arrinsertvalidation ['126'] = 0;
								} else {
									
									// $arrinsertvalidation [$i] ['validation_rule_id'] ['126'] = 1;
								}
							}
							break;
						
						case '9' :
							if (! empty ( $employee_emrollment_periods )) {
								
								foreach ( $employee_emrollment_periods as $enrollment_period ) {
									
									$period_id = $enrollment_period->period_id;
									/**
									 * ******Get all other
									 * enrollment period other
									 * than this period of particular employee********
									 */
									$coverage_start_date = $enrollment_period->coverage_start_date;
									
									/**
									 * ********Can not be empty value***********
									 */
									
									if (empty ( $coverage_start_date ) || $coverage_start_date == '0000-00-00') {
										
										$arrperiodinsertvalidation [$period_id] ['127'] = 0;
									} else {
										
										/**
										 * ********Coverage start date can not be
										 * greater than 31st dec of the current year***********
										 */
										
										$year_end = date ( 'Y-m-d', strtotime ( 'Dec 31' ) );
										
										if ($coverage_start_date > $year_end) {
											
											$arrperiodinsertvalidation [$period_id] ['128'] = 0;
										}
										
										/**
										 * ********can not be greater than coverage end date***********
										 */
										
										if (! empty ( $enrollment_period->coverage_end_date )) {
											if ($coverage_start_date > $enrollment_period->coverage_end_date) {
												$arrperiodinsertvalidation [$period_id] ['129'] = 0;
											}
										}
										
										/**
										 * *additional coverage start date can not be between a enrollment Period
										 * *
										 */
										
										$check_between_period = TblAcaMedicalEnrollmentPeriod::find ()->select ( 'period_id' )->where (  '"'.$coverage_start_date .'" between coverage_start_date and coverage_end_date' )->andWhere ( 'period_id <> ' . $period_id )->andWhere ( 'employee_id='.$employee_id )->All ();
										//print_r($employee_id);die();
										if (! empty ( $check_between_period )) {
											
											$arrperiodinsertvalidation [$period_id] ['130'] = 0;
										}
										
										/**
										 ****** checking for duplicate coverage_start_date 
										*/ 
										$duplicate = TblAcaMedicalEnrollmentPeriod::find ()->select ( 'coverage_start_date' )->where ( [ 
													  'employee_id' => $employee_id 
										] )->andWhere ( [ 
															'coverage_start_date' => $coverage_start_date 
													] )->Count ();
													
										/***** if there is duplicate coverage_start_date *******/
										if($duplicate>1){
											$arrperiodinsertvalidation [$period_id] ['153'] = 0;
										} 
									}
								}
							}
							
							break;
						
						case '10' :
							if (! empty ( $employee_emrollment_periods )) {
								foreach ( $employee_emrollment_periods as $enrollment_period ) {
									
									$period_id = $enrollment_period->period_id;
									$coverage_end_date = $enrollment_period->coverage_end_date;
									
									if (empty ( $coverage_end_date ) || $coverage_end_date == '0000-00-00') {
									} else {
										
										/**
										 * *A coverage end date can not be between a enrollement period
										 * *
										 */
										
										$check_end_between_period = TblAcaMedicalEnrollmentPeriod::find ()->select ( 'period_id' )->where (  '"'.$coverage_end_date .'" between coverage_start_date and coverage_end_date' )->andWhere ( 'period_id != ' . $period_id )->andWhere ( 'employee_id='.$employee_id )->All ();
										
										if (! empty ( $check_end_between_period )) {
											
											$arrperiodinsertvalidation [$period_id] ['131'] = 0;
										}
										
										/**
										 ****** checking for duplicate coverage_end_date 
										*/ 
										$duplicate = TblAcaMedicalEnrollmentPeriod::find ()->select ( 'coverage_end_date' )->where ( [ 
													  'employee_id' => $employee_id
										] )->andWhere ( [ 
															'coverage_end_date' => $coverage_end_date 
													] )->Count ();
													
										/***** if there is duplicate coverage_end_date *******/
										if($duplicate>1){
											$arrperiodinsertvalidation [$period_id] ['154'] = 0;
										} 
									}
								}
							}
							break;
						
						case '11' :
							
							if (! empty ( $employee_emrollment_periods )) {
								foreach ( $employee_emrollment_periods as $enrollment_period ) {
									
									$period_id = $enrollment_period->period_id;
									$person_type = $enrollment_period->person_type;
									
									/**
									 * *Need to be one of "Employee" or
									 * "Dependent of Employee" or
									 * "Non Employee enrolled", or
									 * "Dependent of non employee enrolled"
									 * *
									 */
									
									if (empty ( $person_type )) {
										$arrperiodinsertvalidation [$period_id] ['132'] = 0;
									}
								}
							}
							break;
						
						case '12' :
							
							if (! empty ( $employee_emrollment_periods )) {
								foreach ( $employee_emrollment_periods as $enrollment_period ) {
									
									$period_id = $enrollment_period->period_id;
									$person_type = $enrollment_period->person_type;
									$dependent_dob = $enrollment_period->dependent_dob;
									
									if (! empty ( $person_type ) && $person_type != 84 && $person_type != 87) {
										
										if (empty ( $dependent_dob ))
										{
										/**
										 * ********Can not be empty value***********
										 */
										 
										if (empty ( $enrollment_period->ssn )) {
											
											$arrperiodinsertvalidation [$period_id] ['134'] = 0;
										} else {
											
											/**
											 * ***SSN has to be a 9 digit number****
											 */
											
											if (strlen ( $enrollment_period->ssn ) == 9) {
												
												/**
												 * ***SSN can not have all numbers same
												 * ( eg.
												 * 000-00-0000, 111-11-1111 etc)
												 * ****
												 */
												
												if (in_array ( $enrollment_period->ssn, $this->arrinvalid_ssn)) {
													//return strlen ( $enrollment_period->ssn );
													$arrperiodinsertvalidation [$period_id] ['136'] = 0;
												}
												else{
													//return $enrollment_period->ssn;
												}
											} else {
												
												$arrperiodinsertvalidation [$period_id] ['135'] = 0;
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
									$period_id = $enrollment_period->period_id;
									$person_type = $enrollment_period->person_type;
									
									if (! empty ( $person_type ) && $person_type != 84 && $person_type != 87) {
										/**
										 * ********If person type is not
										 * employee and social
										 * is not entered
										 * this is required***********
										 */
										if (empty ( $enrollment_period->ssn )) {
											
											if (empty ( $enrollment_period->dependent_dob )) {
												
												$arrperiodinsertvalidation [$period_id] ['137'] = 0;
											}
										}
									}
								}
							}
							
							break;
						
						case '14' :
							
							if (! empty ( $employee_emrollment_periods )) {
								foreach ( $employee_emrollment_periods as $enrollment_period ) {
									
									$period_id = $enrollment_period->period_id;
									$dependent_dob = $enrollment_period->dependent_dob;
									
									/**
									 * *If use dependent dob
									 * is selected then DOB
									 * cannot be blank, can not
									 * give a future date
									 * *
									 */
									
									if (! empty ( $dependent_dob ) && $dependent_dob == 1 && (! empty ( $person_type )) && $person_type != 84 && $person_type != 87) {
										if (empty ( $enrollment_period->dob )) {
											
											$arrperiodinsertvalidation [$period_id] ['138'] = 0;
										} else {
											
											/**
											 * ********Cannot be a future date***********
											 */
											if ($enrollment_period->dob > date ( 'Y-m-d' )) {
												
												$arrperiodinsertvalidation [$period_id] ['139'] = 0;
											} else {
											}
										}
									}
								}
							}
							break;
						case '15' :
									
									if (empty ( $employee_emrollment_periods )) {
										
										$arrinsertvalidation['156'] = 0;
										
									}
							break;
					}
				}
			}
			$result ['success'] = $arrinsertvalidation;
			$result ['period_success'] = $arrperiodinsertvalidation;
		} catch ( \Exception $e ) { // catching the exception
			
			$msg = $e->getMessage ();
			$result ['error'] = $msg;
		}
		
		return $result;
	}
}