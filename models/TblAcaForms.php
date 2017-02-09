<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "tbl_aca_forms".
 *
 * @property integer $id
 * @property integer $generate_form_id
 * @property string $version
 * @property integer $company_id
 * @property integer $is_approved
 * @property string $approved_by_name
 * @property integer $created_by
 * @property string $created_date
 * @property integer $approved_by
 * @property string $approved_date
 * @property string $efile_status
 * @property string $efile_receipt_number
 * @property resource $xml_file
 * @property string $efile_receipt_date
 */
class TblAcaForms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_forms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['generate_form_id', 'version', 'company_id', 'created_by'], 'required'],
            [['generate_form_id', 'company_id', 'is_approved', 'created_by', 'approved_by', 'modified_by'], 'integer'],
            [['version'], 'number'],
			[['efile_status', 'xml_file', 'csv_file'], 'string'],
            [['created_date', 'approved_date' , 'modified_date_print', 'modified_date_form', 'efile_receipt_date'], 'safe'],
            [['approved_by_name', 'efile_receipt_number'], 'string', 'max' => 20],
            [['generate_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblGenerateForms::className(), 'targetAttribute' => ['generate_form_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'generate_form_id' => 'Generate Form ID',
            'version' => 'Version',
            'company_id' => 'Company ID',
            'is_approved' => 'Is Approved',
            'approved_by_name' => 'Approved By Name',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'approved_by' => 'Approved By',
			'modified_by' => 'Modified By',
            'approved_date' => 'Approved Date',
			'efile_status' => 'Efile Status',
            'efile_receipt_number' => 'Efile Receipt Number',
			'modified_date_print' => 'Modified Date Print',
            'modified_date_form' => 'Modified Date Form',
			'xml_file' => 'Xml File',
			'csv_file' => 'Csv File',
			'efile_receipt_date'=>'Efile Receipt Date',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAca1094s()
    {
    	return $this->hasMany(TblAca1094::className(), ['form_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAca1095s()
    {
    	return $this->hasMany(TblAca1095::className(), ['form_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblGenerateForms()
    {
    	return $this->hasOne(TblGenerateForms::className(), ['id' => 'generate_form_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsername()
    {
    	return $this->hasOne(TblAcaCompanyUsers::className(), ['user_id' => 'created_by']);
    }
	   /**
     * @return \yii\db\ActiveQuery
     */
    public function getModifiedusername()
    {
    	return $this->hasOne(TblAcaCompanyUsers::className(), ['user_id' => 'modified_by']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApprovedusername()
    {
    	return $this->hasOne(TblAcaCompanyUsers::className(), ['user_id' => 'approved_by']);
    }
	 /**
     * @return \yii\db\ActiveQuery
     */
	public function getTblprintandmail()
    {
    	return $this->hasOne(TblAcaPrintAndMail::className(), ['form_id' => 'id']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(TblAcaCompanies::className(), ['company_id' => 'company_id']);
    }
	
	 public function getCompanyreportingyear()
    {
        return $this->hasOne(TblAcaCompanyReportingPeriod::className(), ['company_id' => 'company_id']);
    }
	
	 public function getPdfforms()
    {
    	return $this->hasOne(TblAcaPdfForms::className(), ['form_id' => 'id']);
    }
	
	 public function getTbl_aca_form_errors()
    {
    	return $this->hasOne(TblAcaFormErrors::className(), ['company_id' => 'company_id']);
    }
	
	 public function Cronstatus()
    {

    	$query = new Query ();
    	$query->select ( [
    			'tac.company_name',
    			'tc.client_name',
    			'tfe.error_desc',
    			'tfe.error_type',
    			'taf.approved_date'
    			] )->from ( 'tbl_aca_forms taf' )
    			->join ( 'LEFT JOIN', 'tbl_aca_form_errors tfe', 'tfe.company_id = taf.company_id' )
    			->join ( 'INNER JOIN', 'tbl_aca_companies tac', 'tac.company_id = taf.company_id' )
    			->join ( 'INNER JOIN', 'tbl_aca_clients tc', 'tc.client_id = tac.client_id' )
    			->where ( 'taf.is_approved = 1 AND (((tfe.created_date >= taf.approved_date) AND tfe.error_type=5) OR (taf.xml_file IS NULL)) Order BY taf.created_date,tfe.created_date DESC' );
    	 
    	$command = $query->createCommand ();
    	$details = $command->queryAll ();
    	

		return $details;
       
    }
}
