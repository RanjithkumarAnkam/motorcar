<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_payroll_element_master".
 *
 * @property integer $element_id
 * @property string $element_name
 */
class TblAcaPayrollElementMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_payroll_element_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['element_id', 'element_name'], 'required'],
            [['element_id'], 'integer'],
            [['element_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'element_id' => 'Element ID',
            'element_name' => 'Element Name',
        ];
    }
}
