<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_form_pricing".
 *
 * @property integer $price_id
 * @property string $details
 * @property double $value
 * @property integer $type
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 */
class TblAcaFormPricing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_form_pricing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['details', 'value', 'created_by', 'created_date'], 'required'],
            [['value'], 'number'],
            [['type', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['details'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'price_id' => 'Price ID',
            'details' => 'Details',
            'value' => 'Value',
            'type' => 'Type',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }
}
