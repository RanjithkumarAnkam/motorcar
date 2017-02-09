<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_payroll_employment_period".
 *
 * @property integer $period_id
 * @property integer $employee_id
 * @property string $hire_date
 * @property string $termination_date
 * @property integer $plan_class
 * @property integer $status
 * @property integer $waiting_period
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaPayrollData $employee
 */
class TblAcaPayrollEmploymentPeriod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_payroll_employment_period';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'created_by'], 'required'],
            [['employee_id', 'plan_class', 'status', 'waiting_period', 'created_by', 'modified_by'], 'integer'],
            [['hire_date', 'termination_date', 'created_date', 'modified_date'], 'safe'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaPayrollData::className(), 'targetAttribute' => ['employee_id' => 'employee_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'period_id' => 'Period ID',
            'employee_id' => 'Employee ID',
            'hire_date' => 'Hire Date',
            'termination_date' => 'Termination Date',
            'plan_class' => 'Plan Class',
            'status' => 'Status',
            'waiting_period' => 'Waiting Period',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
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
	
	 
    public function getPlanClass()
    {
    	return $this->hasOne(TblAcaPlanCoverageType::className(), ['plan_class_id' => 'plan_class']);
    }
}
