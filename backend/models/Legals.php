<?php

namespace backend\models;
use backend\models\Agent;
use Yii;

/**
 * This is the model class for table "legals".
 *
 * @property int $id
 * @property string $unp
 * @property string $legal_address
 * @property string $pc
 * @property string $bic
 * @property string $bank_data
 * @property int $agent_id
 *
 * @property Agents $agent
 */
class Legals extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'legals';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unp', 'legal_address', 'pc', 'agent_id'], 'required'],
            [['agent_id'], 'integer'],
            [['unp'], 'string', 'max' => 9],
            [['legal_address', 'bank_data'], 'string', 'max' => 100],
            [['pc'], 'string', 'max' => 28],
            [['bic'], 'string', 'max' => 20],
            [['pc'], 'unique'],
            [['agent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Agent::className(), 'targetAttribute' => ['agent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unp' => 'УНП',
            'legal_address' => 'Юридический адрес',
            'pc' => 'Расчетный счет',
            'bic' => 'Bic',
            'bank_data' => 'Реквизиты Банка',
            'agent_id' => 'Agent ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgent()
    {
        return $this->hasOne(Agents::className(), ['id' => 'agent_id']);
    }
}
