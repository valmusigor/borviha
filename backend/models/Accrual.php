<?php

namespace backend\models;
use backend\models\Contract;
use Yii;

/**
 * This is the model class for table "accruals".
 *
 * @property int $id
 * @property int $date_accrual
 * @property int $number_invoice
 * @property int $contract_id
 * @property string $name_accrual
 * @property string $units
 * @property double $quantity
 * @property double $price
 * @property double $sum
 * @property double $vat
 * @property double $sum_with_vat
 *
 * @property Contracts $contract
 */
class Accrual extends \yii\db\ActiveRecord
{
    const NAMES_ACCRUAL = [
        1 => 'Возмещение электроэнергии',
        2 => 'Оперативно-техническое обсл. электрооборудования и электрических сетей',
        3 => 'Вывоз и обезвреживание отходов не входящих в жилищный фонд',
        4 => 'ТО лифта',
        5 => 'Теплоснабжение',
        6 => 'Дымоудаление и АПС',
        7 => 'Круглосуточный контроль за состоянием ср-в противопож. защиты НИИ ПБ ЧС МСЧ',
        8 => 'Водоотведение',
        9 => 'Холодное водоснабжение',
        10 => 'Возмещение земельного налога',
        11=> 'Расходы ТС "Борвиха-плюс" по совместному домовладению',
    ];
    const KEY_MAPPING = ['date_accrual'=>'C',
        'number_invoice'=>'B',
        'name_accrual'=>'M',
        'units'=>'N',
        'quantity'=>'O',
        'price'=>'P',
        'sum'=>'J',
        'vat'=>'K',
        'sum_with_vat'=>'L',
        'agent'=>'E',
        'contract'=>'G',
        ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accruals';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_accrual', 'number_invoice', 'contract_id', 'name_accrual', 'units'], 'required'],
            [['date_accrual', 'number_invoice', 'contract_id','name_accrual'], 'integer'],
            [['quantity', 'price', 'sum', 'vat', 'sum_with_vat'], 'number'],
            [['units'], 'string', 'max' => 10],
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
            'date_accrual' => 'Дата',
            'number_invoice' => 'Номер счета',
            'contract_id' => 'Номер договора',
            'name_accrual' => 'Наименование услуги',
            'units' => 'ЕдИзм',
            'quantity' => 'Кол.',
            'price' => 'Стоимость',
            'sum' => 'Сумма',
            'vat' => 'НДС',
            'sum_with_vat' => 'ВСЕГО, рублей',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contract::className(), ['id' => 'contract_id']);
    }
      public function beforeValidate()
        {
        if (parent::beforeValidate()) {
            $this->date_accrual= strtotime($this->date_accrual);
            return true;
        }
        
        return false;
        }
        public function afterFind()
    {
        parent::afterFind();
        $this->date_accrual=date('d.m.Y', $this->date_accrual);
    }
    public static function checkExist($data) {
        if(($model=self::find()->where(['number_invoice'=>$data[self::KEY_MAPPING['number_invoice']]])
               ->andWhere(['date_accrual'=> strtotime($data[self::KEY_MAPPING['date_accrual']])])->andWhere(['name_accrual'=>self::convertNameAccrual($data[self::KEY_MAPPING['name_accrual']])])->one()))
           return $model;
        return false;
    }
    public static function convertNameAccrual($name){
        if(($temp_name= explode('_', $name))){
            foreach (self::NAMES_ACCRUAL as $key=>$value)
                if(count ($temp_name)===1 && $temp_name[0]===$value)
                    return $key;
                else if(count ($temp_name)>1 && $temp_name[1]===$value)
                    return $key;
        }
        return false;
    }
}
