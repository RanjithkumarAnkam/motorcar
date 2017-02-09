<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_usa_states".
 *
 * @property integer $state_id
 * @property string $state_code
 * @property string $state_name
 */
class TblUsaStates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_usa_states';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['state_code', 'state_name'], 'required'],
            [['state_code'], 'string', 'max' => 10],
            [['state_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'state_id' => 'State ID',
            'state_code' => 'State Code',
            'state_name' => 'State Name',
        ];
    }
}
