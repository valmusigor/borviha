<?php

namespace backend\models;
use backend\models\Contract;
use backend\models\Accrual;
use Yii;

/**
 * This is the model class for table "invoices".
 *
 * @property int $id
 * @property int $date_invoice
 * @property int $number_invoice
 * @property int $contract_id
 *
 * @property Accruals[] $accruals
 * @property Contracts $contract
 */
class Invoices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_invoice', 'number_invoice', 'contract_id'], 'required'],
            [['date_invoice', 'number_invoice', 'contract_id'], 'integer'],
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
            'date_invoice' => 'Дата',
            'number_invoice' => 'Номер счета',
            'contract_id' => 'Номер договора',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contract::className(), ['id' => 'contract_id']);
    }
     public function getAccruals()
    {
        return $this->hasMany(Accrual::className(), ['invoice_id' => 'id']);
    }
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->date_invoice= strtotime($this->date_invoice);
            return true;
        }
        return false;
    }
    public function afterFind()
    {
        parent::afterFind();
        $this->date_invoice=date('d.m.Y', $this->date_invoice);
    }
    
    public static function checkExistAccrual($data) {
        if(($model=self::checkExistInvoice($data)))
        {
            foreach ($model->accruals as $accrual)
                if($accrual->name_accrual===Accrual::convertNameAccrual($data[Accrual::KEY_MAPPING['name_accrual']]))
            return $model;
        }     
        return false;
    }
    public static function checkExistInvoice($data){
     if(($model=self::find()->where(['number_invoice'=>$data[Accrual::KEY_MAPPING['number_invoice']]])
               ->andWhere(['date_invoice'=> strtotime($data[Accrual::KEY_MAPPING['date_invoice']])])->one()))
        {
         return $model;
        }
        return false;
    }
    public function getAllSum(){
        $sum=0;
        $vat=0;
        $sum_with_vat=0;
        foreach ($this->accruals as $accrual){
            $sum+=$accrual->sum;
            $vat+=$accrual->vat;
            $sum_with_vat+=$accrual->sum_with_vat;
        }
        return ['sum'=>$sum,'vat'=>$vat,'sum_with_vat'=>$sum_with_vat];
    }
}
