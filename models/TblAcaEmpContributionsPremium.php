<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_emp_contributions_premium".
 *
 * @property integer $contribution_premium_id
 * @property integer $emp_contribution_id
 * @property integer $premium_year
 * @property string $premium_value
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaEmpContributions $empContribution
 */
class TblAcaEmpContributionsPremium extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_emp_contributions_premium';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_contribution_id', 'premium_year', 'created_by'], 'required'],
            [['emp_contribution_id', 'premium_year', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
           // [['premium_value'], 'string', 'max' => 10],
			[['premium_value'], 'number'],
            [['emp_contribution_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaEmpContributions::className(), 'targetAttribute' => ['emp_contribution_id' => 'emp_contribution_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'contribution_premium_id' => 'Contribution Premium ID',
            'emp_contribution_id' => 'Emp Contribution ID',
            'premium_year' => 'Premium Year',
            'premium_value' => 'Premium Value',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpContribution()
    {
        return $this->hasOne(TblAcaEmpContributions::className(), ['emp_contribution_id' => 'emp_contribution_id']);
    }
    
    //Function gets Emp contribution data by coverage_type_id
    public static function FindbyempcontributionId($emp_contribution_id)
    {
    	return static::find()->where(['emp_contribution_id'=>$emp_contribution_id])->One();
    }
    
    //public function get plan offer type month
    public static function getPremiumvalue($emp_contribution_id,$premium_year)
    {
    	 
    	$premium = static::find()
    	->where(['emp_contribution_id'=>$emp_contribution_id])
    	->andwhere(['premium_year'=>$premium_year])
    	->One();
    	 
    	 
    	return $premium->premium_value;
    	 
    	 
    }
    
    //public function get plan offer type month
    public static function getPremiumvalueall($emp_contribution_id,$premium_year)
    {
    
    	$premium = static::find()
    	->where(['emp_contribution_id'=>$emp_contribution_id])
    	->andwhere(['premium_year'=>$premium_year])
    	->One();
    
    
    	return $premium;
    
    
    }
}
