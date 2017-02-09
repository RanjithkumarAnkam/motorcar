<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_designated_govt_entity".
 *
 * @property integer $dge_id
 * @property integer $company_id
 * @property integer $period_id
 * @property integer $assign_dge
 * @property string $dge_name
 * @property string $dge_ein
 * @property string $street_address_1
 * @property string $street_address_2
 * @property string $dge_address
 * @property string $dge_city
 * @property string $dge_state
 * @property integer $dge_zip
 * @property string $dge_contact_first_name
 * @property string $dge_contact_middle_name
 * @property string $dge_contact_last_name
 * @property string $dge_contact_phone_number
 * @property string $dge_contact_suffix
 * @property integer $dge_reporting
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaCompanies $company
 * @property TblAcaCompanyReportingPeriod $period
 */
class TblAcaDesignatedGovtEntity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_designated_govt_entity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'period_id', 'created_by'], 'required'],
            [['company_id', 'period_id', 'assign_dge', 'dge_zip', 'dge_reporting', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['dge_ein', 'dge_contact_first_name', 'dge_contact_middle_name', 'dge_contact_last_name', 'dge_contact_phone_number'], 'string', 'max' => 50],
            [['dge_name'], 'string', 'max' => 75],
			[['street_address_1', 'street_address_2', 'dge_address', 'dge_city'], 'string', 'max' => 200],
            [['dge_state'], 'string', 'max' => 25],
            [['dge_contact_suffix'], 'string', 'max' => 10],
			['dge_name', 'match', 'pattern' => "/^[a-zA-Z0-9&.'()\-\ ]+$/", 'message' => 'Name of Designated Governmental Entity can only contain alphanumeric, dot, Ampersand, hyphen ,brackets .'],
            ['street_address_1', 'match', 'pattern' => '/^[a-zA-Z0-9\-\/\ ]+$/', 'message' => 'Street Address 1 can only contain alphanumeric, space, hyphen, Slash .'],
			['street_address_2', 'match', 'pattern' => '/^[a-zA-Z0-9\-\/\ ]+$/', 'message' => 'Street Address 2 can only contain alphanumeric, space, hyphen, Slash .'],
			['dge_contact_first_name', 'match', 'pattern' => '/^[a-zA-Z ]+$/', 'message' => 'DGE"s Contact Person First Name can only contain alphabets.'],
			['dge_contact_middle_name', 'match', 'pattern' => '/^[a-zA-Z ]+$/', 'message' => 'DGE"s Contact Person Middle Name can only contain alphabets.'],
			['dge_contact_last_name', 'match', 'pattern' => '/^[a-zA-Z ]+$/', 'message' => 'DGE"s Contact Person Last Name can only contain alphabets.'],
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
            'dge_id' => 'Dge ID',
            'company_id' => 'Company ID',
            'period_id' => 'Period ID',
            'assign_dge' => 'Assign Dge',
            'dge_name' => 'Dge Name',
            'dge_ein' => 'Dge Ein',
            'street_address_1' => 'Street Address 1',
            'street_address_2' => 'Street Address 2',
            'dge_address' => 'Dge Address',
            'dge_city' => 'Dge City',
            'dge_state' => 'Dge State',
            'dge_zip' => 'Dge Zip',
            'dge_contact_first_name' => 'Dge Contact First Name',
            'dge_contact_middle_name' => 'Dge Contact Middle Name',
            'dge_contact_last_name' => 'Dge Contact Last Name',
            'dge_contact_phone_number' => 'Dge Contact Phone Number',
            'dge_contact_suffix' => 'Dge Contact Suffix',
            'dge_reporting' => 'Dge Reporting',
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
    	return TblAcaDesignatedGovtEntity::find()->where(['company_id'=>$company_id])->andwhere(['period_id'=>$period_id])->One();
    }
}
