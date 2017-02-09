<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_1095_pdf_fields".
 *
 * @property integer $id
 * @property string $field_label
 * @property string $field_name
 * @property string $field_type
 * @property string $field_value
 * @property integer $is_ssn
 */
class Tbl1095PdfFields extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_1095_pdf_fields';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'field_label', 'field_name', 'field_type'], 'required'],
            [['id', 'is_ssn'], 'integer'],
            [['field_type'], 'string'],
            [['field_label', 'field_name'], 'string', 'max' => 500],
            [['field_value'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field_label' => 'Field Label',
            'field_name' => 'Field Name',
            'field_type' => 'Field Type',
            'field_value' => 'Field Value',
            'is_ssn' => 'Is Ssn',
        ];
    }
}
