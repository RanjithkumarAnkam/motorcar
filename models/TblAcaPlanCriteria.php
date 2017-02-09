<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_plan_criteria".
 *
 * @property integer $plan_criteria_id
 * @property integer $company_id
 * @property integer $period_id
 * @property integer $hours_tracking_method
 * @property string $initial_measurement_period
 * @property integer $initial_measurment_period_begin
 * @property string $plan_offering_criteria_type
 * @property integer $company_certification_workforce
 * @property integer $company_certification_medical_eligibility
 * @property integer $company_certification_employer_contribution
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaCompanies $company
 * @property TblAcaCompanyReportingPeriod $period
 */
class TblAcaPlanCriteria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_plan_criteria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'period_id', 'created_by'], 'required'],
            [['company_id', 'period_id', 'hours_tracking_method', 'initial_measurment_period_begin', 'company_certification_workforce', 'company_certification_medical_eligibility', 'company_certification_employer_contribution', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['initial_measurement_period'], 'string', 'max' => 10],
			[['initial_measurement_period'], 'in','range'=>range(30,365),'message' => 'Length of initial measurement period should be in between 30-365 days'],
            [['plan_offering_criteria_type'], 'string', 'max' => 25],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaCompanies::className(), 'targetAttribute' => ['company_id' => 'company_id']],
            [['period_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaCompanyReportingPeriod::className(), 'targetAttribute' => ['period_id' => 'period_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'plan_criteria_id' => 'Plan Criteria ID',
            'company_id' => 'Company ID',
            'period_id' => 'Period ID',
            'hours_tracking_method' => 'Hours Tracking Method',
            'initial_measurement_period' => 'Initial Measurement Period',
            'initial_measurment_period_begin' => 'Initial Measurment Period Begin',
            'plan_offering_criteria_type' => 'Plan Offering Criteria Type',
            'company_certification_workforce' => 'Company Certification Workforce',
            'company_certification_medical_eligibility' => 'Company Certification Medical Eligibility',
            'company_certification_employer_contribution' => 'Company Certification Employer Contribution',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
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
    public function getPeriod()
    {
        return $this->hasOne(TblAcaCompanyReportingPeriod::className(), ['period_id' => 'period_id']);
    }
    
    public function FindbycompanyIdperiodId($company_id,$period_id)
    {
    	return TblAcaPlanCriteria::find()->where(['company_id'=>$company_id])->andwhere(['period_id'=>$period_id])->One();
    }
}
