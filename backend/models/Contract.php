<?php

namespace backend\models;
use backend\models\Agent;
use Yii;

/**
 * This is the model class for table "contracts".
 *
 * @property int $id
 * @property string $number_contract
 * @property int $date_contract
 * @property double $agent_area
 * @property double $common_area
 * @property int $agent_id
 * @property int $connection_id
 *
 * @property Accruals[] $accruals
 * @property Agents $agent
 */
class Contract extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contracts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number_contract', 'date_contract', 'agent_area', 'common_area', 'agent_id'], 'required'],
            [[ 'agent_id', 'connection_id'], 'integer'],
            [['agent_area', 'common_area'], 'number'],
            [['number_contract'], 'string', 'max' => 20],
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
            'number_contract' => 'Номер договора',
            'date_contract' => 'Date Contract',
            'agent_area' => 'Agent Area',
            'common_area' => 'Common Area',
            'agent_id' => 'Agent ID',
            'connection_id' => 'Connection ID',
        ];
    }
     public function beforeSave($insert)
        {
        if (parent::beforeSave($insert)) {
            $this->date_contract= strtotime($this->date_contract);
            return true;
        }
        return false;
        }
        public function afterFind()
    {
        parent::afterFind();
        $this->date_contract=date('d.m.Y', $this->date_contract);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['contract_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgent()
    {
        return $this->hasOne(Agent::className(), ['id' => 'agent_id']);
    }
    public static function getContractId($agent,$contract){
        if($contract)
        {   $arg=explode('№', $contract);
            if (count($arg)>1){
            $number_contract= explode(' ',$arg[1])[0];
            if(($contract=self::findOne(['number_contract'=>$number_contract])))
                    return $contract->id;
            }
        }
        if(($findAgent=Agent::findOne(['name'=>$agent]))){
            return $findAgent->contracts[0]->id;
        }
        return null;
    }
}
