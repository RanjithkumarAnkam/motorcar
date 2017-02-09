<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblAcaCompanies;
use app\components\EncryptDecryptComponent;
/**
 * TblAcaCompaniesSearch represents the model behind the search form about `app\models\TblAcaCompanies`.
 */
class TblAcaCompaniesSearch extends TblAcaCompanies
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'client_id', 'reporting_status', 'created_by', 'modified_by'], 'integer'],
            [['company_id','company_client_number', 'company_name', 'company_ein', 'created_date', 'modified_date'], 'safe'],
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
        $query = TblAcaCompanies::find()->joinWith('client')->joinWith('tbl_aca_company_reporting_period')->where(['tbl_aca_clients.is_deleted'=>0]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['company_id'=>SORT_DESC]],
			'pagination' => [
    			'pagesize' => 10,
    			],
        ]);
		
		$dataProvider->sort->attributes['tbl_aca_company_reporting_period.year.lookup_value'] = [
    	'asc' => ['tbl_aca_company_reporting_period.reporting_year' => SORT_ASC],
    	'desc' => ['tbl_aca_company_reporting_period.reporting_year' => SORT_DESC],
    	];
		
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'company_id' => $this->company_id,
            'client_id' => $this->client_id,
            'reporting_status' => $this->reporting_status,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'modified_by' => $this->modified_by,
            'modified_date' => $this->modified_date,
        ]);

        $query->andFilterWhere(['like', 'company_client_number', $this->company_client_number])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'company_ein', $this->company_ein]);

        return $dataProvider;
    }
	
	
	
	 /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function companysearch($params,$client_ids)
    {
        $query = TblAcaCompanies::find()->joinWith('client')->joinWith('tbl_aca_company_reporting_period')->where(['company_id' => $company_ids])->andwhere(['tbl_aca_clients.is_deleted'=>0]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
    			'pagesize' => 10,
    			],
        ]);
		
		$dataProvider->sort->attributes['tbl_aca_company_reporting_period.year.lookup_value'] = [
    	'asc' => ['tbl_aca_company_reporting_period.reporting_year' => SORT_ASC],
    	'desc' => ['tbl_aca_company_reporting_period.reporting_year' => SORT_DESC],
    	];
		
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'company_id' => $this->company_id,
            'client_id' => $this->client_id,
            'reporting_status' => $this->reporting_status,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'modified_by' => $this->modified_by,
            'modified_date' => $this->modified_date,
        ]);

        $query->andFilterWhere(['like', 'company_client_number', $this->company_client_number])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'company_ein', $this->company_ein]);

        return $dataProvider;
    }
	
	
	
	  /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchcompanies($params,$company_ids)
    {
        $query = TblAcaCompanies::find()->joinWith('client')->joinWith('tbl_aca_company_reporting_period')->where(['tbl_aca_clients.is_deleted'=>0])->andwhere(['tbl_aca_companies.company_id'=>$company_ids]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
    			'pagesize' => 10,
    			],
        ]);
		
		$dataProvider->sort->attributes['tbl_aca_company_reporting_period.year.lookup_value'] = [
    	'asc' => ['tbl_aca_company_reporting_period.reporting_year' => SORT_ASC],
    	'desc' => ['tbl_aca_company_reporting_period.reporting_year' => SORT_DESC],
    	];
		
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		$company_id = '';
		if(!empty($this->company_id))
		{
			$encrypt_component = new EncryptDecryptComponent();
			$company_id = $encrypt_component->decryptUser($this->company_id);
		}
        // grid filtering conditions
        $query->andFilterWhere([
            'tbl_aca_companies.company_id' => $company_id,
            'client_id' => $this->client_id,
            'reporting_status' => $this->reporting_status,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'modified_by' => $this->modified_by,
            'modified_date' => $this->modified_date,
        ]);
		
        $query->andFilterWhere(['like', 'company_client_number', $this->company_client_number])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'company_ein', $this->company_ein]);

        return $dataProvider;
    }
}
