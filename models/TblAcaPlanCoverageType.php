<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "tbl_aca_plan_coverage_type".
 *
 * @property integer $plan_class_id
 * @property integer $company_id
 * @property integer $period_id
 * @property string $plan_class_name
 * @property integer $plan_offer_type
 * @property integer $plan_type_doh
 * @property integer $employee_medical_plan
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaCompanies $company
 * @property TblAcaCompanyReportingPeriod $period
 * @property TblAcaPlanCoverageTypeOffered[] $tblAcaPlanCoverageTypeOffereds
 * @property TblAcaPlanOfferTypeYears[] $tblAcaPlanOfferTypeYears
 */
class TblAcaPlanCoverageType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_plan_coverage_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'period_id', 'plan_class_number','created_by'], 'required'],
            [['company_id', 'period_id', 'plan_offer_type', 'plan_type_doh', 'employee_medical_plan', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date','plan_class_number'], 'safe'],
            [['plan_class_name'], 'string', 'max' => 34],
			[['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaCompanies::className(), 'targetAttribute' => ['company_id' => 'company_id']],
            [['period_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaCompanyReportingPeriod::className(), 'targetAttribute' => ['period_id' => 'period_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'plan_class_id' => 'Plan Class ID',
            'company_id' => 'Company ID',
            'period_id' => 'Period ID',
			'plan_class_number' => 'Plan Class Number',
            'plan_class_name' => 'Plan Class Name',
            'plan_offer_type' => 'Plan Offer Type',
            'plan_type_doh' => 'Plan Type Doh',
            'employee_medical_plan' => 'Employee Medical Plan',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(TblAcaCompanies::className(), ['company_id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriod()
    {
        return $this->hasOne(TblAcaCompanyReportingPeriod::className(), ['period_id' => 'period_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaPlanCoverageTypeOffereds()
    {
        return $this->hasOne(TblAcaPlanCoverageTypeOffered::className(), ['plan_class_id' => 'plan_class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaPlanOfferTypeYears()
    {
        return $this->hasMany(TblAcaPlanOfferTypeYears::className(), ['plan_class_id' => 'plan_class_id']);
    }
    
    
    //Function gets Plan class data by plan_class_id
    public static function FindplanbyId($plan_id,$company_id)
    {
    	return static::find()->joinWith('tblAcaPlanOfferTypeYears')->where(['tbl_aca_plan_coverage_type.plan_class_id'=>$plan_id])->andwhere(['tbl_aca_plan_coverage_type.company_id'=>$company_id])->One();
    }
    
    
    //Function gets all plan class
    public static function Findallplans($company_id)
    {
    	return static::find()->where(['company_id'=>$company_id])->All();
    }
	
	//***Count of plans***/
	public function Countplans($company_id)
	{
		return static::find()->where(['company_id'=>$company_id])->count();
	}
	/*
     * this function is to return the plan class names and its id 
     * the main requirement is to convert plan_class_id (int to char)
     */
   public function planclasses($cmp_id)
    {
    	$connection = \Yii::$app->db;
    	
    	$sql="SELECT plan_class_number,CONCAT(plan_class_id ,'') as plan_class_id FROM tbl_aca_plan_coverage_type WHERE company_id=:company_id ";
    	    	
    	$classes = $connection->createCommand($sql);
    	 
    	$classes->bindValue(':company_id', $cmp_id);
    	 
    	return $classes->query();
    	
    //	$classes = $connection->createCommand($sql);
    	
    //	return $classes->queryAll();
    
    }
    
    public function plancheck($cmp_id)
    {
    	$query = new Query();
    	$query	->select(['tpct.plan_class_id','tpct.plan_class_number','tec.employee_plan_contribution'])
    	->from('tbl_aca_plan_coverage_type tpct')
    	->join('LEFT JOIN', 'tbl_aca_plan_coverage_type_offered tpco',
    			'tpco.plan_class_id =tpct.plan_class_id')
    			->join('LEFT JOIN', 'tbl_aca_emp_contributions tec',
    					'tec.coverage_type_id =tpco.coverage_type_id')->where(['tpct.company_id'=>$cmp_id,'tec.employee_plan_contribution'=>2]);
    	
    	$command = $query->createCommand();
    	return $command->queryOne();
    	
    	
    
    }
    
    
}
