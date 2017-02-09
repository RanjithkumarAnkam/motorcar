<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_city_states_united_states".
 *
 * @property string $locationID
 * @property string $city
 * @property string $state
 * @property string $lat
 * @property string $lon
 * @property string $topFivePopulation
 */
class TblCityStatesUnitedStates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_city_states_united_states';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city', 'state', 'lat', 'lon', 'topFivePopulation'], 'required'],
            [['topFivePopulation'], 'string'],
            [['city'], 'string', 'max' => 255],
            [['state'], 'string', 'max' => 2],
            [['lat', 'lon'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'locationID' => 'Location ID',
            'city' => 'City',
            'state' => 'State',
            'lat' => 'Lat',
            'lon' => 'Lon',
            'topFivePopulation' => 'Top Five Population',
        ];
    }
}
