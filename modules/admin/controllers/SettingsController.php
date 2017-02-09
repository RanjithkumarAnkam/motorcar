<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class SettingsController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$this->layout='main';
        return $this->render('index');
    }
    
    public function actionOptions()
    {
    	$this->layout='main';
    	return $this->render('options');
    }
}
