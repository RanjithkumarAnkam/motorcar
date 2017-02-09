<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_payroll_validation_log".
 *
 * @property integer $log_id
 * @property integer $employee_id
 * @property integer $validation_rule_id
 * @property integer $company_id
 * @property integer $is_validated
 * @property string $modified_date
 *
 * @property TblAcaPayrollData $employee
 * @property TblAcaCompanies $company
 * @property TblAcaValidationRules $validationRule
 */
class TblAcaPayrollValidationLog extends \yii\db\ActiveRecord
{
	public $cnt;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_payroll_validation_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'validation_rule_id', 'company_id', 'is_validated'], 'required'],
            [['employee_id', 'validation_rule_id', 'company_id', 'is_validated'], 'integer'],
            [['modified_date'], 'safe'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaPayrollData::className(), 'targetAttribute' => ['employee_id' => 'employee_id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaCompanies::className(), 'targetAttribute' => ['company_id' => 'company_id']],
            [['validation_rule_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaValidationRules::className(), 'targetAttribute' => ['validation_rule_id' => 'rule_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'employee_id' => 'Employee ID',
            'validation_rule_id' => 'Validation Rule ID',
            'company_id' => 'Company ID',
            'is_validated' => 'Is Validated',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(TblAcaPayrollData::className(), ['employee_id' => 'employee_id']);
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
    public function getValidationRule()
    {
        return $this->hasOne(TblAcaValidationRules::className(), ['rule_id' => 'validation_rule_id']);
    }
}
