<?php

namespace backend\models\forms;
use backend\models\Agent;
use backend\models\Contract;
use yii\base\Model;
use Yii;

abstract class AddAgent extends Model
{
    public $name;
    public $post_address;
    public $email;
    public $type;//тип собственник или арендатор
    public $number_contract;
    public $date_contract;
    public $agent_area;
    public $common_area;
    public $connection_id;//задаем для арендатора собственника
    public $agent_id;
    public $person_org;//физик или юрик
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        
        return [
            [['name','type','number_contract','date_contract','agent_area', 'common_area','person_org'], 'required'],
            [['type','connection_id','agent_id','person_org'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['post_address'], 'string', 'max' => 100],
            [['number_contract'], 'string', 'max' => 10],
            [['email'], 'email'],
            [['name'], 'unique','targetClass' => Agent::class],
            [['agent_area', 'common_area'], 'number'],
            ['date_contract','checkRightData'],
        ];
    }
    
    public function checkRightData($attribute,$params){
       if(strtotime($this->date_contract)<strtotime("31-07-2014"))
       {
           $this->addError($attribute, 'Некорректно задано время');
           return false;
       }
       return true;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название фирмы',
            'post_address' => 'Почтовый адрес',
            'email' => 'Email',
            'type' => 'Собственник/Арендатор',
            'number_contract'=>'Номер договора',
            'date_contract'=>'от',
            'agent_area'=>"Занимаемая площадь",
            'common_area'=>'Места общего пользования',
            'connection_id'=>'Собственник',
            'person_org'=>'',
        ];
    }
    abstract public function save();
}
