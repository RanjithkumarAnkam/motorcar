<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_countries1".
 *
 * @property integer $id
 * @property string $country_code
 * @property string $country_name
 */
class TblAcaCountries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_code'], 'string', 'max' => 2],
            [['country_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_code' => 'Country Code',
            'country_name' => 'Country Name',
        ];
    }
}
