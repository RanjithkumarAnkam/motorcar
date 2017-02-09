<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_company_users".
 *
 * @property integer $company_user_id
 * @property integer $client_id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property string $address_1
 * @property string $address_2
 * @property string $state
 * @property string $city
 * @property integer $zip
 * @property string $role_notes
 * @property string $profile_image
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaCompanyUserPermission[] $tblAcaCompanyUserPermissions
 * @property TblAcaClients $client
 * @property TblAcaUsers $user
 */
class TblAcaCompanyUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_company_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'user_id', 'first_name', 'last_name', 'email', 'role_notes', 'created_by'], 'required'],
            [['client_id', 'user_id', 'zip', 'is_admin','created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['address_1', 'address_2', 'profile_image'], 'string', 'max' => 200],
			['first_name', 'match', 'pattern' => '/^[a-zA-Z- ]+$/', 'message' => 'First name can only contain alphabets.'],
			['last_name', 'match', 'pattern' => '/^[a-zA-Z- ]+$/', 'message' => 'Last name can only contain alphabets.'],
			[['state', 'city'], 'string', 'max' => 50],
            [['role_notes'], 'string', 'max' => 250],
			['role_notes', 'match', 'pattern' => '/^[a-zA-Z0-9&., ]+$/', 'message' => 'Role notes can only contain alphabets, dot, Ampersand, Comma .'],
			['address_1', 'match', 'pattern' => '/^[a-zA-Z0-9\-\/\ ]+$/', 'message' => 'Address 1 can only contain alphanumeric, hyphen, slash .'],
			['address_2', 'match', 'pattern' => '/^[a-zA-Z0-9\-\/\ ]+$/', 'message' => 'Address 2 can only contain alphanumeric, hyphen, slash.'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaClients::className(), 'targetAttribute' => ['client_id' => 'client_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaUsers::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company_user_id' => 'Company User ID',
            'client_id' => 'Client ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'address_1' => 'Address 1',
            'address_2' => 'Address 2',
            'state' => 'State',
            'city' => 'City',
            'zip' => 'Zip',
			'is_admin' => 'Is Admin',
            'role_notes' => 'Role Notes',
            'profile_image' => 'Profile Image',
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
        return $this->hasMany(TblAcaCompanyUserPermission::className(), ['company_user_id' => 'company_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(TblAcaClients::className(), ['client_id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(TblAcaUsers::className(), ['user_id' => 'user_id']);
    }
    
    public static function FindByuserId($id)
    {
    	return static::findOne(['user_id' => $id]);
    }
	
	
	
	public static function FindByuserIdclientId($user_id,$client_id)
    {
    	return static::find()->where(['user_id' => $user_id,'client_id'=>$client_id])->One();
    }
    
    public static function FindBycompanyuserId($company_user_id)
    {
    	return static::findOne(['company_user_id' => $company_user_id]);
    }
    
    
   
    public static function FindByuserIds($id)
    {
    	return static::findAll(['user_id' => $id]);
    }
	
	
    
    public static function FindAllbyclient($client_id,$company_id)
    {
    	return static::find()->joinWith('tblAcaCompanyUserPermissions')->where(['tbl_aca_company_users.client_id'=>$client_id])->andwhere(['tbl_aca_company_user_permission.company_id'=>$company_id])->All();
    }
	
	
	public static function FindAllbyclientId($client_id)
    {
    	return static::find()->joinWith('tblAcaCompanyUserPermissions')->where(['tbl_aca_company_users.client_id'=>$client_id])->All();
    }
    
   
    public static function GetallusersbycompanyId($company_id)
    {
    	return static::find()->joinWith('tblAcaCompanyUserPermissions')->where(['tbl_aca_company_user_permission.company_id' => $company_id])->All();
    }
	
	 public static function Getactivecompanyusercount()
    {
    	$all_active_clients = static::find()
    	->joinWith('user')
    	->joinWith('client')
    	->where(['tbl_aca_clients.is_deleted'=>0])
    	//->andwhere(['tbl_aca_users.is_active'=>1])
    	->andwhere(['tbl_aca_users.is_deleted'=>0])
    	->all();
    	 
    	return count($all_active_clients);
    }
	  public function Getadminuser($client_id)
    {
    	
    	return TblAcaCompanyUsers::find()->where(['client_id'=>$client_id])->andWhere(['is_admin'=>1])->One();
    }
	
	
	public function Getcompanyusername($user_id)
    {
    	 
    	$model_companyuser = TblAcaCompanyUsers::find()->select('first_name,last_name')->where(['user_id'=>$user_id])->One();
        if(!empty($model_companyuser->first_name)){
        	return $model_companyuser->first_name .' '.$model_companyuser->last_name;
        }else{
        	return 'adminuser';
        }
    }
}
