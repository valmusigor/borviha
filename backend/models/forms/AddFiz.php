<?php

namespace backend\models\forms;
use backend\models\forms\AddAgent;
use backend\models\Passports;
use backend\models\Agent;
use backend\models\Contract;

class AddFiz extends AddAgent
{
    public $serial_number_passport;
    public $issued_by;
    public $date_issue;
    public $personal_number;
    public $personal_settings;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        
        return \yii\helpers\ArrayHelper::merge(parent::rules(),[
            [['serial_number_passport','issued_by', 'date_issue'], 'required'],
            [['serial_number_passport'], 'string', 'max' => 10],
            [['issued_by'], 'string', 'max' => 30],
            [['personal_number'], 'string', 'max' => 14],
            [['serial_number_passport','personal_number',], 'unique','targetClass' => Passports::class],
        ]);
    }
    public function attributeLabels()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rules(),[
            'serial_number_passport' => 'Cерия и номер паспорта',
            'issued_by' => 'Орган выдавший паспорт',
            'date_issue' => 'Дата выдачи',
            'personal_number' => 'Личный номер',
            
        ]);
    }
    public function init() {
        parent::init();
        $this->personal_settings=Agent::AGENT_FIZ_PERSONAL_SETTINGS;
        $this->person_org= Agent::AGENT_FIZ;
    }
    public function save(){
        if($this->validate()){
            $agent= new Agent();
            $agent->attributes=$this->toArray();
            $passport=new Passports();
            $passport->attributes=$this->toArray();
            $contract=new Contract();
            $contract->attributes=$this->toArray();
            if($agent->save())
            {
                $passport->agent_id=$agent->id;
                $contract->agent_id=$agent->id;
                if($passport->save() && $contract->save())
                {
                    return $agent->id;
                }
            }
        }
        return false;
    }
}
