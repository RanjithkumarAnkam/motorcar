<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_basic_information".
 *
 * @property integer $basic_info_id
 * @property integer $company_id
 * @property integer $period_id
 * @property string $contact_first_name
 * @property string $contact_middle_name
 * @property string $contact_last_name
 * @property string $contact_person_suffix
 * @property string $contact_person_title
 * @property string $contact_person_email
 * @property string $contact_phone_number
 * @property string $street_address_1
 * @property string $street_address_2
 * @property string $contact_country
 * @property string $contact_state
 * @property string $contact_city
 * @property string $contact_zip
 * @property string $emp_benefit_broker_name
 * @property string $emp_benefit_broker_email
 * @property string $emp_benefit_phone_number
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaCompanies $company
 * @property TblAcaCompanyReportingPeriod $period
 */
class TblAcaBasicInformation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_basic_information';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'period_id', 'created_by'], 'required'],
            [['company_id', 'period_id', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['contact_first_name', 'contact_middle_name', 'contact_last_name', 'contact_phone_number', 'contact_city', 'emp_benefit_broker_name', 'emp_benefit_phone_number'], 'string', 'max' => 50],
            [['contact_person_suffix'], 'string', 'max' => 10],
			[['contact_person_title'], 'string', 'max' => 30], 
            [['contact_person_email', 'emp_benefit_broker_email'], 'string', 'max' => 100],
            [['street_address_1', 'street_address_2'], 'string', 'max' => 200],
            [['contact_country'], 'string', 'max' => 20],
            [['contact_state'], 'string', 'max' => 25],
            [['contact_zip'], 'string', 'max' => 10],
			['contact_first_name', 'match', 'pattern' => '/^[a-zA-Z- ]+$/', 'message' => 'Contact First name can only contain alphabets.'],
			['contact_middle_name', 'match', 'pattern' => '/^[a-zA-Z- ]+$/', 'message' => 'Contact Middle name can only contain alphabets.'],
            ['contact_last_name', 'match', 'pattern' => '/^[a-zA-Z- ]+$/', 'message' => 'Contact Last name can only contain alphabets.'],
			['contact_person_title', 'match', 'pattern' => '/^[a-zA-Z\-\/\ ]+$/', 'message' => 'Contact Person Title can only contain  alphabets, hyphen, slash.'],
			['street_address_1', 'match', 'pattern' => '/^[a-zA-Z0-9\-\/\ ]+$/', 'message' => 'Street Address 1 can only contain alphanumeric, hyphen, slash.'],
			['street_address_2', 'match', 'pattern' => '/^[a-zA-Z0-9\-\/\ ]+$/', 'message' => 'Street Address 2 can only contain alphanumeric, hyphen, slash.'],
			['emp_benefit_broker_name', 'match', 'pattern' => '/^[a-zA-Z ]+$/', 'message' => 'Employee Benefit Broker Name can only contain alphabets.'],
			[['contact_person_email', 'emp_benefit_broker_email'], 'email'],
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
            'basic_info_id' => 'Basic Info ID',
            'company_id' => 'Company ID',
            'period_id' => 'Period ID',
            'contact_first_name' => 'Contact First Name',
            'contact_middle_name' => 'Contact Middle Name',
            'contact_last_name' => 'Contact Last Name',
            'contact_person_suffix' => 'Contact Person Suffix',
            'contact_person_title' => 'Contact Person Title',
            'contact_person_email' => 'Contact Person Email',
            'contact_phone_number' => 'Contact Phone Number',
            'street_address_1' => 'Street Address 1',
            'street_address_2' => 'Street Address 2',
            'contact_country' => 'Contact Country',
            'contact_state' => 'Contact State',
            'contact_city' => 'Contact City',
            'contact_zip' => 'Contact Zip',
            'emp_benefit_broker_name' => 'Emp Benefit Broker Name',
            'emp_benefit_broker_email' => 'Emp Benefit Broker Email',
            'emp_benefit_phone_number' => 'Emp Benefit Phone Number',
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
    
    
    public function FindbycompanyIdperiodId($company_id,$period_id)
    {
    	return TblAcaBasicInformation::find()->where(['company_id'=>$company_id])->andwhere(['period_id'=>$period_id])->One();
    }
}
