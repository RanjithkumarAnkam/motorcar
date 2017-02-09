<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_sharefile_error".
 *
 * @property integer $error_id
 * @property integer $user_id
 * @property string $error_in
 * @property string $error_msg
 * @property string $created_date
 * @property string $modified_date
 */
class TblAcaSharefileError extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_sharefile_error';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['error_in'], 'string', 'max' => 100],
            [['error_msg'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'error_id' => 'Error ID',
            'user_id' => 'User ID',
            'error_in' => 'Error In',
            'error_msg' => 'Error Msg',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
        ];
    }
}
