<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "tbl_generate_forms".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $version
 * @property integer $cron_status
 * @property integer $created_by
 * @property string $created_date
 * @property string $updated_date
 */
class TblGenerateForms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_generate_forms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'version', 'created_by'], 'required'],
            [['company_id', 'cron_status', 'created_by'], 'integer'],
            [['version'], 'number'],
            [['created_date', 'updated_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'version' => 'Version',
            'cron_status' => 'Cron Status',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }
	
	 /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(TblAcaCompanies::className(), ['company_id' => 'company_id']);
    }
	
	 /**
     * @return \yii\db\ActiveQuery
     */
    public function getErrorcompany()
    {
        return $this->hasOne(TblAcaFormErrors::className(), ['company_id' => 'company_id']);
    }

	 public function Cronstatus()
    {
    	
    	$query = new Query();
    	$query->select ( [
    			'tac.company_name',
    			'tc.client_name',
    			'tfe.error_desc',
    			'tfe.error_type',
    			'tgf.created_date',
    			'tgf.cron_status'
    			] )->from ( 'tbl_generate_forms tgf' )
    			->join ( 'LEFT JOIN', 'tbl_aca_form_errors tfe', 'tfe.company_id = tgf.company_id' )
    			->join ( 'INNER JOIN', 'tbl_aca_companies tac', 'tac.company_id = tgf.company_id' )
    			->join ( 'INNER JOIN', 'tbl_aca_clients tc', 'tc.client_id = tac.client_id' )
    			->where ( '(tgf.cron_status = 0) OR 
    					(tfe.created_date >= tgf.created_date AND 
    					tgf.cron_status =1 AND tfe.error_type IN (1,2)) Order BY tgf.created_date,tfe.created_date DESC' );
    	 
    	$command = $query->createCommand ();
    	$details = $command->queryAll ();
    	
		return $details;
    }
	
	public function Errortype($value){
		
		switch ($value) {
				case (1):
					$value ='1094:';
					break;
				case (2):
					$value ='1095:';
					break;
				
				case (3):
						$value ='Pdf Generation:';
						break;
			    case (4):
		 				$value ='';
						break;
				 case (5):
		 				$value ='xml generation:';
						break;
				default:
					$value = '';
					break;
						
					
			}
			
			return $value;
	}

}
