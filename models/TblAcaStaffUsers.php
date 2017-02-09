<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_staff_users".
 *
 * @property integer $staff_id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $profile_pic
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaStaffUserPermission[] $tblAcaStaffUserPermissions
 * @property TblAcaUsers $user
 */
class TblAcaStaffUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_staff_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'first_name', 'last_name', 'created_by'], 'required'],
            [['user_id', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 100],
			['first_name', 'match', 'pattern' => '/^[a-zA-Z ]+$/', 'message' => 'First name can only contain alphabets.'],
			['last_name', 'match', 'pattern' => '/^[a-zA-Z ]+$/', 'message' => 'Last name can only contain alphabets.'],
			[['phone'], 'string', 'max' => 20],
			[['phone_ext'], 'string', 'max' => 10],
            [['profile_pic'], 'string', 'max' => 200],
			['profile_pic', 'file', 'extensions' => 'jpeg, gif, png, jpg'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaUsers::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'staff_id' => 'Staff ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
			'phone_ext' => 'Phone Ext',
            'phone' => 'Phone',
            'profile_pic' => 'Profile Pic',
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
        return $this->hasMany(TblAcaStaffUserPermission::className(), ['staff_id' => 'staff_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(TblAcaUsers::className(), ['user_id' => 'user_id']);
    }
    
    public function getadminusers()
    {
    	return static::find()->joinWith('user')->where(['tbl_aca_users.is_deleted'=>0,'tbl_aca_users.usertype'=>1]) ->andWhere(['<>','tbl_aca_users.user_id', 1])->All();
    }
    /**
     * Finds user by id
     *
     * @param string $id
     * @return static|null
     */
    public static function findById($id)
    {
    	return static::findOne(['user_id' => $id]);
    }
	
	public static function Findallmanagerscount()
    {
    	$all_managers = static::find()
    	->joinWith('user')
    	->Where(['tbl_aca_users.is_active'=>1])
    	->andwhere(['tbl_aca_users.is_deleted'=>0])
    	->All();
    	
    	return count($all_managers);
    }
    
    public static function Topfiveusers()
    {
    	return static::find()
    	->joinWith('user')
    	//->Where(['tbl_aca_users.is_active'=>1])
    	->andwhere(['tbl_aca_users.is_deleted'=>0])
		->orderBy(['staff_id' => SORT_DESC])
    	->limit(5)
    	->All();
    	
    	 
    	
    }
   
    
}
