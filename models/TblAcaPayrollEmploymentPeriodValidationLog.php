<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_payroll_employment_period_validation_log".
 *
 * @property integer $log_id
 * @property integer $company_id
 * @property integer $employee_id
 * @property integer $period_id
 * @property integer $validation_rule_id
 * @property integer $is_validated
 * @property string $modified_date
 *
 * @property TblAcaPayrollData $employee
 * @property TblAcaValidationRules $validationRule
 */
class TblAcaPayrollEmploymentPeriodValidationLog extends \yii\db\ActiveRecord
{
	public $cnt;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_payroll_employment_period_validation_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'employee_id', 'period_id', 'validation_rule_id', 'is_validated'], 'required'],
            [['company_id', 'employee_id', 'period_id', 'validation_rule_id', 'is_validated'], 'integer'],
            [['modified_date'], 'safe'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaPayrollData::className(), 'targetAttribute' => ['employee_id' => 'employee_id']],
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
            'company_id' => 'Company ID',
            'employee_id' => 'Employee ID',
            'period_id' => 'Period ID',
            'validation_rule_id' => 'Validation Rule ID',
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
    public function getValidationRule()
    {
        return $this->hasOne(TblAcaValidationRules::className(), ['rule_id' => 'validation_rule_id']);
    }
}
