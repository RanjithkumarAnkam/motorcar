<?php

/**
 * Helper class for validating each element and inserting validation results in TblAcaValidationLog
 * @author PRAVEEN
 * Date Created : 03 October 2016
 * Date Modified : 13 October 2016
 */
namespace app\components;

use Yii;
use yii\base\Component;
use app\controllers\SiteController;
use app\models\TblAcaElementMaster;
use app\models\TblAcaBasicInformation;
use app\models\TblAcaCompanies;
use app\models\TblAcaValidationLog;
use yii\validators\EmailValidator;
use app\models\TblAcaEmpStatusTrack;
use app\models\TblAcaPlanCriteria;
use app\models\TblAcaDesignatedGovtEntity;
use app\models\TblAcaAggregatedGroup;
use app\models\TblAcaAggregatedGroupList;
use app\models\TblAcaGeneralPlanInfo;
use app\models\TblAcaGeneralPlanMonths;
use app\models\TblAcaMecCoverage;

class ValidateindividualElementComponent extends Component {
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
	/**
	 * ***Function validates basic info******
	 */
	public function Validatebasicinfo($company_id, $element_id) {
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
			
			switch ($element_id) {
				
				/**
				 * ***********Case 1 Starts********************
				 */
				case '1' :
					$arrvalidation = array ();
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
						if (strlen ( $company_details->company_name ) == 1 && (preg_match ( '/[^a-zA-Z0-9&?- ]+/i', $company_details->company_name ) == 1)) {
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
				
				/*case '2' :
					$arrvalidation = array ();
					/**
					 * ********Can not be empty value***********
					 
					
					if (empty ( $company_details->company_ein )) {
						$arrvalidation ['4'] = 0; // key represents rule_id value represents is_validated;
					} else {
						
						$arrvalidation ['4'] = 1;
						
						/**
						 * ***it shold be 9 digit number with format NN-NNNNNNN****
						 
						// Replacing special characters from EIN
						$clean_ein = preg_replace ( '/[^0-9]/s', '', $company_details->company_ein );
						
						if (preg_match ( $this->ein_regex, $company_details->company_ein ) && strlen ( $clean_ein ) == 9) {
							
							$arrvalidation ['3'] = 1; // key represents rule_id value represents is_validated;
							
							/**
							 * ***Can not be NN-NNNNNNN
							 * EIN Can not be all N ( where N = 0..9)
							 * ****
							 
							
							if (in_array ( $clean_ein, $this->arrinvalid_ein, TRUE )) {
								
								$arrvalidation ['5'] = 0;
							} else {
								
								$arrvalidation ['5'] = 1;
							}
						} else {
							
							$arrvalidation ['3'] = 0;
						}
					}
					
					
					break;
				*/
				/**
				 * ***********Case 2 Ends********************
				 */
				/**
				 * ***********Case 4 Starts********************
				 */
				case '4' :
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
					/**
					 * ********Can not be empty value***********
					 */
					
					if (empty ( $basic_info_details->contact_phone_number )) {
						$arrvalidation ['16'] = 0; // key represents rule_id value represents is_validated;
					} else {
						
						$arrvalidation ['16'] = 1;
						
						if(strlen($basic_info_details->contact_phone_number) == 10){
							
							$arrvalidation ['17'] = 1;
							
						}
						else
						{
							$arrvalidation ['17'] = 0;
							
						}
						/**
						 * ****To be done yet*********
						 */
						
					}
					
						
					break;
				
				/**
				 * ***********Case 10 Ends********************
				 */
				
				/**
				 * ***********Case 11 Starts********************
				 */
				case '11' :
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
			
			
			$result['success'] = $arrvalidation;
			
		} catch ( \Exception $e ) { // catching the exception
			
			$result ['error'] = $e->getMessage ();
		}
		
		return $result;
	}
	
	/**
	 * ***Function validates Large Employer Status & Tracking******
	 */
	public function Validateale($company_id, $element_id) {
		$insert_result = array ();
		$result = array ();
		 $arrvalidation = array ();
		 
		$ale_details = TblAcaEmpStatusTrack::find ()->select ( 'ale_applicable, ale_first_applicable, ale_category' )->where ( [ 
				'company_id' => $company_id 
		] )->One ();
		
		try {
			
			switch ($element_id) {
				/**
				 * ***********Case 22 Starts********************
				 */
				case '22' :
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
			
			$result['success'] = $arrvalidation;
		} catch ( \Exception $e ) { // catching the exception
			
			$result ['error'] = $e->getMessage ();
		}
		return $result;
	}
	
	/**
	 * ***Function validates Plan Offering Criteria******
	 */
	public function Validateplanofferingcriteria($company_id, $element_id) {
		$insert_result = array ();
		$result = array ();
		$arrvalidation = array ();
		
		$plan_offering_criteria_details = TblAcaPlanCriteria::find ()->select ( 'hours_tracking_method, initial_measurement_period, initial_measurment_period_begin, company_certification_workforce, company_certification_medical_eligibility, company_certification_employer_contribution' )->where ( [ 
				'company_id' => $company_id 
		] )->One ();
		
		try {
			
			switch ($element_id) {
				
				/**
				 * ***********Case 25 Starts********************
				 */
				case '25' :
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
			
			$result['success'] = $arrvalidation;
		} catch ( \Exception $e ) { // catching the exception
			
			$result ['error'] = $e->getMessage ();
		}
		
		return $result;
	}
	
	/**
	 * ***Function validates Designated Government Entity******
	 */
	public function Validatedge($company_id, $element_id) {
		$result = array ();
		$insert_result = array ();
		 $arrvalidation = array ();
		 
		try {
			$dge_details = TblAcaDesignatedGovtEntity::find ()->select ( 'assign_dge, dge_name, dge_ein, street_address_1, dge_state, dge_city, dge_zip, dge_contact_first_name,dge_contact_last_name, dge_contact_phone_number, dge_reporting' )->where ( [ 
					'company_id' => $company_id 
			] )->One ();
			
			switch ($element_id) {
				/**
				 * ***********Case 42 Starts********************
				 */
				case '42' :
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
					
					if (! empty ( $dge_details->assign_dge ) && $dge_details->assign_dge == 1) {
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $dge_details->dge_ein )) {
							$arrvalidation ['36'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$clean_ein = preg_replace ( '/[^0-9]/s', '', $dge_details->dge_ein );
							
							if(empty($clean_ein))
							{
								$arrvalidation ['36'] = 0; // key represents rule_id value represents is_validated;
								
							}
							else{	
							$arrvalidation ['36'] = 1;
							
							/**
							 * ***it shold be 9 digit number with format NN-NNNNNNN****
							 */
							// Replacing special characters from EIN
							$clean_ein = preg_replace ( '/[^0-9]/s', '', $dge_details->dge_ein );
							
							if (preg_match ( $this->ein_regex, $dge_details->dge_ein ) && strlen ( $clean_ein ) == 9) {
								
								$arrvalidation ['35'] = 1; // key represents rule_id value represents is_validated;
								
								/**
								 * ***Can not be NN-NNNNNNN
								 * EIN Can not be all N ( where N = 0..9)
								 * ****
								 */
								
								if (in_array ( $clean_ein, $this->arrinvalid_ein, TRUE )) {
									
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
					$arrvalidation = array ();
					
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
					$arrvalidation = array ();
					
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
						$arrvalidation = array ();
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
									if (strlen ( $dge_details->dge_contact_last_name ) < 2) {
											
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
					$arrvalidation = array ();
					if (! empty ( $dge_details->assign_dge ) && $dge_details->assign_dge == 1) {
						/**
						 * ********Can not be empty value***********
						 */
						
						if (empty ( $dge_details->dge_contact_phone_number )) {
							$arrvalidation ['46'] = 0; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['46'] = 1;
							
							if(strlen($dge_details->dge_contact_phone_number) == 10){
							
							$arrvalidation ['47'] = 1;
							
								}
								else
								{
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
					$arrvalidation = array ();
					
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
			
			$result['success'] = $arrvalidation;
		} catch ( \Exception $e ) { // catching the exception
			
			$result ['error'] = $e->getMessage ();
		}
		
		return $result;
	}
	
	/**
	 * ***Function validates Aggregated Group******
	 */
	public function Validateaggreagate($company_id, $element_id) {
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
			
			switch ($element_id) {
				/**
				 * ***********Case 56 Starts********************
				 */
				case '56' :
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
					
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
					$arrvalidation = array ();
					
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
					$arrvalidation = array ();
					
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
					$arrvalidation = array ();
					
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
										
										$arrvalidation ['54'] = 1; // key represents rule_id value represents is_validated;
										
										/**
										 * ***Can not be NN-NNNNNNN
										 * EIN Can not be all N ( where N = 0..9)
										 * ****
										 */
										
										if (in_array ( $clean_ein, $this->arrinvalid_ein, TRUE )) {
											
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
			
			$result['success'] = $arrvalidation;
		} catch ( \Exception $e ) { // catching the exception
			
			$result ['error'] = $e->getMessage ();
		}
		return $result;
	}
	
	
	
	/**
	 * ***Function validates General Plan Information******
	 */
	public function ValidateGeneralplaninfo($company_id, $element_id) {
		$insert_result = array ();
		$result = array ();
		$plan_info_months = array ();
		$arrmonths = array();
		 
		$general_plan_info = TblAcaGeneralPlanInfo::find ()->select ( 'general_plan_id, is_first_year, renewal_month, is_multiple_waiting_periods, multiple_description, is_employees_hra, offer_type' )->where ( [ 
				'company_id' => $company_id 
		] )->One ();
		
		if (! empty ( $general_plan_info )) {
			
			$plan_info_months = TblAcaGeneralPlanMonths::find ()->select ( 'plan_value' )->where ( [ 
					'general_plan_id' => $general_plan_info->general_plan_id 
			] )->asArray ()->All ();
			
			foreach($plan_info_months as $key=>$value)
			{
				
				$arrmonths[] = $value['plan_value'];
			}
		
			
		}
		
		try {
			
			switch ($element_id) {
				
				/**
				 * ***********Case 64 Starts********************
				 */
				case '64' :
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
					$arrvalidation = array ();
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
								foreach($arrmonths as $key=>$value)
								{
									if($value !=0 )
									{
										$arrvalidation ['61'] = 1;
										break;
									}
									
								}
								
							}
							else {
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
			
			$result['success'] = $arrvalidation;
		} catch ( \Exception $e ) { // catching the exception
			
			$result ['error'] = $e->getMessage ();
		}
		
		return $result;
	}
	
	
	
	
	
	/**
	 * ***Function validates MEC Coverage******
	 */
	public function ValidateMec($company_id, $element_id) {
		$insert_result = array ();
		$result = array ();
		$plan_info_months = array ();
		 $arrvalidation = array ();
		 
		$mec_info = TblAcaMecCoverage::find ()->select ( 'mec_months' )->where ( [ 
				'company_id' => $company_id 
		] )->One ();
		
		try {
			
			switch ($element_id) {
				
				/**
				 * ***********Case 73 Starts********************
				 */
				case '73' :
					$arrvalidation = array ();
					/**
					 * ********Atleast one value must be present***********
					 */
					//print_r($mec_info->mec_months);die();
					if(!empty($mec_info)){
						if ($mec_info->mec_months!='' || $mec_info->mec_months==0) {
							$arrvalidation ['62'] = 1; // key represents rule_id value represents is_validated;
						} else {
							
							$arrvalidation ['62'] = 0;
						}
					} else {							
						$arrvalidation ['62'] = 0;
					}
					
					
					break;
			
			/**
			 * ***********Case 73 Ends********************
			 */
			}
			
			$result['success'] = $arrvalidation;
		} catch ( \Exception $e ) { // catching the exception
			
			$result ['error'] = $e->getMessage ();
		}
		
		return $result;
	}

	
	
}