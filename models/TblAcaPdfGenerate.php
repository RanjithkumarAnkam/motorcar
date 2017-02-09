<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "tbl_aca_pdf_generate".
 *
 * @property integer $id
 * @property integer $form_id
 * @property integer $status
 * @property integer $created_by
 * @property string $created_date
 * @property string $updated_date
 *
 * @property TblAcaForms $form
 */
class TblAcaPdfGenerate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_pdf_generate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_id', 'status', 'created_by'], 'required'],
            [['form_id', 'status', 'created_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['form_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaForms::className(), 'targetAttribute' => ['form_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_id' => 'Form ID',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }

   /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(TblAcaForms::className(), ['id' => 'form_id']);
    }
	
	   /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsername()
    {
    	return $this->hasOne(TblAcaCompanyUsers::className(), ['user_id' => 'created_by']);
    }
	
	 /*
     * this function is used to return the scheduled job for 
     * create forms for 1094,1095,pdf generation upload files to ftp along with the errors if exists
     */
	public function Cronstatus()
    {
	

		$query1 = new Query();
		$query1->select ( ['tpg.status','tpg.form_id','tpg.created_date','tfe.error_desc','tac.company_name','tc.client_name','tfe.error_type'])
		->from ( 'tbl_aca_pdf_generate tpg' )
		->join ( 'INNER JOIN', 'tbl_aca_forms taf', 'tpg.form_id = taf.id' )
		->join ( 'LEFT JOIN', 'tbl_aca_form_errors tfe', 'tfe.company_id = taf.company_id')
		->join ( 'INNER JOIN', 'tbl_aca_companies tac', 'tac.company_id = taf.company_id')
		->join ( 'INNER JOIN', 'tbl_aca_clients tc', 'tac.client_id = tc.client_id')
		->where ( 'tpg.status = 0 OR (tfe.created_date > tpg.created_date AND tpg.status = 1 AND tfe.error_type=3) GROUP BY tpg.id Order BY tpg.created_date,tfe.created_date DESC' );
			
		$command = $query1->createCommand ();
		$dge_details = $command->queryAll ();
		
       
		return $dge_details;
       
    }
}
