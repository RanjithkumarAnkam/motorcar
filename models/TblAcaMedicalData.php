<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_medical_data".
 *
 * @property integer $employee_id
 * @property integer $company_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property integer $suffix
 * @property string $ssn
 * @property string $address1
 * @property string $apt_suite
 * @property string $city
 * @property string $state
 * @property integer $zip
 * @property string $dob
 * @property string $notes
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaCompanies $company
 * @property TblAcaMedicalEmploymentPeriod[] $tblAcaMedicalEmploymentPeriods
 */
class TblAcaMedicalData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_medical_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'first_name', 'last_name', 'created_by'], 'required'],
            [['company_id', 'suffix', 'zip', 'created_by', 'modified_by'], 'integer'],
            [['dob', 'created_date', 'modified_date'], 'safe'],
            [['notes'], 'string'],
            [['first_name', 'middle_name', 'last_name', 'ssn'], 'string', 'max' => 50],
            [['address1', 'apt_suite', 'city'], 'string', 'max' => 200],
            [['state'], 'string', 'max' => 10],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaCompanies::className(), 'targetAttribute' => ['company_id' => 'company_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employee_id' => 'Employee ID',
            'company_id' => 'Company ID',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'suffix' => 'Suffix',
            'ssn' => 'Ssn',
            'address1' => 'Address1',
            'apt_suite' => 'Apt Suite',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
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
    public function getCompany()
    {
        return $this->hasOne(TblAcaCompanies::className(), ['company_id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaMedicalEmploymentPeriods()
    {
        return $this->hasMany(TblAcaMedicalEmploymentPeriod::className(), ['employee_id' => 'employee_id']);
    }
    
	
	 public function getTblAcaMedicalEnrollmentPeriods()
    {
        return $this->hasMany(TblAcaMedicalEnrollmentPeriod::className(), ['employee_id' => 'employee_id']);
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
     * this function returns the medical employment period details based on the employee id
    */
    public function medicalemploymentdata($employ_id)
    {
    	$connection = \Yii::$app->db;
    
    	$sql="SELECT * FROM tbl_aca_medical_employment_period WHERE employee_id=:employ_id";
    	
    	$user = $connection->createCommand($sql);
    	
    	$user->bindValue(':employ_id', $employ_id);
    	
    	$users = $user->query();

    	return $users;
    }
}
