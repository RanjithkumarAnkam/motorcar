<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblAcaForms;

/**
 * TblAcaFormsSearch represents the model behind the search form of `app\models\TblAcaForms`.
 */
class TblAcaFormsSearch extends TblAcaForms
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'generate_form_id', 'company_id', 'is_approved', 'created_by', 'approved_by'], 'integer'],
            [['version'], 'number'],
            [['approved_by_name', 'efile_status', 'efile_receipt_number', 'created_date', 'approved_date'], 'safe'],
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
        $query = TblAcaForms::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'generate_form_id' => $this->generate_form_id,
            'version' => $this->version,
            'company_id' => $this->company_id,
            'is_approved' => $this->is_approved,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'approved_by' => $this->approved_by,
            'approved_date' => $this->approved_date,
        ]);

        $query->andFilterWhere(['like', 'approved_by_name', $this->approved_by_name])
            ->andFilterWhere(['like', 'efile_status', $this->efile_status])
            ->andFilterWhere(['like', 'efile_receipt_number', $this->efile_receipt_number]);

        return $dataProvider;
    }
	
	/**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function approvedrecords($params)
    {
        $query = TblAcaForms::find()->joinwith('company')->where(['is_approved'=>1]);

        // add conditions that should always apply here
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
    			'pagesize' => 10,
    			],
        ]);
		
		$dataProvider->sort->attributes['company.company_name'] = [
			'asc' => ['tbl_aca_companies.company_name' => SORT_ASC],
			'desc' => ['tbl_aca_companies.company_name' => SORT_DESC],
    	];
		
		$dataProvider->sort->attributes['company.company_client_number'] = [
			'asc' => ['tbl_aca_companies.company_client_number' => SORT_ASC],
			'desc' => ['tbl_aca_companies.company_client_number' => SORT_DESC],
    	];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'generate_form_id' => $this->generate_form_id,
            'version' => $this->version,
            'company_id' => $this->company_id,
            'is_approved' => $this->is_approved,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'approved_by' => $this->approved_by,
            'approved_date' => $this->approved_date,
        ]);

       $query->andFilterWhere(['like', 'tbl_aca_companies.company_name', $this->approved_by_name])
            ->andFilterWhere(['like', 'efile_status', $this->efile_status])
            ->andFilterWhere(['like', 'efile_receipt_number', $this->efile_receipt_number]);

        return $dataProvider;
    }
}
