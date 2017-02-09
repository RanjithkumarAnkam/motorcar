<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_aggregated_group_list".
 *
 * @property integer $aggregated_ein_list_id
 * @property integer $aggregated_grp_id
 * @property string $group_name
 * @property string $group_ein
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaAggregatedGroup $aggregatedGrp
 */
class TblAcaAggregatedGroupList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_aggregated_group_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aggregated_grp_id', 'created_by'], 'required'],
            [['aggregated_grp_id', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['group_name'], 'string', 'max' => 100],
            [['group_ein'], 'string', 'max' => 50],
			['group_name', 'match', 'pattern' => '/^[a-zA-Z0-9\&\ ]+$/', 'message' => 'Group name can only contain alphanumeric.'],
            [['aggregated_grp_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaAggregatedGroup::className(), 'targetAttribute' => ['aggregated_grp_id' => 'aggregated_grp_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'aggregated_ein_list_id' => 'Aggregated Ein List ID',
            'aggregated_grp_id' => 'Aggregated Grp ID',
            'group_name' => 'Group Name',
            'group_ein' => 'Group Ein',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAggregatedGrp()
    {
        return $this->hasOne(TblAcaAggregatedGroup::className(), ['aggregated_grp_id' => 'aggregated_grp_id']);
    }
    
    /**Function used to get particular aggregate group details**/
    public function FindbyaggregateId($id)
    {
    	return TblAcaAggregatedGroupList::find()->where(['aggregated_grp_id' => $id])->All();
    }
}
