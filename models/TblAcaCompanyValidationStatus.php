<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_company_validation_status".
 *
 * @property integer $validation_id
 * @property integer $company_id
 * @property integer $is_initialized
 * @property string $exception
 * @property integer $is_completed
 * @property string $start_date_time
 * @property string $end_date_time
 *
 * @property TblAcaCompanies $company
 */
class TblAcaCompanyValidationStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_company_validation_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'is_initialized', 'is_completed', 'start_date_time'], 'required'],
            [['company_id', 'is_initialized', 'is_completed'], 'integer'],
            [['exception'], 'string'],
            [['start_date_time', 'end_date_time'], 'safe'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaCompanies::className(), 'targetAttribute' => ['company_id' => 'company_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'validation_id' => 'Validation ID',
            'company_id' => 'Company ID',
            'is_initialized' => 'Is Initialized',
            'exception' => 'Exception',
            'is_completed' => 'Is Completed',
            'start_date_time' => 'Start Date Time',
            'end_date_time' => 'End Date Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(TblAcaCompanies::className(), ['company_id' => 'company_id']);
    }
}
