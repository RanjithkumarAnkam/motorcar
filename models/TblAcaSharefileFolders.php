<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_sharefile_folders".
 *
 * @property integer $folder_id
 * @property integer $user_id
 * @property integer $client_id
 * @property integer $company_id
 * @property string $company_client_number
 * @property string $folder_name
 * @property string $sharefile_folder_id
 * @property string $created_date
 */
class TblAcaSharefileFolders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_sharefile_folders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'client_id', 'company_id', 'company_client_number', 'folder_name', 'sharefile_folder_id'], 'required'],
            [['user_id', 'client_id', 'company_id', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['company_client_number', 'folder_name', 'sharefile_folder_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'folder_id' => 'Folder ID',
            'user_id' => 'User ID',
            'client_id' => 'Client ID',
            'company_id' => 'Company ID',
            'company_client_number' => 'Company Client Number',
            'folder_name' => 'Folder Name',
            'sharefile_folder_id' => 'Sharefile Folder ID',
             'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }
}
