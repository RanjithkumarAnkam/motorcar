<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_general_plan_info".
 *
 * @property integer $general_plan_id
 * @property integer $company_id
 * @property integer $period_id
 * @property integer $is_first_year
 * @property integer $renewal_month
 * @property string $plan_type_description
 * @property integer $is_multiple_waiting_periods
 * @property string $multiple_description
 * @property integer $is_employees_hra
 * @property integer $offer_type
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaCompanies $company
 * @property TblAcaCompanyReportingPeriod $period
 */
class TblAcaGeneralPlanInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_general_plan_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'period_id'], 'required'],
            [['company_id', 'period_id', 'is_first_year', 'renewal_month', 'is_multiple_waiting_periods', 'is_employees_hra', 'offer_type', 'created_by', 'modified_by'], 'integer'],
            [['plan_type_description', 'multiple_description'], 'string'],
            [['created_date', 'modified_date'], 'safe'],
			['plan_type_description', 'match', 'pattern' => '/^[a-zA-Z0-9, ]+$/', 'message' => 'Short Description can only contain alphanumeric, Comma .'],
            ['multiple_description', 'match', 'pattern' => '/^[a-zA-Z0-9, ]+$/', 'message' => 'Multiple waiting period description can only contain alphanumeric, Comma .'],
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
            'general_plan_id' => 'General Plan ID',
            'company_id' => 'Company ID',
            'period_id' => 'Period ID',
            'is_first_year' => 'Is First Year',
            'renewal_month' => 'Renewal Month',
            'plan_type_description' => 'Plan Type Description',
            'is_multiple_waiting_periods' => 'Is Multiple Waiting Periods',
            'multiple_description' => 'Multiple Description',
            'is_employees_hra' => 'Is Employees Hra',
            'offer_type' => 'Offer Type',
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
    /**Function used to get particular additional details**/
    public function FindbycompanyIdperiodId($id,$period_id)
    {
    	return TblAcaGeneralPlanInfo::find()->where(['company_id' => $id,'period_id'=>$period_id])->One();
    }
}
