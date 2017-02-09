<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_general_plan_months".
 *
 * @property integer $plan_month_id
 * @property integer $general_plan_id
 * @property integer $both_self_fully
 * @property integer $month_id
 * @property integer $plan_value
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 */
class TblAcaGeneralPlanMonths extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_general_plan_months';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['general_plan_id', 'created_by'], 'required'],
            [['general_plan_id', 'month_id', 'plan_value', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'plan_month_id' => 'Plan Month ID',
            'general_plan_id' => 'General Plan ID',
          //  'both_self_fully' => 'Both Self Fully',
            'month_id' => 'Month ID',
            'plan_value' => 'Plan Value',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**Function used to get particular general id details**/
    public function FindbygeneralId($id)
    {
    	return TblAcaGeneralPlanMonths::find()->where(['general_plan_id' => $id])->All();
    }
    
    //public function get plan offer type month
    public static function getValueoffermonthvalue($id,$month)
    {
    
    	$plan_value = static::find()
    	->where(['general_plan_id'=>$id])
    
    	->andwhere(['month_id'=>$month])
    	->One();
    
    	if(!empty($plan_value)){
    		return $plan_value->plan_value;
    	}else{
    		return '';
    	}
    	
    	
    }
    
    public function FindallbymonthIds($general_plan_id){
    
    	return TblAcaGeneralPlanMonths::find()->select('month_id, plan_value')
    	->where([
    			'general_plan_id' => $general_plan_id,
    			])
    			->all();
    }
   
    
}
