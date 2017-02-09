<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_emp_status_track".
 *
 * @property integer $emp_tracking_id
 * @property integer $company_id
 * @property integer $period_id
 * @property integer $ale_applicable
 * @property integer $ale_first_applicable
 * @property integer $ale_category
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaCompanies $company
 * @property TblAcaCompanyReportingPeriod $period
 */
class TblAcaEmpStatusTrack extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_emp_status_track';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'period_id', 'created_by'], 'required'],
            [['company_id', 'period_id', 'ale_applicable', 'ale_first_applicable', 'ale_category', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
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
            'emp_tracking_id' => 'Emp Tracking ID',
            'company_id' => 'Company ID',
            'period_id' => 'Period ID',
            'ale_applicable' => 'Ale Applicable',
            'ale_first_applicable' => 'Ale First Applicable',
            'ale_category' => 'Ale Category',
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
    	return TblAcaEmpStatusTrack::find()->where(['company_id'=>$company_id])->andwhere(['period_id'=>$period_id])->One();
    }
}
