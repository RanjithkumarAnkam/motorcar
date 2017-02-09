<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_pdf_forms".
 *
 * @property integer $id
 * @property integer $form_id
 * @property string $pdf_zip_name
 * @property integer $is_changed
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 */
class TblAcaPdfForms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_pdf_forms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_id', 'pdf_zip_name', 'created_by'], 'required'],
            [['form_id', 'is_changed', 'created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['pdf_zip_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_id' => 'Form ID',
            'pdf_zip_name' => 'Pdf Zip Name',
            'is_changed' => 'Is Changed',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
        ];
    }
}
