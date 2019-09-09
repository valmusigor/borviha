<?php

namespace backend\models;
use backend\models\Invoices;
use Yii;

/**
 * This is the model class for table "accruals".
 *
 * @property int $id
 * @property int $name_accrual
 * @property string $units
 * @property double $quantity
 * @property double $price
 * @property double $sum
 * @property double $vat
 * @property double $sum_with_vat
 * @property int $invoice_id
 *
 * @property Invoices $invoice
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
        12=> 'Уборка МОП'
    ];
    const UNITS_MAPPING = [
        1 => 'кВт.ч',
        2 => 'м.кв',
        3 => 'м.куб.',
        4 => 'м.кв',
        5 => 'Гкал',
        6 => 'м.кв.',
        7 => 'м.кв',
        8 => 'м.куб',
        9 => 'м.куб',
        10 => 'м.кв',
        11 => 'м.кв',
        12 => 'м.кв',
    ];
    const KEY_MAPPING = ['date_invoice'=>'C',
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
    const VOCABULARY = ['rub'=>['рубль', 'рубля', 'рублей'],'kop'=>['копейка','копейки','копеек']];
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
            [['name_accrual', 'units','invoice_id'], 'required'],
            [['name_accrual', 'invoice_id','units'], 'integer'],
            [['quantity', 'price', 'sum', 'vat', 'sum_with_vat'], 'number'],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoices::className(), 'targetAttribute' => ['invoice_id' => 'id']],
            ['name_accrual','checkUniqueForInvoice',]
        ];
    }
    public function checkUniqueForInvoice($attribute,$params){
       if(self::find()->where(['name_accrual'=> $this->name_accrual,'invoice_id'=>$this->invoice_id])->all())
       {
           $this->addError($attribute, 'В данном счете уже есть выбранное начисление');
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
            'name_accrual' => 'Наименование услуги',
            'units' => 'ЕдИзм',
            'quantity' => 'Кол.',
            'price' => 'Стоимость',
            'sum' => 'Сумма',
            'vat' => 'НДС',
            'sum_with_vat' => 'ВСЕГО, рублей',
            'invoice_id' => 'Номер счета',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
     public function getInvoice()
    {
        return $this->hasOne(Invoices::className(), ['id' => 'invoice_id']);
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
    public function saveData($data,$invoice_id){
        $index_name_units_accrual=self::convertNameAccrual(trim($data[self::KEY_MAPPING['name_accrual']]));
        $this->name_accrual= $index_name_units_accrual;
        $this->units=$index_name_units_accrual;
        $this->quantity=$data[self::KEY_MAPPING['quantity']];
        $this->price=$data[self::KEY_MAPPING['price']];
        $this->sum=$data[self::KEY_MAPPING['sum']];
        $this->vat=$data[self::KEY_MAPPING['vat']];
        $this->sum_with_vat=$data[self::KEY_MAPPING['sum_with_vat']];
        $this->invoice_id=$invoice_id;
        if(!$accrual->save()){
         return false;
        }
        return true;
    }
    public static function num2word($num,$words) {
        $num=$num%100;
        if ($num>19) { $num=$num%10; }
        switch ($num) {
          case 1:  { return($words[0]); }
          case 2: case 3: case 4:  { return($words[1]); }
          default: { return($words[2]); }
        }
    }
    public static function convertFemale($str){
        $result_str= str_replace('один', 'одна', $str);
        return str_replace('два', 'две', $result_str);
    }
}
