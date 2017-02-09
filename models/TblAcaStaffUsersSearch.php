<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblAcaStaffUsers;

/**
 * TblAcaStaffUsersSearch represents the model behind the search form about `app\models\TblAcaStaffUsers`.
 */
class TblAcaStaffUsersSearch extends TblAcaStaffUsers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_id', 'user_id', 'created_by', 'modified_by'], 'integer'],
            [['first_name', 'last_name', 'phone', 'profile_pic', 'created_date', 'modified_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TblAcaStaffUsers::find();

        // add conditions that should always apply here

         $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['staff_id'=>SORT_DESC]],
			'pagination' => [
    			'pagesize' => 10,
    			],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'staff_id' => $this->staff_id,
            'user_id' => $this->user_id,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'modified_by' => $this->modified_by,
            'modified_date' => $this->modified_date,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->orFilterWhere(['like', 'last_name', $this->first_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'profile_pic', $this->profile_pic]);

        return $dataProvider;
    }
}
