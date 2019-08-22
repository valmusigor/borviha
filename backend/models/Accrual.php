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
            [['date_accrual', 'number_invoice', 'contract_id'], 'integer'],
            [['quantity', 'price', 'sum', 'vat', 'sum_with_vat'], 'number'],
            [['name_accrual'], 'string', 'max' => 100],
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
            'sum_with_vat' => 'ВСЕГО',
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
