<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Accrual;

/**
 * AccrualSearch represents the model behind the search form of `backend\models\Accrual`.
 */
class AccrualSearch extends Accrual
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date_accrual', 'number_invoice', 'contract_id'], 'integer'],
            [['name_accrual', 'units'], 'safe'],
            [['quantity', 'price', 'sum', 'vat', 'sum_with_vat'], 'number'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Accrual::find();

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
            'date_accrual' => $this->date_accrual,
            'number_invoice' => $this->number_invoice,
            'contract_id' => $this->contract_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'sum' => $this->sum,
            'vat' => $this->vat,
            'sum_with_vat' => $this->sum_with_vat,
        ]);

        $query->andFilterWhere(['like', 'name_accrual', $this->name_accrual])
            ->andFilterWhere(['like', 'units', $this->units]);

        return $dataProvider;
    }
}
