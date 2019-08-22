<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%accruals}}`.
 */
class m190804_062512_create_accruals_table extends Migration
{
     const FORMAT = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%accruals}}', [
            'id' => $this->primaryKey(),
            'date_accrual'=>$this->integer()->notNull(),//дата начисления
            'number_invoice'=>$this->integer()->notNull(),//номер счета
            'contract_id'=>$this->integer()->notNull(),//номер договора
            'name_accrual'=>$this->string(100)->notNull(),//название начисления
            'units'=>$this->string(10)->notNull(),//еденицы измерения
            'quantity'=>$this->double(),//количество
            'price'=>$this->double(),//цена
            'sum'=>$this->double(),//сумма
            'vat'=>$this->double(),//ндс
            'sum_with_vat'=>$this->double(),//сумма с ндс
        ],self::FORMAT);
         $this->createIndex(
            'idx-accruals-contract_id',
            'accruals',
            'contract_id'
        );
         $this->addForeignKey(
            'fk-accruals-contract_id',
            'accruals',
            'contract_id',
            'contracts',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
           'fk-accruals-contract_id',
            'accruals'
        );
          $this->dropIndex(
           'idx-accruals-contract_id',
            'accruals'
        );
        $this->dropTable('{{%accruals}}');
    }
}
