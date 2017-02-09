<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_clients".
 *
 * @property integer $client_id
 * @property integer $user_id
 * @property integer $brand_id
 * @property string $client_number
 * @property string $client_name
 * @property string $order_number
 * @property string $contact_first_name
 * @property string $contact_last_name
 * @property string $phone
 * @property string $email
 * @property string $profile_image
 * @property integer $product
 * @property string $package_type
 *  * @property integer $reporting_structure
 * @property integer $aca_year
 * @property integer $forms_bought
 * @property integer $ein_count
 * @property integer $account_manager
 * @property integer $price_paid
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaUsers $accountManager
 * @property TblAcaBrands $brand
 * @property TblAcaUsers $user
 * @property TblAcaCompanies[] $tblAcaCompanies
 * @property TblAcaCompanyUsers[] $tblAcaCompanyUsers
 */
class TblAcaClients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_clients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'brand_id', 'client_number', 'client_name', 'contact_first_name', 'contact_last_name', 'phone', 'email', 'package_type',  'reporting_structure', 'aca_year', 'created_by'], 'required'],
            [['user_id', 'brand_id', 'product', 'reporting_structure', 'aca_year', 'forms_bought', 'ein_count', 'account_manager', 'is_deleted', 'created_by', 'modified_by'], 'integer'],
            [['price_paid'], 'number'],
			[['created_date', 'modified_date'], 'safe'],
            [['client_number', 'order_number', 'contact_first_name', 'contact_last_name', 'email'], 'string', 'max' => 100],
            [['package_type'], 'string', 'max' => 50],
			[['client_name'], 'string', 'max' => 75],
            [['phone'], 'string', 'max' => 20],
            [['email'],'email'],
			['contact_first_name', 'match', 'pattern' => '/^[a-zA-Z- ]+$/', 'message' => 'First name can only contain alphabets.'],
			['contact_last_name', 'match', 'pattern' => '/^[a-zA-Z- ]+$/', 'message' => 'Last name can only contain alphabets.'],
			[['profile_image'], 'string', 'max' => 200],
            [['account_manager'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaUsers::className(), 'targetAttribute' => ['account_manager' => 'user_id']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaBrands::className(), 'targetAttribute' => ['brand_id' => 'brand_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaUsers::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client_id' => 'Client ID',
            'user_id' => 'User ID',
            'brand_id' => 'Brand ID',
            'client_number' => 'Client Number',
            'client_name' => 'Client Name',
            'order_number' => 'Order Number',
            'contact_first_name' => 'Contact First Name',
            'contact_last_name' => 'Contact Last Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'profile_image' => 'Profile Image',
            'product' => 'Product',
            'package_type' => 'Package Type',
            'reporting_structure' => 'Reporting_structure',
            'aca_year' => 'Aca Year',
            'forms_bought' => 'Forms Bought',
            'ein_count' => 'Ein Count',
            'account_manager' => 'Account Manager',
            'price_paid' => 'Price Paid',
            'is_deleted' => 'Is Deleted',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountManager()
    {
        return $this->hasOne(TblAcaUsers::className(), ['user_id' => 'account_manager']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(TblAcaBrands::className(), ['brand_id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(TblAcaUsers::className(), ['user_id' => 'user_id']);
    }
    
    public function getPackage()
    {
    	return $this->hasOne(TblAcaLookupOptions::className(), ['lookup_id' => 'package_type']);
    }
    
    
    public function getYear()
    {
    	return $this->hasOne(TblAcaLookupOptions::className(), ['lookup_id' => 'aca_year']);
    }
	
        public function getStaffusers()
    {
    	return $this->hasOne(TblAcaStaffUsers::className(), ['user_id' => 'account_manager']);
    } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaCompanies()
    {
        return $this->hasMany(TblAcaCompanies::className(), ['client_id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaCompanyUsers()
    {
        return $this->hasMany(TblAcaCompanyUsers::className(), ['client_id' => 'client_id']);
    }
    
	/**Function used to get client details by client_id**/
     public function Clientuniquedetails($id)
    {
     
     return TblAcaClients::findOne(['client_id' => $id]);
 
    }
	/**Function used to get client details by brand_id**/
	 public function FindBybrandId($brand_id)
    {
     
     return TblAcaClients::findOne(['brand_id' => $brand_id,'is_deleted'=>0]);
 
    }
    /**Function used to get client details by user_id**/
    public function Findbyuserid($id)
    {
    	return TblAcaClients::findOne(['user_id' => $id]);
    }
	
	 /**Function used to get all clients details by user_id**/
	public function FindallclientsbyId($id)
    {
    	return TblAcaClients::find()->joinWith('tblAcaCompanies')->where(['user_id' => $id,'is_deleted'=>0])->All();
    }
    
	/**Function used to get all clients in application**/
    public function Findallclients()
    {
    	return TblAcaClients::find()->where(['is_deleted'=>'0'])->orderBy(['client_name' => SORT_ASC])->All();
    }
	
	 public function Findallclientsindex($id)
    
    {
    	if(empty($id)){
    	return TblAcaClients::findAll(['is_deleted'=>'0']);
        }else{
    	$records=TblAcaClients::find()->where(['client_id'=>$id])->andwhere(['is_deleted'=>'0'])->All();
    	return $records;
    		}
    }
	
	 /**Function used to get count of all active clients in application**/
    public function Getactiveclientcount()
    {
    	$all_active_clients = TblAcaClients::find()
    	->joinWith('user')
    	->where(['tbl_aca_clients.is_deleted'=>0])
    	//->andwhere(['tbl_aca_users.is_active'=>1])
    	->andwhere(['tbl_aca_users.is_deleted'=>0])
    	->all();
    	
    	return count($all_active_clients);
    }
    
	 /**Function used to get count of all forms purchased by active clients in application**/
    public function Getformscount()
    {
    	
    	$all_active_clients = TblAcaClients::find()
    	->joinWith('user')
    	->where(['tbl_aca_clients.is_deleted'=>0])
    	//->andwhere(['tbl_aca_users.is_active'=>1])
    	->andwhere(['tbl_aca_users.is_deleted'=>0])
    	->sum('forms_bought');
    	
    	
    	return $all_active_clients;
    	
    	
    }
    
	 /**Function used to get top 5 active clients in application**/
    public function Topfiveclients()
    {
    	return TblAcaClients::find()
    	->joinWith('user')
    	->where(['tbl_aca_clients.is_deleted'=>0])
    	//->andwhere(['tbl_aca_users.is_active'=>1])
    	->andwhere(['tbl_aca_users.is_deleted'=>0])
		->orderBy(['client_id' => SORT_DESC])
    	->limit(5)
    	->All();
    	 
    }
	
	    public function checkduplicatename($name,$year)
    {
    	//$name = trim($name);
    	//$sql = "SELECT * FROM `tbl_aca_clients` WHERE LCASE(client_name) LIKE '%$name%' AND (`aca_year`='$year') ";
    	//$resp = TblAcaClients::findBySql ( $sql )->one ();
    	//return $resp;
		$value = trim($name);
    	
    	$model = TblAcaClients::find()->where(['client_name' => $value])->andwhere(['aca_year' => $year])->one();
    	 
    	return $model;
	}
}
