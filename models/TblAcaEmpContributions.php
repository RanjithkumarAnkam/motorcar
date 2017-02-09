<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_emp_contributions".
 *
 * @property integer $emp_contribution_id
 * @property integer $coverage_type_id
 * @property integer $safe_harbor
 * @property integer $employee_plan_contribution
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaPlanCoverageTypeOffered $coverageType
 * @property TblAcaEmpContributionsPremium[] $tblAcaEmpContributionsPremia
 */
class TblAcaEmpContributions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_emp_contributions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coverage_type_id', 'created_by'], 'required'],
            [['coverage_type_id', 'safe_harbor', 'employee_plan_contribution', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['coverage_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaPlanCoverageTypeOffered::className(), 'targetAttribute' => ['coverage_type_id' => 'coverage_type_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'emp_contribution_id' => 'Emp Contribution ID',
            'coverage_type_id' => 'Coverage Type ID',
            'safe_harbor' => 'Safe Harbor',
            'employee_plan_contribution' => 'Employee Plan Contribution',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoverageType()
    {
        return $this->hasOne(TblAcaPlanCoverageTypeOffered::className(), ['coverage_type_id' => 'coverage_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaEmpContributionsPremia()
    {
        return $this->hasMany(TblAcaEmpContributionsPremium::className(), ['emp_contribution_id' => 'emp_contribution_id']);
    }
    
    //Function gets Emp contribution data by coverage_type_id
    public static function FindbycoveragetypeId($coverage_type_id)
    {
    	return static::find()->where(['coverage_type_id'=>$coverage_type_id])->One();
    }
}
