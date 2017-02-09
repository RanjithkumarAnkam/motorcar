<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_global_settings".
 *
 * @property integer $setting_id
 * @property string $name
 * @property string $value
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 */
class TblAcaGlobalSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_global_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_by'], 'required'],
            [['created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['value'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'setting_id' => 'Setting ID',
            'name' => 'Name',
            'value' => 'Value',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }
    
    public function Findemailsettings()                     //getting all details
    {
    	return TblAcaGlobalSettings::find()->where(['<>','setting_id',''])->All();
    	 
    }
    public function settinguniquedetails($id)             //getting unique details
    {
    	return TblAcaGlobalSettings::find()->where(['setting_id' => $id])->One();
    
    }
}
