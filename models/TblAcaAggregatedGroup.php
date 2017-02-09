<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_aggregated_group".
 *
 * @property integer $aggregated_grp_id
 * @property integer $company_id
 * @property integer $period_id
 * @property integer $is_authoritative_transmittal
 * @property integer $is_ale_member
 * @property integer $is_other_entity
 * @property integer $total_1095_forms
 * @property string $total_aggregated_grp_months
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaCompanies $company
 * @property TblAcaCompanyReportingPeriod $period
 * @property TblAcaAggregatedGroupList[] $tblAcaAggregatedGroupLists
 */
class TblAcaAggregatedGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_aggregated_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'period_id', 'created_by'], 'required'],
            [['company_id', 'period_id', 'is_authoritative_transmittal', 'is_ale_member', 'is_other_entity', 'total_1095_forms', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['total_aggregated_grp_months'], 'string', 'max' => 50],
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
            'aggregated_grp_id' => 'Aggregated Grp ID',
            'company_id' => 'Company ID',
            'period_id' => 'Period ID',
            'is_authoritative_transmittal' => 'Is Authoritative Transmittal',
            'is_ale_member' => 'Is Ale Member',
            'is_other_entity' => 'Is Other Entity',
            'total_1095_forms' => 'Total 1095 Forms',
            'total_aggregated_grp_months' => 'Total Aggregated Grp Months',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaAggregatedGroupLists()
    {
        return $this->hasMany(TblAcaAggregatedGroupList::className(), ['aggregated_grp_id' => 'aggregated_grp_id']);
    }
    
    /**Function used to get particular aggregate group details**/
    public function FindbycompanyIdperiodId($id,$period_id)
    {
    	return TblAcaAggregatedGroup::find()->where(['company_id' => $id,'period_id'=>$period_id])->One();
    }
}
