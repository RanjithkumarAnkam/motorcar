<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\models\TblAcaCompanies;
use app\models\TblAcaCompaniesSearch;
use yii\db\Query;

/**
 * Default controller for the `admin` module
 */
class CompanyController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
		\Yii::$app->view->title = 'ACA Reporting Service | Manage Companies';
		$session = \Yii::$app->session;
		$admin_permissions = $session ['admin_permissions'];
    	if (\Yii::$app->SessionCheck->isLogged () == true && in_array("4", $admin_permissions)) 		// checking logged session
    	{
			/*if(\Yii::$app->Permission->CheckAdminactionpermission ( '4' ) == true)
                  {*/
    	$this->layout='main';
    	$model_companies = new TblAcaCompanies();              //initialising model
		$searchModel = new TblAcaCompaniesSearch();
		
    	$all_companies = $model_companies->Findallcompanies();      //finding all companies
		
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams); //dataProvider for grid 
		
        return $this->render('index', [                       //render values to index view
					'all_companies' => $all_companies,
					'dataProvider'=>$dataProvider,
					'searchModel'=>$searchModel,
			] );
			
			/* }else{
					\Yii::$app->session->setFlash ( 'error', 'Permission denied' );
							return $this->redirect ( array (
									'/admin' 
							) );  
				  }*/
				  
        } else {
        	\Yii::$app->SessionCheck->adminlogout ();        // Redirecting to home page if session destroyed
        		
        	return $this->goHome ();
        }
    }
	
    public function actionAddform()
    {
    	$this->layout='main';
    	return $this->render('addform');
    }
    
	/**
	 * Action for updating the status of lookupoptions
	 */
	public function actionStatuschange()
    {
		$result = '';
       $post=\Yii::$app->request->post (); 
        if(!empty($post))	{                                 //checking the values for post
		$id = $post ['id'];
		$old_status = '';
		$statusid = $post ['statusid'];
		$model_companies = new TblAcaCompanies();
		$transaction = \Yii::$app->db->beginTransaction ();      // begining the transaction
		try {
			$model=$model_companies->Companyuniquedetails($id);      //finding unique details of a company
			$old_status = $model->reporting_status;
			
			if($statusid >= $old_status)
			{
				$model->reporting_status = strip_tags($statusid);
			
			
			if ($model->save () && $model->validate ())           // validating model and saving it(server side validation)

			{
				  
				$transaction->commit ();                       // commiting the transaction
				 $result = 'success';                             //sending response to ajax
			} else {
				
				$result = 'fail';                                   //sending response to ajax
			}
		}
		else {
				
				$result = 'Cannot degrade company reporting status';                                   //sending response to ajax
			}
		} catch ( \Exception $e ) {                          // catching the exception
			
			$msg = $e->getMessage ();
			$result = $msg;
    		 
    		$transaction->rollback ();                    //if exception occurs transaction rollbacks
    	}
	}else{
		$result = 'fail';
	}
	
	return $result;
    }
	
    public function actionEditform()
    {
    	$this->layout='main';
    	return $this->render('editform');
    }

}
