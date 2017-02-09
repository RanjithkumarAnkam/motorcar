<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_plan_class_validation_log".
 *
 * @property integer $log_id
 * @property integer $plan_class_id
 * @property integer $validation_rule_id
 * @property integer $company_id
 * @property integer $is_validated
 * @property string $modified_date
 *
 * @property TblAcaCompanies $company
 * @property TblAcaValidationRules $validationRule
 * @property TblAcaPlanCoverageType $planClass
 */
class TblAcaPlanClassValidationLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_plan_class_validation_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plan_class_id', 'validation_rule_id', 'company_id', 'is_validated'], 'required'],
            [['plan_class_id', 'validation_rule_id', 'company_id', 'is_validated'], 'integer'],
            [['modified_date'], 'safe'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaCompanies::className(), 'targetAttribute' => ['company_id' => 'company_id']],
            [['validation_rule_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaValidationRules::className(), 'targetAttribute' => ['validation_rule_id' => 'rule_id']],
            [['plan_class_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaPlanCoverageType::className(), 'targetAttribute' => ['plan_class_id' => 'plan_class_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'plan_class_id' => 'Plan Class ID',
            'validation_rule_id' => 'Validation Rule ID',
            'company_id' => 'Company ID',
            'is_validated' => 'Is Validated',
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
    public function getValidationRule()
    {
        return $this->hasOne(TblAcaValidationRules::className(), ['rule_id' => 'validation_rule_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanClass()
    {
        return $this->hasOne(TblAcaPlanCoverageType::className(), ['plan_class_id' => 'plan_class_id']);
    }
}
