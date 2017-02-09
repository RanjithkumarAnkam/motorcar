<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_company_reporting_period".
 *
 * @property integer $period_id
 * @property integer $company_id
 * @property integer $reporting_year
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaAggregatedGroup[] $tblAcaAggregatedGroups
 * @property TblAcaBasicAdditionalDetail[] $tblAcaBasicAdditionalDetails
 * @property TblAcaBasicInformation[] $tblAcaBasicInformations
 * @property TblAcaCompanies $company
 * @property TblAcaDesignatedGovtEntity[] $tblAcaDesignatedGovtEntities
 * @property TblAcaEmpStatusTrack[] $tblAcaEmpStatusTracks
 * @property TblAcaGeneralPlanInfo[] $tblAcaGeneralPlanInfos
 * @property TblAcaMecCoverage[] $tblAcaMecCoverages
 * @property TblAcaPayrollData[] $tblAcaPayrollDatas
 * @property TblAcaPlanCoverageType[] $tblAcaPlanCoverageTypes
 * @property TblAcaPlanCriteria[] $tblAcaPlanCriterias
 */
class TblAcaCompanyReportingPeriod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_company_reporting_period';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'reporting_year', 'created_by'], 'required'],
            [['company_id', 'reporting_year', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaCompanies::className(), 'targetAttribute' => ['company_id' => 'company_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'period_id' => 'Period ID',
            'company_id' => 'Company ID',
            'reporting_year' => 'Reporting Year',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaAggregatedGroups()
    {
        return $this->hasMany(TblAcaAggregatedGroup::className(), ['period_id' => 'period_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaBasicAdditionalDetails()
    {
        return $this->hasMany(TblAcaBasicAdditionalDetail::className(), ['period_id' => 'period_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaBasicInformations()
    {
        return $this->hasMany(TblAcaBasicInformation::className(), ['period_id' => 'period_id']);
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
    public function getTblAcaDesignatedGovtEntities()
    {
        return $this->hasMany(TblAcaDesignatedGovtEntity::className(), ['period_id' => 'period_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaEmpStatusTracks()
    {
        return $this->hasMany(TblAcaEmpStatusTrack::className(), ['period_id' => 'period_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaGeneralPlanInfos()
    {
        return $this->hasMany(TblAcaGeneralPlanInfo::className(), ['period_id' => 'period_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaMecCoverages()
    {
        return $this->hasMany(TblAcaMecCoverage::className(), ['period_id' => 'period_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaPayrollDatas()
    {
        return $this->hasMany(TblAcaPayrollData::className(), ['period_id' => 'period_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaPlanCoverageTypes()
    {
        return $this->hasMany(TblAcaPlanCoverageType::className(), ['period_id' => 'period_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaPlanCriterias()
    {
        return $this->hasMany(TblAcaPlanCriteria::className(), ['period_id' => 'period_id']);
    }
	
	 public function getYear()
    {
    	return $this->hasOne(TblAcaLookupOptions::className(), ['lookup_id' => 'reporting_year']);
    }
	
	 public static function FindbycompanyId($id)
    {
    	
    	return static::find()->where(['company_id'=>$id])->one();
    }
}
