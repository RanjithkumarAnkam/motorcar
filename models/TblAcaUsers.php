<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "tbl_aca_users".
 *
 * @property integer $user_id
 * @property string $useremail
 * @property string $password
 * @property integer $is_deleted
 * @property integer $is_active
 * @property integer $is_verified
 * @property integer $usertype
 * @property string $random_salt
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaClients[] $tblAcaClients
 * @property TblAcaCompanyUsers[] $tblAcaCompanyUsers
 * @property TblAcaStaffUsers[] $tblAcaStaffUsers
 */
class TblAcaUsers extends \yii\db\ActiveRecord implements IdentityInterface {
	/**
	 * @inheritdoc
	 */
	const STATUS_ACTIVE = 1;
	public static function tableName() {
		return 'tbl_aca_users';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [ 
				[ 
						[ 
								'useremail',
								'is_deleted',
								'is_active',
								'is_verified',
								'usertype',
								'created_by',
								'modified_by',
								'modified_date' 
						],
						'required' 
				],
				[ 
						[ 
								'is_deleted',
								'is_active',
								'is_verified',
								'usertype',
								'created_by',
								'modified_by' 
						],
						'integer' 
				],
				[ 
						[ 
								'created_date',
								'modified_date' 
						],
						'safe' 
				],
				[ 
						[ 
								'useremail' 
						],
						'string',
						'max' => 50 
				],
				[ 
						'useremail',
						'email' 
				],
				[ 
						'useremail',
						'unique' 
				],
				[ 
						[ 
								'password',
								'random_salt' 
						],
						'string',
						'max' => 200 
				] 
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [ 
				'user_id' => 'User ID',
				'useremail' => 'Email',
				'password' => 'Password',
				'is_deleted' => 'Is Deleted',
				'is_active' => 'Is Active',
				'is_verified' => 'Is Verified',
				'usertype' => 'Usertype',
				'random_salt' => 'Random Salt',
				'created_by' => 'Created By',
				'created_date' => 'Created Date',
				'modified_by' => 'Modified By',
				'modified_date' => 'Modified Date' 
		];
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getTblAcaClients() {
		return $this->hasMany ( TblAcaClients::className (), [ 
				'user_id' => 'user_id' 
		] );
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getTblAcaCompanyUsers() {
		return $this->hasMany ( TblAcaCompanyUsers::className (), [ 
				'user_id' => 'user_id' 
		] );
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getTblAcaStaffUsers() {
		return $this->hasMany ( TblAcaStaffUsers::className (), [ 
				'user_id' => 'user_id' 
		] );
	}
	
	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id) {
		return static::findOne ( [ 
				'user_id' => $id,
				'status' => self::STATUS_ACTIVE 
		] );
	}
	
	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null) {
		throw new NotSupportedException ( '"findIdentityByAccessToken" is not implemented.' );
	}
	
	/**
	 * Finds user by useremail
	 *
	 * @param string $useremail        	
	 * @return static null
	 */
	public static function findByUsername($username) {
		return static::findOne ( [ 
				'useremail' => $username 
		] );
	}
	
	/**
	 * Finds user by password reset token
	 *
	 * @param string $token
	 *        	password reset token
	 * @return static null
	 */
	public static function findByPasswordResetToken($token) {
		if (! static::isPasswordResetTokenValid ( $token )) {
			return null;
		}
		
		return static::findOne ( [ 
				'random_salt' => $token,
				'is_active' => self::STATUS_ACTIVE 
		] );
	}
	
	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token
	 *        	password reset token
	 * @return boolean
	 */
	public static function isPasswordResetTokenValid($token) {
		if (empty ( $token )) {
			return false;
		}
		
		$timestamp = ( int ) substr ( $token, strrpos ( $token, '_' ) + 1 );
		$expire = Yii::$app->params ['user.passwordResetTokenExpire'];
		return $timestamp + $expire >= time ();
	}
	
	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->getPrimaryKey ();
	}
	
	/**
	 * @inheritdoc
	 */
	public function getAuthKey() {
		return $this->random_salt;
	}
	
	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey) {
		return $this->getAuthKey () === $authKey;
	}
	
	/**
	 * Validates password
	 *
	 * @param string $password
	 *        	password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password) {
		return Yii::$app->security->validatePassword ( $password, $this->password );
	}
	
	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password        	
	 */
	public function setPassword($password) {
		$this->password = Yii::$app->security->generatePasswordHash ( $password );
	}
	
	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey() {
		$this->random_salt = Yii::$app->security->generateRandomString ();
	}
	
	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken() {
		return \Yii::$app->security->generateRandomString () . '_' . time ();
	}
	
	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken() {
		$this->random_salt = null;
	}
	
	/**
	 * Finds user by id
	 *
	 * @param string $id        	
	 * @return static null
	 */
	public static function findById($id) {
		return static::findOne ( [ 
				'user_id' => $id 
		] );
	}
	/**
	 * @inheritdoc
	 */
	public function setPasswordIdentity($id, $random_salt) {
		$user = TblAcaUsers::findOne ( [ 
				'random_salt' => $random_salt 
		] );
		$output = array();
		if (! empty ( $user )) {
			$crypt_user_id = md5 ( $user->user_id );
			
			if ($crypt_user_id === $id) {
				
				
				$output['success'] = $user;
				
			} else {
				$output['fail'] = 'User Does not Exist';
	    	}
    	}
    	else {
    		$output['fail'] = 'Link Expired';
    	}
    	
    	return $output;
    }
    
  
}
