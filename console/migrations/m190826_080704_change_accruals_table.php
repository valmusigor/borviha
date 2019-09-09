<?php

use yii\db\Migration;

/**
 * Class m190826_080704_change_accruals_table
 */
class m190826_080704_change_accruals_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->deleteContractId();
        $this->addInvoiceId();
        $this->deleteNumberInvoice();
        $this->deleteDateAccrual();
    }
   
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->recoverContractId(); 
        $this->dropInvoiceId();
        $this->recoverNumberInvoice();
        $this->recoverDateAccrual();
    }
    public function deleteContractId() {
            $this->dropForeignKey(
              'fk-accruals-contract_id',
               'accruals'
           );
             $this->dropIndex(
              'idx-accruals-contract_id',
               'accruals'
           );
           $this->dropColumn('accruals', 'contract_id');
       }
       public function recoverContractId() {
            $this->addColumn('accruals', 'contract_id', $this->integer()->notNull());
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
       public function addInvoiceId() {
           $this->addColumn('accruals', 'invoice_id', $this->integer()->notNull());
            $this->createIndex(
               'idx-accruals-invoice_id',
               'accruals',
               'invoice_id'
           );
            $this->addForeignKey(
               'fk-accruals-invoice_id',
               'accruals',
               'invoice_id',
               'invoices',
               'id'
           );
       }
       public function dropInvoiceId() {
           
           $this->dropForeignKey(
              'fk-accruals-invoice_id',
               'accruals'
           );
             $this->dropIndex(
              'idx-accruals-invoice_id',
               'accruals'
           );
           $this->dropColumn('accruals', 'invoice_id');
       }
       public function deleteNumberInvoice() {
           $this->dropIndex(
           'idx-accruals-number_invoice',
            'accruals'
        );
         $this->dropColumn('accruals', 'number_invoice');
       }
       public function recoverNumberInvoice() {
           $this->addColumn('accruals', 'number_invoice', $this->integer()->notNull());
            $this->createIndex(
               'idx-accruals-number_invoice',
               'accruals',
               'number_invoice'
           );
       }
       public function deleteDateAccrual() {
           $this->dropIndex(
           'idx-accruals-date_accrual',
            'accruals'
        );
         $this->dropColumn('accruals', 'date_accrual');
       }
       public function recoverDateAccrual() {
           $this->addColumn('accruals', 'date_accrual', $this->integer()->notNull());
           $this->createIndex(
               'idx-accruals-date_accrual',
               'accruals',
               'date_accrual'
           );
       }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190826_080704_change_accruals_table cannot be reverted.\n";

        return false;
    }
    */
}
