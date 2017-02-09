<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\components\EncryptDecryptComponent;
use yii\web\HttpException;
use app\models\TblAcaForms;
use app\models\TblAca1094;
use app\models\TblAca1095;
use app\models\TblAcaCompanies;
use app\models\TblAcaFormErrors;
use yii2tech\csvgrid\CsvGrid;
use yii\data\ArrayDataProvider;
use app\models\TblAcaFormsSearch;

class EfileController extends Controller {
	
	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex() {
		
		$this->layout = 'main'; 
		$session = \Yii::$app->session;                    //initialising session
		$admin_permissions = $session ['admin_permissions'];
		if (\Yii::$app->SessionCheck->isLogged () == true && in_array("13", $admin_permissions)) 		// checking logged session
		{
			/*
			 * Query to get all the e-file records
			 */
			$searchModel = new TblAcaFormsSearch();
			$dataProvider = $searchModel->approvedrecords(Yii::$app->request->queryParams);
			
			return $this->render ( 'index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			] );
			
		} else {
			
			\Yii::$app->SessionCheck->adminlogout ();
			
			return $this->goHome ();
		}

	}
	
	public function actionUpdateefiledetails(){
		\Yii::$app->view->title = 'ACA Reporting Service | Lookup Options';
		$this->layout = 'main';
		$session = \Yii::$app->session;                    //initialising session
		$admin_permissions = $session ['admin_permissions'];
		$output = array();
		if (\Yii::$app->SessionCheck->isLogged () == true && in_array("13", $admin_permissions)) 		// checking logged session
		{
			$post_details = yii::$app->request->post();
			$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
			
			try{
			if(!empty($post_details)){          //getting post values
				
				$id =$post_details['id'];
				$status =$post_details['status'];
				$receipt_number =$post_details['receipt_number'];
				$receipt_date =$post_details['receipt_date'];
				
				if($receipt_date != '')
				{
					$receipt_date = date('Y-m-d', strtotime($receipt_date));
				}
				
				$model_acaforms =TblAcaForms::find()->where(['id'=>$id])->one();    //gettin details of record which is goin to update
				
				$model_acaforms->efile_status = $status;
				$model_acaforms->efile_receipt_number = $receipt_number;
				$model_acaforms->approved_date = date('Y-m-d H:i:s');
				$model_acaforms->efile_receipt_date = $receipt_date;
				
				if ($model_acaforms->save () && $model_acaforms->validate ()) { // model save
					$transaction->commit();
					$output['success']= 'E-File datails updated successfully';
				}else{
				
					$output['error']= 'Error occured while saving';
				}
			}
			} catch ( \Exception $e ) { // any \Exceptions catch throws error msg
				$msg = $e->getMessage ();
			
				$output['error'] = $msg;
					
				$transaction->rollback (); // if \Exception occurs transaction rollbacks
			}
			return json_encode($output);
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
	}
	
	// function to generate XML
	// calling function in cron	
	public function actionGeneratexml(){
		
	try{
		$clean_ein='';
		$reporting_year='';
		$employer_name='';
		$addressone='';
		$addresstwo='';
		$city='';
		$state ='';
		$zip='';
		$contact_first_name='';
		$contact_middle_name='';
		$contact_last_name='';
		$contact_suffix='';
		$clean_phone='';
		$govt_entity_name='';
		$employer_ein='';
		$total_no_records_submitted='';
		$_1094c_box23B = '';
		$_1094c_box23C = '';
		$arr_minimal_essential_coverage = array();
		$other_ale_member='';
		$address_line_one = '';
		$address_line_two = '';
		$city_or_town_2_I = '';
		$state_or_province_2_I = '';
		$country_and_zip_2_I = '';
		$first_name_of_person_to_contact_2_I = '';
		$middle_name_of_person_to_contact_2_I = '';
		$last_name_of_person_to_contact_2_I = '';
		$suffix_name_of_person_to_contact_2_I = '';
		$contact_telephone_number_2_I = '';
		$total_no_records_submitted = '';
		$total_no_of_1095c_filled_II = '';
		$ale_member_check = '';
		$quality_offer_method ='';
		$section_4980_transition = '';
		$offer_method = '';
		$minimal_essential_coverage = '';
		$full_time_employee_count = '';
		$total_employee_count_for_ale_member = '';
		$aggregate_group_all ='';
		$arr_minimal_essential_coverage = array();
		$arr_total_employee_count = array();
		$arr_aggrigated_grp_indicator = array();
		$arr_section_4980h_transition = array();
		$other_ale_member = '';
		$total_1095_count = '';
		
		// get the efile approved companies
		$companies = TblAcaForms::find()->where(['is_approved'=>1])->andWhere(['xml_file'=>NULL])->All();	
		
		foreach($companies as $company){
					
			$time = time();
			
			$unique_company_id = $company->company_id;
			
			$company_details = TblAcaCompanies::find()->where(['company_id'=>$unique_company_id])->One();
			
			$company_client_number = $company_details->company_client_number;
			
			$form_id = $company->id;
			
			// getting compamy EIN (2)
			$company_ein = $company->company->company_ein;
			$clean_ein = preg_replace ( '/[^0-9]/s', '', $company_ein );
			
			// getting company year
			$reporting_year = $company->companyreportingyear->year->lookup_value;
			$model_1094 = TblAca1094::find()->where(['form_id'=>$form_id])->one();
			//print_r($model_1094);die();
			// getting 1094c data
			
			//part 1
			if(!empty($model_1094->serialise_data1)){
				$unserialise_data_part1 = unserialize ( $model_1094->serialise_data1 );
				$part1 = json_decode ( $unserialise_data_part1 );
			}
			else{
				$part1 = array();
			}
		    
			
			//part 2
			if(!empty($model_1094->serialise_data2)){
				$unserialise_data_part2 = unserialize ( $model_1094->serialise_data2 );
				$part2 = json_decode ( $unserialise_data_part2 );
			}
			else{
				$part2 = array();
			}
			
			//part 3
			if(!empty($model_1094->serialise_data3)){
				$unserialise_data_part3 = unserialize ( $model_1094->serialise_data3 );
				$part3 = json_decode ( $unserialise_data_part3 );
			}
			else{
				$part3 = array();
			}
			
			//part 4
			if(!empty($model_1094->serialise_data4)){
				$unserialise_data_part4 = unserialize ( $model_1094->serialise_data4 );
				$part4 = json_decode ( $unserialise_data_part4 );
			}
			else{
				$part4 = array();
			}
			
			//part 5
			if(!empty($model_1094->xml_data)){
				$unserialise_data_part5 = unserialize ( $model_1094->xml_data );
				$part5 = json_decode ( $unserialise_data_part5 );
			}
			else{
				$part5 = array();
			}
			
			///////////////////////
			
			//getting 1094c company name (1)
			if(!empty($part1->name_of_ale_member_1_I)){
				$employer_name = $part1->name_of_ale_member_1_I;
			}
			
			//getting 1094c address one (3.1)
			if(!empty($part5->street_address_1__3)){
				$addressone = $part5->street_address_1__3;
			}
			
			//getting 1094c address two (3.2)
			if(!empty($part5->street_address_2__3)){
				$addresstwo = $part5->street_address_2__3;
			}
			 
			//getting 1094c city (4)
			if(!empty($part1->city_or_town_I)){
				$city = $part1->city_or_town_I;
			}
		 
			//getting 1094c state (5)
			if(!empty($part1->state_or_province_I)){
				$state = $part1->state_or_province_I;
			}
		  
			//getting 1094c zip (6)
			if(!empty($part1->country_and_zip_I)){
				$zip = $part1->country_and_zip_I;
			}
			
			//getting 1094c contact_first_name (7.1)
			/*if(!empty($part1->first_name_of_the_person_contact_I)){
				$contact_first_name = $part1->first_name_of_the_person_contact_I;
			}
			$contact_first_name = $part1->name_of_the_person_contact_I;*/
			if(!empty($part5->first_name__7)){
				$contact_first_name = $part5->first_name__7;
			}
			
			
			//getting 1094c contact_middle_name (7.2)
			if(!empty($part5->middle_name__7)){
				$contact_middle_name = $part5->middle_name__7;
			}
			
			//getting 1094c contact_last_name (7.3)
			if(!empty($part5->last_name__7)){
				$contact_last_name = $part5->last_name__7;
			}
			
			//getting 1094c contact_suffix (7.4)
			if(!empty($part5->suffix__7)){
				$contact_suffix = $part5->suffix__7;
			}
			
			//getting 1094c contact_phone (8)
			if(!empty($part1->contact_telephone_number_I)){
				$contact_phone = $part1->contact_telephone_number_I;
				$clean_phone = preg_replace ( '/[^0-9\']/', '',  $contact_phone);
			}
			
			//getting 1094c name of DGE (9)
			if(!empty($part1->name_of_designated_government_entity_I)){
				$govt_entity_name = $part1->name_of_designated_government_entity_I;
			}
			
			//getting 1094c employer EIN (10)
			if(!empty($part1->employer_identification_number_2_I)){
				$employer_ein = preg_replace ( '/[^0-9]/s', '', $part1->employer_identification_number_2_I );
			}
			
			//getting 1094c address_line_one (11.1)
			if(!empty($part5->street_address_1__11)){
				$address_line_one = $part5->street_address_1__11;
			}
			
			//getting 1094c address_line_two (11.2)
			if(!empty($part5->street_address_2__11)){
				$address_line_two = $part5->street_address_2__11;
			}
			
			//getting 1094c city_or_town_2_I (12)
			if(!empty($part1->city_or_town_2_I)){
				$city_or_town_2_I = $part1->city_or_town_2_I;
			}
			
			//getting 1094c state_or_province_2_I (13)
			if(!empty($part1->state_or_province_2_I)){
				$state_or_province_2_I = $part1->state_or_province_2_I;
			}
			
			//getting 1094c country_and_zip_2_I (14)
			if(!empty($part1->country_and_zip_2_I)){
				$country_and_zip_2_I = $part1->country_and_zip_2_I;
			}
			
			//getting 1094c first_name_of_person_to_contact_2_I (15.1)
			if(!empty($part5->first_name__15)){
				$first_name_of_person_to_contact_2_I = $part5->first_name__15;
			}
			
			//getting 1094c last_name_of_person_to_contact_2_I (15.3)
			if(!empty($part5->last_name__15)){
				$last_name_of_person_to_contact_2_I = $part5->last_name__15;
			}
			
			//getting 1094c middle_name_of_person_to_contact_2_I (15.2)
			if(!empty($part5->middle_name__15)){
				$middle_name_of_person_to_contact_2_I = $part5->middle_name__15;
			}
			
			//getting 1094c suffix_name_of_person_to_contact_2_I (15.4)
			if(!empty($part5->suffix__15)){
				$suffix_name_of_person_to_contact_2_I = $part5->suffix__15;
			}
			
			//getting 1094c contact_telephone_number_2_I (16)
			if(!empty($part1->contact_telephone_number_2_I)){
				$contact_telephone_number_2_I = $part1->contact_telephone_number_2_I;
				$contact_telephone_number_2_I = preg_replace ( '/[^0-9\']/', '',  $contact_telephone_number_2_I);
			}
			
			//getting 1094c total number of forms submitted (18)
			if(!empty($part1->total_no_of_1095c_submitted_I)){
				$total_no_records_submitted = $part1->total_no_of_1095c_submitted_I;
			}
			
			//getting 1094c total number of forms filled (20)
			if(!empty($part2->total_no_of_1095c_filled_II)){
				$total_no_of_1095c_filled_II = $part2->total_no_of_1095c_filled_II;
			}
			
			//getting 1094c ale member check (21)
			if(isset($part2->is_ale_member_yes_II) && $part2->is_ale_member_yes_II == 1){
				$ale_member_check = 1;
			}
			else if(isset($part2->is_ale_member_no_II) && $part2->is_ale_member_no_II == 1){
				$ale_member_check = 2;
			}
			
			//getting 1094c quality_offer_method (22A)
			if(!empty($part2->quality_offer_method_II) &&  $part2->quality_offer_method_II== 1){
				$quality_offer_method = 1;
			}
			else{
				$quality_offer_method = 0;
			}
			
			//getting 1094c section_4980_transition (22C)
			if(!empty($part2->section_4980_transition_II) &&  $part2->section_4980_transition_II== 1){
				$section_4980_transition = 1;
			}
			else{
				$section_4980_transition = 0;
			}
			
			//getting 1094c offer_method (22D)
			if(!empty($part2->offer_method_II) &&  $part2->offer_method_II== 1){
				$offer_method = 1;
			}
			else{
				$offer_method = 0;
			}
			
			//getting 1094c section_4980_transition (22C)
			if(!empty($part3->minimal_essential_coverage_all_yes_III) &&  $part3->minimal_essential_coverage_all_yes_III== 1){
				$minimal_essential_coverage = 1;
			}
			else if(!empty($part3->minimal_essential_coverage_all_no_III) &&  $part3->minimal_essential_coverage_all_no_III == 1){
				$minimal_essential_coverage = 2;
			}
			else{
				$minimal_essential_coverage = 0;
			}
			
			//getting 1094c full_time_employee_count (23B)
			if(!empty($part3->section_4980h_fulltime_employee_count_all_III)){
				$full_time_employee_count = $part3->section_4980h_fulltime_employee_count_all_III;
			}
			
			//getting 1094c total_employee_count_for_ale_member (23C)
			if(!empty($part3->total_employee_count_all_III)){
				$total_employee_count_for_ale_member = $part3->total_employee_count_all_III;
			}
			
			//getting 1094c aggregate_group_all (23D)
			if(!empty($part3->aggregate_group_all_III) &&  $part3->aggregate_group_all_III== 1){
				$aggregate_group_all = 1;
			}
			else{
				$aggregate_group_all = 0;
			}
			
			/////////////////////////////////////////////////
			//getting 1094c 24-35 A values (preparing array)
			
			// jan value
			if(!empty($part3->minimal_essential_coverage_jan_yes_III) &&  $part3->minimal_essential_coverage_jan_yes_III== 1){
				$minimal_essential_coverage_jan = 1;
			}
			else if(!empty($part3->minimal_essential_coverage_jan_no_III) &&  $part3->minimal_essential_coverage_jan_no_III== 1){
				$minimal_essential_coverage_jan = 2;
			}
			else{
				$minimal_essential_coverage_jan = 0;
			}
			$arr_minimal_essential_coverage[0] = '<JanMinEssentialCvrOffrCd>'.$minimal_essential_coverage_jan.'</JanMinEssentialCvrOffrCd>';
			
			// feb value
			if(!empty($part3->minimal_essential_coverage_feb_yes_III) &&  $part3->minimal_essential_coverage_feb_yes_III== 1){
				$minimal_essential_coverage_feb = 1;
			}
			else if(!empty($part3->minimal_essential_coverage_feb_no_III) &&  $part3->minimal_essential_coverage_feb_no_III== 1){
				$minimal_essential_coverage_feb = 2;
			}
			else{
				$minimal_essential_coverage_feb = 0;
			}
			$arr_minimal_essential_coverage[1] = '<FebMinEssentialCvrOffrCd>'.$minimal_essential_coverage_feb.'</FebMinEssentialCvrOffrCd>';
			
			// mar value
			if(!empty($part3->minimal_essential_coverage_mar_yes_III) &&  $part3->minimal_essential_coverage_mar_yes_III== 1){
				$minimal_essential_coverage_mar = 1;
			}
			else if(!empty($part3->minimal_essential_coverage_feb_no_III) &&  $part3->minimal_essential_coverage_feb_no_III== 1){
				$minimal_essential_coverage_mar = 2;
			}
			else{
				$minimal_essential_coverage_mar = 0;
			}
			$arr_minimal_essential_coverage[2] = '<MarMinEssentialCvrOffrCd>'.$minimal_essential_coverage_mar.'</MarMinEssentialCvrOffrCd>';
			
			// apr value
			if(!empty($part3->minimal_essential_coverage_apr_yes_III) &&  $part3->minimal_essential_coverage_apr_yes_III== 1){
				$minimal_essential_coverage_apr = 1;
			}
			else if(!empty($part3->minimal_essential_coverage_apr_no_III) &&  $part3->minimal_essential_coverage_apr_no_III== 1){
				$minimal_essential_coverage_apr = 2;
			}
			else{
				$minimal_essential_coverage_apr = 0;
			}
			$arr_minimal_essential_coverage[3] = '<AprMinEssentialCvrOffrCd>'.$minimal_essential_coverage_apr.'</AprMinEssentialCvrOffrCd>';
			
			// may value
			if(!empty($part3->minimal_essential_coverage_may_yes_III) &&  $part3->minimal_essential_coverage_may_yes_III== 1){
				$minimal_essential_coverage_may = 1;
			}
			else if(!empty($part3->minimal_essential_coverage_may_no_III) &&  $part3->minimal_essential_coverage_may_no_III== 1){
				$minimal_essential_coverage_may = 2;
			}
			else{
				$minimal_essential_coverage_may = 0;
			}
			$arr_minimal_essential_coverage[4] = '<MayMinEssentialCvrOffrCd>'.$minimal_essential_coverage_may.'</MayMinEssentialCvrOffrCd>';
			
			// jun value
			if(!empty($part3->minimal_essential_coverage_june_yes_III) &&  $part3->minimal_essential_coverage_june_yes_III== 1){
				$minimal_essential_coverage_june = 1;
			}
			else if(!empty($part3->minimal_essential_coverage_june_no_III) &&  $part3->minimal_essential_coverage_june_no_III== 1){
				$minimal_essential_coverage_june = 2;
			}
			else{
				$minimal_essential_coverage_june = 0;
			}
			$arr_minimal_essential_coverage[5] = '<JunMinEssentialCvrOffrCd>'.$minimal_essential_coverage_june.'</JunMinEssentialCvrOffrCd>';
			
			// jul value
			if(!empty($part3->minimal_essential_coverage_july_yes_III) &&  $part3->minimal_essential_coverage_july_yes_III== 1){
				$minimal_essential_coverage_july = 1;
			}
			else if(!empty($part3->minimal_essential_coverage_july_no_III) &&  $part3->minimal_essential_coverage_july_no_III== 1){
				$minimal_essential_coverage_july = 2;
			}
			else{
				$minimal_essential_coverage_july = 0;
			}
			$arr_minimal_essential_coverage[6] = '<JulMinEssentialCvrOffrCd>'.$minimal_essential_coverage_july.'</JulMinEssentialCvrOffrCd>';
			
			// aug value
			if(!empty($part3->minimal_essential_coverage_aug_yes_III) &&  $part3->minimal_essential_coverage_aug_yes_III== 1){
				$minimal_essential_coverage_aug = 1;
			}
			else if(!empty($part3->minimal_essential_coverage_aug_no_III) &&  $part3->minimal_essential_coverage_aug_no_III== 1){
				$minimal_essential_coverage_aug = 2;
			}
			else{
				$minimal_essential_coverage_aug = 0;
			}
			$arr_minimal_essential_coverage[7] = '<AugMinEssentialCvrOffrCd>'.$minimal_essential_coverage_aug.'</AugMinEssentialCvrOffrCd>';
			
			// sep value
			if(!empty($part3->minimal_essential_coverage_sept_yes_III) &&  $part3->minimal_essential_coverage_sept_yes_III== 1){
				$minimal_essential_coverage_sept = 1;
			}
			else if(!empty($part3->minimal_essential_coverage_sept_no_III) &&  $part3->minimal_essential_coverage_sept_no_III== 1){
				$minimal_essential_coverage_sept = 2;
			}
			else{
				$minimal_essential_coverage_sept = 0;
			}
			$arr_minimal_essential_coverage[8] = '<SepMinEssentialCvrOffrCd>'.$minimal_essential_coverage_sept.'</SepMinEssentialCvrOffrCd>';
			
			// oct value
			if(!empty($part3->minimal_essential_coverage_oct_yes_III) &&  $part3->minimal_essential_coverage_oct_yes_III== 1){
				$minimal_essential_coverage_oct = 1;
			}
			else if(!empty($part3->minimal_essential_coverage_oct_no_III) &&  $part3->minimal_essential_coverage_oct_no_III== 1){
				$minimal_essential_coverage_oct = 2;
			}
			else{
				$minimal_essential_coverage_oct = 0;
			}
			$arr_minimal_essential_coverage[9] = '<OctMinEssentialCvrOffrCd>'.$minimal_essential_coverage_oct.'</OctMinEssentialCvrOffrCd>';
			
			// nov value
			if(!empty($part3->minimal_essential_coverage_nov_yes_III) &&  $part3->minimal_essential_coverage_nov_yes_III== 1){
				$minimal_essential_coverage_nov = 1;
			}
			else if(!empty($part3->minimal_essential_coverage_nov_no_III) &&  $part3->minimal_essential_coverage_nov_no_III== 1){
				$minimal_essential_coverage_nov = 2;
			}
			else{
				$minimal_essential_coverage_nov = 0;
			}
			$arr_minimal_essential_coverage[10] = '<NovMinEssentialCvrOffrCd>'.$minimal_essential_coverage_nov.'</NovMinEssentialCvrOffrCd>';
			
			// dec value
			if(!empty($part3->minimal_essential_coverage_dec_yes_III) &&  $part3->minimal_essential_coverage_dec_yes_III== 1){
				$minimal_essential_coverage_dec = 1;
			}
			else if(!empty($part3->minimal_essential_coverage_dec_no_III) &&  $part3->minimal_essential_coverage_dec_no_III== 1){
				$minimal_essential_coverage_dec = 2;
			}
			else{
				$minimal_essential_coverage_dec = 0;
			}
			$arr_minimal_essential_coverage[11] = '<DecMinEssentialCvrOffrCd>'.$minimal_essential_coverage_dec.'</DecMinEssentialCvrOffrCd>';
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			
			/////////////////////////////////////////////////
			//getting 1094c 24-35 C values (preparing array)
			
			// jan value
			if(isset($part3->total_employee_count_jan_III)){
				$total_employee_count_jan = $part3->total_employee_count_jan_III;
				if(!empty($total_employee_count_jan)){
				$arr_total_employee_count[0] = '<JanALEMonthlyInfoGrp>
												<TotalEmployeeCnt>'.$total_employee_count_jan.'</TotalEmployeeCnt>
											</JanALEMonthlyInfoGrp>';
				}
				else
				{
					$arr_total_employee_count[0] = '';
				}
			}			
			
			
			// feb value
			if(isset($part3->total_employee_count_feb_III)){
				$total_employee_count_feb = $part3->total_employee_count_feb_III;
				if(!empty($total_employee_count_feb)){
				$arr_total_employee_count[1] = '<FebALEMonthlyInfoGrp>
												<TotalEmployeeCnt>'.$total_employee_count_feb.'</TotalEmployeeCnt>
											</FebALEMonthlyInfoGrp>';
				}
				else
				{
					$arr_total_employee_count[1] = '';
				}
				
			}			
			
			
			// mar value
			if(isset($part3->total_employee_count_mar_III)){
				$total_employee_count_mar = $part3->total_employee_count_mar_III;
				
				if(!empty($total_employee_count_mar)){
				$arr_total_employee_count[2] = '<MarALEMonthlyInfoGrp>
												<TotalEmployeeCnt>'.$total_employee_count_mar.'</TotalEmployeeCnt>
											</MarALEMonthlyInfoGrp>';
				}else
				{
					$arr_total_employee_count[2] = '';
				}
			}			
			
			
			// apr value
			if(isset($part3->total_employee_count_apr_III)){
				$total_employee_count_apr = $part3->total_employee_count_apr_III;
				if(!empty($total_employee_count_apr)){
				$arr_total_employee_count[3] = '<AprALEMonthlyInfoGrp>
												<TotalEmployeeCnt>'.$total_employee_count_apr.'</TotalEmployeeCnt>
											</AprALEMonthlyInfoGrp>';
				}else
				{
					$arr_total_employee_count[3] = '';
				}
			}			
			
			
			// may value
			if(isset($part3->total_employee_count_may_III)){
				$total_employee_count_may = $part3->total_employee_count_may_III;
				
				if(!empty($total_employee_count_may)){
				$arr_total_employee_count[4] = '<MayALEMonthlyInfoGrp>
												<TotalEmployeeCnt>'.$total_employee_count_may.'</TotalEmployeeCnt>
											</MayALEMonthlyInfoGrp>';
				}else
				{
					$arr_total_employee_count[4] = '';
				}
			}			
			
			
			// jun value
			if(isset($part3->total_employee_count_jun_III)){
				$total_employee_count_jun = $part3->total_employee_count_june_III;
				if(!empty($total_employee_count_jun)){
				$arr_total_employee_count[5] = '<JunALEMonthlyInfoGrp>
												<TotalEmployeeCnt>'.$total_employee_count_jun.'</TotalEmployeeCnt>
											</JunALEMonthlyInfoGrp>';
				}else
				{
					$arr_total_employee_count[5] = '';
				}
			}			
			
			
			// jul value
			if(isset($part3->total_employee_count_jul_III)){
				$total_employee_count_jul = $part3->total_employee_count_july_III;
				if(!empty($total_employee_count_jul)){
				$arr_total_employee_count[6] = '<JulALEMonthlyInfoGrp>
												<TotalEmployeeCnt>'.$total_employee_count_jul.'</TotalEmployeeCnt>
											</JulALEMonthlyInfoGrp>';
				}else
				{
					$arr_total_employee_count[6] = '';
				}
			}			
			
			
			// aug value
			if(isset($part3->total_employee_count_aug_III)){
				$total_employee_count_aug = $part3->total_employee_count_aug_III;
				
				if(!empty($total_employee_count_aug)){
				$arr_total_employee_count[7] = '<AugALEMonthlyInfoGrp>
												<TotalEmployeeCnt>'.$total_employee_count_aug.'</TotalEmployeeCnt>
											</AugALEMonthlyInfoGrp>';
				}else
				{
					$arr_total_employee_count[7] = '';
				}
			}			
			
			
			// sep value
			if(isset($part3->total_employee_count_sept_III)){
				$total_employee_count_sep = $part3->total_employee_count_sept_III;
				
				if(!empty($total_employee_count_sep)){
				$arr_total_employee_count[8] = '<SeptALEMonthlyInfoGrp>
												<TotalEmployeeCnt>'.$total_employee_count_sep.'</TotalEmployeeCnt>
											</SeptALEMonthlyInfoGrp>';
											
				}else
				{
					$arr_total_employee_count[8] = '';
				}
			}			
			
			
			// oct value
			if(isset($part3->total_employee_count_oct_III)){
				$total_employee_count_oct = $part3->total_employee_count_oct_III;
				
				if(!empty($total_employee_count_oct)){
				$arr_total_employee_count[9] = '<OctALEMonthlyInfoGrp>
												<TotalEmployeeCnt>'.$total_employee_count_oct.'</TotalEmployeeCnt>
											</OctALEMonthlyInfoGrp>';
											
				}else
				{
					$arr_total_employee_count[9] = '';
				}
			}			
			
			
			// nov value
			if(isset($part3->total_employee_count_nov_III)){
				$total_employee_count_nov = $part3->total_employee_count_nov_III;
				
				if(!empty($total_employee_count_nov)){
				$arr_total_employee_count[10] = '<NovALEMonthlyInfoGrp>
												<TotalEmployeeCnt>'.$total_employee_count_nov.'</TotalEmployeeCnt>
											</NovALEMonthlyInfoGrp>';
											
				}else
				{
					$arr_total_employee_count[10] = '';
				}
			}			
			
			
			// dec value
			if(isset($part3->total_employee_count_dec_III)){
				$total_employee_count_dec = $part3->total_employee_count_dec_III;
				if(!empty($total_employee_count_dec)){
				$arr_total_employee_count[11] = '<DecALEMonthlyInfoGrp>
												<TotalEmployeeCnt>'.$total_employee_count_dec.'</TotalEmployeeCnt>
											</DecALEMonthlyInfoGrp>';
											
				}else
				{
					$arr_total_employee_count[10] = '';
				}
			}			
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			/////////////////////////////////////////////////
			//getting 1094c 24-35 D values (preparing array)
			
			// jan value
			if(!empty($part3->aggregate_group_jan_III)){
				$aggregate_group_jan = $part3->aggregate_group_jan_III;
			}
			else{
				$aggregate_group_jan = 0;
			}
			$arr_aggrigated_grp_indicator[0] = '<JanAggregatedGroupInd>'.$aggregate_group_jan.'</JanAggregatedGroupInd>';
			
			// feb value
			if(!empty($part3->aggregate_group_feb_III)){
				$aggregate_group_feb = $part3->aggregate_group_feb_III;
			}
			else{
				$aggregate_group_feb = 0;
			}			
			$arr_aggrigated_grp_indicator[1] = '<FebAggregatedGroupInd>'.$aggregate_group_feb.'</FebAggregatedGroupInd>';
			
			// mar value
			if(!empty($part3->aggregate_group_mar_III)){
				$aggregate_group_mar = $part3->aggregate_group_mar_III;
			}
			else{
				$aggregate_group_mar = 0;
			}			
			$arr_aggrigated_grp_indicator[2] = '<MarAggregatedGroupInd>'.$aggregate_group_mar.'</MarAggregatedGroupInd>';
			
			// apr value
			if(!empty($part3->aggregate_group_apr_III)){
				$aggregate_group_apr = $part3->aggregate_group_apr_III;
			}
			else{
				$aggregate_group_apr = 0;
			}
			$arr_aggrigated_grp_indicator[3] = '<AprAggregatedGroupInd>'.$aggregate_group_apr.'</AprAggregatedGroupInd>';
			
			// may value
			if(!empty($part3->aggregate_group_may_III)){
				$aggregate_group_may = $part3->aggregate_group_may_III;
			}
			else{
				$aggregate_group_may = 0;
			}
			$arr_aggrigated_grp_indicator[4] = '<MayAggregatedGroupInd>'.$aggregate_group_may.'</MayAggregatedGroupInd>';
			
			// jun value
			if(!empty($part3->aggregate_group_jun_III)){
				$aggregate_group_jun = $part3->aggregate_group_jun_III;
			}
			else{
				$aggregate_group_jun = 0;
			}			
			$arr_aggrigated_grp_indicator[5] = '<JunAggregatedGroupInd>'.$aggregate_group_jun.'</JunAggregatedGroupInd>';
			
			// jul value
			if(!empty($part3->aggregate_group_jul_III)){
				$aggregate_group_jul = $part3->aggregate_group_jul_III;
			}
			else{
				$aggregate_group_jul = 0;
			}			
			$arr_aggrigated_grp_indicator[6] = '<JulAggregatedGroupInd>'.$aggregate_group_jul.'</JulAggregatedGroupInd>';
			
			// aug value
			if(!empty($part3->aggregate_group_aug_III)){
				$aggregate_group_aug = $part3->aggregate_group_aug_III;
			}
			else{
				$aggregate_group_aug = 0;
			}			
			$arr_aggrigated_grp_indicator[7] = '<AugAggregatedGroupInd>'.$aggregate_group_aug.'</AugAggregatedGroupInd>';
			
			// sep value
			if(!empty($part3->aggregate_group_sep_III)){
				$aggregate_group_sep = $part3->aggregate_group_sep_III;
			}
			else{
				$aggregate_group_sep = 0;
			}			
			$arr_aggrigated_grp_indicator[8] = '<SepAggregatedGroupInd>'.$aggregate_group_sep.'</SepAggregatedGroupInd>';			
			
			// oct value
			if(!empty($part3->aggregate_group_oct_III)){
				$aggregate_group_oct = $part3->aggregate_group_oct_III;
			}
			else{
				$aggregate_group_oct = 0;
			}			
			$arr_aggrigated_grp_indicator[9] = '<OctAggregatedGroupInd>'.$aggregate_group_oct.'</OctAggregatedGroupInd>';
			
			// nov value
			if(!empty($part3->aggregate_group_nov_III)){
				$aggregate_group_nov = $part3->aggregate_group_nov_III;
			}
			else{
				$aggregate_group_nov = 0;
			}			
			$arr_aggrigated_grp_indicator[10] = '<NovAggregatedGroupInd>'.$aggregate_group_nov.'</NovAggregatedGroupInd>';
			
			// dec value
			if(!empty($part3->aggregate_group_dec_III)){
				$aggregate_group_dec = $part3->aggregate_group_dec_III;
			}
			else{
				$aggregate_group_dec = 0;
			}			
			$arr_aggrigated_grp_indicator[11] = '<DecAggregatedGroupInd>'.$aggregate_group_dec.'</DecAggregatedGroupInd>';			
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			/////////////////////////////////////////////////
			//getting 1094c 24-35 E values (preparing array)
			
			// jan value
			if(!empty($part3->section_4980h_transition_jan_III)){
				$section_4980h_transition_jan = $part3->section_4980h_transition_jan_III;
				$arr_section_4980h_transition[0] = '<JanALESect4980HTrnstReliefCd>'.$section_4980h_transition_jan.'</JanALESect4980HTrnstReliefCd>';
			}
			
			// feb value
			if(!empty($part3->section_4980h_transition_feb_III)){
				$section_4980h_transition_feb = $part3->section_4980h_transition_feb_III;
				$arr_section_4980h_transition[1] = '<FebALESect4980HTrnstReliefCd>'.$section_4980h_transition_feb.'</FebALESect4980HTrnstReliefCd>';
			}
			
			// mar value
			if(!empty($part3->section_4980h_transition_mar_III)){
				$section_4980h_transition_mar = $part3->section_4980h_transition_mar_III;
				$arr_section_4980h_transition[2] = '<MarALESect4980HTrnstReliefCd>'.$section_4980h_transition_mar.'</MarALESect4980HTrnstReliefCd>';
			}
			
			// apr value
			if(!empty($part3->section_4980h_transition_apr_III)){
				$section_4980h_transition_apr = $part3->section_4980h_transition_apr_III;
				$arr_section_4980h_transition[3] = '<AprALESect4980HTrnstReliefCd>'.$section_4980h_transition_apr.'</AprALESect4980HTrnstReliefCd>';
			}
			
			// may value
			if(!empty($part3->section_4980h_transition_may_III)){
				$section_4980h_transition_may = $part3->section_4980h_transition_may_III;
				$arr_section_4980h_transition[4] = '<MayALESect4980HTrnstReliefCd>'.$section_4980h_transition_may.'</MayALESect4980HTrnstReliefCd>';
			}
			
			// jun value
			if(!empty($part3->section_4980h_transition_jun_III)){
				$section_4980h_transition_jun = $part3->section_4980h_transition_jun_III;
				$arr_section_4980h_transition[5] = '<JunALESect4980HTrnstReliefCd>'.$section_4980h_transition_jun.'</JunALESect4980HTrnstReliefCd>';
			}
			
			// jul value
			if(!empty($part3->section_4980h_transition_jul_III)){
				$section_4980h_transition_jul = $part3->section_4980h_transition_jul_III;
				$arr_section_4980h_transition[6] = '<JulALESect4980HTrnstReliefCd>'.$section_4980h_transition_jul.'</JulALESect4980HTrnstReliefCd>';
			}
			
			// aug value
			if(!empty($part3->section_4980h_transition_aug_III)){
				$section_4980h_transition_aug = $part3->section_4980h_transition_aug_III;
				$arr_section_4980h_transition[7] = '<AugALESect4980HTrnstReliefCd>'.$section_4980h_transition_aug.'</AugALESect4980HTrnstReliefCd>';
			}
			
			// sep value
			if(!empty($part3->section_4980h_transition_sep_III)){
				$section_4980h_transition_sep = $part3->section_4980h_transition_sep_III;
				$arr_section_4980h_transition[8] = '<SepALESect4980HTrnstReliefCd>'.$section_4980h_transition_sep.'</SepALESect4980HTrnstReliefCd>';
			}
			
			// oct value
			if(!empty($part3->section_4980h_transition_oct_III)){
				$section_4980h_transition_oct = $part3->section_4980h_transition_oct_III;
				$arr_section_4980h_transition[9] = '<OctALESect4980HTrnstReliefCd>'.$section_4980h_transition_oct.'</OctALESect4980HTrnstReliefCd>';
			}
			
			// nov value
			if(!empty($part3->section_4980h_transition_nov_III)){
				$section_4980h_transition_nov = $part3->section_4980h_transition_nov_III;
				$arr_section_4980h_transition[10] = '<NovALESect4980HTrnstReliefCd>'.$section_4980h_transition_nov.'</NovALESect4980HTrnstReliefCd>';
			}
			
			// dec value
			if(!empty($part3->section_4980h_transition_dec_III)){
				$section_4980h_transition_dec = $part3->section_4980h_transition_dec_III;
				$arr_section_4980h_transition[11] = '<DecALESect4980HTrnstReliefCd>'.$section_4980h_transition_dec.'</DecALESect4980HTrnstReliefCd>';
			}			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			//preparing array of other ALE members of aggrigated ALE Group
			for($i=36;$i<=65;$i++){
				$val = 'name_IV_'.$i;
				$ein_val = 'ein_IV_'.$i;
				if(!empty($part4->$val) || !empty($part4->$ein_val)){
									
					$other_ale_member .= '<OtherALEMembersGrp>';
										if(!empty($part4->$val)){
					$other_ale_member .=	'<BusinessName>
												<BusinessNameLine1Txt>'.$part4->$val.'</BusinessNameLine1Txt>
											</BusinessName>';
										}
					$other_ale_member .=	'<irs:TINRequestTypeCd>BUSINESS_TIN</irs:TINRequestTypeCd>';
					
										if(!empty($part4->$ein_val) && preg_replace ( '/[^0-9]/s', '', $part4->$ein_val )!= ''){
					$other_ale_member .= 	'<irs:EIN>'.preg_replace ( '/[^0-9]/s', '', $part4->$ein_val ).'</irs:EIN>';
										}
					$other_ale_member .= '</OtherALEMembersGrp>';
				}
			}
			
			/////// getting total 1095 records count
			$total_1095_count = TblAca1095::find()->where(['form_id'=>$form_id])->count();
			
			
			
			//assigning all values into an array
			//array is for 
			$params_array = array(
				'form_id'=>$form_id,
				'clean_ein'=>$clean_ein,
				'reporting_year'=>$reporting_year,
				'employer_name'=>$employer_name,
				'addressone'=>$addressone,
				'addresstwo'=>$addresstwo,
				'city'=>$city,
				'state'=>$state,
				'zip'=>$zip,
				'contact_first_name'=>$contact_first_name,
				'contact_middle_name'=>$contact_middle_name,
				'contact_last_name'=>$contact_last_name,
				'contact_suffix'=>$contact_suffix,
				'contact_phone'=>$clean_phone,
				'govt_entity_name'=>$govt_entity_name,
				'employer_ein'=>$employer_ein,
				'address_line_one'=>$address_line_one,
				'address_line_two'=>$address_line_two,
				'city_or_town_2_I'=>$city_or_town_2_I,
				'state_or_province_2_I'=>$state_or_province_2_I,
				'country_and_zip_2_I'=>$country_and_zip_2_I,
				'first_name_of_person_to_contact_2_I'=>$first_name_of_person_to_contact_2_I,
				'middle_name_of_person_to_contact_2_I'=>$middle_name_of_person_to_contact_2_I,
				'last_name_of_person_to_contact_2_I'=>$last_name_of_person_to_contact_2_I,
				'suffix_name_of_person_to_contact_2_I'=>$suffix_name_of_person_to_contact_2_I,
				'contact_telephone_number_2_I'=>$contact_telephone_number_2_I,
				'total_no_records_submitted'=>$total_no_records_submitted,
				'total_no_of_1095c_filled_II'=>$total_no_of_1095c_filled_II,
				'ale_member_check'=>$ale_member_check,
				'quality_offer_method'=>$quality_offer_method,
				'section_4980_transition'=>$section_4980_transition,
				'offer_method'=>$offer_method,
				'minimal_essential_coverage'=>$minimal_essential_coverage,
				'full_time_employee_count'=>$full_time_employee_count,
				'total_employee_count_for_ale_member'=>$total_employee_count_for_ale_member,
				'aggregate_group_all'=>$aggregate_group_all,
				'arr_minimal_essential_coverage'=>$arr_minimal_essential_coverage,
				'arr_total_employee_count'=>$arr_total_employee_count,
				'arr_aggrigated_grp_indicator'=>$arr_aggrigated_grp_indicator,
				'arr_section_4980h_transition'=>$arr_section_4980h_transition,
				'other_ale_member'=>$other_ale_member,
				'total_1095_count'=>$total_1095_count,
				'time'=>$time
			);
			
			// calling create data xml function			
			$create_data_xml = $this->createdataxml($params_array,$company_client_number);
			
			// calling create manifest xml function			
			if($create_data_xml == 'success'){
				$create_xml = $this->createmanifestxml($params_array,$company_client_number);
				
				// creating zip files
				if($create_xml == 'success'){
					$result = \Yii::$app->Sharefile->zipaDirectory ( getcwd () . '/files/xml/'.$company_client_number. '/', getcwd () . '/files/xml/' . $company_client_number . '.zip' );
					if ($result == 'success') {
						/**
						 * ** removing files & folders from server **
						*/
						exec ( 'rm -R ' . getcwd () . '/files/xml/'.$company_client_number );
						
						$imgData = file_get_contents(getcwd () . '/files/xml/'.$company_client_number. '.zip');
						
						/// update in table
						$sql = "UPDATE tbl_aca_forms SET xml_file='".addslashes($imgData)."' WHERE id=$form_id";

						Yii::$app->db->createCommand($sql)->execute();
						
						/**
						 * ** removing files  **
						*/
						exec ( 'rm ' . getcwd () . '/files/xml/'.$company_client_number .'.zip' );
						
					}
					
				}
				
			}	
			
		}
		
		} catch ( \Exception $e ) { // catching the exception
				
			$msg = $e->getMessage ().' at line no '.$e->getLine();
			
			$arrerror ['error_desc'] = $msg;
			$arrerror ['error_type'] = 5;

			if(!empty($company_id)){
				$arrerror ['company_id'] = $company_id;
			}
				
			// Below function saves exceptions if occurs
			$this->Saveerrors ( $arrerror );
		}
	}
	
	
		/***
	*Function is used for saving errors if any occurred in form creation, pdf generation, print & mail
	**/
	private function Saveerrors($arrerror) {
		$model_form_errors = new TblAcaFormErrors ();
		/**
		* transaction block for the sql transactions to the database
		*/
				
		$connection = \yii::$app->db;
				
		// starting the transaction
		$transaction = $connection->beginTransaction ();
		try {
			
			$model_form_errors->error_desc = $arrerror ['error_desc'];
			$model_form_errors->error_type = $arrerror ['error_type']; // error_type 1= 1094, 2=1095, 3=pdf generation, 4= print & mail,5=xml generate
			$model_form_errors->created_date = date ( 'Y-m-d H:i:s' );

			if(!empty($arrerror ['company_id'])){
			$model_form_errors->company_id = $arrerror ['company_id'];
			}
			
			if ($model_form_errors->validate () && $model_form_errors->save ()) {
				// commiting the model
				$transaction->commit ();
			}
		} catch ( \Exception $e ) { // catching the exception
			
			$e->getMessage ();
			// rollback transaction
			$transaction->rollback ();
		}
	}
	
	/////////////////////// function to create manifest file (1094)//////////////
	private function createmanifestxml($params_array,$company_client_number){
		
		// getting UUID
		$uuid = file_get_contents('https://www.uuidgenerator.net/api/version4');
		$val = array("\n","\r");
		$uuid = str_replace($val, "", $uuid);

		// getting current timestamp
		
		$time = $params_array['time'];
		$date = date('Ymd',$time);
		$h = date('H',$time);
		$i = date('i',$time);
		$s = date('s',$time);
		$current_date = date('Y-m-d',$time);
		$current_time = date('H:i:s',$time);
		$current_timestamp = $current_date.'T'.$current_time.'Z';

		//getting reporting year
		$reporting_year = trim($params_array['reporting_year']);		

		//getting 1094c company name (1)
		$company_name = trim($params_array['employer_name']);
		
		// getting company EIN (2)
		$company_ein = trim($params_array['clean_ein']);
		
		//getting 1094c address one (3.1)
		$address_one = trim($params_array['addressone']);
		
		//getting 1094c address two (3.2)
		$address_two = trim($params_array['addresstwo']);
		
		//getting 1094c city (4)
		$city = trim($params_array['city']);
		
		//getting 1094c state (5)
		$state = trim($params_array['state']);
		
		//getting 1094c zip (6)
		$zip = trim($params_array['zip']);
		
		//getting 1094c contact_first_name (7.1)
		$contact_first_name = trim($params_array['contact_first_name']);
		
		//getting 1094c contact_middle_name (7.2)
		$contact_middle_name = trim($params_array['contact_middle_name']);
		
		//getting 1094c contact_last_name (7.3)
		$contact_last_name = trim($params_array['contact_last_name']);
		
		//getting 1094c contact_suffix (7.4)
		$contact_suffix = trim($params_array['contact_suffix']);
		
		//getting 1094c contact_phone (8)
		$contact_phone = trim($params_array['contact_phone']);

		// getting payee record count (18)
		$payee_record_count = trim($params_array['total_no_records_submitted']);
		if($payee_record_count != ''){$payee_record_count = $payee_record_count; }
		else{$payee_record_count = 0;}

		// getting 1095c data file size
		/*$onezeroninefive_datafile_size = '';*/
		$onezeroninefive_datafile_size = filesize(getcwd().'/files/xml/'.$company_client_number.'/1094C_Request_BB2K6_'.$date.''.$time.'Z.xml');
		
		// getting unique md5 hash for ChecksumAugmentationNum
		
		$unique_hash = md5($time);

		$xmlString = '<ACAUIBusinessHeader xmlns:p4="urn:us:gov:treasury:irs:common" xmlns:p3="urn:us:gov:treasury:irs:ext:aca:air:ty16" xmlns:p2="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd" xmlns:p1="urn:us:gov:treasury:irs:msg:acabusinessheader" xsi:schemaLocation="urn:us:gov:treasury:irs:msg:acauibusinessheader IRS-ACAUserInterfaceHeaderMessage.xsd " xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="urn:us:gov:treasury:irs:msg:acauibusinessheader">
							<p1:ACABusinessHeader>
								<p3:UniqueTransmissionId>'.$uuid.':SYS12:BB2K6::T</p3:UniqueTransmissionId>
								<p4:Timestamp>'.$current_timestamp.'</p4:Timestamp>
							</p1:ACABusinessHeader>
							<p3:ACATransmitterManifestReqDtl>
								<p3:PaymentYr>'.$reporting_year.'</p3:PaymentYr>
								<p3:PriorYearDataInd>0</p3:PriorYearDataInd>
								<p4:EIN>'.$company_ein.'</p4:EIN>
								<p3:TransmissionTypeCd>O</p3:TransmissionTypeCd>
								<p3:TestFileCd>P</p3:TestFileCd>
								<p3:TransmitterNameGrp>
									<p3:BusinessNameLine1Txt>SKY INSURANCE TECHNOLOGIES LLC</p3:BusinessNameLine1Txt>
								</p3:TransmitterNameGrp>
								<p3:CompanyInformationGrp>
									<p3:CompanyNm>'.$company_name.'</p3:CompanyNm>
									<p3:MailingAddressGrp>
										<p3:USAddressGrp>';
											if($address_one !=''){
		$xmlString .= 						'<p3:AddressLine1Txt>'.$address_one.'</p3:AddressLine1Txt>';
											}
											if($address_two !=''){
		$xmlString .= 						'<p3:AddressLine2Txt>'.$address_two.'</p3:AddressLine2Txt>';
											}
											if($city !=''){
		$xmlString .= 						'<p4:CityNm>'.$city.'</p4:CityNm>';
											}
											if($state !=''){
		$xmlString .= 						'<p3:USStateCd>'.$state.'</p3:USStateCd>';
											}
											if($zip !=''){
		$xmlString .= 						'<p4:USZIPCd>'.$zip.'</p4:USZIPCd>';
											}									
		$xmlString .= 						'</p3:USAddressGrp>
									</p3:MailingAddressGrp>
									<p3:ContactNameGrp>';
										if($contact_first_name !=''){
		$xmlString .= 						'<p3:PersonFirstNm>'.$contact_first_name.'</p3:PersonFirstNm>';
										}
										if($contact_middle_name !=''){
		$xmlString .= 						'<p3:PersonMiddleNm>'.$contact_middle_name.'</p3:PersonMiddleNm>';
										}
										if($contact_last_name !=''){
		$xmlString .= 						'<p3:PersonLastNm>'.$contact_last_name.'</p3:PersonLastNm>';
										}
										if($contact_suffix !=''){
		$xmlString .= 						'<p3:SuffixNm>'.$contact_suffix.'</p3:SuffixNm>';
										}								
		$xmlString .= 				'</p3:ContactNameGrp>';
									if($contact_phone !=''){
		$xmlString .= 					'<p3:ContactPhoneNum>'.$contact_phone.'</p3:ContactPhoneNum>';
									}
		$xmlString .= 			'</p3:CompanyInformationGrp>
								<p3:VendorInformationGrp>
									<p3:VendorCd>I</p3:VendorCd>
									<p3:ContactNameGrp>
										<p3:PersonFirstNm>Jordan</p3:PersonFirstNm>
										<p3:PersonMiddleNm>O</p3:PersonMiddleNm>
										<p3:PersonLastNm>Smith</p3:PersonLastNm>
									</p3:ContactNameGrp>
									<p3:ContactPhoneNum>8886636503</p3:ContactPhoneNum>
								</p3:VendorInformationGrp>
								<p3:TotalPayeeRecordCnt>'.$payee_record_count.'</p3:TotalPayeeRecordCnt>
								<p3:TotalPayerRecordCnt>1</p3:TotalPayerRecordCnt>
								<p3:SoftwareId>15A0000123</p3:SoftwareId>
								<p3:FormTypeCd>1094/1095C</p3:FormTypeCd>
								<p4:BinaryFormatCd>application/xml</p4:BinaryFormatCd>
								<p4:ChecksumAugmentationNum>'.$unique_hash.'</p4:ChecksumAugmentationNum>
								<p4:AttachmentByteSizeNum>'.$onezeroninefive_datafile_size.'</p4:AttachmentByteSizeNum>';
								/*<p3:DocumentSystemFileNm>1094C_Request_BB2K6_'.$date.'T'.$h.''.$i.''.$s.'000Z.xml</p3:DocumentSystemFileNm>*/
		$xmlString .=			'<p3:DocumentSystemFileNm>1094C_Request_BB2K6_'.$date.''.$time.'Z.xml</p3:DocumentSystemFileNm>
							</p3:ACATransmitterManifestReqDtl>
						</ACAUIBusinessHeader>';
		//print_r($xmlString);die();
		$dom = new \DOMDocument();
		//$dom->preserveWhiteSpace = FALSE;
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($xmlString);
		
		
		// create folder
		if (!file_exists(getcwd().'/files/xml/'.$company_client_number)) {
			mkdir(getcwd().'/files/xml/'.$company_client_number, 0777, true);
		}
		//Save XML as a file
		if($dom->save(getcwd().'/files/xml/'.$company_client_number.'/Manifest_soapheader_P.xml')){
			return 'success';
		}
		else{
			return 'fail';
		}
	}	
	
	/////////// function to create data xml file ///////////
	private function createdataxml($params_array,$company_client_number){
		
		$time = $params_array['time'];
		$date = date('Ymd',$time);
		
		//getting form_id
		$form_id = trim($params_array['form_id']);
		
		//getting reporting year
		$reporting_year = trim($params_array['reporting_year']);
		
		//getting 1094c company name (1)
		$company_name = trim($params_array['employer_name']);
		
		// getting company EIN (2)
		$company_ein = trim($params_array['clean_ein']);
		
		//getting 1094c address one (3.1)
		$address_one = trim($params_array['addressone']);
		
		//getting 1094c address two (3.2)
		$address_two = trim($params_array['addresstwo']);
		
		//getting 1094c city (4)
		$city = trim($params_array['city']);
		
		//getting 1094c state (5)
		$state = trim($params_array['state']);
		
		//getting 1094c zip (6)
		$zip = trim($params_array['zip']);
		
		//getting 1094c contact_first_name (7.1)
		$contact_first_name = trim($params_array['contact_first_name']);
		
		//getting 1094c contact_middle_name (7.2)
		$contact_middle_name = trim($params_array['contact_middle_name']);
		
		//getting 1094c contact_last_name (7.3)
		$contact_last_name = trim($params_array['contact_last_name']);
		
		//getting 1094c contact_suffix (7.4)
		$contact_suffix = trim($params_array['contact_suffix']);
		
		//getting 1094c contact_phone (8)
		$contact_phone = trim($params_array['contact_phone']);
		
		//getting 1094c govt_entity_name (9)
		$govt_entity_name = trim($params_array['govt_entity_name']);
		
		//getting 1094c employer_ein (10)
		$employer_ein = trim($params_array['employer_ein']);
		
		//getting 1094c govt_entity_name (11.1)
		$address_line_one = trim($params_array['address_line_one']);
		
		//getting 1094c govt_entity_name (11.2)
		$address_line_two = trim($params_array['address_line_two']);
		
		//getting 1094c govt_city (12)
		$govt_city = trim($params_array['city_or_town_2_I']);
		
		//getting 1094c govt_state (13)
		$govt_state = trim($params_array['state_or_province_2_I']);
		
		//getting 1094c govt_zip (14)
		$govt_zip = trim($params_array['country_and_zip_2_I']);
		
		//getting 1094c person_first_name (15.1)
		$person_first_name = trim($params_array['first_name_of_person_to_contact_2_I']);
		
		//getting 1094c person_middle_name (15.2)
		$person_middle_name = trim($params_array['middle_name_of_person_to_contact_2_I']);
		
		//getting 1094c person_last_name (15.3)
		$person_last_name = trim($params_array['last_name_of_person_to_contact_2_I']);
		
		//getting 1094c person_suffix_name (15.4)
		$person_suffix_name = trim($params_array['suffix_name_of_person_to_contact_2_I']);
		
		//getting 1094c person_phone (16)
		$person_phone = trim($params_array['contact_telephone_number_2_I']);
		
		// getting 1094payee record count (18)
		$payee_record_count = trim($params_array['total_no_records_submitted']);
		if($payee_record_count != ''){$payee_record_count = $payee_record_count; }
		else{$payee_record_count = 0;}
		
		// getting 1094 filled record count (20)
		$filled_record_count = trim($params_array['total_no_of_1095c_filled_II']);
		
		// getting 1094 ale_member_check (21)
		$ale_member_check = trim($params_array['ale_member_check']);
		
		// getting 1094 quality_offer_method (22A)
		$quality_offer_method = trim($params_array['quality_offer_method']);
		
		// getting 1094 section_4980_transition (22C)
		$section_4980_transition = trim($params_array['section_4980_transition']);
		
		// getting 1094 offer_method (22D)
		$offer_method = trim($params_array['offer_method']);
		
		// getting 1094 offer_method (23A)
		$minimal_essential_coverage = trim($params_array['minimal_essential_coverage']);
		
		// getting 1094 section 4980 (23B)
		$full_time_employee_count_for_ale_member = trim($params_array['full_time_employee_count']);
		
		// getting 1094 total employee count for ale member (23C)
		$total_employee_count_for_ale_member = trim($params_array['total_employee_count_for_ale_member']);
		
		// getting 1094 aggregate_group_indecator (23D)
		$aggregate_group_indicator = trim($params_array['aggregate_group_all']);
		
		// getting 1094 array of minimum essential cover offered (24A-35A)
		$arr_minimal_essential_coverage = $params_array['arr_minimal_essential_coverage'];
		
		// getting 1094 array of total employee count for ALE member (24C-35C)
		$arr_total_employee_count = $params_array['arr_total_employee_count'];
		
		// getting 1094 array of aggregated grp count (24D-35D)
		$arr_aggrigated_grp_indicator = $params_array['arr_aggrigated_grp_indicator'];
		
		// getting 1094 array of Section 4980H Transition Relief Indicator (24E-35E)
		$arr_section_4980h_transition = $params_array['arr_section_4980h_transition'];
		
		// getting total 1095 forms count
		$_1095_count = $params_array['total_1095_count'];
		
		$other_ale_member = trim($params_array['other_ale_member']);
		
		
		
		
		$xmlString = '<n1:Form109495CTransmittalUpstream xmlns="urn:us:gov:treasury:irs:ext:aca:air:ty16" xmlns:irs="urn:us:gov:treasury:irs:common" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:n1="urn:us:gov:treasury:irs:msg:form1094-1095Ctransmitterupstreammessage" xsi:schemaLocation="urn:us:gov:treasury:irs:msg:form1094-1095Ctransmitterupstreammessage IRS-Form1094-1095CTransmitterUpstreamMessage.xsd">
						<Form1094CUpstreamDetail recordType="String" lineNum="0">
							<SubmissionId>1</SubmissionId>
							<TaxYr>'.$reporting_year.'</TaxYr>
							<CorrectedInd>0</CorrectedInd>
							<EmployerInformationGrp>
								<BusinessName>
									<BusinessNameLine1Txt>'.$company_name.'</BusinessNameLine1Txt>
								</BusinessName>
								<irs:TINRequestTypeCd>BUSINESS_TIN</irs:TINRequestTypeCd>
								<irs:EmployerEIN>'.$company_ein.'</irs:EmployerEIN>
								<MailingAddressGrp>
									<USAddressGrp>';
								if($address_one !=''){
		$xmlString .= 					'
										<AddressLine1Txt>'.$address_one.'</AddressLine1Txt>';
								}
								if($address_two !=''){
		$xmlString .= 					'
										<AddressLine2Txt>'.$address_two.'</AddressLine2Txt>';
								}
								if($city !=''){
		$xmlString .= 					'
										<irs:CityNm>'.$city.'</irs:CityNm>';
								}
								if($state !=''){
		$xmlString .= 					'
										<USStateCd>'.$state.'</USStateCd>';
								}
								if($zip !=''){
		$xmlString .= 					'
										<irs:USZIPCd>'.$zip.'</irs:USZIPCd>';
								}								
		$xmlString .=				'</USAddressGrp>
								</MailingAddressGrp>
								<ContactNameGrp>';
							if($contact_first_name !=''){
		$xmlString .= 				'
									<PersonFirstNm>'.$contact_first_name.'</PersonFirstNm>';
							}
							if($contact_middle_name !=''){
		$xmlString .= 				'
									<PersonMiddleNm>'.$contact_middle_name.'</PersonMiddleNm>';
							}
							if($contact_last_name !=''){
		$xmlString .= 				'
									<PersonLastNm>'.$contact_last_name.'</PersonLastNm>';
							}
							if($contact_suffix !=''){
		$xmlString .= 				'
									<SuffixNm>'.$contact_suffix.'</SuffixNm>';
							}							
		$xmlString .=			'</ContactNameGrp>';
						if($contact_phone !=''){
		$xmlString .= 			'
								<ContactPhoneNum>'.$contact_phone.'</ContactPhoneNum>';
						}
		$xmlString .=		'</EmployerInformationGrp>';					  
					  
					if($govt_entity_name!='' || $employer_ein!='')  {					  
		$xmlString .=		'<GovtEntityEmployerInfoGrp>
								<BusinessName>
									<BusinessNameLine1Txt>'.$govt_entity_name.'</BusinessNameLine1Txt>
								</BusinessName>
								<BusinessNameControlTxt>BUSI</BusinessNameControlTxt>
								<irs:TINRequestTypeCd>BUSINESS_TIN</irs:TINRequestTypeCd>';
							if($employer_ein !=''){
		$xmlString .=			'<irs:EmployerEIN>'.$employer_ein.'</irs:EmployerEIN>
								<MailingAddressGrp>
									<USAddressGrp>';
							}
								if($address_line_one !=''){
		$xmlString .= 					'
										<AddressLine1Txt>'.$address_line_one.'</AddressLine1Txt>';
								}
								if($address_line_two !=''){
		$xmlString .= 					'
										<AddressLine2Txt>'.$address_line_two.'</AddressLine2Txt>';
								}
								if($govt_city !=''){
		$xmlString .= 					'
										<irs:CityNm>'.$govt_city.'</irs:CityNm>';
								}
								if($govt_state !=''){
		$xmlString .= 					'
										<USStateCd>'.$govt_state.'</USStateCd>';
								}
								if($govt_zip !=''){
		$xmlString .= 					'
										<irs:USZIPCd>'.$govt_zip.'</irs:USZIPCd>';
								}
									
		$xmlString .=				'</USAddressGrp>
								</MailingAddressGrp>
								<ContactNameGrp>';
							if($person_first_name !=''){
		$xmlString .= 				'
									<PersonFirstNm>'.$person_first_name.'</PersonFirstNm>';
							}
							if($person_middle_name !=''){
		$xmlString .= 				'
									<PersonMiddleNm>'.$person_middle_name.'</PersonMiddleNm>';
							}
							if($person_last_name !=''){
		$xmlString .= 				'
									<PersonLastNm>'.$person_last_name.'</PersonLastNm>';
							}
							if($person_suffix_name !=''){
		$xmlString .= 				'
									<SuffixNm>'.$person_suffix_name.'</SuffixNm>';
							}
		$xmlString .=			'</ContactNameGrp>';
							if($person_phone !=''){
		$xmlString .= 			'
								<ContactPhoneNum>'.$person_phone.'</ContactPhoneNum>';
						}					 
		$xmlString .=		'</GovtEntityEmployerInfoGrp>';		
					}
					
		$xmlString .=		'<Form1095CAttachedCnt>'.$payee_record_count.'</Form1095CAttachedCnt>
							<AuthoritativeTransmittalInd>1</AuthoritativeTransmittalInd>';
							
							
							if(!empty($filled_record_count))
							{
		$xmlString .=		'<TotalForm1095CALEMemberCnt>'.$filled_record_count.'</TotalForm1095CALEMemberCnt>';
							}
		
		
		$xmlString .=		'<AggregatedGroupMemberCd>'.$ale_member_check.'</AggregatedGroupMemberCd>
							<QualifyingOfferMethodInd>'.$quality_offer_method.'</QualifyingOfferMethodInd>
							<Section4980HReliefInd>'.$section_4980_transition.'</Section4980HReliefInd>
							<NinetyEightPctOfferMethodInd>'.$offer_method.'</NinetyEightPctOfferMethodInd>
						
						
							<ALEMemberInformationGrp>
								<YearlyALEMemberDetail>
									<MinEssentialCvrOffrCd>'.$minimal_essential_coverage.'</MinEssentialCvrOffrCd>';
								if($full_time_employee_count_for_ale_member!=''){
		$xmlString .=				'<ALEMemberFTECnt>'.$full_time_employee_count_for_ale_member.'</ALEMemberFTECnt>';
								}
								if($total_employee_count_for_ale_member!=''){
		$xmlString .=				'<TotalEmployeeCnt>'.$total_employee_count_for_ale_member.'</TotalEmployeeCnt>';
								}
		$xmlString .=				'<AggregatedGroupInd>'.$aggregate_group_indicator.'</AggregatedGroupInd>
								</YearlyALEMemberDetail>';
						/*for($i=0;$i<12;$i++){
							if(!empty($arr_minimal_essential_coverage[$i])){
		$xmlString .=			$arr_minimal_essential_coverage[$i];
							}
						}*/
						for($i=0;$i<12;$i++){	
							if(!empty($arr_total_employee_count[$i])){
		$xmlString .=			$arr_total_employee_count[$i];
							}
						}
						/*for($i=0;$i<12;$i++){
							if(!empty($arr_aggrigated_grp_indicator[$i])){
		$xmlString .=			$arr_aggrigated_grp_indicator[$i];
							}
						}*/
						for($i=0;$i<12;$i++){
							if(!empty($arr_section_4980h_transition[$i])){
		$xmlString .=			$arr_section_4980h_transition[$i];
							}
						}
		$xmlString .=		'</ALEMemberInformationGrp>';
		
		$xmlString .=	$other_ale_member;
		
		
		$xmlString .= $this->getindividual1095details($form_id, $reporting_year);
		
		$xmlString .=	'</Form1094CUpstreamDetail>
					</n1:Form109495CTransmittalUpstream>';

		$dom = new \DOMDocument();
		//$dom->preserveWhiteSpace = FALSE;
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($xmlString);

		// create folder
		if (!file_exists(getcwd().'/files/xml/'.$company_client_number)) {
			mkdir(getcwd().'/files/xml/'.$company_client_number, 0777, true);
		}
		
		//Save XML as a file 1094C_Request_BB2K6_<date><timestamp>Z​
		if($dom->save(getcwd().'/files/xml/'.$company_client_number.'/1094C_Request_BB2K6_'.$date.''.$time.'Z.xml')){
			return 'success';
		}
		else{
			return 'fail';
		}
	}
	 
	
	////////// function to get individual 1095 details //////////////
	function getindividual1095details($form_id, $reporting_year){
	
		/////// getting total 1095 records 
		$total_1095_records = TblAca1095::find()->where(['form_id'=>$form_id])->All();
		$individual_count=1;
		$xmlString = '';
		
		
		foreach($total_1095_records as $total_records){
			
			// getting 1094c data
			$new_part4 = array();	
			//$new_part3 = array();
			//part 1
			$unserialise_data_part1 = unserialize ( $total_records->serialise_data1 );
			$part1 = json_decode ( $unserialise_data_part1 );
				
			//part 2
			$unserialise_data_part2 = unserialize ( $total_records->serialise_data2 );
			$part2 = json_decode ( $unserialise_data_part2 );
					//print_r($part2->plan_start_month__II);die();			
				 
			//part 3
			$unserialise_data_part3 = unserialize ( $total_records->serialise_data3 );
			$part3 = json_decode ( $unserialise_data_part3 );
			
			//part 4
			$unserialise_data_part4 = unserialize ( $total_records->xml_data );
			$part4 = json_decode ( $unserialise_data_part4 );
			
			if(!empty($part4))
			{
				$new_part4 = (array)$part4;
			}
			
			$xmlString .= '
							<Form1095CUpstreamDetail recordType="String" lineNum="0">
								<RecordId>'.$individual_count.'</RecordId>
								<CorrectedInd>0</CorrectedInd>
								<TaxYr>'.$reporting_year.'</TaxYr>
								<EmployeeInfoGrp>
									<OtherCompletePersonName>';
									if(isset($part4->first_name__1)&&$part4->first_name__1 !=''){
			$xmlString .=				'<PersonFirstNm>'.trim($part4->first_name__1).'</PersonFirstNm>';
									}
									//$part1->employee_middle_name__I = 'ranjith';
									if(isset($part4->middle_name__1)&&$part4->middle_name__1 !=''){
			$xmlString .=				'<PersonMiddleNm>'.trim($part4->middle_name__1).'</PersonMiddleNm>';
									}
									//$part1->employee_last_name__I = 'ranjith';
									if(isset($part4->last_name__1)&&$part4->last_name__1 !=''){
			$xmlString .=				'<PersonLastNm>'.trim($part4->last_name__1).'</PersonLastNm>';
									}
									//$part1->employee_suffix__I = 'ranjith';
									if(isset($part4->suffix__1)&&$part4->suffix__1 !=''){
			$xmlString .=				'<SuffixNm>'.trim($part4->suffix__1).'</SuffixNm>';
									}
			$xmlString .=			'</OtherCompletePersonName>
									<irs:TINRequestTypeCd>INDIVIDUAL_TIN</irs:TINRequestTypeCd>
									<irs:SSN>'.preg_replace ( '/[^0-9]/s', '', $part1->employee_ssn__I ).'</irs:SSN>
									<MailingAddressGrp>
										<USAddressGrp>';
										if(isset($part4->street_address_1__3)&&$part4->street_address_1__3 !=''){
			$xmlString .= 					'<AddressLine1Txt>'.trim($part4->street_address_1__3).'</AddressLine1Txt>';
										}
										//$part1->employee_street_Address__I_two = 'ranjith';
										if(isset($part4->street_address_1__3)&&$part4->street_address_2__3 !=''){
			$xmlString .= 					'<AddressLine2Txt>'.trim($part4->street_address_2__3).'</AddressLine2Txt>';
										}
										if($part1->employee_city_or_town__I !=''){
			$xmlString .= 					'<irs:CityNm>'.trim($part1->employee_city_or_town__I).'</irs:CityNm>';
										}
										if($part1->employee_state_province__I !=''){
			$xmlString .= 					'<USStateCd>'.trim($part1->employee_state_province__I).'</USStateCd>';
										}
										if($part1->employee_country_and_zip_code__I !=''){
			$xmlString .= 					'<irs:USZIPCd>'.trim($part1->employee_country_and_zip_code__I).'</irs:USZIPCd>';
										}
			$xmlString .='				</USAddressGrp>
									</MailingAddressGrp>
								</EmployeeInfoGrp>';
							if($part1->employer_contact_telephone_number__I !=''){
			$xmlString .= 		'<ALEContactPhoneNum>'.preg_replace ( '/[^0-9\']/', '',  $part1->employer_contact_telephone_number__I).'</ALEContactPhoneNum>';
							}
							if(!empty($part2->plan_start_month__II)){
			$xmlString .=		'<StartMonthNumberCd>'.$part2->plan_start_month__II.'</StartMonthNumberCd>';
							}
			$xmlString .=		'<EmployeeOfferAndCoverageGrp>';
								if(!empty($part2->offer_of_coverage_all_12_months__II)){
			$xmlString .=			'<AnnualOfferOfCoverageCd>'.$part2->offer_of_coverage_all_12_months__II.'</AnnualOfferOfCoverageCd>';
								}
								else{
			$xmlString .=			'<MonthlyOfferCoverageGrp>';
									if(!empty($part2->offer_of_coverage_jan__II)){
			$xmlString .=				'<JanOfferCd>'.$part2->offer_of_coverage_jan__II.'</JanOfferCd>';			
									}
									if(!empty($part2->offer_of_coverage_feb__II)){
			$xmlString .=				'<FebOfferCd>'.$part2->offer_of_coverage_feb__II.'</FebOfferCd>';			
									}
									if(!empty($part2->offer_of_coverage_march__II)){
			$xmlString .=				'<MarOfferCd>'.$part2->offer_of_coverage_march__II.'</MarOfferCd>';			
									}
									if(!empty($part2->offer_of_coverage_april__II)){
			$xmlString .=				'<AprOfferCd>'.$part2->offer_of_coverage_april__II.'</AprOfferCd>';			
									}
									if(!empty($part2->offer_of_coverage_may__II)){
			$xmlString .=				'<MayOfferCd>'.$part2->offer_of_coverage_may__II.'</MayOfferCd>';			
									}
									if(!empty($part2->offer_of_coverage_june__II)){
			$xmlString .=				'<JunOfferCd>'.$part2->offer_of_coverage_june__II.'</JunOfferCd>';			
									}
									if(!empty($part2->offer_of_coverage_july__II)){
			$xmlString .=				'<JulOfferCd>'.$part2->offer_of_coverage_july__II.'</JulOfferCd>';			
									}
									if(!empty($part2->offer_of_coverage_august__II)){
			$xmlString .=				'<AugOfferCd>'.$part2->offer_of_coverage_august__II.'</AugOfferCd>';			
									}
									if(!empty($part2->offer_of_coverage_september__II)){
			$xmlString .=				'<SepOfferCd>'.$part2->offer_of_coverage_september__II.'</SepOfferCd>';			
									}
									if(!empty($part2->offer_of_coverage_october__II)){
			$xmlString .=				'<OctOfferCd>'.$part2->offer_of_coverage_october__II.'</OctOfferCd>';			
									}
									if(!empty($part2->offer_of_coverage_november__II)){
			$xmlString .=				'<NovOfferCd>'.$part2->offer_of_coverage_november__II.'</NovOfferCd>';			
									}
									if(!empty($part2->offer_of_coverage_december__II)){
			$xmlString .=				'<DecOfferCd>'.$part2->offer_of_coverage_december__II.'</DecOfferCd>';			
									}
										
			$xmlString .=			'</MonthlyOfferCoverageGrp>';
								}
								if(!empty($part2->employee_required_contributions_all_12_months__II)){
			$xmlString .=			'<AnnlShrLowestCostMthlyPremAmt>'.$part2->employee_required_contributions_all_12_months__II.'</AnnlShrLowestCostMthlyPremAmt>';
								}
								else{
			$xmlString .=			'<MonthlyShareOfLowestCostMonthlyPremGrp>';
									if(!empty($part2->employee_required_contributions_jan__II)){
			$xmlString .=				'<JanuaryAmt>'.$part2->employee_required_contributions_jan__II.'</JanuaryAmt>';
									}
									if(!empty($part2->employee_required_contributions_feb__II)){
			$xmlString .=				'<FebruaryAmt>'.$part2->employee_required_contributions_feb__II.'</FebruaryAmt>';
									}
									if(!empty($part2->employee_required_contributions_march__II)){
			$xmlString .=				'<MarchAmt>'.$part2->employee_required_contributions_march__II.'</MarchAmt>';
									}
									if(!empty($part2->employee_required_contributions_april__II)){
			$xmlString .=				'<AprilAmt>'.$part2->employee_required_contributions_april__II.'</AprilAmt>';
									}
									if(!empty($part2->employee_required_contributions_may__II)){
			$xmlString .=				'<MayAmt>'.$part2->employee_required_contributions_may__II.'</MayAmt>';
									}
									if(!empty($part2->employee_required_contributions_june__II)){
			$xmlString .=				'<JuneAmt>'.$part2->employee_required_contributions_june__II.'</JuneAmt>';
									}
									if(!empty($part2->employee_required_contributions_july__II)){
			$xmlString .=				'<JulyAmt>'.$part2->employee_required_contributions_july__II.'</JulyAmt>';
									}
									if(!empty($part2->employee_required_contributions_august__II)){
			$xmlString .=				'<AugustAmt>'.$part2->employee_required_contributions_august__II.'</AugustAmt>';
									}
									if(!empty($part2->employee_required_contributions_september__II)){
			$xmlString .=				'<SeptemberAmt>'.$part2->employee_required_contributions_september__II.'</SeptemberAmt>';
									}
									if(!empty($part2->employee_required_contributions_october__II)){
			$xmlString .=				'<OctoberAmt>'.$part2->employee_required_contributions_october__II.'</OctoberAmt>';
									}
									if(!empty($part2->employee_required_contributions_november__II)){
			$xmlString .=				'<NovemberAmt>'.$part2->employee_required_contributions_november__II.'</NovemberAmt>';
									}
									if(!empty($part2->employee_required_contributions_december__II)){
			$xmlString .=				'<DecemberAmt>'.$part2->employee_required_contributions_december__II.'</DecemberAmt>';
									}								
										
			$xmlString .=			'</MonthlyShareOfLowestCostMonthlyPremGrp>';
								}
								if(!empty($part2->section_4980h_safe_harbor_all_12_months__II)){
			$xmlString .=			'<AnnualSafeHarborCd>'.$part2->section_4980h_safe_harbor_all_12_months__II.'</AnnualSafeHarborCd>';
								}
								else{
			$xmlString .=			'<MonthlySafeHarborGrp>';
									if(!empty($part2->section_4980h_safe_harbor_jan__II)){
			$xmlString .=				'<JanSafeHarborCd>'.$part2->section_4980h_safe_harbor_jan__II.'</JanSafeHarborCd>';
									}
									if(!empty($part2->section_4980h_safe_harbor_feb__II)){
			$xmlString .=				'<FebSafeHarborCd>'.$part2->section_4980h_safe_harbor_feb__II.'</FebSafeHarborCd>';
									}
									if(!empty($part2->section_4980h_safe_harbor_march__II)){
			$xmlString .=				'<MarSafeHarborCd>'.$part2->section_4980h_safe_harbor_march__II.'</MarSafeHarborCd>';
									}
									if(!empty($part2->section_4980h_safe_harbor_april__II)){
			$xmlString .=				'<AprSafeHarborCd>'.$part2->section_4980h_safe_harbor_april__II.'</AprSafeHarborCd>';
									}
									if(!empty($part2->section_4980h_safe_harbor_may__II)){
			$xmlString .=				'<MaySafeHarborCd>'.$part2->section_4980h_safe_harbor_may__II.'</MaySafeHarborCd>';
									}
									if(!empty($part2->section_4980h_safe_harbor_june__II)){
			$xmlString .=				'<JunSafeHarborCd>'.$part2->section_4980h_safe_harbor_june__II.'</JunSafeHarborCd>';
									}
									if(!empty($part2->section_4980h_safe_harbor_july__II)){
			$xmlString .=				'<JulSafeHarborCd>'.$part2->section_4980h_safe_harbor_july__II.'</JulSafeHarborCd>';
									}
									if(!empty($part2->section_4980h_safe_harbor_august__II)){
			$xmlString .=				'<AugSafeHarborCd>'.$part2->section_4980h_safe_harbor_august__II.'</AugSafeHarborCd>';
									}
									if(!empty($part2->section_4980h_safe_harbor_september__II)){
			$xmlString .=				'<SepSafeHarborCd>'.$part2->section_4980h_safe_harbor_september__II.'</SepSafeHarborCd>';
									}
									if(!empty($part2->section_4980h_safe_harbor_october__II)){
			$xmlString .=				'<OctSafeHarborCd>'.$part2->section_4980h_safe_harbor_october__II.'</OctSafeHarborCd>';
									}
									if(!empty($part2->section_4980h_safe_harbor_november__II)){
			$xmlString .=				'<NovSafeHarborCd>'.$part2->section_4980h_safe_harbor_november__II.'</NovSafeHarborCd>';
									}
									if(!empty($part2->section_4980h_safe_harbor_december__II)){
			$xmlString .=				'<DecSafeHarborCd>'.$part2->section_4980h_safe_harbor_december__II.'</DecSafeHarborCd>';
									}										
			$xmlString .=			'</MonthlySafeHarborGrp>';
								}					
			$xmlString .=		'</EmployeeOfferAndCoverageGrp>';
							if(!empty($part3->employer_self_insured__III) && $part3->employer_self_insured__III == 1){
			$xmlString .=		'<CoveredIndividualInd>1</CoveredIndividualInd>';
							}
							else{
			$xmlString .=		'<CoveredIndividualInd>0</CoveredIndividualInd>';
							}
										
							for($i=17;$i<=34;$i++){
						
								$name_of_covered_individual = 'section_2__'.$i;
								
								if(!empty($new_part4[$name_of_covered_individual][0]->first_name) && !empty($new_part4[$name_of_covered_individual][0]->last_name)){
			$xmlString .=		'<CoveredIndividualGrp>';
			$xmlString .=			'<CoveredIndividualName>';
									
									if(!empty($new_part4[$name_of_covered_individual][0]->first_name)){
			$xmlString .=				'<PersonFirstNm>'.trim($new_part4[$name_of_covered_individual][0]->first_name).'</PersonFirstNm>';
									}
									
									if(!empty($new_part4[$name_of_covered_individual][0]->middle_name)){
			$xmlString .=				'<PersonMiddleNm>'.trim($new_part4[$name_of_covered_individual][0]->middle_name).'</PersonMiddleNm>';
									}
									
									if(!empty($new_part4[$name_of_covered_individual][0]->last_name)){
			$xmlString .=				'<PersonLastNm>'.trim($new_part4[$name_of_covered_individual][0]->last_name).'</PersonLastNm>';
									}
									
									if(!empty($new_part4[$name_of_covered_individual][0]->suffix)){
			$xmlString .=				'<SuffixNm>'.trim($new_part4[$name_of_covered_individual][0]->suffix).'</SuffixNm>';
									}	
			$xmlString .=			'</CoveredIndividualName>';
								
			$xmlString .=			'<irs:TINRequestTypeCd>INDIVIDUAL_TIN</irs:TINRequestTypeCd>';
								$ssn_ind = 'name_'.$i.'_ssn__III';
								if(!empty($part3->$ssn_ind)){
			$xmlString .=			'<irs:SSN>'.preg_replace ( '/[^0-9\']/', '', $part3->$ssn_ind).'</irs:SSN>';
								}
								$dob_ind = 'name_'.$i.'_dob__III';
								if(!empty($part3->$dob_ind)){
			$xmlString .=			'<BirthDt>'.date('Y-m-d',strtotime($part3->$dob_ind)).'</BirthDt>';
								}
								$all_12_months_ind = 'name_'.$i.'_all_12_months__III';
								if(!empty($part3->$all_12_months_ind) && $part3->$all_12_months_ind == 1){
			$xmlString .=			'<CoveredIndividualAnnualInd>1</CoveredIndividualAnnualInd>';
								}
								else{
			$xmlString .=			'<CoveredIndividualMonthlyIndGrp>';
									$all_12_jan__III = 'name_'.$i.'_jan__III';
									if(!empty($part3->$all_12_jan__III) && $part3->$all_12_jan__III == 1){
			$xmlString .=				'<JanuaryInd>1</JanuaryInd>';			
									}
									else{
			$xmlString .=				'<JanuaryInd>0</JanuaryInd>';						
									}
									$all_12_feb__III = 'name_'.$i.'_feb__III';
									if(!empty($part3->$all_12_feb__III) && $part3->$all_12_feb__III == 1){
			$xmlString .=				'<FebruaryInd>1</FebruaryInd>';			
									}
									else{
			$xmlString .=				'<FebruaryInd>0</FebruaryInd>';						
									}
									$all_12_mar__III = 'name_'.$i.'_march__III';
									if(!empty($part3->$all_12_mar__III) && $part3->$all_12_mar__III == 1){
			$xmlString .=				'<MarchInd>1</MarchInd>';			
									}
									else{
			$xmlString .=				'<MarchInd>0</MarchInd>';						
									}
									$all_12_apr__III = 'name_'.$i.'_april__III';
									if(!empty($part3->$all_12_apr__III) && $part3->$all_12_apr__III == 1){
			$xmlString .=				'<AprilInd>1</AprilInd>';			
									}
									else{
			$xmlString .=				'<AprilInd>0</AprilInd>';						
									}
									$all_12_may__III = 'name_'.$i.'_may__III';
									if(!empty($part3->$all_12_may__III) && $part3->$all_12_may__III == 1){
			$xmlString .=				'<MayInd>1</MayInd>';			
									}
									else{
			$xmlString .=				'<MayInd>0</MayInd>';						
									}
									$all_12_jun__III = 'name_'.$i.'_june__III';
									if(!empty($part3->$all_12_jun__III) && $part3->$all_12_jun__III == 1){
			$xmlString .=				'<JuneInd>1</JuneInd>';			
									}
									else{
			$xmlString .=				'<JuneInd>0</JuneInd>';						
									}
									$all_12_jul__III = 'name_'.$i.'_july__III';									
									if(!empty($part3->$all_12_jul__III) && $part3->$all_12_jul__III == 1){
			$xmlString .=				'<JulyInd>1</JulyInd>';			
									}
									else{
			$xmlString .=				'<JulyInd>0</JulyInd>';						
									}
									$all_12_aug__III = 'name_'.$i.'_august__III';
									if(!empty($part3->$all_12_aug__III) && $part3->$all_12_aug__III == 1){
			$xmlString .=				'<AugustInd>1</AugustInd>';			
									}
									else{
			$xmlString .=				'<AugustInd>0</AugustInd>';						
									}
									$all_12_sep__III = 'name_'.$i.'_september__III';
									if(!empty($part3->$all_12_sep__III) && $part3->$all_12_sep__III == 1){
			$xmlString .=				'<SeptemberInd>1</SeptemberInd>';			
									}
									else{
			$xmlString .=				'<SeptemberInd>0</SeptemberInd>';						
									}
									$all_12_oct__III = 'name_'.$i.'_october__III';
									if(!empty($part3->$all_12_oct__III) && $part3->$all_12_oct__III == 1){
			$xmlString .=				'<OctoberInd>1</OctoberInd>';			
									}
									else{
			$xmlString .=				'<OctoberInd>0</OctoberInd>';						
									}
									$all_12_nov__III = 'name_'.$i.'_november__III';
									if(!empty($part3->$all_12_nov__III) && $part3->$all_12_nov__III == 1){
			$xmlString .=				'<NovemberInd>1</NovemberInd>';			
									}
									else{
			$xmlString .=				'<NovemberInd>0</NovemberInd>';						
									}
									$all_12_dec__III = 'name_'.$i.'_december__III';
									if(!empty($part3->$all_12_dec__III) && $part3->$all_12_dec__III == 1){
			$xmlString .=				'<DecemberInd>1</DecemberInd>';			
									}
									else{
			$xmlString .=				'<DecemberInd>0</DecemberInd>';						
									}									
										
			$xmlString .=			'</CoveredIndividualMonthlyIndGrp>';
								}
								
			$xmlString .=		'</CoveredIndividualGrp>';
							}
			
								
							}
									
																	
			$xmlString .=	'</Form1095CUpstreamDetail>';
			
			$individual_count++;
		}
		
		return $xmlString;	
	}

	/**
	*
	* Function to download xml file from db if exists
	* File is saved in db in BLOB
	**/
	
	public function actionDownloadxml()
	{
		$session = \Yii::$app->session;
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$result = array();
			$post_details = yii::$app->request->post();
			$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
			try{
				
				if(!empty($post_details['form_id']))
				{
					$form_id = $post_details['form_id'];
					$model_companies = new TblAcaCompanies ();
					
					$check_file = TblAcaForms::find()->select('xml_file, company_id')->where(['id'=>$form_id])->One();
					$check_company_details = $model_companies->Companyuniquedetails ( $check_file->company_id );
					
					if(!empty($check_file))
					{
					
						if(empty($check_file->xml_file))
						{
							
							
							/*$result['success'] = 'Downloading...';
							
							file_put_contents(''.getcwd () . '/files/xml/downloadxml/'.$check_company_details->company_client_number.'.zip', $check_file->xml_file);
							
							$filepath = 'files/xml/downloadxml/'.$check_company_details->company_client_number.'.zip';
							
							if(file_exists($filepath))
							{
								$result ['filepath'] =  '/'.$filepath; 
								
								
							}
							else
							{
								throw new \Exception ('File not found');
								
							}*/
							throw new \Exception ( 'Xml creation is in process. Please come back after some time');

						
						}else
						{
							$result['success'] = 'Downloading...';
							//throw new \Exception ( 'Xml creation is in process. Please come back after some time');
							
						}
					}
					else
					{
						throw new \Exception ( 'Invalid form selected');
						
					}
					
					
					
					
				}
				else
				{
					throw new Exception ( 'No value posted');
					
				}
			
			} catch ( \Exception $e ) { // any \Exceptions catch throws error msg
				$msg = $e->getMessage ();
			
				$result['error'] = $msg;
				$transaction->rollback();	
				
			}
			
			return (json_encode($result));
			
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
		
	}
	
	/**
	*
	* Function to download zip file from db if exists
	* File is saved in db in BLOB (calling from ajax)
	**/
	public function actionZipdownload(){
		if(isset($_GET['form_id']) && $_GET['form_id']!=''){
			$form_id = $_GET['form_id'];
			$model_companies = new TblAcaCompanies ();
			
			$check_file = TblAcaForms::find()->select('xml_file, company_id')->where(['id'=>$form_id])->One();
			$check_company_details = $model_companies->Companyuniquedetails ( $check_file->company_id );
			
			$filedata = $check_file->xml_file;
			
			header("Content-type:application/zip");
			header("Content-length: ".strlen($filedata));
			header("Content-disposition: download; filename=$check_company_details->company_client_number.zip"); //disposition of download forces a download
			echo $filedata; 
		}
	}
	
		/**
			 * *************** action to generate csv****************
		*/
		public function actionGeneratecsv(){
	//	ini_set('memory_limit', '-1');
		ini_set ( 'memory_limit', '1024M' );
		ini_set ( 'max_execution_time', 3600 );
		ini_set ( 'max_input_time', 3600 );
		/**
			 * *************** initialising variables****************
		*/
		
    	$name_of_employer_1 = '';
    	$name_of_employer_2 = '';
    	$street_address_1='';
    	$street_address_2='';
    	$city='';
    	$state='';
        $ssnumber='';
    	$zip_ext='';
    	$phone_ext='';
    	$employeezipext = '';
    	$employeeemail = '';
    	$miscsearch = '';
		$planstartmonth='';
		$employeeemail='';
		$employeezip='';
		$employeestate='';
		$employeecity='';
		$employeeaddress2='';
		$employeeaddress1='';
		$lastname='';
		$middlename='';
		$firstname='';
		$employeelastname='';
		$employeemiddlename='';
		$employeefirstname='';
		$ssn='';
		$ein='';
		$phone_ext='';
		$phone_number='';
		$zip_ext='';
		$zip_code='';
		$state='';
		$city='';
		$street_address_2='';
		$street_address_1='';
		$name_of_employer_2='';
		$name_of_employer_1='';
    	
		
    	$arrayPart1 = array();
    	$arrOffercoverage =array();
    	$arrEmployeeshare =array();
    	$arrSafehabour =array();
    	$arrCoveredindividual =array();
		$array = array();
	
		try{
		/**
			 * *************** getting approved forms****************
		*/
    	$model_acaforms = TblAcaForms::find()->select('id,company_id')->where(['is_approved'=>1])->andWhere(['csv_file'=>NULL])->All();	
    	
    
    	foreach($model_acaforms as $forms){ 
    		
			/**
			 * *************** getting all the forms with this form id****************
	     	*/
    		$model_1095c = TblAca1095::find()->where(['form_id'=>$forms->id])->all();
		   
			if(!empty($model_1095c)){
				$company_id = $forms->company_id;
				foreach($model_1095c as $form){
					
					$serialised_data_1 = $form->serialise_data1;
					$serialised_data_2 = $form->serialise_data2;
					$serialised_data_3 = $form->serialise_data3;
					$serialised_data_xml = $form->xml_data;
					
					
					//part 1
					if(!empty($serialised_data_1)){
						$unserialise_data_part1 = unserialize ( $serialised_data_1 );
						$part1 = json_decode ( $unserialise_data_part1 );
					}
					else{
						$part1 = array();
					}
					
						
					//part 2
					if(!empty($serialised_data_2)){
						$unserialise_data_part2 = unserialize ( $serialised_data_2 );
						$part2 = json_decode ( $unserialise_data_part2 );
					}
					else{
						$part2 = array();
					}
						
					//part 3
					if(!empty($serialised_data_3)){
						$unserialise_data_part3 = unserialize ( $serialised_data_3 );
						$part3 = json_decode ( $unserialise_data_part3 );
					}
					else{
						$part3 = array();
					}
						
				
					//part xml       
					if(!empty($serialised_data_xml)){
						$unserialise_data_part_xml = unserialize ( $serialised_data_xml );
						$partxml = json_decode ( $unserialise_data_part_xml );
					}
					else{
						$partxml = array();
					}
					
					if(!empty($partxml))
					{
						$new_part4 = (array)$partxml;
					}
					//getting employer_name
					if(!empty($part1->employer_name__I)){
						$name_of_employer_1 = $part1->employer_name__I;
					}
					
					//getting street_address
					if(!empty($partxml->street_address_1__9)){
						$street_address_1 = $partxml->street_address_1__9;
					}
					
					//getting street_address
					if(!empty($partxml->street_address_2__9)){
						$street_address_2 = $partxml->street_address_2__9;
					}
					
					//getting employer_city_town
					if(!empty($part1->employer_city_town__I)){
						$city = $part1->employer_city_town__I;
					}
					//getting employer_state_province
					if(!empty($part1->employer_state_province__I)){
						$state = $part1->employer_state_province__I;
					}
					//getting employer_country_and_zip
					if(!empty($part1->employer_country_and_zip__I)){
						$zip_code = $part1->employer_country_and_zip__I;
					}
					
					//getting employer_contact_telephone_number__I
					if(!empty($part1->employer_contact_telephone_number__I)){
						$phone_number = $part1->employer_contact_telephone_number__I;
					}
					
					//getting ein
					if(!empty($part1->employer_ein__I)){
						$ein = $part1->employer_ein__I;
					}
					
					//getting ssn
					if(!empty($part1->employee_ssn__I)){
						$ssnumber = $part1->employee_ssn__I;
					}
					
					//getting firstname
					if(!empty($partxml->first_name__1)){
						$employeefirstname = $partxml->first_name__1;
					}
					
					//getting middle initial
					if(!empty($partxml->middle_name__1)){
						$employeemiddlename = $partxml->middle_name__1;
					}
					
					//getting last name
					if(!empty($partxml->last_name__1)){
						$employeelastname = $partxml->last_name__1;
					}
					
					//getting employyee address
					if(!empty($partxml->street_address_1__3)){
						$employeeaddress1 = $partxml->street_address_1__3;
					}
					
					//getting employyee address
					if(!empty($partxml->street_address_2__3)){
						$employeeaddress2 = $partxml->street_address_2__3;
					}
					
					//getting employyee city
					if(!empty($part1->employee_city_or_town__I)){
						$employeecity = $part1->employee_city_or_town__I;
					}
					
					//getting employyee state
					if(!empty($part1->employee_state_province__I)){
						$employeestate = $part1->employee_state_province__I;
					}
					
					//getting employyee zip
					if(!empty($part1->employee_country_and_zip_code__I)){
						$employeezip = $part1->employee_country_and_zip_code__I;
					}
					
					
						
						//getting employyee zip
						if(!empty($part2->plan_start_month__II)){
							$planstartmonth = $part2->plan_start_month__II;
						}
						
						
						//getting employee line14
						if(!empty($part2->offer_of_coverage_all_12_months__II)){
							$month_all12month =$part2->offer_of_coverage_all_12_months__II;
							$arrOffercoverage['all_12_months_offer_of_coverage']=$month_all12month;
						}else{
							$arrOffercoverage['all_12_months_offer_of_coverage']='';
							if(!empty($part2->offer_of_coverage_jan__II)){
								$month_jan =$part2->offer_of_coverage_jan__II;
								$arrOffercoverage['jan_offer_of_coverage']=$month_jan;
							}else{
								$arrOffercoverage['jan_offer_of_coverage']='';
							}
							if(!empty($part2->offer_of_coverage_feb__II)){
								$month_feb =$part2->offer_of_coverage_feb__II;
								$arrOffercoverage['feb_offer_of_coverage']=$month_feb;
							}else{
								$arrOffercoverage['feb_offer_of_coverage']='';
							}
							if(!empty($part2->offer_of_coverage_march__II)){
								$month_mar =$part2->offer_of_coverage_march__II;
								$arrOffercoverage['mar_offer_of_coverage']=$month_mar;
							}else{
								$arrOffercoverage['mar_offer_of_coverage']='';
							}
							if(!empty($part2->offer_of_coverage_april__II)){
								$month_apr =$part2->offer_of_coverage_april__II;
								$arrOffercoverage['apr_offer_of_coverage']=$month_apr;
							}else{
								$arrOffercoverage['apr_offer_of_coverage']='';
							}
							if(!empty($part2->offer_of_coverage_may__II)){
								$month_may =$part2->offer_of_coverage_may__II;
								$arrOffercoverage['may_offer_of_coverage']=$month_may;
							}else{
								$arrOffercoverage['may_offer_of_coverage']='';
							}
							if(!empty($part2->offer_of_coverage_june__II)){
								$month_jun =$part2->offer_of_coverage_june__II;
								$arrOffercoverage['jun_offer_of_coverage']=$month_jun;
							}else{
								$arrOffercoverage['jun_offer_of_coverage']='';
							}
							if(!empty($part2->offer_of_coverage_july__II)){
								$month_jul =$part2->offer_of_coverage_july__II;
								$arrOffercoverage['jul_offer_of_coverage']=$month_jul;
							}else{
								$arrOffercoverage['jul_offer_of_coverage']='';
							}
							if(!empty($part2->offer_of_coverage_august__II)){
								$month_aug =$part2->offer_of_coverage_august__II;
								$arrOffercoverage['aug_offer_of_coverage']=$month_aug;
							}else{
								$arrOffercoverage['aug_offer_of_coverage']='';
							}
							if(!empty($part2->offer_of_coverage_september__II)){
								$month_sep =$part2->offer_of_coverage_september__II;
								$arrOffercoverage['sep_offer_of_coverage']=$month_sep;
							}else{
								$arrOffercoverage['sep_offer_of_coverage']='';
							}
						   if(!empty($part2->offer_of_coverage_october__II)){
								$month_oct =$part2->offer_of_coverage_october__II;
								$arrOffercoverage['oct_offer_of_coverage']=$month_oct;
							}else{
								$arrOffercoverage['oct_offer_of_coverage']='';
							}
						   if(!empty($part2->offer_of_coverage_november__II)){
								$month_nov =$part2->offer_of_coverage_november__II;
								$arrOffercoverage['nov_offer_of_coverage']=$month_nov;
							}else{
								$arrOffercoverage['nov_offer_of_coverage']='';
							}
						   if(!empty($part2->offer_of_coverage_december__II)){
								$month_dec =$part2->offer_of_coverage_december__II;
								$arrOffercoverage['dec_offer_of_coverage']=$month_dec;
							}else{
								$arrOffercoverage['dec_offer_of_coverage']='';
							}
							
						}
						
						//getting employee line15
						if(!empty($part2->employee_required_contributions_all_12_months__II)){
							$month_all12month15 =$part2->employee_required_contributions_all_12_months__II;
							$arrEmployeeshare['employee_share_for_all_12_months']=$month_all12month15;
						}else{
							$arrEmployeeshare['employee_share_for_all_12_months']='';
							if(!empty($part2->employee_required_contributions_jan__II)){
								$month_jan15 =$part2->employee_required_contributions_jan__II;
								$arrEmployeeshare['employee_share_for_jan']=$month_jan15;
							}else{
								$arrEmployeeshare['employee_share_for_jan']='';
							}
							if(!empty($part2->employee_required_contributions_feb__II)){
							$month_feb15 =$part2->employee_required_contributions_feb__II;
							$arrEmployeeshare['employee_share_for_feb']=$month_feb15;
							}else{
							$arrEmployeeshare['employee_share_for_feb']='';	
							}
							if(!empty($part2->employee_required_contributions_march__II)){
							$month_mar15 =$part2->employee_required_contributions_march__II;
							$arrEmployeeshare['employee_share_for_mar']=$month_mar15;
							}else{
							$arrEmployeeshare['employee_share_for_mar']='';	
							}
							if(!empty($part2->employee_required_contributions_april__II)){
							$month_apr15 =$part2->employee_required_contributions_april__II;
							$arrEmployeeshare['employee_share_for_apr']=$month_apr15;
							}else{
							$arrEmployeeshare['employee_share_for_apr']='';	
							}
							if(!empty($part2->employee_required_contributions_may__II)){
							$month_may15 =$part2->employee_required_contributions_may__II;
							$arrEmployeeshare['employee_share_for_may']=$month_may15;
							}else{
							$arrEmployeeshare['employee_share_for_may']='';	
							}
							if(!empty($part2->employee_required_contributions_june__II)){
							$month_jun15 =$part2->employee_required_contributions_june__II;
							$arrEmployeeshare['employee_share_for_jun']=$month_jun15;
							}else{
							$arrEmployeeshare['employee_share_for_jun']='';	
							}
							if(!empty($part2->employee_required_contributions_july__II)){
							$month_jul15 =$part2->employee_required_contributions_july__II;
							$arrEmployeeshare['employee_share_for_jul']=$month_jul15;
							}else{
							$arrEmployeeshare['employee_share_for_jul']='';	
							}
							if(!empty($part2->employee_required_contributions_august__II)){
							$month_aug15 =$part2->employee_required_contributions_august__II;
							$arrEmployeeshare['employee_share_for_aug']=$month_aug15;
							}else{
							$arrEmployeeshare['employee_share_for_aug']='';	
							}
							if(!empty($part2->employee_required_contributions_september__II)){
							$month_sep15 =$part2->employee_required_contributions_september__II;
							$arrEmployeeshare['employee_share_for_sep']=$month_sep15;
							}else{
							$arrEmployeeshare['employee_share_for_sep']='';	
							}
							if(!empty($part2->employee_required_contributions_october__II)){
							$month_oct15 =$part2->employee_required_contributions_october__II;
							$arrEmployeeshare['employee_share_for_oct']=$month_oct15;
							}else{
							$arrEmployeeshare['employee_share_for_oct']='';	
							}
							if(!empty($part2->employee_required_contributions_november__II)){
							$month_nov15 =$part2->employee_required_contributions_november__II;
							$arrEmployeeshare['employee_share_for_nov']=$month_nov15;
							}else{
							$arrEmployeeshare['employee_share_for_nov']='';	
							}
							if(!empty($part2->employee_required_contributions_december__II)){
							$month_dec15 =$part2->employee_required_contributions_december__II;
							$arrEmployeeshare['employee_share_for_dec']=$month_dec15;
							}else{
							$arrEmployeeshare['employee_share_for_dec']='';	
							}
						}
						
						//getting employee line16
						if(!empty($part2->section_4980h_safe_harbor_all_12_months__II)){
							$month_all12month16 =$part2->section_4980h_safe_harbor_all_12_months__II;
							$arrSafehabour['safe_harbor_code_for_all_12_months']=$month_all12month16;
						}else{
							$arrSafehabour['safe_harbor_code_for_all_12_months']='';
							if(!empty($part2->section_4980h_safe_harbor_jan__II)){
								$month_jan16 =$part2->section_4980h_safe_harbor_jan__II;
								$arrSafehabour['safe_harbor_code_for_jan']=$month_jan16;
							}else{
								$arrSafehabour['safe_harbor_code_for_jan']='';
							}
							if(!empty($part2->section_4980h_safe_harbor_feb__II)){
								$month_feb16 =$part2->section_4980h_safe_harbor_feb__II;
								$arrSafehabour['safe_harbor_code_for_feb']=$month_feb16;
							}else{
								$arrSafehabour['safe_harbor_code_for_feb']='';
							}
							if(!empty($part2->section_4980h_safe_harbor_march__II)){
								$month_mar16 =$part2->section_4980h_safe_harbor_march__II;
								$arrSafehabour['safe_harbor_code_for_mar']=$month_mar16;
							}else{
								$arrSafehabour['safe_harbor_code_for_mar']='';
							}
							if(!empty($part2->section_4980h_safe_harbor_april__II)){
								$month_apr16 =$part2->section_4980h_safe_harbor_april__II;
								$arrSafehabour['safe_harbor_code_for_apr']=$month_apr16;
							}else{
								$arrSafehabour['safe_harbor_code_for_apr']='';
							}
							if(!empty($part2->section_4980h_safe_harbor_may__II)){
								$month_may16 =$part2->section_4980h_safe_harbor_may__II;
								$arrSafehabour['safe_harbor_code_for_may']=$month_may16;
							}else{
								$arrSafehabour['safe_harbor_code_for_may']='';
							}
							if(!empty($part2->section_4980h_safe_harbor_june__II)){
								$month_jun16 =$part2->section_4980h_safe_harbor_june__II;
								$arrSafehabour['safe_harbor_code_for_jun']=$month_jun16;
							}else{
								$arrSafehabour['safe_harbor_code_for_jun']='';
							}
							if(!empty($part2->section_4980h_safe_harbor_july__II)){
								$month_jul16 =$part2->section_4980h_safe_harbor_july__II;
								$arrSafehabour['safe_harbor_code_for_jul']=$month_jul16;
							}else{
								$arrSafehabour['safe_harbor_code_for_jul']='';
							}
							if(!empty($part2->section_4980h_safe_harbor_august__II)){
								$month_aug16 =$part2->section_4980h_safe_harbor_august__II;
								$arrSafehabour['safe_harbor_code_for_aug']=$month_aug16;
							}else{
								$arrSafehabour['safe_harbor_code_for_aug']='';
							}
							if(!empty($part2->section_4980h_safe_harbor_september__II)){
								$month_sep16 =$part2->section_4980h_safe_harbor_september__II;
								$arrSafehabour['safe_harbor_code_for_sep']=$month_sep16;
							}else{
								$arrSafehabour['safe_harbor_code_for_sep']='';
							}
							if(!empty($part2->section_4980h_safe_harbor_october__II)){
								$month_oct16 =$part2->section_4980h_safe_harbor_october__II;
								$arrSafehabour['safe_harbor_code_for_oct']=$month_oct16;
							}else{
								$arrSafehabour['safe_harbor_code_for_oct']='';
							}
							if(!empty($part2->section_4980h_safe_harbor_november__II)){
								$month_nov16 =$part2->section_4980h_safe_harbor_november__II;
								$arrSafehabour['safe_harbor_code_for_nov']=$month_nov16;
							}else{
								$arrSafehabour['safe_harbor_code_for_nov']='';
							}
							if(!empty($part2->section_4980h_safe_harbor_december__II)){
								$month_dec16 =$part2->section_4980h_safe_harbor_december__II;
								$arrSafehabour['safe_harbor_code_for_dec']=$month_dec16;
							}else{
								$arrSafehabour['safe_harbor_code_for_dec']='';
							}
							
						}
						
				/**
				 * *************** for part 3 from 17 to 34****************
					*/
						if(!empty($part3->employer_self_insured__III) && $part3->employer_self_insured__III == '1' ){
							$covered_individual =$part3->employer_self_insured__III;
							$covered_individual_text = 'true';
							
							for($i=17,$j=1;$i<=34;$i++,$j++){
							
								$name_of_covered_individual = 'section_2__'.$i;
								if(!empty($new_part4[$name_of_covered_individual][0]->first_name)){
									$firstname = trim($new_part4[$name_of_covered_individual][0]->first_name);
									$arrCoveredindividual['first_name(a'.$j.')']=$firstname;
								}else{
									$arrCoveredindividual['first_name(a'.$j.')']='';
								}
								if(!empty($new_part4[$name_of_covered_individual][0]->last_name)){
									$lastname = trim($new_part4[$name_of_covered_individual][0]->last_name);
									$arrCoveredindividual['last_name(a'.$j.')']=$lastname;
								}else{
									$arrCoveredindividual['last_name(a'.$j.')']='';
								}
								if(!empty($new_part4[$name_of_covered_individual][0]->middle_name)){
									$middlename = trim($new_part4[$name_of_covered_individual][0]->middle_name);
									$arrCoveredindividual['middle_initial(a'.$j.')']=$middlename;
								}else{
									$arrCoveredindividual['middle_initial(a'.$j.')']='';
								}
								if(!empty($new_part4[$name_of_covered_individual][0]->suffix)){
									$suffix = trim($new_part4[$name_of_covered_individual][0]->suffix);
									$arrCoveredindividual['suffix(a'.$j.')']=$suffix;
								}else{
									$arrCoveredindividual['suffix(a'.$j.')']='';
								}
								
								$ssn = 'name_'.$i.'_ssn__III';
								
								if(!empty($part3->$ssn)){
									$ssn = $part3->$ssn;
									$arrCoveredindividual['individual_ssn(b'.$j.')']=$ssn;
								}else{
									$arrCoveredindividual['individual_ssn(b'.$j.')']='';
								}
								$dob = 'name_'.$i.'_dob__III';
								if(!empty($part3->$dob)){
									$dob = $part3->$dob;
									$arrCoveredindividual['dob(c'.$j.')']=$dob;
								}else{
									$arrCoveredindividual['dob(c'.$j.')']='';
								}
								$months_coverage = 'name_'.$i.'_all_12_months__III';
								$months_jan = 'name_'.$i.'_jan__III';
								$months_feb = 'name_'.$i.'_feb__III';
								$months_mar = 'name_'.$i.'_march__III';
								$months_apr = 'name_'.$i.'_april__III';
								$months_may = 'name_'.$i.'_may__III';
								$months_jun = 'name_'.$i.'_june__III';
								$months_jul = 'name_'.$i.'_july__III';
								$months_aug = 'name_'.$i.'_august__III';
								$months_sep = 'name_'.$i.'_september__III';
								$months_oct = 'name_'.$i.'_october__III';
								$months_nov = 'name_'.$i.'_november__III';
								$months_dec = 'name_'.$i.'_december__III';
						
								if(!empty($part3->$months_coverage) && $part3->$months_coverage == '1'){
									$month_all12month =$part3->$months_coverage;
									$arrCoveredindividual['covered_12_months(d'.$j.')']=$month_all12month;
								}else{
									$arrCoveredindividual['covered_12_months(d'.$j.')']='';
									if(!empty($part3->$months_jan)){
										$month_jan =$part3->$months_jan;
										$arrCoveredindividual['jan(e'.$j.')']=$month_jan;
									}else{
										$arrCoveredindividual['jan(e'.$j.')']='';
									}
									if(!empty($part3->$months_feb)){
										$month_feb =$part3->$months_feb;
										$arrCoveredindividual['feb(e'.$j.')']=$month_feb;
									}else{
										$arrCoveredindividual['feb(e'.$j.')']='';
									}
									if(!empty($part3->$months_mar)){
										$month_mar =$part3->$months_mar;
										$arrCoveredindividual['mar(e'.$j.')']=$month_mar;
									}else{
										$arrCoveredindividual['mar(e'.$j.')']='';
									}
									if(!empty($part3->$months_apr)){
										$month_apr =$part3->$months_apr;
										$arrCoveredindividual['apr(e'.$j.')']=$month_apr;
									}else{
										$arrCoveredindividual['apr(e'.$j.')']='';
									}
									if(!empty($part3->$months_may)){
										$month_may =$part3->$months_may;
										$arrCoveredindividual['may(e'.$j.')']=$month_may;
									}else{
										$arrCoveredindividual['may(e'.$j.')']='';
									}
									if(!empty($part3->$months_jun)){
										$month_jun =$part3->$months_jun;
										$arrCoveredindividual['jun(e'.$j.')']=$month_jun;
									}else{
										$arrCoveredindividual['jun(e'.$j.')']='';
									}
									if(!empty($part3->$months_jul)){
										$month_jul =$part3->$months_jul;
										$arrCoveredindividual['jul(e'.$j.')']=$month_jul;
									}else{
										$arrCoveredindividual['jul(e'.$j.')']='';
									}
									if(!empty($part3->$months_aug)){
										$month_aug =$part3->$months_aug;
										$arrCoveredindividual['aug(e'.$j.')']=$month_aug;
									}else{
										$arrCoveredindividual['aug(e'.$j.')']='';
									}
									if(!empty($part3->$months_sep)){
										$month_sep =$part3->$months_sep;
										$arrCoveredindividual['sep(e'.$j.')']=$month_sep;
									}
									if(!empty($part3->$months_oct)){
										$month_oct =$part3->$months_oct;
										$arrCoveredindividual['oct(e'.$j.')']=$month_oct;
									}else{
										$arrCoveredindividual['oct(e'.$j.')']='';
									}
									if(!empty($part3->$months_nov)){
										$month_nov =$part3->$months_nov;
										$arrCoveredindividual['nov(e'.$j.')']=$month_nov;
									}else{
										$arrCoveredindividual['nov(e'.$j.')']='';
									}
									if(!empty($part3->$months_dec)){
										$month_dec =$part3->$months_dec;
										$arrCoveredindividual['dec(e'.$j.')']=$month_dec;
									}else{
										$arrCoveredindividual['dec(e'.$j.')']='';
									}
									
									
								}
							}
						}else{
							
							$covered_individual_text = 'false';
							
						for($j=1;$j<=17;$j++){
							$arrCoveredindividual['first_name(a'.$j.')']='';
							$arrCoveredindividual['suffix(a'.$j.')']='';
							$arrCoveredindividual['middle_initial(a'.$j.')']='';
							$arrCoveredindividual['last_name(a'.$j.')']='';
							$arrCoveredindividual['individual_ssn(b'.$j.')']='';
							$arrCoveredindividual['dob(c'.$j.')']='';
							$arrCoveredindividual['covered_12_months(d'.$j.')']='';
							$arrCoveredindividual['jan(e'.$j.')']='';
							$arrCoveredindividual['feb(e'.$j.')']='';
							$arrCoveredindividual['mar(e'.$j.')']='';
							$arrCoveredindividual['apr(e'.$j.')']='';
							$arrCoveredindividual['may(e'.$j.')']='';
							$arrCoveredindividual['jun(e'.$j.')']='';
							$arrCoveredindividual['jul(e'.$j.')']='';
							$arrCoveredindividual['aug(e'.$j.')']='';
							$arrCoveredindividual['sep(e'.$j.')']='';
							$arrCoveredindividual['oct(e'.$j.')']='';
							$arrCoveredindividual['nov(e'.$j.')']='';
							$arrCoveredindividual['dec(e'.$j.')']='';
							
						}
						//unset ($arrCoveredindividual);
						}
					
					$array1 = array(
							'name_of_employer_1'=>$name_of_employer_1,
							'name_of_employer_2'=>$name_of_employer_2,
							'employer_address_1'=>$street_address_1,
							'employer_address_2'=>$street_address_2,
							'employer_city'=>$city,
							'employer_state'=>$state,
							'employer_zip'=>$zip_code,
							'employer_zip_ext'=>$zip_ext,
							'contact_phone'=>$phone_number,
							'contact_phone_ext'=>$phone_ext,
							'employer_identification_number'=>$ein,
							'employee_social_security_number'=>$ssnumber,
							'employee_first_name'=>$employeefirstname,
							'employee_middle_initial'=>$employeemiddlename,
							'employee_last_name'=>$employeelastname,
							'employee_address_1'=>$employeeaddress1,
							'employee_address_2'=>$employeeaddress2,
							'employee_city'=>$employeecity,
							'employee_state'=>$employeestate,
							'employee_zip'=>$employeezip,
							'employee_zip_ext'=>$employeezipext,
							'employee_email'=>$employeeemail,
							'misc_search'=>$miscsearch,
							'plan_start_month'=>$planstartmonth,
							'covered_individual_checkbox'=>$covered_individual_text,
							'foreign_state_number'=>'',
							'foreign_postal_code'=>'',
							'country_code'=>'',
							'foreign_address_indicator'=>''
							
					);
				
					$array_all = array_merge($array1,$arrOffercoverage,$arrEmployeeshare,$arrSafehabour,$arrCoveredindividual);
					$array[] = $array_all;
					
				}
			}
    	 
    		$exporter = new CsvGrid([
    				'dataProvider' => new ArrayDataProvider([
    						'allModels' =>$array,
    						]),
    				'columns' => [
    				[
    				'attribute' => 'name_of_employer_1',
    				],
    				[
    				'attribute' => 'name_of_employer_2',
    				],
    				[
    				'attribute' => 'employer_address_1',
    				],
    				[
    				'attribute' => 'employer_address_2',
    				],
    				[
    				'attribute' => 'employer_city',
    				],
    				[
    				'attribute' => 'employer_state',
    				],
    				[
    				'attribute' => 'employer_zip',
    				],
    				[
    				'attribute' => 'employer_zip_ext',
    				],
    				[
    				'attribute' => 'contact_phone',
    				],
    				[
    				'attribute' => 'contact_phone_ext',
    				],
    				[
    				'attribute' => 'employer_identification_number',
    				],
    				[
    				'attribute' => 'employee_social_security_number',
    				],
    				[
    				'attribute' => 'employee_first_name',
    				],
    				[
    				'attribute' => 'employee_middle_initial',
    				],
    				[
    				'attribute' => 'employee_last_name',
    				],
    				[
    				'attribute' => 'employee_address_1',
    				],
    				[
    				'attribute' => 'employee_address_2',
    				],
    				[
    				'attribute' => 'employee_city',
    				],
    				[
    				'attribute' => 'employee_state',
    				],
    				[
    				'attribute' => 'employee_zip',
    				],
    				[
    				'attribute' => 'employee_zip_ext',
    				],
    				[
    				'attribute' => 'employee_email',
    				],
    				[
    				'attribute' => 'misc_search',
    				],
    				[
    				'attribute' => 'plan_start_month',
    				],
    				[
    				'attribute' => 'all_12_months_offer_of_coverage',
    				],
    				[
    				'attribute' => 'jan_offer_of_coverage',
    				],
    				[
    				'attribute' => 'feb_offer_of_coverage',
    				],
    				[
    				'attribute' => 'mar_offer_of_coverage',
    				],
    				[
    				'attribute' => 'apr_offer_of_coverage',
    				],
    				[
    				'attribute' => 'may_offer_of_coverage',
    				],
    				[
    				'attribute' => 'jun_offer_of_coverage',
    				],
    				[
    				'attribute' => 'jul_offer_of_coverage',
    				],
    				[
    				'attribute' => 'aug_offer_of_coverage',
    				],
    				[
    				'attribute' => 'sep_offer_of_coverage',
    				],
    				[
    				'attribute' => 'oct_offer_of_coverage',
    				],
    				[
    				'attribute' => 'nov_offer_of_coverage',
    				],
    				[
    				'attribute' => 'dec_offer_of_coverage',
    				],
					[
    				'attribute' => 'employee_share_for_all_12_months',
    				],
    				[
    				'attribute' => 'employee_share_for_jan',
    				],
    				[
    				'attribute' => 'employee_share_for_feb',
    				],
    				[
    				'attribute' => 'employee_share_for_mar',
    				],
    				[
    				'attribute' => 'employee_share_for_apr',
    				],
    				[
    				'attribute' => 'employee_share_for_may',
    				],
    				[
    				'attribute' => 'employee_share_for_jun',
    				],
    				[
    				'attribute' => 'employee_share_for_jul',
    				],
    				[
    				'attribute' => 'employee_share_for_aug',
    				],
    				[
    				'attribute' => 'employee_share_for_sep',
    				],
    				[
    				'attribute' => 'employee_share_for_oct',
    				],
    				[
    				'attribute' => 'employee_share_for_nov',
    				],
    				[
    				'attribute' => 'employee_share_for_dec',
    				],
    				[
    				'attribute' => 'safe_harbor_code_for_all_12_months',
    				],
    				[
    				'attribute' => 'safe_harbor_code_for_jan',
    				],
    				[
    				'attribute' => 'safe_harbor_code_for_feb',
    				],
    				[
    				'attribute' => 'safe_harbor_code_for_mar',
    				],
    				[
    				'attribute' => 'safe_harbor_code_for_apr',
    				],
    				[
    				'attribute' => 'safe_harbor_code_for_may',
    				],
    				[
    				'attribute' => 'safe_harbor_code_for_jun',
    				],
    				[
    				'attribute' => 'safe_harbor_code_for_jul',
    				],
    				[
    				'attribute' => 'safe_harbor_code_for_aug',
    				],
    				[
    				'attribute' => 'safe_harbor_code_for_sep',
    				],
    				[
    				'attribute' => 'safe_harbor_code_for_oct',
    				],
    				[
    				'attribute' => 'safe_harbor_code_for_nov',
    				],
    				[
    				'attribute' => 'safe_harbor_code_for_dec',
    				],
    				[
    				'attribute' => 'covered_individual_checkbox',
    				],
    				[
    				'attribute' => 'individual_ssn(b1)',
    				],
    				[
    				'attribute' => 'dob(c1)',
    				],
    				[
    				'attribute' => 'first_name(a1)',
    				],
    				[
    				'attribute' => 'middle_initial(a1)',
    				],
    				[
    				'attribute' => 'last_name(a1)',
    				],
    				[
    				'attribute' => 'suffix(a1)',
    				],
    				[
    				'attribute' => 'covered_12_months(d1)',
    				],
    				[
    				'attribute' => 'jan(e1)',
    				],
    				[
    				'attribute' => 'feb(e1)',
    				],
    				[
    				'attribute' => 'mar(e1)',
    				],
    				[
    				'attribute' => 'apr(e1)',
    				],
    				[
    				'attribute' => 'may(e1)',
    				],
    				[
    				'attribute' => 'jun(e1)',
    				],
    				[
    				'attribute' => 'jul(e1)',
    				],
    				[
    				'attribute' => 'aug(e1)',
    				],
    				[
    				'attribute' => 'sep(e1)',
    				],
    				[
    				'attribute' => 'oct(e1)',
    				],
    				[
    				'attribute' => 'nov(e1)',
    				],
    				[
    				'attribute' => 'dec(e1)',
    				],
    				[
    				'attribute' => 'individual_ssn(b2)',
    				],
    				[
    				'attribute' => 'dob(c2)',
    				],
    				[
    				'attribute' => 'first_name(a2)',
    				],
    				[
    				'attribute' => 'middle_initial(a2)',
    				],
    				[
    				'attribute' => 'last_name(a2)',
    				],
    				[
    				'attribute' => 'suffix(a2)',
    				],
    				[
    				'attribute' => 'covered_12_months(d2)',
    				],
    				[
    				'attribute' => 'jan(e2)',
    				],
    				[
    				'attribute' => 'feb(e2)',
    				],
    				[
    				'attribute' => 'mar(e2)',
    				],
    				[
    				'attribute' => 'apr(e2)',
    				],
    				[
    				'attribute' => 'may(e2)',
    				],
    				[
    				'attribute' => 'jun(e2)',
    				],
    				[
    				'attribute' => 'jul(e2)',
    				],
    				[
    				'attribute' => 'aug(e2)',
    				],
    				[
    				'attribute' => 'sep(e2)',
    				],
    				[
    				'attribute' => 'oct(e2)',
    				],
    				[
    				'attribute' => 'nov(e2)',
    				],
    				[
    				'attribute' => 'dec(e2)',
    				],
    				[
    				'attribute' => 'individual_ssn(b3)',
    				],
    				[
    				'attribute' => 'dob(c3)',
    				],
    				[
    				'attribute' => 'first_name(a3)',
    				],
    				[
    				'attribute' => 'middle_initial(a3)',
    				],
    				[
    				'attribute' => 'last_name(a3)',
    				],
    				[
    				'attribute' => 'suffix(a3)',
    				],
    				[
    				'attribute' => 'covered_12_months(d3)',
    				],
    				[
    				'attribute' => 'jan(e3)',
    				],
    				[
    				'attribute' => 'feb(e3)',
    				],
    				[
    				'attribute' => 'mar(e3)',
    				],
    				[
    				'attribute' => 'apr(e3)',
    				],
    				[
    				'attribute' => 'may(e3)',
    				],
    				[
    				'attribute' => 'jun(e3)',
    				],
    				[
    				'attribute' => 'jul(e3)',
    				],
    				[
    				'attribute' => 'aug(e3)',
    				],
    				[
    				'attribute' => 'sep(e3)',
    				],
    				[
    				'attribute' => 'oct(e3)',
    				],
    				[
    				'attribute' => 'nov(e3)',
    				],
    				[
    				'attribute' => 'dec(e3)',
    				],
    				[
    				'attribute' => 'individual_ssn(b4)',
    				],
    				[
    				'attribute' => 'dob(c4)',
    				],
    				[
    				'attribute' => 'first_name(a4)',
    				],
    				[
    				'attribute' => 'middle_initial(a4)',
    				],
    				[
    				'attribute' => 'last_name(a4)',
    				],
    				[
    				'attribute' => 'suffix(a4)',
    				],
    				[
    				'attribute' => 'covered_12_months(d4)',
    				],
    				[
    				'attribute' => 'jan(e4)',
    				],
    				[
    				'attribute' => 'feb(e4)',
    				],
    				[
    				'attribute' => 'mar(e4)',
    				],
    				[
    				'attribute' => 'apr(e4)',
    				],
    				[
    				'attribute' => 'may(e4)',
    				],
    				[
    				'attribute' => 'jun(e4)',
    				],
    				[
    				'attribute' => 'jul(e4)',
    				],
    				[
    				'attribute' => 'aug(e4)',
    				],
    				[
    				'attribute' => 'sep(e4)',
    				],
    				[
    				'attribute' => 'oct(e4)',
    				],
    				[
    				'attribute' => 'nov(e4)',
    				],
    				[
    				'attribute' => 'dec(e4)',
    				],
    				[
    				'attribute' => 'individual_ssn(b5)',
    				],
    				[
    				'attribute' => 'dob(c5)',
    				],
    				[
    				'attribute' => 'first_name(a5)',
    				],
    				[
    				'attribute' => 'middle_initial(a5)',
    				],
    				[
    				'attribute' => 'last_name(a5)',
    				],
    				[
    				'attribute' => 'suffix(a5)',
    				],
    				[
    				'attribute' => 'covered_12_months(d5)',
    				],
    				[
    				'attribute' => 'jan(e5)',
    				],
    				[
    				'attribute' => 'feb(e5)',
    				],
    				[
    				'attribute' => 'mar(e5)',
    				],
    				[
    				'attribute' => 'apr(e5)',
    				],
    				[
    				'attribute' => 'may(e5)',
    				],
    				[
    				'attribute' => 'jun(e5)',
    				],
    				[
    				'attribute' => 'jul(e5)',
    				],
    				[
    				'attribute' => 'aug(e5)',
    				],
    				[
    				'attribute' => 'sep(e5)',
    				],
    				[
    				'attribute' => 'oct(e5)',
    				],
    				[
    				'attribute' => 'nov(e5)',
    				],
    				[
    				'attribute' => 'dec(e5)',
    				],
    				[
    				'attribute' => 'individual_ssn(b6)',
    				],
    				[
    				'attribute' => 'dob(c6)',
    				],
    				[
    				'attribute' => 'first_name(a6)',
    				],
    				[
    				'attribute' => 'middle_initial(a6)',
    				],
    				[
    				'attribute' => 'last_name(a6)',
    				],
    				[
    				'attribute' => 'suffix(a6)',
    				],
    				[
    				'attribute' => 'covered_12_months(d6)',
    				],
    				[
    				'attribute' => 'jan(e6)',
    				],
    				[
    				'attribute' => 'feb(e6)',
    				],
    				[
    				'attribute' => 'mar(e6)',
    				],
    				[
    				'attribute' => 'apr(e6)',
    				],
    				[
    				'attribute' => 'may(e6)',
    				],
    				[
    				'attribute' => 'jun(e6)',
    				],
    				[
    				'attribute' => 'jul(e6)',
    				],
    				[
    				'attribute' => 'aug(e6)',
    				],
    				[
    				'attribute' => 'sep(e6)',
    				],
    				[
    				'attribute' => 'oct(e6)',
    				],
    				[
    				'attribute' => 'nov(e6)',
    				],
    				[
    				'attribute' => 'dec(e6)',
    				],
    				[
    				'attribute' => 'individual_ssn(b7)',
    				],
    				[
    				'attribute' => 'dob(c7)',
    				],
    				[
    				'attribute' => 'first_name(a7)',
    				],
    				[
    				'attribute' => 'middle_initial(a7)',
    				],
    				[
    				'attribute' => 'last_name(a7)',
    				],
    				[
    				'attribute' => 'suffix(a7)',
    				],
    				[
    				'attribute' => 'covered_12_months(d7)',
    				],
    				[
    				'attribute' => 'jan(e7)',
    				],
    				[
    				'attribute' => 'feb(e7)',
    				],
    				[
    				'attribute' => 'mar(e7)',
    				],
    				[
    				'attribute' => 'apr(e7)',
    				],
    				[
    				'attribute' => 'may(e7)',
    				],
    				[
    				'attribute' => 'jun(e7)',
    				],
    				[
    				'attribute' => 'jul(e7)',
    				],
    				[
    				'attribute' => 'aug(e7)',
    				],
    				[
    				'attribute' => 'sep(e7)',
    				],
    				[
    				'attribute' => 'oct(e7)',
    				],
    				[
    				'attribute' => 'nov(e7)',
    				],
    				[
    				'attribute' => 'dec(e7)',
    				],
    				[
    				'attribute' => 'individual_ssn(b8)',
    				],
    				[
    				'attribute' => 'dob(c8)',
    				],
    				[
    				'attribute' => 'first_name(a8)',
    				],
    				[
    				'attribute' => 'middle_initial(a8)',
    				],
    				[
    				'attribute' => 'last_name(a8)',
    				],
    				[
    				'attribute' => 'suffix(a8)',
    				],
    				[
    				'attribute' => 'covered_12_months(d8)',
    				],
    				[
    				'attribute' => 'jan(e8)',
    				],
    				[
    				'attribute' => 'feb(e8)',
    				],
    				[
    				'attribute' => 'mar(e8)',
    				],
    				[
    				'attribute' => 'apr(e8)',
    				],
    				[
    				'attribute' => 'may(e8)',
    				],
    				[
    				'attribute' => 'jun(e8)',
    				],
    				[
    				'attribute' => 'jul(e8)',
    				],
    				[
    				'attribute' => 'aug(e8)',
    				],
    				[
    				'attribute' => 'sep(e8)',
    				],
    				[
    				'attribute' => 'oct(e8)',
    				],
    				[
    				'attribute' => 'nov(e8)',
    				],
    				[
    				'attribute' => 'dec(e8)',
    				],
    				[
    				'attribute' => 'individual_ssn(b9)',
    				],
    				[
    				'attribute' => 'dob(c9)',
    				],
    				[
    				'attribute' => 'first_name(a9)',
    				],
    				[
    				'attribute' => 'middle_initial(a9)',
    				],
    				[
    				'attribute' => 'last_name(a9)',
    				],
    				[
    				'attribute' => 'suffix(a9)',
    				],
    				[
    				'attribute' => 'covered_12_months(d9)',
    				],
    				[
    				'attribute' => 'jan(e9)',
    				],
    				[
    				'attribute' => 'feb(e9)',
    				],
    				[
    				'attribute' => 'mar(e9)',
    				],
    				[
    				'attribute' => 'apr(e9)',
    				],
    				[
    				'attribute' => 'may(e9)',
    				],
    				[
    				'attribute' => 'jun(e9)',
    				],
    				[
    				'attribute' => 'jul(e9)',
    				],
    				[
    				'attribute' => 'aug(e9)',
    				],
    				[
    				'attribute' => 'sep(e9)',
    				],
    				[
    				'attribute' => 'oct(e9)',
    				],
    				[
    				'attribute' => 'nov(e9)',
    				],
    				[
    				'attribute' => 'dec(e9)',
    				],
    				[
    				'attribute' => 'individual_ssn(b10)',
    				],
    				[
    				'attribute' => 'dob(c10)',
    				],
    				[
    				'attribute' => 'first_name(a10)',
    				],
    				[
    				'attribute' => 'middle_initial(a10)',
    				],
    				[
    				'attribute' => 'last_name(a10)',
    				],
    				[
    				'attribute' => 'suffix(a10)',
    				],
    				[
    				'attribute' => 'covered_12_months(d10)',
    				],
    				[
    				'attribute' => 'jan(e10)',
    				],
    				[
    				'attribute' => 'feb(e10)',
    				],
    				[
    				'attribute' => 'mar(e10)',
    				],
    				[
    				'attribute' => 'apr(e10)',
    				],
    				[
    				'attribute' => 'may(e10)',
    				],
    				[
    				'attribute' => 'jun(e10)',
    				],
    				[
    				'attribute' => 'jul(e10)',
    				],
    				[
    				'attribute' => 'aug(e10)',
    				],
    				[
    				'attribute' => 'sep(e10)',
    				],
    				[
    				'attribute' => 'oct(e10)',
    				],
    				[
    				'attribute' => 'nov(e10)',
    				],
    				[
    				'attribute' => 'dec(e10)',
    				],
    				[
    				'attribute' => 'individual_ssn(b11)',
    				],
    				[
    				'attribute' => 'dob(c11)',
    				],
    				[
    				'attribute' => 'first_name(a11)',
    				],
    				[
    				'attribute' => 'middle_initial(a11)',
    				],
    				[
    				'attribute' => 'last_name(a11)',
    				],
    				[
    				'attribute' => 'suffix(a11)',
    				],
    				[
    				'attribute' => 'covered_12_months(d11)',
    				],
    				[
    				'attribute' => 'jan(e11)',
    				],
    				[
    				'attribute' => 'feb(e11)',
    				],
    				[
    				'attribute' => 'mar(e11)',
    				],
    				[
    				'attribute' => 'apr(e11)',
    				],
    				[
    				'attribute' => 'may(e11)',
    				],
    				[
    				'attribute' => 'jun(e11)',
    				],
    				[
    				'attribute' => 'jul(e11)',
    				],
    				[
    				'attribute' => 'aug(e11)',
    				],
    				[
    				'attribute' => 'sep(e11)',
    				],
    				[
    				'attribute' => 'oct(e11)',
    				],
    				[
    				'attribute' => 'nov(e11)',
    				],
    				[
    				'attribute' => 'dec(e11)',
    				],
    				[
    				'attribute' => 'individual_ssn(b12)',
    				],
    				[
    				'attribute' => 'dob(c12)',
    				],
    				[
    				'attribute' => 'first_name(a12)',
    				],
    				[
    				'attribute' => 'middle_initial(a12)',
    				],
    				[
    				'attribute' => 'last_name(a12)',
    				],
    				[
    				'attribute' => 'suffix(a12)',
    				],
    				[
    				'attribute' => 'covered_12_months(d12)',
    				],
    				[
    				'attribute' => 'jan(e12)',
    				],
    				[
    				'attribute' => 'feb(e12)',
    				],
    				[
    				'attribute' => 'mar(e12)',
    				],
    				[
    				'attribute' => 'apr(e12)',
    				],
    				[
    				'attribute' => 'may(e12)',
    				],
    				[
    				'attribute' => 'jun(e12)',
    				],
    				[
    				'attribute' => 'jul(e12)',
    				],
    				[
    				'attribute' => 'aug(e12)',
    				],
    				[
    				'attribute' => 'sep(e12)',
    				],
    				[
    				'attribute' => 'oct(e12)',
    				],
    				[
    				'attribute' => 'nov(e12)',
    				],
    				[
    				'attribute' => 'dec(e12)',
    				],
    				[
    				'attribute' => 'individual_ssn(b13)',
    				],
    				[
    				'attribute' => 'dob(c13)',
    				],
    				[
    				'attribute' => 'first_name(a13)',
    				],
    				[
    				'attribute' => 'middle_initial(a13)',
    				],
    				[
    				'attribute' => 'last_name(a13)',
    				],
    				[
    				'attribute' => 'suffix(a13)',
    				],
    				[
    				'attribute' => 'covered_12_months(d13)',
    				],
    				[
    				'attribute' => 'jan(e13)',
    				],
    				[
    				'attribute' => 'feb(e13)',
    				],
    				[
    				'attribute' => 'mar(e13)',
    				],
    				[
    				'attribute' => 'apr(e13)',
    				],
    				[
    				'attribute' => 'may(e13)',
    				],
    				[
    				'attribute' => 'jun(e13)',
    				],
    				[
    				'attribute' => 'jul(e13)',
    				],
    				[
    				'attribute' => 'aug(e13)',
    				],
    				[
    				'attribute' => 'sep(e13)',
    				],
    				[
    				'attribute' => 'oct(e13)',
    				],
    				[
    				'attribute' => 'nov(e13)',
    				],
    				[
    				'attribute' => 'dec(e13)',
    				],
    				[
    				'attribute' => 'individual_ssn(b14)',
    				],
    				[
    				'attribute' => 'dob(c14)',
    				],
    				[
    				'attribute' => 'first_name(a14)',
    				],
    				[
    				'attribute' => 'middle_initial(a14)',
    				],
    				[
    				'attribute' => 'last_name(a14)',
    				],
    				[
    				'attribute' => 'suffix(a14)',
    				],
    				[
    				'attribute' => 'covered_12_months(d14)',
    				],
    				[
    				'attribute' => 'jan(e14)',
    				],
    				[
    				'attribute' => 'feb(e14)',
    				],
    				[
    				'attribute' => 'mar(e14)',
    				],
    				[
    				'attribute' => 'apr(e14)',
    				],
    				[
    				'attribute' => 'may(e14)',
    				],
    				[
    				'attribute' => 'jun(e14)',
    				],
    				[
    				'attribute' => 'jul(e14)',
    				],
    				[
    				'attribute' => 'aug(e14)',
    				],
    				[
    				'attribute' => 'sep(e14)',
    				],
    				[
    				'attribute' => 'oct(e14)',
    				],
    				[
    				'attribute' => 'nov(e14)',
    				],
    				[
    				'attribute' => 'dec(e14)',
    				],
    				[
    				'attribute' => 'individual_ssn(b15)',
    				],
    				[
    				'attribute' => 'dob(c15)',
    				],
    				[
    				'attribute' => 'first_name(a15)',
    				],
    				[
    				'attribute' => 'middle_initial(a15)',
    				],
    				[
    				'attribute' => 'last_name(a15)',
    				],
    				[
    				'attribute' => 'suffix(a15)',
    				],
    				[
    				'attribute' => 'covered_12_months(d15)',
    				],
    				[
    				'attribute' => 'jan(e15)',
    				],
    				[
    				'attribute' => 'feb(e15)',
    				],
    				[
    				'attribute' => 'mar(e15)',
    				],
    				[
    				'attribute' => 'apr(e15)',
    				],
    				[
    				'attribute' => 'may(e15)',
    				],
    				[
    				'attribute' => 'jun(e15)',
    				],
    				[
    				'attribute' => 'jul(e15)',
    				],
    				[
    				'attribute' => 'aug(e15)',
    				],
    				[
    				'attribute' => 'sep(e15)',
    				],
    				[
    				'attribute' => 'oct(e15)',
    				],
    				[
    				'attribute' => 'nov(e15)',
    				],
    				[
    				'attribute' => 'dec(e15)',
    				],
    				[
    				'attribute' => 'individual_ssn(b16)',
    				],
    				[
    				'attribute' => 'dob(c16)',
    				],
    				[
    				'attribute' => 'first_name(a16)',
    				],
    				[
    				'attribute' => 'middle_initial(a16)',
    				],
    				[
    				'attribute' => 'last_name(a16)',
    				],
    				[
    				'attribute' => 'suffix(a16)',
    				],
    				[
    				'attribute' => 'covered_12_months(d16)',
    				],
    				[
    				'attribute' => 'jan(e16)',
    				],
    				[
    				'attribute' => 'feb(e16)',
    				],
    				[
    				'attribute' => 'mar(e16)',
    				],
    				[
    				'attribute' => 'apr(e16)',
    				],
    				[
    				'attribute' => 'may(e16)',
    				],
    				[
    				'attribute' => 'jun(e16)',
    				],
    				[
    				'attribute' => 'jul(e16)',
    				],
    				[
    				'attribute' => 'aug(e16)',
    				],
    				[
    				'attribute' => 'sep(e16)',
    				],
    				[
    				'attribute' => 'oct(e16)',
    				],
    				[
    				'attribute' => 'nov(e16)',
    				],
    				[
    				'attribute' => 'dec(e16)',
    				],
    				[
    				'attribute' => 'individual_ssn(b17)',
    				],
    				[
    				'attribute' => 'dob(c17)',
    				],
    				[
    				'attribute' => 'first_name(a17)',
    				],
    				[
    				'attribute' => 'middle_initial(a17)',
    				],
    				[
    				'attribute' => 'last_name(a17)',
    				],
    				[
    				'attribute' => 'suffix(a17)',
    				],
    				[
    				'attribute' => 'covered_12_months(d17)',
    				],
    				[
    				'attribute' => 'jan(e17)',
    				],
    				[
    				'attribute' => 'feb(e17)',
    				],
    				[
    				'attribute' => 'mar(e17)',
    				],
    				[
    				'attribute' => 'apr(e17)',
    				],
    				[
    				'attribute' => 'may(e17)',
    				],
    				[
    				'attribute' => 'jun(e17)',
    				],
    				[
    				'attribute' => 'jul(e17)',
    				],
    				[
    				'attribute' => 'aug(e17)',
    				],
    				[
    				'attribute' => 'sep(e17)',
    				],
    				[
    				'attribute' => 'oct(e17)',
    				],
    				[
    				'attribute' => 'nov(e17)',
    				],
    				[
    				'attribute' => 'dec(e17)',
    				],
    				[
    				'attribute' => 'employer_foreign_address_indicator',
    				],
    				[
    				'attribute' => 'foreign_state_number',
    				],
    				[
    				'attribute' => 'foreign_postal_code',
    				],
    				[
    				'attribute' => 'country_code',
    				],
    				[
    				'attribute' => 'foreign_address_indicator',
    				],
    				
    				],
    				]);
				unset($array);
				unset($array1);
				unset($arrOffercoverage);
				unset($arrEmployeeshare);
				unset($arrSafehabour);
				unset($arrCoveredindividual);
				
		$name='file_'.$forms->id;
		
    	$curl=$exporter->export()->saveAs(getcwd().'/files/formcsv/'.$name.'.csv');
	
		$result = \Yii::$app->Sharefile->zipaDirectory ( getcwd () . '/files/formcsv', getcwd () . '/files/csv/csv_download.zip' );
			
		 if($result){
    	// calling insert function for blob	
			$create_data_csv = $this->insertcsvdata($forms->id);
		
				if($create_data_csv)	{
					exec ( 'rm -R ' . getcwd () . '/files/formcsv/'.$name.'.csv' );
					exec ( 'rm -R ' . getcwd () . '/files/csv/csv_download.zip' );
				}	
		 }	
    	}
		
		} catch ( \Exception $e ) { // catching the exception
				
			$msg = $e->getMessage ().' at line no '.$e->getLine();
			
			$arrerror ['error_desc'] = $msg;
			$arrerror ['error_type'] = 6;

			if(!empty($company_id)){
				$arrerror ['company_id'] = $company_id;
			}
				
			// Below function saves exceptions if occurs
			$this->Saveerrors ( $arrerror );
		}
	}
	
	private function insertcsvdata($id){
		
		$csvData = file_get_contents(getcwd () . '/files/csv/csv_download.zip');
						//INSERT INTO MyTable (id, image) VALUES(1, LOAD_FILE('/tmp/your_file.zip'));
				/// update in table
		$sql = "UPDATE tbl_aca_forms SET csv_file='".addslashes($csvData)."' WHERE id='".$id."'";

		$result =	Yii::$app->db->createCommand($sql)->execute();
		
		return $result;
						
	}
	
	
	/**
	*
	* Function to download csv file from db if exists
	* File is saved in db in BLOB
	**/
	
	public function actionDownloadcsv()
	{
		$session = \Yii::$app->session;
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$result = array();
			$post_details = yii::$app->request->post();
			$transaction = \Yii::$app->db->beginTransaction (); // begining the transaction
			try{
				
				if(!empty($post_details['form_id']))
				{
					$form_id = $post_details['form_id'];
					$model_companies = new TblAcaCompanies ();
					
					$check_file = TblAcaForms::find()->select('csv_file')->where(['id'=>$form_id])->One();
					
					if(!empty($check_file))
					{
					
						if(empty($check_file->csv_file))
						{
							
							throw new \Exception ( 'Csv creation is in process. Please come back after some time');

						
						}else
						{
							$result['success'] = 'Downloading...';
							
						}
					}
					else
					{
						throw new \Exception ( 'Invalid form selected');
						
					}
					
				}
				else
				{
					throw new Exception ( 'No value posted');
					
				}
			
			} catch ( \Exception $e ) { // any \Exceptions catch throws error msg
				$msg = $e->getMessage ();
			
				$result['error'] = $msg;
				$transaction->rollback();	
				
			}
			
			return (json_encode($result));
			
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
		
	}
	
	/**
	*
	* Function to download zip file from db if exists
	* File is saved in db in BLOB (calling from ajax)
	**/
	public function actionCsvdownload(){
		
		$session = \Yii::$app->session;
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			if(isset($_GET['form_id']) && $_GET['form_id']!=''){
				$form_id = $_GET['form_id'];
				
				$check_file = TblAcaForms::find()->select('csv_file')->where(['id'=>$form_id])->One();
				
				$filedata = $check_file->csv_file;
				
				header('Content-Description: File Transfer');
				header("Content-Type: application/zip") ;
				header("Content-length: ".strlen($filedata));
				header("Content-Disposition: attachment; filename=file_".$form_id.".zip");
				
				echo $filedata;

			}
		
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
	}
}
