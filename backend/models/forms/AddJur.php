<?php

namespace backend\models\forms;
use backend\models\forms\AddAgent;
use backend\models\Agent;
use backend\models\Contract;
use backend\models\Legals;
//use yii\base\Model;
//use Yii;

class AddJur extends AddAgent
{
    //const PERSONAL_SETTINGS=['unp','pc','bic','bank_data'];
    public $personal_settings;
    public $unp;
    public $legal_address;
    public $pc;
    public $bic;
    public $bank_data;
    public $equal_post;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        
        return \yii\helpers\ArrayHelper::merge(parent::rules(),[
            [['unp','legal_address', 'pc','bic','bank_data'], 'required'],
            [['unp'], 'string', 'max' => 9,'min'=>9],
            [['pc'], 'string', 'max' => 28,'min'=>28],
            [['unp','pc',], 'unique','targetClass' => Legals::class],
            [['legal_address', 'bank_data'], 'string', 'max' => 100],
            [['bic'], 'string', 'max' => 20],
            //['equal_post','safe'],
        ]);
    }
    public function attributeLabels()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rules(),[
            'unp' => 'УНП',
            'legal_address' => 'Юридический адрес',
            'pc' => 'Расчетный счет',
            'bic' => 'Бик',
            'bank_data' => 'Данные Банка',
            'equal_post'=>'Юридический адрес совпадает с почтовым',
        ]);
    }
    public function init() {
        parent::init();
        $this->personal_settings= Agent::AGENT_JUR_PERSONAL_SETTINGS;
        $this->person_org= Agent::AGENT_JUR;
    }
    public function save(){
        if($this->validate()){
            $agent= new Agent();
            $agent->attributes=$this->toArray();
            $legal=new Legals();
            $legal->attributes=$this->toArray();
            $contract=new Contract();
            $contract->attributes=$this->toArray();
            if($agent->save())
            {
                $legal->agent_id=$agent->id;
                $contract->agent_id=$agent->id;
                if($legal->save() && $contract->save())
                {
                    return $agent->id;
                }
            }
        }
        return false;
    }
}
