<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_staff_rights_master".
 *
 * @property integer $staff_permission_id
 * @property string $permission_name
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaStaffUserPermission[] $tblAcaStaffUserPermissions
 */
class TblAcaStaffRightsMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_staff_rights_master';
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
            'staff_permission_id' => 'Staff Permission ID',
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
    public function getTblAcaStaffUserPermissions()
    {
        return $this->hasMany(TblAcaStaffUserPermission::className(), ['staff_permission_id' => 'staff_permission_id']);
    }
    
    /*
     * Getting all permissions from table
     * */
    
    public function getAllpermissions()
    {
    	return static::find()->All();
    }
}
