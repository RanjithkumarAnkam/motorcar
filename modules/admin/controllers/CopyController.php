<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\models\TblAcaCompanies;
use app\models\TblAcaClients;
use app\components\EncryptDecryptComponent;
use app\models\TblAcaCompanyReportingPeriod;
use app\models\TblAcaCompaniesSearch;
use mikehaertl\pdftk\Pdf;
use app\models\TblAcaBasicInformation;
use app\models\TblAcaBasicAdditionalDetail;
use app\models\TblAcaEmpStatusTrack;
use app\models\TblAcaPlanCriteria;
use app\models\TblAcaDesignatedGovtEntity;
use app\models\TblAcaAggregatedGroup;
use app\models\TblAcaAggregatedGroupList;
use app\models\TblAcaUsers;
use app\models\TblAcaGeneralPlanInfo;
use app\models\TblAcaMecCoverage;
use app\models\TblAcaPlanCoverageType;
use app\models\TblAcaGeneralPlanMonths;
use app\models\TblAcaPlanCoverageTypeOffered;
use app\models\TblAcaPlanOfferTypeYears;
use app\models\TblAcaEmpContributions;
use app\models\TblAcaEmpContributionsPremium;

class CopyController extends \yii\web\Controller {
	public function actionIndex() {
		
		if (\Yii::$app->SessionCheck->isLogged () == true) {
		$this->layout = 'main'; // using layout
		$model_companies = new TblAcaCompanies (); // initialising models
		$model_client = new TblAcaClients ();
		$model_company_period = new TblAcaCompanyReportingPeriod ();
		$encrypt_component = new EncryptDecryptComponent ();
		$client_id = '';
		$session = \Yii::$app->session; // initialising session
		$arrayCompanynodata = array ();
		$arrCompanyhasdata_ids = array ();
		$model_datacompanies = '';
		$encrypt_client_id='';
		
		$get_values = \yii::$app->request->get ();
		
		$all_clients = $model_client->Findallclients ();
		
		if (! empty ( $get_values )) {
			
			$encrypt_client_id = $get_values ['client_id'];
			$client_id = $encrypt_component->decryptUser ( $encrypt_client_id );
			
			if (! empty ( $client_id )) {
				// to get user id from client table
				$modelclients = TblAcaClients::find ()->select ( 'user_id' )->where ( [ 
						'client_id' => $client_id 
				] )->one ();
				
				// getting all the clients with the user id for borker
				$modelallclients = TblAcaClients::find ()->select ( 'client_id,client_name' )->where ( [ 
						'user_id' => $modelclients->user_id 
				] )->all ();
				
				if (! empty ( $modelallclients )) {
					foreach ( $modelallclients as $modelallclient ) { // loop for all the clients
						$client_name = $modelallclient->client_name;
						$model_companies = TblAcaCompanies::find ()->select ( 'company_id,company_name,client_id,company_client_number' )->where ( [ 
								'client_id' => $modelallclient->client_id 
						] )->all ();
						
						foreach ( $model_companies as $company ) {
							
							$company_value = $this->findnullcompanies ( $company->company_id); // function to check the company has empty data or not
						//	print_r($company_value);die();
							if ($company_value == 0) { // if company_value = 0 the company doesnt have data
								
								$arrayCompanynodata [] = array (
										'company_id' => $company->company_id,
										'company_name' => $company->company_name,
										'client_id' => $company->client_id,
										'client_name' => $client_name ,
										'company_client_number'=>$company->company_client_number
								);
							} else { // company has data
								$arrCompanyhasdata_ids [] = array (
										'company_id' => $company->company_id,
										'client_id' => $company->client_id ,
										
								);
							}
						}
						
					
					}
				}
				
				$model_datacompanies = TblAcaCompanies::find ()->select ( 'company_id,company_name' )->where ( [ 
						'IN',
						'company_id',
						$arrCompanyhasdata_ids 
				] )->all ();
				
				// $dataProvider = $searchModel->searchdatacompanies(\Yii::$app->request->queryParams, $arrCompany_ids);
			}
		}
		
		return $this->render ( 'index', [ 
				'model_clients' => $all_clients,
				'client_id' => $client_id,
				'encryptclient_id' => $encrypt_client_id,
				'model_datacompanies' => $model_datacompanies,
				'arrayCompanynodata' => $arrayCompanynodata 
		// 'dataProvider'=>$dataProvider,
		// 'searchModel'=>$searchModel,
		
		 ]);
		 	} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
	}
	/*
	 * private function to check company details
	 */
	private function findnullcompanies($company_id) {
		
		/**
		 * *************** getting details for basic information****************
		 */
		$databasicinfo = TblAcaBasicInformation::find ()->where ( [ 
				'company_id' => $company_id 
		] )->one ();
		
		/**
		 * *************** getting details for basic additional details****************
		 */
		$databasicinfoadditionaldetails = TblAcaBasicAdditionalDetail::find ()->where ( [ 
				'company_id' => $company_id 
		] )->one ();
		
		/**
		 * *************** getting details for emp status track****************
		 */
		// $datacompanyreportingperiod = TblAcaCompanyReportingPeriod::find()->where(['company_id'=>$company_id])->one();
		$dataempstatus = TblAcaEmpStatusTrack::find ()->where ( [ 
				'company_id' => $company_id 
		] )->one ();
		
		/**
		 * *************** getting details for plan criteria****************
		 */
		$dataplancreteria = TblAcaPlanCriteria::find ()->where ( [ 
				'company_id' => $company_id 
		] )->one ();
		
		/**
		 * *************** getting details for dge****************
		 */
		$datadesignatedgovtentity = TblAcaDesignatedGovtEntity::find ()->where ( [ 
				'company_id' => $company_id 
		] )->one ();
		
		/**
		 * *************** getting details for aggregate group****************
		 */
		$dataaggregategroup = TblAcaAggregatedGroup::find ()->where ( [ 
				'company_id' => $company_id 
		] )->one ();
		
		/**
		 * *************** getting details for General plan info****************
		 */
		$datageneralplaninfo = TblAcaGeneralPlanInfo::find ()->where ( [
				'company_id' => $company_id
				] )->one ();
		
		/**
		 * *************** getting details for mec coverage****************
		 */
		$datameccoverage = TblAcaMecCoverage::find ()->where ( [
				'company_id' => $company_id
				] )->one ();
		
		/**
		 * *************** getting details for plan coverage type****************
		 */
		$dataplancoveragetype = TblAcaPlanCoverageType::find ()->where ( [
				'company_id' => $company_id
				] )->one ();
		
		
		
		if (! empty ( $databasicinfo ) || ! empty ( $databasicinfoadditionaldetails ) || ! empty ( $dataempstatus ) || ! empty ( $dataplancreteria ) 
		|| ! empty ( $datadesignatedgovtentity ) || ! empty ( $dataaggregategroup) || ! empty ( $datageneralplaninfo ) || ! empty ( $datameccoverage )|| ! empty ( $dataplancoveragetype )) {
			
			$value = 1;
		} else {
			$value = 0;
		}
		
		return $value;
		// print_R($datacompanyreportingperiod);
		// print_r($databasicinfo.'-'.$databasicinfoadditionaldetails.'-'.$datacompanyreportingperiod.'-'.$dataempstatus.'-'.$dataplancreteria.'-'.$datadesignatedgovtentity.'-'.$dataaggregategroup) ;
	}
	/*
	 * *getting coampny details using ajax
	 */
	public function actionCompanydetails() {
		if (\Yii::$app->SessionCheck->isLogged () == true) {
			$output = array ();
			$post_values = \yii::$app->request->get ();
			
			if (! empty ( $post_values )) { // checking for values to be posted
				$client_id = $post_values ['client_id'];
				
				$model_companies = TblAcaCompanies::find ()->select ( 'company_id,company_name' )->where ( [ 
						'client_id' => $client_id 
				] )->andWhere ( [ 
						'<>',
						'company_name',
						'' 
				] )->asArray ()->all ();
				// $model_emptycompanies = TblAcaCompanies::find()->select('company_id,company_name')->where(['client_id'=>$client_id])->andWhere(['=','company_name',''])->asArray()->all();
				$output ['success'] = $model_companies;
			} else {
				$output ['error'] = 'Please try again, Error occured'; // sending errro if values doesnt pst
			}
			return json_encode ( $output );
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
	}
	public function actionCopydetails() {
		if (\Yii::$app->SessionCheck->isLogged () == true) {
			
			$session = \Yii::$app->session;                         // collecting variables from session
			$user_id = $session ['admin_user_id'];
			$post_values = \yii::$app->request->post ();
	
			if (! empty ( $post_values )) { // checking for values to be posted
				
				$encrypt_component = new EncryptDecryptComponent ();
				$model_basicinfo = new TblAcaBasicInformation ();
				$model_basicinfoadditionaldetails = new TblAcaBasicAdditionalDetail ();
				$model_empstatus = new TblAcaEmpStatusTrack ();
				$model_plancreteria = new TblAcaPlanCriteria ();
				$model_designatedgovtentity = new TblAcaDesignatedGovtEntity ();
				$model_aggregategroup = new TblAcaAggregatedGroup ();
				$model_aggregategrouplist = new TblAcaAggregatedGroupList ();
				$model_generalplaninfo =new TblAcaGeneralPlanInfo();
				$model_generalplaninfomonths =new TblAcaGeneralPlanMonths();
				$model_meccoverage = new TblAcaMecCoverage();
				$model_plancoveragetype = new TblAcaPlanCoverageType();
				$model_plancoveragetypeoffered = new TblAcaPlanCoverageTypeOffered();
				$model_planoffertypeyears = new TblAcaPlanOfferTypeYears();
				$model_empcontribution = new TblAcaEmpContributions();
				$model_empcontributionpremium = new TblAcaEmpContributionsPremium();
				
				$nodata_companies = $post_values ['nodata-company'];
				$encrypt_company_id = $post_values['data-company-id'];
				$company_id =  $encrypt_component->decryptUser ( $encrypt_company_id );
				/**
				 * *************** getting details for basic information****************
				 */
				$databasicinfo = TblAcaBasicInformation::find ()->where ( [ 
						'company_id' => $company_id 
				] )->asArray()->one ();
				
				/**
				 * *************** getting details for basic additional details****************
				 */
				$databasicinfoadditionaldetails = TblAcaBasicAdditionalDetail::find ()->where ( [ 
						'company_id' => $company_id 
				] )->asArray()->one ();
				
				/**
				 * *************** getting details for Emp status track****************
				 */
				// $datacompanyreportingperiod = TblAcaCompanyReportingPeriod::find()->where(['company_id'=>$company_id])->one();
				$dataempstatus = TblAcaEmpStatusTrack::find ()->where ( [ 
						'company_id' => $company_id 
				] )->asArray()->one ();
				
				/**
				 * *************** getting details for Plan criteria****************
				 */
				$dataplancreteria = TblAcaPlanCriteria::find ()->where ( [ 
						'company_id' => $company_id 
				] )->asArray()->one ();
				
				/**
				 * *************** getting details for Desiganted govt entity****************
				 */
				$datadesignatedgovtentity = TblAcaDesignatedGovtEntity::find ()->where ( [ 
						'company_id' => $company_id 
				] )->asArray()->one ();
				
				/**
				 * *************** getting details for Aggregated group****************
				 */
				$dataaggregategroup = TblAcaAggregatedGroup::find ()->where ( [ 
						'company_id' => $company_id 
				] )->asArray()->one ();
				
				
				/**
				 * *************** getting details for Aggregated group list****************
				 */
				if(!empty($dataaggregategroup)){
					$dataaggregategrouplist = TblAcaAggregatedGroupList::find ()->where ( [
							'aggregated_grp_id' => $dataaggregategroup['aggregated_grp_id']
							] )->all ();
				}
				
				
				/**
				 * *************** getting details for general plan info****************
				 */
				$datageneralplaninfo = TblAcaGeneralPlanInfo::find ()->where ( [
						'company_id' => $company_id
						] )->asArray()->one ();
			
				
				/**
				 * *************** getting details for general plan info months****************
				 */
				if(!empty($datageneralplaninfo)){
					$datageneralplaninfomonths = TblAcaGeneralPlanMonths::find ()->where ( [
							'general_plan_id' => $datageneralplaninfo['general_plan_id']
							] )->all ();
				}
				
				/**
				 * *************** getting details for mec coverage****************
				 */
			
					$datameccoverage = TblAcaMecCoverage::find ()->where ( [
							'company_id' => $company_id
						] )->asArray()->one ();
				
				
					/**
					 * *************** getting details for plan coverage type****************
					 */
						
					$dataplancoveragetype = TblAcaPlanCoverageType::find ()->where ( [
							'company_id' => $company_id
							] )->all ();
					
				
				
					
				
				// begin transaction
				$transaction = \Yii::$app->db->beginTransaction ();
				try {
					
					foreach ( $nodata_companies as $key => $value ) {
						
						$company_id = $encrypt_component->decryptUser ( $key );
						
						/**
						 * *************** getting period id****************
						 */
						$model_reportingyear = TblAcaCompanyReportingPeriod::find()->select('period_id')->where(['company_id'=>$company_id])->one();
						$period_id = $model_reportingyear->period_id;
						
						/**
						 * *************** inserting details for basic information****************
						 */
						if (! empty ( $databasicinfo )) {
							
							$model_basicinfo->attributes = $databasicinfo;
							$model_basicinfo->period_id = $period_id;
							$model_basicinfo->company_id = $company_id;
							$model_basicinfo->created_by = $user_id;
							$model_basicinfo->created_date = date ( 'Y-m-d H:i:s' );
							$model_basicinfo->isNewRecord = true;
							$model_basicinfo->basic_info_id = null;
						
							if ($model_basicinfo->save ()) {
								
								// do nothing
							} else {
								
								$arrerrors = $model_basicinfo->getFirstErrors ();
								$errorstring = '';
								
								foreach ( $arrerrors as $key => $value ) {
									$errorstring .= $value . '<br>';
								}
								
								throw new \Exception ( $errorstring );
							}
						}
						
						/**
						 * *************** inserting details for basic additional details****************
						 */
						
						if (! empty ( $databasicinfoadditionaldetails )) {
							
							$model_basicinfoadditionaldetails->attributes = $databasicinfoadditionaldetails;
							$model_basicinfoadditionaldetails->company_id = $company_id;
							$model_basicinfoadditionaldetails->period_id = $period_id;
							$model_basicinfoadditionaldetails->created_by = $user_id;
							$model_basicinfoadditionaldetails->created_date = date ( 'Y-m-d H:i:s' );
							$model_basicinfoadditionaldetails->isNewRecord = true;
							$model_basicinfoadditionaldetails->anything_else_id = null;
							if ($model_basicinfoadditionaldetails->save ()) {
								
								// do nothing
							} else {
								
								$arrerrors = $model_basicinfoadditionaldetails->getFirstErrors ();
								$errorstring = '';
								
								foreach ( $arrerrors as $key => $value ) {
									$errorstring .= $value . '<br>';
								}
								
								throw new \Exception ( $errorstring );
							}
						}
						
						/**
						 * *************** inserting details for TblAcaEmpStatusTrack****************
						 */
						
						if (! empty ( $dataempstatus )) {
							
							$model_empstatus->attributes = $dataempstatus;
							$model_empstatus->company_id = $company_id;
							$model_empstatus->period_id = $period_id;
							$model_empstatus->created_by = $user_id;
							$model_empstatus->created_date = date ( 'Y-m-d H:i:s' );
							$model_empstatus->isNewRecord = true;
							$model_empstatus->emp_tracking_id = null;
							if ($model_empstatus->save ()) {
								
								// do nothing
							} else {
								
								$arrerrors = $model_empstatus->getFirstErrors ();
								$errorstring = '';
								
								foreach ( $arrerrors as $key => $value ) {
									$errorstring .= $value . '<br>';
								}
								
								throw new \Exception ( $errorstring );
							}
						}
						
						/**
						 * *************** inserting details for plan criteria****************
						 */
						
						if (! empty ( $dataplancreteria )) {
							
							$model_plancreteria->attributes = $dataplancreteria;
							$model_plancreteria->company_id = $company_id;
							$model_plancreteria->period_id = $period_id;
							$model_plancreteria->created_by = $user_id;
							$model_plancreteria->created_date = date ( 'Y-m-d H:i:s' );
							$model_plancreteria->isNewRecord = true;
							$model_plancreteria->plan_criteria_id = null;
							if ($model_plancreteria->save ()) {
								// do nothing
							} else {
								
								$arrerrors = $model_plancreteria->getFirstErrors ();
								$errorstring = '';
								
								foreach ( $arrerrors as $key => $value ) {
									$errorstring .= $value . '<br>';
								}
								
								throw new \Exception ( $errorstring );
							}
						}
						
						/**
						 * *************** inserting details for desiganted govtmental entity****************
						 */
						
						if (! empty ( $datadesignatedgovtentity )) {
							
							$model_designatedgovtentity->attributes = $datadesignatedgovtentity;
							$model_designatedgovtentity->company_id = $company_id;
							$model_designatedgovtentity->period_id = $period_id;
							$model_designatedgovtentity->created_by = $user_id;
							$model_designatedgovtentity->created_date = date ( 'Y-m-d H:i:s' );
							$model_designatedgovtentity->isNewRecord = true;
							$model_designatedgovtentity->dge_id = null;
							if ($model_designatedgovtentity->save ()) {
								
								// do nothing
							} else {
								
								$arrerrors = $model_designatedgovtentity->getFirstErrors ();
								$errorstring = '';
								
								foreach ( $arrerrors as $key => $value ) {
									$errorstring .= $value . '<br>';
								}
								
								throw new \Exception ( $errorstring );
							}
						}
						
						/**
						 * *************** inserting details for aggregated group ****************
						 */
						
						if (! empty ( $dataaggregategroup )) {
							
							$model_aggregategroup->attributes = $dataaggregategroup;
							$model_aggregategroup->company_id = $company_id;
							$model_aggregategroup->period_id = $period_id;
							$model_aggregategroup->created_by = $user_id;
							$model_aggregategroup->created_date = date ( 'Y-m-d H:i:s' );
							$model_aggregategroup->isNewRecord = true;
							$model_aggregategroup->aggregated_grp_id = null;
							
							/**
							 * *************** inserting details for aggregated group list****************
							 */
							
							if ($model_aggregategroup->save ()) {
								if (! empty ( $dataaggregategrouplist )) {
									
									$aggregate_grp_id = $model_aggregategroup->aggregated_grp_id;
									
									foreach ( $dataaggregategrouplist as $grouplist ) {
										
										
										$model_aggregategrouplist->attributes = $grouplist->attributes;
										$model_aggregategrouplist->aggregated_grp_id = $aggregate_grp_id;
										$model_aggregategrouplist->created_by = $user_id;
										$model_aggregategrouplist->created_date = date ( 'Y-m-d H:i:s' );
										$model_aggregategrouplist->isNewRecord = true;
										$model_aggregategrouplist->aggregated_ein_list_id = null;
									
										if ($model_aggregategrouplist->save ()) {
											// do nothing
										} else {
											
											$arrerrors = $model_aggregategrouplist->getFirstErrors ();
											$errorstring = '';
											
											foreach ( $arrerrors as $key => $value ) {
												$errorstring .= $value . '<br>';
											}
											
											throw new \Exception ( $errorstring );
										}
									}
								}
							} else {
								
								$arrerrors = $model_aggregategroup->getFirstErrors ();
								$errorstring = '';
								
								foreach ( $arrerrors as $key => $value ) {
									$errorstring .= $value . '<br>';
								}
								
								throw new \Exception ( $errorstring );
							}
						}
						
						/**
						 * *************** inserting details for general plan info****************
						 */
						
						if (! empty ( $datageneralplaninfo )) {
								
							$model_generalplaninfo->attributes = $datageneralplaninfo;
							$model_generalplaninfo->company_id = $company_id;
							$model_generalplaninfo->period_id = $period_id;
							$model_generalplaninfo->created_by = $user_id;
							$model_generalplaninfo->created_date = date ( 'Y-m-d H:i:s' );
							$model_generalplaninfo->isNewRecord = true;
							$model_generalplaninfo->general_plan_id = null;
								
							/**
							 * *************** inserting details for general plan info months****************
							 */
								
							if ($model_generalplaninfo->save ()) {
								if (! empty ( $datageneralplaninfomonths )) {
										
									$general_plan_id = $model_generalplaninfo->general_plan_id;
										
									foreach ( $datageneralplaninfomonths as $months ) {
						
						
										$model_generalplaninfomonths->attributes = $months->attributes;
										$model_generalplaninfomonths->general_plan_id = $general_plan_id;
										$model_generalplaninfomonths->created_by = $user_id;
										$model_generalplaninfomonths->created_date = date ( 'Y-m-d H:i:s' );
										$model_generalplaninfomonths->isNewRecord = true;
										$model_generalplaninfomonths->plan_month_id = null;
											
										if ($model_generalplaninfomonths->save ()) {
											// do nothing
										} else {
												
											$arrerrors = $model_generalplaninfomonths->getFirstErrors ();
											$errorstring = '';
												
											foreach ( $arrerrors as $key => $value ) {
												$errorstring .= $value . '<br>';
											}
												
											throw new \Exception ( $errorstring );
										}
									}
								}
							} else {
						
								$arrerrors = $model_generalplaninfo->getFirstErrors ();
								$errorstring = '';
						
								foreach ( $arrerrors as $key => $value ) {
									$errorstring .= $value . '<br>';
								}
						
								throw new \Exception ( $errorstring );
							}
						}
						
						/**
						 * *************** inserting details for mec coverage****************
						 */
						
						if (! empty ( $datameccoverage )) {
						
							$model_meccoverage->attributes = $datameccoverage;
							$model_meccoverage->company_id = $company_id;
							$model_meccoverage->period_id = $period_id;
							$model_meccoverage->created_by = $user_id;
							$model_meccoverage->created_date = date ( 'Y-m-d H:i:s' );
							$model_meccoverage->isNewRecord = true;
							$model_meccoverage->mec_id = null;
						
						
							if ($model_meccoverage->save ()) {
							//do nothing
							} else {
						
								$arrerrors = $model_meccoverage->getFirstErrors ();
								$errorstring = '';
						
								foreach ( $arrerrors as $key => $value ) {
									$errorstring .= $value . '<br>';
								}
						
								throw new \Exception ( $errorstring );
							}
						}
						
						/**
						 * *************** loop for plan class****************
						 */
						foreach($dataplancoveragetype as $plancoveragetype){
						
							/**
							 * *************** getting details for plan coverage type offered and plan offer type years****************
							 */
							if(!empty($plancoveragetype)){
						
								$dataplantypeoffered = TblAcaPlanCoverageTypeOffered::find ()->where ( [
										'plan_class_id' => $plancoveragetype['plan_class_id']
										] )->asArray()->one ();
						
								$dataplanoffertypeyears = TblAcaPlanOfferTypeYears::find ()->where ( [
										'plan_class_id' => $plancoveragetype['plan_class_id']
										] )->all ();
						
								/**
								 * *************** getting details for employee contributions****************
								*/
								if(!empty($dataplantypeoffered)){
						
									$dataempcontribution = TblAcaEmpContributions::find ()->where ( [
											'coverage_type_id' => $dataplantypeoffered['coverage_type_id']
											] )->asArray()->one ();
						
						
									if(!empty($dataempcontribution)){
										$dataempcontributionpremium = TblAcaEmpContributionsPremium::find ()->where ( [
												'emp_contribution_id' => $dataempcontribution['emp_contribution_id']
												] )->all ();
									}
								}
							}
							
							/**
							 * *************** inserting details for plan coverage type****************
							 */
							
							if (! empty ( $plancoveragetype )) {
							
								$model_plancoveragetype->attributes = $plancoveragetype->attributes;
								$model_plancoveragetype->company_id = $company_id;
								$model_plancoveragetype->period_id = $period_id;
								$model_plancoveragetype->created_by = $user_id;
								$model_plancoveragetype->created_date = date ( 'Y-m-d H:i:s' );
								$model_plancoveragetype->isNewRecord = true;
								$model_plancoveragetype->plan_class_id = null;
							
								/**
								 * *************** inserting details for coveragetype offered and offertypeyeas****************
								 */
							
								if ($model_plancoveragetype->save ()) {
							
									$plan_class_id = $model_plancoveragetype->plan_class_id;
									/**
									 * *************** inserting details for coveragetype offered****************
									 */
									if (! empty ( $dataplantypeoffered )) {
							
										//foreach ( $dataplantypeoffered as $planoffered ) {
							
							
										$model_plancoveragetypeoffered->attributes = $dataplantypeoffered;
										$model_plancoveragetypeoffered->plan_class_id = $plan_class_id;
										$model_plancoveragetypeoffered->created_by = $user_id;
										$model_plancoveragetypeoffered->created_date = date ( 'Y-m-d H:i:s' );
										$model_plancoveragetypeoffered->isNewRecord = true;
										$model_plancoveragetypeoffered->coverage_type_id = null;
											
										if ($model_plancoveragetypeoffered->save ()) {
											$coverage_type_id = $model_plancoveragetypeoffered->coverage_type_id;
											/**
											 * *************** inserting details for employee contribtion****************
											 */
											$model_empcontribution->attributes = $dataempcontribution;
											$model_empcontribution->coverage_type_id = $coverage_type_id;
											$model_empcontribution->created_by = $user_id;
											$model_empcontribution->created_date = date ( 'Y-m-d H:i:s' );
											$model_empcontribution->created_by = $user_id;
											$model_empcontribution->isNewRecord = true;
											$model_empcontribution->emp_contribution_id = null;
												
											if ($model_empcontribution->save ()) {
							
												$emp_contribution_id = $model_empcontribution->emp_contribution_id;
												/**
												 * *************** inserting details for employee contribtion premium****************
												 */
												if(!empty($dataempcontributionpremium)){
													
													
													foreach ( $dataempcontributionpremium as $premium ) {
															
															
														$model_empcontributionpremium->attributes = $premium->attributes;
														$model_empcontributionpremium->emp_contribution_id = $emp_contribution_id;
														$model_empcontributionpremium->created_by = $user_id;
														$model_empcontributionpremium->created_date = date ( 'Y-m-d H:i:s' );
														$model_empcontributionpremium->created_by = $user_id;
														$model_empcontributionpremium->isNewRecord = true;
														$model_empcontributionpremium->contribution_premium_id = null;
															
														if ($model_empcontributionpremium->save ()) {
															// do nothing
																
														} else {
																
															$arrerrors = $model_empcontributionpremium->getFirstErrors ();
															$errorstring = '';
																
															foreach ( $arrerrors as $key => $value ) {
																$errorstring .= $value . '<br>';
															}
																
															throw new \Exception ( $errorstring );
														}
													}
												}
												
							
											} else {
							
												$arrerrors = $model_empcontribution->getFirstErrors ();
												$errorstring = '';
							
												foreach ( $arrerrors as $key => $value ) {
													$errorstring .= $value . '<br>';
												}
							
												throw new \Exception ( $errorstring );
											}
												
										} else {
							
											$arrerrors = $model_plancoveragetypeoffered->getFirstErrors ();
											$errorstring = '';
							
											foreach ( $arrerrors as $key => $value ) {
												$errorstring .= $value . '<br>';
											}
							
											throw new \Exception ( $errorstring );
										}
										//}
									}
									/**
									 * *************** inserting details for offertypeyeas****************
									 */
									if (! empty ( $dataplanoffertypeyears)) {
							
										foreach ( $dataplanoffertypeyears as $typeyears ) {
							
							
											$model_planoffertypeyears->attributes = $typeyears->attributes;
											$model_planoffertypeyears->plan_class_id = $plan_class_id;
											$model_planoffertypeyears->created_by = $user_id;
											$model_planoffertypeyears->created_date = date ( 'Y-m-d H:i:s' );
											$model_planoffertypeyears->isNewRecord = true;
											$model_planoffertypeyears->plan_years_id = null;
												
											if ($model_planoffertypeyears->save ()) {
												// do nothing
													
											} else {
							
												$arrerrors = $model_planoffertypeyears->getFirstErrors ();
												$errorstring = '';
							
												foreach ( $arrerrors as $key => $value ) {
													$errorstring .= $value . '<br>';
												}
							
												throw new \Exception ( $errorstring );
											}
										}
									}
								} else {
									
									$arrerrors = $model_plancoveragetype->getFirstErrors ();
									$errorstring = '';
							
									foreach ( $arrerrors as $key => $value ) {
										$errorstring .= $value . '<br>';
									}
							
									throw new \Exception ( $errorstring );
								}
							}
						}
						/**
						 * *************** end loop for plan class****************
						 */
						
						
					}
					$transaction->commit ();
					\Yii::$app->session->setFlash ( 'success', 'Company details copied successfully' );
					return $this->redirect ( array (
							'/admin/copy/index'
					) );
				} catch ( \Exception $e ) {
					
					
					$msg = $e->getMessage ();
					\Yii::$app->session->setFlash ( 'error', $msg );
					// rollback transaction
					$transaction->rollback ();
					/**
					 * Redirect to Index (Company dashboard)*
					 */
					return $this->redirect ( array (
							'/admin/copy/index' 
					) );
				}
			} else {
				\Yii::$app->session->setFlash ( 'error', 'Error While copying files' );
				return $this->redirect ( array ( // redirecting with success message
						'/admin/copy/index' 
				) );
			}
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to home page if session destroyed
			
			return $this->goHome ();
		}
	}
}
