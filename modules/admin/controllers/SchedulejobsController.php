<?php

namespace app\modules\admin\controllers;
use yii\web\Controller;
use app\models\TblAcaCompanyValidationStatus;
use app\models\TblGenerateForms;
use app\models\TblAcaPdfGenerate;
use app\models\TblAcaForms;

class SchedulejobsController extends \yii\web\Controller
{
    public function actionIndex()
    {
	
        \Yii::$app->view->title = 'ACA Reporting Service | Scheduled Job Status';
		$this->layout = 'main';
		if (\Yii::$app->SessionCheck->isLogged () == true) 		// checking logged session
		{
			$model_validation_status = TblAcaCompanyValidationStatus::find()->where(['<>','is_completed',1])->andwhere(['is_initialized'=>1])->all();
			
			$model_generate_form =new TblGenerateForms();
			$model_generate_forms = $model_generate_form->cronstatus();
		
			//TblGenerateForms::find()->where(['<>','cron_status',2])->all();
			$model_pdfgenerate = new TblAcaPdfGenerate();
				$model_generate_pdf = $model_pdfgenerate->cronstatus();
			//	print_r($model_generate_pdf); die();
				//TblAcaPdfGenerate::find()->where(['status'=>0])->all();
		
			
			$model_xmlgenerate = new TblAcaForms();
			$model_generate_xml = $model_xmlgenerate->cronstatus();
			
			//TblAcaForms::find()->where(['is_approved'=>1])->andWhere(['xml_file'=>NULL])->All();	
			
			
			return $this->render ( 'index',[
			'model_validation_status'=>$model_validation_status,
			'model_generate_form'=>$model_generate_form,
			'model_generate_forms'=>$model_generate_forms,
			'model_generate_pdf'=>$model_generate_pdf,
			'model_generate_xml'=>$model_generate_xml
			]);
		} else {
			\Yii::$app->SessionCheck->adminlogout (); // Redirecting to login page if session destroyed
			
			return $this->goHome ();
		}	
		
	}

}
