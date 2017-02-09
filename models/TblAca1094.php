<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_1094".
 *
 * @property integer $id
 * @property integer $form_id
 * @property string $serialise_data1
 * @property string $serialise_data2
 * @property string $serialise_data3
 * @property string $serialise_data4
 * @property string $xml_data
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 *
 * @property TblAcaForms $form
 */
class TblAca1094 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_1094';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_id', 'serialise_data1', 'serialise_data2', 'created_by'], 'required'],
            [['form_id', 'created_by', 'updated_by'], 'integer'],
            [['serialise_data1', 'serialise_data2', 'serialise_data3', 'serialise_data4', 'xml_data'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['form_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaForms::className(), 'targetAttribute' => ['form_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_id' => 'Form ID',
            'serialise_data1' => 'Serialise Data1',
            'serialise_data2' => 'Serialise Data2',
            'serialise_data3' => 'Serialise Data3',
            'serialise_data4' => 'Serialise Data4',
            'xml_data' => 'Xml Data',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(TblAcaForms::className(), ['id' => 'form_id']);
    }
    
    public function getUsername()
    {
    	return $this->hasOne(TblAcaCompanyUsers::className(), ['user_id' => 'updated_by']);
    }
}
