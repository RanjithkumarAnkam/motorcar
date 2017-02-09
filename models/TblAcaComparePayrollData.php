<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_compare_payroll_data".
 *
 * @property integer $compare_id
 * @property string $session_id
 * @property integer $company_id
 * @property integer $employee_id
 * @property integer $line_number
 * @property string $file_name
 * @property string $uploaded_date
 *
 * @property TblAcaCompanies $company
 * @property TblAcaPayrollData $employee
 */
class TblAcaComparePayrollData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_compare_payroll_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['session_id', 'company_id', 'employee_id', 'line_number', 'file_name'], 'required'],
            [['company_id', 'employee_id', 'line_number'], 'integer'],
            [['uploaded_date'], 'safe'],
            [['session_id'], 'string', 'max' => 100],
            [['file_name'], 'string', 'max' => 250],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaCompanies::className(), 'targetAttribute' => ['company_id' => 'company_id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaPayrollData::className(), 'targetAttribute' => ['employee_id' => 'employee_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'compare_id' => 'Compare ID',
            'session_id' => 'Session ID',
            'company_id' => 'Company ID',
            'employee_id' => 'Employee ID',
            'line_number' => 'Line Number',
            'file_name' => 'File Name',
            'uploaded_date' => 'Uploaded Date',
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
    public function getEmployee()
    {
        return $this->hasOne(TblAcaPayrollData::className(), ['employee_id' => 'employee_id']);
    }
    
    public function findbysessionandcompanyid($companyid,$sessionid)                           //find url for particular id
    {
    	return TblAcaComparePayrollData::find()->where(['company_id'=>$companyid])->andwhere(['session_id'=>$sessionid])->orderBy('line_number,employee_id')->all();
  //  return $sessionid;
    }
	
	  public function findbysessionid($sessionid)                        
    {
    	return TblAcaComparePayrollData::find()->select('uploaded_date')->where(['session_id'=>$sessionid])->one();
    	
    }
}
