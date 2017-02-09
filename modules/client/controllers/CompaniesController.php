<?php

namespace app\modules\client\controllers;
use yii\web\Controller;
use app\models\TblAcaCompanies;
use app\models\TblAcaClients;
use app\components\EncryptDecryptComponent;
use app\models\TblAcaCompanyReportingPeriod;
use app\models\TblAcaCompaniesSearch;
use mikehaertl\pdftk\Pdf;

class CompaniesController extends Controller
{
	
		/**
	 * Displays homepage.
	 *
	 * action for rendering companies
	 */
    public function actionIndex()
    {
	/*	$file_loc='/files/f1095c.pdf';
		
		$pdf = new Pdf($file_loc);
		
		$pdf->fillForm(array(
				'topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].f1_24[0]'=>'testing',
				//'topmostSubform[0].Page1[0].Name[0].f1_01[0]'=>'ranjith',
			//	'topmostSubform[0].Page1[0].Part2Table[0].BodyRow1[0].f1_016[0]'=>'test',
		))
		->flatten()
		//->saveAs('filled.pdf');
		->send();
		
		$data = $pdf->getDataFields();
		echo '<pre>';
		print_r($pdf); die();*/
		
		
    	
    	if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
    	{
    	$this->layout='main-companies';                                 //using layout
    	$model_companies = new TblAcaCompanies();                       //initialising models
    	$model_client = new TblAcaClients();
    	$model_company_period = new TblAcaCompanyReportingPeriod();
    	
    	$session = \Yii::$app->session;                                 //initialising session
    	$logged_user_id = $session ['client_user_id'];                  //storing values into variable
    	$client_ids =  $session ['client_ids']; //all related clients to the logged user
		$company_ids = $session ['company_ids'];//all related companies to the logged user
		$mapped_company_ids = array_map(function($piece){
				return (string) $piece;
			}, $company_ids);
		
    	$searchModel = new TblAcaCompaniesSearch();
			$dataProvider = $searchModel->searchcompanies( \Yii::$app->request->queryParams,$company_ids);
    		
    	$all_companies = $model_companies->FindallwherecompanyIds($company_ids); //finding all companies
    	
    	
    	
    
    	
    	
        return $this->render('index', [                        //rendering the values to view 
					'dataProvider'=>$dataProvider,
        		'searchModel'=>$searchModel,
					'all_companies' => $all_companies,
        		
			] );
        } else {
        	\Yii::$app->SessionCheck->clientlogout ();            //checks session and if not set logouts
        		
        	return $this->goHome ();
        }
    }

   
    public function actionCompanydetails()
    {
    	if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
    	{
    		
    		$encrypt_component = new EncryptDecryptComponent();        //function for encrpt the user id
    		$model_companies = new TblAcaCompanies();                   //initialising model
    		$result = array();                                          //preparing array
    		
    		
    		$company = \Yii::$app->request->post();
    		$encrypt_company_id = $company['company_id'];
    		
    		$company_id = $encrypt_component->decryptUser($encrypt_company_id);          //decrypt the user id
    		
    		$company_details = $model_companies->Companyuniquedetails($company_id);       //getting the company details
    		
    		if(!empty($company_details))
    		{
    			$result['company_name'] = $company_details->company_name;
    			$result['company_ein'] = $company_details->company_ein;
    			$period_details = $model_companies->getcompanyperiod($company_details->company_id);
    			$result['reporting_year'] = $period_details->tbl_aca_company_reporting_period->reporting_year;
    		   		}
    		
    		return json_encode($result);                    //return the json result
    	 } else {
        	\Yii::$app->SessionCheck->clientlogout ();           //checks session and if not set logouts
        		
        	return $this->goHome ();
        }
    }
    
    /*
	*action for update company
	*/
    
    public function actionUpdatecompany()
    {
    	if (\Yii::$app->SessionCheck->isclientLogged () == true) 		// checking logged session
    	{
    		
    	$session = \Yii::$app->session;                                 //initialising session
    	$logged_user_id = $session ['client_user_id'];                  //storing in variable
    		 
    		
    	$company_details = \Yii::$app->request->post();                //getting the post values
    	
    	$encrypt_component = new EncryptDecryptComponent();             //initialising encrpt component
    	$model_companies = new TblAcaCompanies();                      //initialising model
    	$model_company_reporting_year = new TblAcaCompanyReportingPeriod();
    	$result = array();                                               //initialising array
    	$check_ein_validity = array();
		$arrerrors = array();
    	$encrypt_company_id = $company_details['company_id'];
    	
    	$company_id = $encrypt_component->decryptUser($encrypt_company_id);      //decrypt the user id
    	$company_name = $company_details['company_name'];
    	$company_ein = $company_details['company_ein'];
    	$company_reporting_year = $company_details['company_reporting_year'];
    	if($company_id)                                   //checking for company id
    	{
    		
    		$old_company_details = $model_companies->Companyuniquedetails($company_id);           //getting details of particular company
    		$old_company_period = $model_company_reporting_year->FindbycompanyId($company_id);    //getting period of company
    		if(!empty($old_company_details))
    		{
				if($old_company_details->company_ein != $company_ein )
				{
				$check_ein_validity = $model_companies->Checkeinvalidity($old_company_details->company_ein,$company_ein,$company_reporting_year);   
    			}
				if(empty($check_ein_validity))
				{
				// begin transaction
    			$transaction = \Yii::$app->db->beginTransaction ();
    				
    			try {                         
    				
    				$old_company_details->company_name = $company_name;                    //assigning values
    				$old_company_details->company_ein = $company_ein;
    				$old_company_details->modified_by  = $logged_user_id;
    				$old_company_details->modified_date = date('Y-m-d H:i:s');
    				
    				if($old_company_details->save() && $old_company_details->validate() )       //validating and saving model
    				{
    					
    					$old_company_period->reporting_year = $company_reporting_year;         //assigning values
    					$old_company_period->modified_by  = $logged_user_id;
    					$old_company_period->modified_date = date('Y-m-d H:i:s');
    					
    					if($old_company_period->save())                           //save model
    					{
    						$transaction->commit();                         //commiting the transaction
    						$result = 'success';
    						
    					}
    					
    				}
					else{
						$arrerrors = $old_company_details->getFirstErrors();
						
						$errorstring = '';
							/*******Converting error into string********/
							foreach ($arrerrors as $key=>$value)
							{
								$errorstring .= $value.'<br>';
							}
							
							throw new \Exception($errorstring);
						
					}
    				
    			} catch ( \Exception $e ) {             //catch the exception
				
				$result = $e->getMessage ();
				
				
				// rollback transaction
				$transaction->rollback ();                  //transaction rollback
			}
    			
    		}
			else
			{
				$result = 'EIN already exists in selected year.';
				
			}	
    			
    		}
    	 	}
    	 	
    	 	return $result;
    	} else {
    		\Yii::$app->SessionCheck->clientlogout ();           //checks session and if not set logouts
    	
    		return $this->goHome ();
    	}
    }
}
