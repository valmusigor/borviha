<?php

namespace backend\models;
use backend\models\Agent;
use Yii;

/**
 * This is the model class for table "passports".
 *
 * @property int $id
 * @property string $serial_number_passport
 * @property string $issued_by
 * @property int $date_issue
 * @property string $personal_number
 * @property int $agent_id
 *
 * @property Agents $agent
 */
class Passports extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'passports';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['serial_number_passport', 'issued_by', 'date_issue', 'agent_id'], 'required'],
            [['agent_id'], 'integer'],
            [['serial_number_passport'], 'string', 'max' => 10],
            [['issued_by'], 'string', 'max' => 30],
            [['personal_number'], 'string', 'max' => 14],
            [['agent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Agent::className(), 'targetAttribute' => ['agent_id' => 'id']],
        ];
    }
    public function beforeSave($insert)
        {
        if (parent::beforeSave($insert)) {
            $this->date_issue= strtotime($this->date_issue);
            return true;
        }
        return false;
    }
      public function afterFind()
    {
        parent::afterFind();
         $this->date_issue=date('d.m.Y', $this->date_issue);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'serial_number_passport' => 'Серия и номер паспорта',
            'issued_by' => 'Кем выдан',
            'date_issue' => 'Дата выдачи',
            'personal_number' => 'Личный номер',
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
