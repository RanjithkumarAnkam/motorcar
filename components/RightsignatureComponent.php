<?php

namespace app\components;

use Yii;
use yii\base\Component;
use app\models\TblAcaSharefileFolders;
use app\models\TblAcaSharefileEmployees;
use app\models\TblAcaCompanies;
use app\models\TblAcaBrands;

class RightsignatureComponent extends Component {
	
	/***** function to get the document details based on recipient email ********/
	function documentdetails($data,$type,$client_brand){ 
		try{
			if($type == 'email'){
				$uri = "https://rightsignature.com/api/documents.json?recipient_email=".$data;
			}
			else{
				$uri = "https://rightsignature.com/api/documents/".$data.".json";
			}
			
			// get the secure token from db
			$secure_token = TblAcaBrands::find()->where(['brand_id'=>$client_brand])->One();
		/*	if(!empty($secure_token->secure_token)){
				$token = $secure_token->secure_token;
				
			}
			else{*/
				
				$token='nNVOqQXgEziK6AhOJ1QmV3CNvBDDs5IC2V133rQM';
			/*}*/
			
			//$headers = array("Content-type: application/json", "api-token: tPHIJhDqqcXz8yRhcYvFmclj11DyJta4RmIbXYD5");
			$headers = array("Content-type: application/json", "api-token: ".$token);
					 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $uri);
			curl_setopt($ch, CURLOPT_TIMEOUT, 300);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_VERBOSE, FALSE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				 
			$curl_response = curl_exec ($ch);
			
			return json_decode($curl_response);
		
		} catch ( \Exception $e ) {
			return '';
		}
	}
}