<?php

namespace backend\models\forms;
use backend\models\Agent;
use backend\models\Contract;
use backend\models\Locagent;
use yii\base\Model;
class AddLoc extends Model
{
    public $square;
    public $agent_name;
    public $number_contract;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
         return [
            [['agent_name', 'number_contract'], 'trim'],
            [['square', 'agent_name','number_contract'], 'required'],
            [['number_contract'], 'string', 'max' => 20],
            [['agent_name'], 'string', 'max' => 50],
            [['square'], 'number'],
            ['agent_name','checkExist'],
            ['number_contract', 'checkExist'],
         ];
    }
    public function checkExist($attribute,$params){
    if($attribute==='agent_name' && !(Agent::find()->andWhere(['name'=>$this->$attribute])->all()))
        {
          $agents=Agent::find()->andWhere(['like','name',$this->$attribute])->all();
           $help_agent=($agents[0])?$agents[0]->name:'';
           $this->addError($attribute, 'Контрагент не найден попробуйте '.  $help_agent);
           return false; 
        }
    else if($attribute==='number_contract' && !(Contract::find()->andWhere(['number_contract'=>$this->$attribute])->all()))
        { 
           $help_number_contract=($this->agent_name && ($agent=Agent::findOne(['name'=>$this->agent_name])))?$agent->contracts[0]->number_contract:'';
           $this->addError($attribute, 'Номер договора не существует попробуйте договор '.$help_number_contract);
           return false;  
        }
    
       return true;
    }
    public function attributeLabels()
    {
         return [
            'square' => 'Площадь',
            'agent_name' => 'Наименование собственника/арендатора',
            'number_contract'=>'Номер договора',
        ];
    }
    public function save($model){
        if(!($this->validate()))
            return false;
        $locagent=new Locagent();
        $locagent->square= $this->square;
        $locagent->number_office= $model->number_office;
          $locagent->number_floor=$model->floor; 
        if(($contract= Contract::findOne(['number_contract'=>$this->number_contract])))  
          $locagent->contract_id=$contract->id;
        if($locagent->save())
            return true;
        return false;
    }

}
