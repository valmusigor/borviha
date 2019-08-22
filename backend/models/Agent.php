<?php

namespace backend\models;
use backend\models\Contract;
use Yii;

/**
 * This is the model class for table "agents".
 *
 * @property int $id
 * @property string $name
 * @property string $unp
 * @property string $legal_address
 * @property string $post_address
 * @property string $pc
 * @property string $bic
 * @property string $bank_data
 * @property string $email
 * @property int $type
 *
 * @property Contracts[] $contracts
 */
class Agent extends \yii\db\ActiveRecord
{
    const AGENT_OWNER = 1;
    const AGENT_RENTER = 2;
    const AGENT_JUR=1;
    const AGENT_FIZ=2;
    const AGENT_FIZ_PERSONAL_SETTINGS=['serial_number_passport','issued_by','date_issue','personal_number'];
    const AGENT_JUR_PERSONAL_SETTINGS=['equal_post','legal_address','unp','pc','bic','bank_data'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'person_org'], 'required'],
            [['type', 'person_org'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['post_address'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 30],
            [['email'], 'email'],
            [['name'], 'unique'],
        ];
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
            'person_org' => 'Физик/Юрик',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContracts()
    {
        return $this->hasMany(Contract::className(), ['agent_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLegals()
    {
        return $this->hasOne(Legals::className(), ['agent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPassports()
    {
        return $this->hasOne(Passports::className(), ['agent_id' => 'id']);
    }
    public function setDetalViewJur(){
        return [
            'name',
            'legals.unp',
            'legals.legal_address',
            'post_address',
            'legals.pc',
            'legals.bic',
            'legals.bank_data',
            'email:email',
            [ 
               'attribute' => 'type',
               'format' => 'raw',
                'value' => function ($data) {
                    $type = $data->type;
                    return \yii\helpers\Html::tag(
                        'span',
                        (($type===1) ? 'Cобственник' : (($type===2)? 'Арендатор':'непопределено') )
                    );
                },
            ],
            
        ];
    }
    public function setDetalViewFiz(){
        return [
            'name',
            'post_address',
            'passports.serial_number_passport',
            'passports.issued_by',
            'passports.date_issue',
            'passports.personal_number',
            'email:email',
            [ 
               'attribute' => 'type',
               'format' => 'raw',
                'value' => function ($data) {
                    $type = $data->type;
                    return \yii\helpers\Html::tag(
                        'span',
                        (($type===1) ? 'собственник' : (($type===2)? 'арендатор':'непопределено') )
                    );
                },
            ],
            
        ];
    }
}
