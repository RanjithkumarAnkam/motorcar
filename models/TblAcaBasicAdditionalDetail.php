<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_basic_additional_detail".
 *
 * @property integer $anything_else_id
 * @property integer $company_id
 * @property integer $period_id
 * @property string $hear_about_us
 * @property string $others
 * @property string $anything_else
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaCompanies $company
 * @property TblAcaCompanyReportingPeriod $period
 */
class TblAcaBasicAdditionalDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_basic_additional_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'period_id', 'created_by'], 'required'],
            [['company_id', 'period_id', 'created_by', 'modified_by'], 'integer'],
            [['others', 'anything_else'], 'string'],
            [['created_date', 'modified_date'], 'safe'],
            [['hear_about_us'], 'string', 'max' => 100],
			['anything_else', 'match', 'pattern' => '/^[a-zA-Z0-9, ]+$/', 'message' => '6.2 can only contain alphanumeric, Comma .'],
			['others', 'match', 'pattern' => '/^[a-zA-Z0-9, ]+$/', 'message' => '6.1 Others description can only contain alphanumeric, Comma .'],
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
            'anything_else_id' => 'Anything Else ID',
            'company_id' => 'Company ID',
            'period_id' => 'Period ID',
            'hear_about_us' => 'Hear About Us',
            'others' => 'Others',
            'anything_else' => 'Anything Else',
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
    	return TblAcaBasicAdditionalDetail::find()->where(['company_id' => $id,'period_id'=>$period_id])->One();
    }
}
