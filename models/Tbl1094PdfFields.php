<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_1094_pdf_fields".
 *
 * @property integer $id
 * @property string $field_label
 * @property string $field_name
 * @property string $field_type
 * @property string $field_value
 */
class Tbl1094PdfFields extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_1094_pdf_fields';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'field_label', 'field_name', 'field_type'], 'required'],
            [['id'], 'integer'],
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
        ];
    }
}
