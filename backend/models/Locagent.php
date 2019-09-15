<?php

namespace backend\models;
use backend\models\Contract;
use Yii;

/**
 * This is the model class for table "locagent".
 *
 * @property int $id
 * @property int $number_floor
 * @property double $square
 * @property int $contract_id
 *
 * @property Contracts $contract
 */
class Locagent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'locagent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number_floor', 'square', 'contract_id','number_office'], 'required'],
            [['number_floor', 'contract_id'], 'integer'],
            [['number_office'], 'string', 'max' => 10],
            [['square'], 'number'],
            [['contract_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contract::className(), 'targetAttribute' => ['contract_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number_office'=>'Номер офиса',
            'number_floor' => 'Номер этажа',
            'square' => 'Площадь',
            'contract_id' => 'Contract ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contract::className(), ['id' => 'contract_id']);
    }
}
