<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_validation_log".
 *
 * @property integer $log_id
 * @property integer $company_id
 * @property integer $validation_rule_id
 * @property string $modified_date
 * @property integer $is_validated
 *
 * @property TblAcaValidationRulesBack $validationRule
 * @property TblAcaCompanies $company
 */
class TblAcaValidationLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_validation_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'validation_rule_id', 'modified_date', 'is_validated'], 'required'],
            [['company_id', 'validation_rule_id', 'is_validated'], 'integer'],
            [['modified_date'], 'safe'],
            [['validation_rule_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaValidationRules::className(), 'targetAttribute' => ['validation_rule_id' => 'rule_id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaCompanies::className(), 'targetAttribute' => ['company_id' => 'company_id']],
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
            'validation_rule_id' => 'Validation Rule ID',
            'modified_date' => 'Modified Date',
            'is_validated' => 'Is Validated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValidationRule()
    {
        return $this->hasOne(TblAcaValidationRules::className(), ['rule_id' => 'validation_rule_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(TblAcaCompanies::className(), ['company_id' => 'company_id']);
    }
}
