<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_brands".
 *
 * @property integer $brand_id
 * @property string $brand_name
 * @property string $brand_logo
 * @property string $support_email
 * @property string $support_number
 * @property integer $brand_status
 * @property integer $is_deleted
 * @property string $right_sign_url
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 * @property string $secure_token
 *
 * @property TblAcaClients[] $tblAcaClients
 */
class TblAcaBrands extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	
    public static function tableName()
    {
        return 'tbl_aca_brands';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
    	
        return [
            [['brand_name', 'support_email', 'support_number' , 'brand_url',  'brand_status', 'is_deleted', 'created_by'], 'required'],
            [['brand_logo'], 'required','on'=>'save'],
        
			[['brand_url', 'right_sign_url', 'secure_token'], 'string'],
			 ['brand_url','url'],
			  ['right_sign_url','url'],
            //[['brand_logo'],  'file', 'skipOnEmpty'=>false, 'extensions'=>'jpg,jpeg,gif,png', 'maxSize'=>1048576, 'on'=>'create'],
           // [['brand_logo'], 'file', 'skipOnEmpty'=>true, 'extensions'=>'jpg,jpeg,gif,png', 'maxSize'=>1048576, 'on'=>'update'],
            [['brand_status', 'is_deleted', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['brand_name'], 'string', 'max' => 100],
			['brand_name', 'match', 'pattern' => '/^[a-zA-Z0-9 ]+$/', 'message' => 'Brand name can only contain alphanumeric characters.'],
            [['support_email'], 'string', 'max' => 50],
            [['brand_logo'], 'string', 'max' => 100],
            [['support_number'], 'string', 'max' => 20],
            ['brand_logo', 'file', 'extensions' => 'jpeg, gif, png, jpg'],
		//	['brand_name','checkUnique'],
         //   [['support_email'], 'unique'],
        ];
    }
    
    public function scenarios()
    {
    	
    	$scenarios = parent::scenarios();
    	$scenarios['save'] = ['brand_name','brand_logo', 'support_email', 'support_number' , 'brand_url','right_sign_url', 'brand_status', 'is_deleted', 'created_by','required'];
    	$scenarios['update'] = ['brand_name','support_email', 'support_number', 'brand_status', 'is_deleted', 'created_by','required'];
    	
    	return $scenarios;
    }

	/* public function checkUnique($attribute, $params){
    	
    	$brand_name=$this->brand_name;
    	$model= TblAcaBrands::find()->where(['=','brand_name',$brand_name])->andwhere(['=','is_deleted',1])->One();
    	
    	if(!empty($model)){
    		$this->addError('brand_name', 'Brand name already exist');
    	}
    }*/
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'brand_id' => 'Brand ID',
            'brand_name' => 'Brand Name',
            'brand_logo' => 'Brand Logo',
            'support_email' => 'Support Email',
            'support_number' => 'Support Number',
			'brand_url' => 'Brand Url',
            'brand_status' => 'Brand Status',
            'is_deleted' => 'Is Deleted',
			'right_sign_url' => 'Right Sign Url',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
			'secure_token' => 'Secure Token'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaClients()
    {
        return $this->hasMany(TblAcaClients::className(), ['brand_id' => 'brand_id']);
    }

    public static function Branduniquedetails($id)
    {
    	
    	return static::findOne(['brand_id' => $id]);
	
    }
    
	/*
	*this function is used to return all the brands
	*/
    public function Brandalldetails()
    {
    	//  return static::findAll(['is_deleted' => 1]);
		  // return static::findAll(['is_deleted' => 1]);'sort' => ['defaultOrder'=>'topic_order asc']
    	$model = TblAcaBrands::find()->where(['is_deleted'=>1])->orderBy([
           'brand_id' => SORT_DESC,
        ])->all();;
		
       return $model;
    }
	
	/*
	*this function is used to return all the brands
	*/
	  public function Checkbrandname($name)
    {
    	$model = TblAcaBrands::find()->where(['brand_name'=>$name])->andWhere(['is_deleted'=>1])->one();
    	
    	return $model;
    	 
    } 
  
}
