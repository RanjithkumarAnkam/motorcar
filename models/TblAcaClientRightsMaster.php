<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_client_rights_master".
 *
 * @property integer $client_permission_id
 * @property string $permission_name
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaCompanyUserPermission[] $tblAcaCompanyUserPermissions
 */
class TblAcaClientRightsMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_client_rights_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['permission_name', 'created_by', 'modified_by', 'modified_date'], 'required'],
            [['created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['permission_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client_permission_id' => 'Client Permission ID',
            'permission_name' => 'Permission Name',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaCompanyUserPermissions()
    {
        return $this->hasMany(TblAcaCompanyUserPermission::className(), ['client_permission_id' => 'client_permission_id']);
    }
    
    public static function Findallrights()
    {
    	return static::find()->All();
    }
}
