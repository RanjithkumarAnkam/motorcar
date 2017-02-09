<?php

namespace app\modules\client\controllers;
use yii\web\Controller;

class ProfileController extends Controller
{
    public function actionIndex()
    {
    	$this->layout='main-companies';
        return $this->render('index');
    }

   
}
