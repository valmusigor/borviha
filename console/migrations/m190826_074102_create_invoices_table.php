<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoices}}`.
 */
class m190826_074102_create_invoices_table extends Migration
{
    const FORMAT = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%invoices}}', [
            'id' => $this->primaryKey(),
            'date_invoice'=>$this->integer()->notNull(),//дата начисления
            'number_invoice'=>$this->integer()->notNull(),//номер счета
            'contract_id'=>$this->integer()->notNull(),//номер договора
        ],self::FORMAT);
         $this->createIndex(
            'idx-invoices-date_invoice',
            'invoices',
            'date_invoice'
        );
         $this->createIndex(
            'idx-invoices-contract_id',
            'invoices',
            'contract_id'
        );
         $this->addForeignKey(
            'fk-invoices-contract_id',
            'invoices',
            'contract_id',
            'contracts',
            'id'
        );
        $this->createIndex(
            'idx-invoices-number_invoice',
            'invoices',
            'number_invoice'
        ); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
           'idx-invoices-date_invoice',
            'invoices'
        );
        $this->dropForeignKey(
           'fk-invoices-contract_id',
            'invoices'
        );
          $this->dropIndex(
            'idx-invoices-contract_id',
            'invoices'
        );
          $this->dropIndex(
           'idx-invoices-number_invoice',
            'invoices'
        );
        $this->dropTable('{{%invoices}}');
    }
}
