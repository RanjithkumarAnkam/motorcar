<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_sharefile_employees".
 *
 * @property integer $sharefile_user_id
 * @property integer $user_id
 * @property integer $client_id
 * @property string $username
 * @property string $password
 * @property string $sharefile_employee_id
 * @property string $created_date
 */
class TblAcaSharefileEmployees extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_sharefile_employees';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'client_id', 'username', 'password', 'sharefile_employee_id'], 'required'],
            [['user_id', 'client_id', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['username', 'password', 'sharefile_employee_id'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sharefile_user_id' => 'Sharefile User ID',
            'user_id' => 'User ID',
            'client_id' => 'Client ID',
            'username' => 'Username',
            'password' => 'Password',
            'sharefile_employee_id' => 'Sharefile Employee ID',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }
}
