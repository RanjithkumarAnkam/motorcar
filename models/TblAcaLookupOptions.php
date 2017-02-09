<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_lookup_options".
 *
 * @property integer $lookup_id
 * @property integer $code_id
 * @property integer $section_id
 * @property string $lookup_value
 * @property integer $lookup_status
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaCodeMaster $code
 */
class TblAcaLookupOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_lookup_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code_id', 'lookup_value', 'lookup_status', 'created_by'], 'required'],
            [['code_id', 'section_id', 'lookup_status', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['lookup_value'], 'string', 'max' => 50],
            [['code_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaCodeMaster::className(), 'targetAttribute' => ['code_id' => 'code_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lookup_id' => 'Lookup ID',
            'code_id' => 'Code ID',
            'section_id' => 'Section ID',
            'lookup_value' => 'Lookup Value',
            'lookup_status' => 'Lookup Status',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCode()
    {
        return $this->hasOne(TblAcaCodeMaster::className(), ['code_id' => 'code_id']);
    }
	
	 public function lookupoptionsalldetails()
    {
    		return TblAcaLookupOptions::find()
   		->joinWith(['code'])
    		->orderBy(['tbl_aca_lookup_options.lookup_id' => SORT_ASC])
    		->all();
    
    }
    
    public function editlookupoptionsalldetails($id)
    {
    	return TblAcaLookupOptions::find()
    	->where(['=','tbl_aca_lookup_options.lookup_id',$id])
    	->joinWith(['code'])
    	->One();
    
    }
    
    public function lookupuniquedetails($id)
    {
    	return TblAcaLookupOptions::findOne(['lookup_id' => $id]);
    
    }
    
	 public function lookupfindsectionid($id)
	    {
	    	$model = TblAcaLookupOptions::find()->where(['lookup_id' => $id])->one();
	    	
	    	return $model->section_id;
	    
	    }
		
		 public function lookupfindoption($value , $code_id,$lookup_id)
	    {
			
			$value = trim($value);

			if(!empty($lookup_id)){
				
				  $model = TblAcaLookupOptions::find()->where(['lookup_value' => $value])->andwhere(['code_id' => $code_id])->andwhere(['<>','lookup_id',$lookup_id])->one();
	   
	  
			}else{
				
				 $model = TblAcaLookupOptions::find()->where(['lookup_value' => $value])->andwhere(['code_id' => $code_id])->one();
				  
			}
			
	   
	    	return $model;
	    	 
	    }
		
			    public static function Findelement()
	    {
	    	 return static::findAll(['code_id' => 1]);
	    	 
	    }
}
