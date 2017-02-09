<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_element_master".
 *
 * @property integer $master_id
 * @property integer $section_id
 * @property string $element_id
 * @property string $element_label
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 */
class TblAcaElementMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_element_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'element_id', 'element_label', 'created_by'], 'required'],
            [['section_id', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['element_id'], 'string', 'max' => 25],
            [['element_label'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'master_id' => 'Master ID',
            'section_id' => 'Section ID',
            'element_id' => 'Element ID',
            'element_label' => 'Element Label',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }
    
    public function getAlllookupoptions()                            //having relation
    {
    	return $this->hasOne(TblAcaLookupOptions::className(), ['section_id' => 'section_id']);
    }
    
    public function Elementuniquedetails($id)                        //getting unique values
    {
    	return TblAcaElementMaster::findOne(['master_id' => $id]);
    
    }
    public function Elementalldetails($filter_elements)              //getting the values for grid
    {
		if(empty($filter_elements)){
			
    	return TblAcaElementMaster::find()
    	->joinWith(['alllookupoptions'])                                        //joining another table
    	->orderBy(['tbl_aca_element_master.section_id' => SORT_ASC])
    	->all();
		
		}else{
			
			return TblAcaElementMaster::find()
    	->joinWith(['alllookupoptions'])                                         //joining another table
		->where(['=', 'tbl_aca_element_master.section_id', $filter_elements])
    	->orderBy(['tbl_aca_element_master.section_id' => SORT_ASC])
    	->all();
		}
    }
    
  public function FindelementbyelementId($id)                           //get element id
    {
    	return $this->find()->where(['element_id' => $id])->One();
    
    }
	
	 /**Get all element with $section_ids[]*/
    public function FindallbysectionIds($section_ids)
    {
    	return TblAcaElementMaster::find()->select('element_id, element_label')
    	->where([
    			'section_id' => $section_ids,
    			])
    			->all();
    
    }
}
