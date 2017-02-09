<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_staff_user_permission".
 *
 * @property integer $admin_staff_permission_id
 * @property integer $staff_id
 * @property integer $staff_permission_id
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaStaffUsers $staff
 * @property TblAcaStaffRightsMaster $staffPermission
 */
class TblAcaStaffUserPermission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_staff_user_permission';
    }

    /**
     * @inheritdoc
     */
    public $permissions;
    
    public function rules()
    {
        return [
            [['staff_id', 'staff_permission_id', 'created_by'], 'required'],
            [['staff_id', 'staff_permission_id', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaStaffUsers::className(), 'targetAttribute' => ['staff_id' => 'staff_id']],
            [['staff_permission_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaStaffRightsMaster::className(), 'targetAttribute' => ['staff_permission_id' => 'staff_permission_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'admin_staff_permission_id' => 'Admin Staff Permission ID',
            'staff_id' => 'Staff ID',
            'staff_permission_id' => 'Staff Permission ID',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(TblAcaStaffUsers::className(), ['staff_id' => 'staff_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffPermission()
    {
        return $this->hasOne(TblAcaStaffRightsMaster::className(), ['staff_permission_id' => 'staff_permission_id']);
    }
    
    /**
     * Finds user by id
     *
     * @param string $id
     * @return static|null
     */
    public static function findById($id)
    {
    	return static::findAll(['staff_id' => $id]);
    }
    
    /**
     * Finds user by id
     *
     * @param string $id
     * @return static|null
     */
    public static function findpermissionsById($id)
    {
    	$details = static::findAll(['staff_id' => $id]);
    	$permissions = array();
    	if(!empty($details))
    	{
    		foreach($details as $detail)
    		{
    			$permissions[]=$detail->staff_permission_id;
    		}
    	}
    	return $permissions;
    }
    
    /**
     *
     * Find all permissions in string format
     */
    public static function findPermissionsstring($id)
    {
    	$details = static::findAll(['staff_id' => $id]);
    	$permissions = '';
    	if(!empty($details))
    	{
    		foreach($details as $detail)
    		{
    			$permissions .= $detail->staffPermission->permission_name.', ';
    		}
    	}
    	else 
    	{
    		$permissions = '<span style="color: black;">No Permissions assigned</span>';
    	}
    	return $permissions;
    }
}
