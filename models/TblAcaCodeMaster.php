<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_code_master".
 *
 * @property integer $code_id
 * @property string $lookup_code
 * @property integer $code_type
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaLookupOptions[] $tblAcaLookupOptions
 */
class TblAcaCodeMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_code_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lookup_code', 'code_type', 'created_by'], 'required'],
            [['code_type', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['lookup_code'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code_id' => 'Code ID',
            'lookup_code' => 'Lookup Code',
            'code_type' => 'Code Type',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAcaLookupOptions()
    {
        return $this->hasMany(TblAcaLookupOptions::className(), ['code_id' => 'code_id']);
    }
	
	 public function codemasteruniquedetails($id)               //function for getting unique details
    {
    	return TblAcaCodeMaster::findOne(['code_id' => $id]);
    
    }
	public function codemasterfindcode($value)                 //function for getting code details
    {
    	$model = TblAcaCodeMaster::find()->where(['lookup_code' => $value])->one();
    	 
    	return $model;
    	 
    }
}
