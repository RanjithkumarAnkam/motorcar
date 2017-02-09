<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_cron".
 *
 * @property integer $cron_id
 * @property integer $is_cron_started
 */
class TblAcaCron extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_cron';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_cron_started'], 'required'],
            [['is_cron_started'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cron_id' => 'Cron ID',
            'is_cron_started' => 'Is Cron Started',
        ];
    }
}
