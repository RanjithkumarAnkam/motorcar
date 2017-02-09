<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_medical_enrollment_period".
 *
 * @property integer $period_id
 * @property integer $employee_id
 * @property string $coverage_start_date
 * @property string $coverage_end_date
 * @property integer $person_type
 * @property integer $ssn
 * @property integer $dependent_dob
 * @property string $dob
 * @property string $notes
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaMedicalData $employee
 * @property TblAcaLookupOptions $personType
 */
class TblAcaMedicalEnrollmentPeriod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_medical_enrollment_period';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'created_by'], 'required'],
            [['employee_id', 'person_type', 'ssn', 'dependent_dob', 'created_by', 'modified_by'], 'integer'],
            [['coverage_start_date', 'coverage_end_date', 'dob', 'created_date', 'modified_date'], 'safe'],
            [['notes'], 'string', 'max' => 250],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaMedicalData::className(), 'targetAttribute' => ['employee_id' => 'employee_id']],
            [['person_type'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaLookupOptions::className(), 'targetAttribute' => ['person_type' => 'lookup_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'period_id' => 'Period ID',
            'employee_id' => 'Employee ID',
            'coverage_start_date' => 'Coverage Start Date',
            'coverage_end_date' => 'Coverage End Date',
            'person_type' => 'Person Type',
            'ssn' => 'Ssn',
            'dependent_dob' => 'Dependent Dob',
            'dob' => 'Dob',
            'notes' => 'Notes',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(TblAcaMedicalData::className(), ['employee_id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonType()
    {
        return $this->hasOne(TblAcaLookupOptions::className(), ['lookup_id' => 'person_type']);
    }
    
    /*
     * this function returns the medical enrollment period details based on the employee id
    */
    public function medicalenrollmentdata($employ_id)
    {
    	$connection = \Yii::$app->db;
    
    	$sql="SELECT * FROM tbl_aca_medical_enrollment_period WHERE employee_id=:employ_id";
    
    	$user = $connection->createCommand($sql);
    
    	$user->bindValue(':employ_id', $employ_id);
    
    	$users = $user->query();
    
    	return $users;
    }
    
    /*
     * this function is to return the medical data based on the company id
    */
    public function medicaldata($company_id)
    {
    	$connection = \Yii::$app->db;
    
    	$sql="SELECT * FROM tbl_aca_medical_data WHERE company_id=:company";
    
    	$user = $connection->createCommand($sql);
    
    	$user->bindValue(':company', $company_id);
    
    	$users = $user->query();
    
    	return $users;
    }
    
    /*
     * this function is to return the person type and details
    * the main requirement is to convert lookup_id (int to char)
    */
    public function persontype()
    {
    	$connection = \Yii::$app->db;
    
    	$sql="SELECT lookup_value,CONCAT(lookup_id ,'') as lookup_id FROM tbl_aca_lookup_options WHERE lookup_status=1 AND code_id=10";
    
    	$suffix = $connection->createCommand($sql);
    
    	return $suffix->queryAll();
    
    }
}
