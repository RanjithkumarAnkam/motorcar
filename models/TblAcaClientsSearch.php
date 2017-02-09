<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblAcaClients;

/**
 * TblAcaClientsSearch represents the model behind the search form about `app\models\TblAcaClients`.
 */
class TblAcaClientsSearch extends TblAcaClients
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'user_id', 'brand_id', 'product', 'aca_year', 'forms_bought', 'ein_count', 'is_deleted', 'account_manager', 'created_by', 'modified_by', 'reporting_structure'], 'integer'],
            [['client_number', 'client_name', 'order_number', 'contact_first_name', 'contact_last_name', 'phone', 'email', 'profile_image', 'package_type', 'created_date', 'modified_date'], 'safe'],
            [['price_paid'], 'number'],
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
        $query = TblAcaClients::find();

        // add conditions that should always apply here

       $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['client_id'=>SORT_DESC]],
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
            'client_id' => $this->client_id,
            'user_id' => $this->user_id,
            'brand_id' => $this->brand_id,
            'product' => $this->product,
            'aca_year' => $this->aca_year,
            'forms_bought' => $this->forms_bought,
            'ein_count' => $this->ein_count,
            'is_deleted' => $this->is_deleted,
            'account_manager' => $this->account_manager,
            'price_paid' => $this->price_paid,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'modified_by' => $this->modified_by,
            'modified_date' => $this->modified_date,
            'reporting_structure' => $this->reporting_structure,
        ]);

        $query->andFilterWhere(['like', 'client_number', $this->client_number])
            ->andFilterWhere(['like', 'client_name', $this->client_name])
            ->andFilterWhere(['like', 'order_number', $this->order_number])
            ->andFilterWhere(['like', 'contact_first_name', $this->contact_first_name])
            ->andFilterWhere(['like', 'contact_last_name', $this->contact_last_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'profile_image', $this->profile_image])
            ->andFilterWhere(['like', 'package_type', $this->package_type]);

        return $dataProvider;
    }
}
