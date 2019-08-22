<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Agent;

/**
 * AgentSearch represents the model behind the search form of `backend\models\Agent`.
 */
class AgentSearch extends Agent
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type','person_org'], 'integer'],
            [['name',  'post_address', 'email','legals.unp','passports.serial_number_passport'], 'safe'],
        ];
    }
    public function attributes()
    {
        // делаем поле зависимости доступным для поиска
        return array_merge(parent::attributes(), ['legals.unp','passports.serial_number_passport']);
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
        $query = Agent::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->joinWith(['legals','passports']);
        $dataProvider->sort->attributes['legals.unp'] = [
        'asc' => ['legals.unp' => SORT_ASC],
        'desc' => ['legals.unp' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['passports.serial_number_passport'] = [
        'asc' => ['passports.serial_number_passport' => SORT_ASC],
        'desc' => ['passports.serial_number_passport' => SORT_DESC],
        ];
        $query->andFilterWhere(['LIKE','legals.unp',$this->getAttribute('legals.unp')]);
        $query->andFilterWhere(['LIKE','passports.serial_number_passport',$this->getAttribute('passports.serial_number_passport')]);
        $query->andFilterWhere(['type' => $this->type]);
        
        return $dataProvider;
    }
}