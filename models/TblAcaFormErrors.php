<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_form_errors".
 *
 * @property integer $error_id
 * @property string $error_desc
 * @property integer $error_type
 * @property integer $company_id
 * @property string $created_date
 */
class TblAcaFormErrors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_form_errors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['error_desc', 'error_type'], 'required'],
            [['error_desc'], 'string'],
            [['error_type', 'company_id'], 'integer'],
            [['created_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'error_id' => 'Error ID',
            'error_desc' => 'Error Desc',
            'error_type' => 'Error Type',
            'company_id' => 'Company ID',
            'created_date' => 'Created Date',
        ];
    }
}
