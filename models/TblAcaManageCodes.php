<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "tbl_aca_manage_codes".
 *
 * @property integer $uid
 * @property integer $line_14
 * @property integer $line_16
 * @property string $code_combination
 * @property string $employers_organizations
 * @property string $individuals_families
 * @property integer $status
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaLookupOptions $line16
 * @property TblAcaLookupOptions $line14
 */
class TblAcaManageCodes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_manage_codes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['line_14', 'created_by'], 'required'],
            [['line_14', 'line_16', 'status', 'created_by', 'modified_by'], 'integer'],
            [['code_combination', 'employers_organizations', 'individuals_families'], 'string'],
            [['created_date', 'modified_date'], 'safe'],
            [['line_16'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaLookupOptions::className(), 'targetAttribute' => ['line_16' => 'lookup_id']],
            [['line_14'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaLookupOptions::className(), 'targetAttribute' => ['line_14' => 'lookup_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'line_14' => 'Line 14',
            'line_16' => 'Line 16',
            'code_combination' => 'Code Combination',
            'employers_organizations' => 'Employers Organizations',
            'individuals_families' => 'Individuals Families',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLine16()
    {
        return $this->hasOne(TblAcaLookupOptions::className(), ['lookup_id' => 'line_16']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLine14()
    {
        return $this->hasOne(TblAcaLookupOptions::className(), ['lookup_id' => 'line_14']);
    }
    
    /*
     * this function is to return the suffix names and details
    * the main requirement is to convert lookup_id (int to char)
    */
    public function line14()
    {
    	$connection = \Yii::$app->db;
    	 
    	$sql="SELECT lookup_value,CONCAT(lookup_id ,'') as lookup_id FROM tbl_aca_lookup_options WHERE lookup_status=1 AND code_id=11 ORDER BY lookup_value ASC";
    
    	$suffix = $connection->createCommand($sql);
    	 
    	return $suffix->queryAll();
    
    }
    

    /*
     * this function is to return the suffix names and details
    * the main requirement is to convert lookup_id (int to char)
    */
    public function line16()
    {
    	$connection = \Yii::$app->db;
    
    	$sql="SELECT lookup_value,CONCAT(lookup_id ,'') as lookup_id FROM tbl_aca_lookup_options WHERE lookup_status=1 AND code_id=12 ORDER BY lookup_value ASC";
    
    	$suffix = $connection->createCommand($sql);
    
    	return $suffix->queryAll();
    
    }
}
