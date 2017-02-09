<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_plan_offer_type_years".
 *
 * @property integer $plan_years_id
 * @property integer $plan_class_id
 * @property integer $plan_year_type
 * @property integer $plan_year
 * @property string $plan_year_value
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaPlanCoverageType $planClass
 */
class TblAcaPlanOfferTypeYears extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_plan_offer_type_years';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plan_class_id', 'plan_year_type', 'plan_year', 'created_by'], 'required'],
            [['plan_class_id', 'plan_year_type', 'plan_year', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['plan_year_value'], 'string', 'max' => 25],
            [['plan_class_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaPlanCoverageType::className(), 'targetAttribute' => ['plan_class_id' => 'plan_class_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'plan_years_id' => 'Plan Years ID',
            'plan_class_id' => 'Plan Class ID',
            'plan_year_type' => 'Plan Year Type',
            'plan_year' => 'Plan Year',
            'plan_year_value' => 'Plan Year Value',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanClass()
    {
        return $this->hasOne(TblAcaPlanCoverageType::className(), ['plan_class_id' => 'plan_class_id']);
    }
    
    
    //public function get plan offer type month
    public static function getPlanoffermonthvalue($plan_id,$offer_type,$month)
    {
    	
    	$plan_offer = static::find()
    	->where(['plan_class_id'=>$plan_id])
    	->andwhere(['plan_year_type'=>$offer_type])
    	->andwhere(['plan_year'=>$month])
    	->One();
    	
    	
    	if(!empty($plan_offer)){
    		return $plan_offer->plan_year_value;
    	}else{
    		return '';
    	}
    	
    	
    }
    
	public function FindbyplanclassId($plan_class_id)
	{
		return TblAcaPlanOfferTypeYears::find()->where(['plan_class_id'=>$plan_class_id])->All();
	}
    
    //public function get plan old plan
    public static function getOldplan($plan_id,$offer_type,$month)
    {
    	 
    	$plan_offer = static::find()
    	->where(['plan_class_id'=>$plan_id])
    	->andwhere(['plan_year_type'=>$offer_type])
    	->andwhere(['plan_year'=>$month])
    	->One();
    	 
    	 
    	return $plan_offer;
    	 
    	 
    }
}
