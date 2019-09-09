<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Invoices;
use kartik\daterange\DateRangeBehavior;
/**
 * InvoicesSearch represents the model behind the search form of `backend\models\Invoices`.
 */
class InvoicesSearch extends Invoices
{
    public $created_at_range;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'number_invoice', 'contract_id'], 'integer'],
            [['date_invoice','created_at_range','contract.number_contract','contract.agent.name'], 'safe'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    public function attributes()
    {
        // делаем поле зависимости доступным для поиска
        return array_merge(parent::attributes(), ['contract.number_contract','contract.agent.name']);
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
        $query = Invoices::find();

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
         $query->joinWith(['contract','contract.agent']);
        // grid filtering conditions
        $query->andFilterWhere([
//            'date_invoice' => $this->date_invoice,
            'number_invoice' => $this->number_invoice,
        ]);
        $query->andFilterWhere(['like', 'contracts.number_contract', $this->getAttribute('contract.number_contract')])
                ->andFilterWhere(['like', 'agents.name', $this->getAttribute('contract.agent.name')]);
        if(!empty($this->created_at_range) && strpos($this->created_at_range, '-') !== false) {
			list($start_date, $end_date) = explode(' - ', $this->created_at_range);
			$query->andFilterWhere(['between', 'date_invoice', strtotime($start_date), strtotime($end_date)]);
		}	

        return $dataProvider;
    }
}
