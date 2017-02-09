<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_plan_coverage_type_offered".
 *
 * @property integer $coverage_type_id
 * @property integer $plan_class_id
 * @property integer $employee_mv_coverage
 * @property string $mv_coverage_months
 * @property integer $employee_essential_coverage
 * @property string $essential_coverage_months
 * @property integer $spouse_essential_coverage
 * @property integer $spouse_conditional_coverage
 * @property integer $dependent_essential_coverage
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaEmpContributions[] $tblAcaEmpContributions
 * @property TblAcaPlanCoverageType $planClass
 */
class TblAcaPlanCoverageTypeOffered extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_plan_coverage_type_offered';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plan_class_id', 'created_by'], 'required'],
            [['plan_class_id', 'employee_mv_coverage', 'employee_essential_coverage', 'spouse_essential_coverage', 'spouse_conditional_coverage', 'dependent_essential_coverage', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['mv_coverage_months', 'essential_coverage_months'], 'string', 'max' => 100],
            [['plan_class_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaPlanCoverageType::className(), 'targetAttribute' => ['plan_class_id' => 'plan_class_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'coverage_type_id' => 'Coverage Type ID',
            'plan_class_id' => 'Plan Class ID',
            'employee_mv_coverage' => 'Employee Mv Coverage',
            'mv_coverage_months' => 'Mv Coverage Months',
            'employee_essential_coverage' => 'Employee Essential Coverage',
            'essential_coverage_months' => 'Essential Coverage Months',
            'spouse_essential_coverage' => 'Spouse Essential Coverage',
            'spouse_conditional_coverage' => 'Spouse Conditional Coverage',
            'dependent_essential_coverage' => 'Dependent Essential Coverage',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaEmpContributions()
    {
        return $this->hasMany(TblAcaEmpContributions::className(), ['coverage_type_id' => 'coverage_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanClass()
    {
        return $this->hasOne(TblAcaPlanCoverageType::className(), ['plan_class_id' => 'plan_class_id']);
    }

    //Function gets Plan class data by plan_class_id
    public function FindplanbyId($plan_id)
    {
    	return $this->find()->where(['plan_class_id'=>$plan_id])->One();
    }
    
    
    /**
     *
     * Find all MV months in string format
     */
    public function findMvmonthsstring($plan_id)
    {
    	$months = '';
    	$month_name = array(0=>'Entire Year',1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
    	$details = $this->findOne(['plan_class_id' => $plan_id]);
    	if(!empty($details)){
    	$mv_months = $details->mv_coverage_months;
    	}
    	if(!empty($mv_months))
    	{
    		$arrmv_months = explode(',',rtrim($mv_months,','));
    		foreach($arrmv_months as $month)
    		{
    			$months .= $month_name[$month].', ';
    		}
    	}
    	else
    	{
    		$months = '';
    	}
    	return $months;
    }
    
    
    /**
     *
     * Find all MV months in string format
     */
    public function findMecstring($plan_id)
    {
    	$mecs = '';
    	$arrMec = array();
    	$mec_name = array(1 => 'Employee', 2 => 'Spouse', 3 => 'Dependents');
    	$details = $this->findOne(['plan_class_id' => $plan_id]);
    	if(!empty($details)){
    		
    		if($details->employee_essential_coverage == 1)
    		{
    		$arrMec[] = '1';
    		}
    		
    		if($details->spouse_essential_coverage == 1)
    		{
    			$arrMec[] = '2';
    		}
    		
    		if($details->dependent_essential_coverage == 1)
    		{
    			$arrMec[] = '3';
    		}
    	}
    	if(!empty($arrMec))
    	{
    		
    		foreach($arrMec as $mec)
    		{
    			$mecs .= $mec_name[$mec].', ';
    		}
    	}
    	else
    	{
    		$mecs = '';
    	}
    	return $mecs;
    }
    
    
   
}
