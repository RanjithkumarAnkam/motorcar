<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_validation_rules".
 *
 * @property integer $rule_id
 * @property string $validation
 * @property string $error_code
 * @property string $error_message
 * @property integer $element_type
 * @property integer $element_id
 */
class TblAcaValidationRules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_validation_rules';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rule_id', 'validation', 'error_code', 'error_message', 'element_type'], 'required'],
            [['rule_id', 'element_type', 'element_id'], 'integer'],
            [['validation', 'error_message'], 'string', 'max' => 300],
            [['error_code'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rule_id' => 'Rule ID',
            'validation' => 'Validation',
            'error_code' => 'Error Code',
            'error_message' => 'Error Message',
            'element_type' => 'Element Type',
            'element_id' => 'Element ID',
        ];
    }
}
