<?php

use yii\db\Migration;

/**
 * Class m190825_064456_add_indexes_in_accruals_table
 */
class m190825_064456_add_indexes_in_accruals_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createIndex(
            'idx-accruals-date_accrual',
            'accruals',
            'date_accrual'
        );
        $this->createIndex(
            'idx-accruals-number_invoice',
            'accruals',
            'number_invoice'
        ); 
        $this->createIndex(
            'idx-accruals-name_accrual',
            'accruals',
            'name_accrual'
        ); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
           'idx-accruals-date_accrual',
            'accruals'
        );
          $this->dropIndex(
           'idx-accruals-number_invoice',
            'accruals'
        );
           $this->dropIndex(
           'idx-accruals-name_accrual',
            'accruals'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190825_064456_add_indexes_in_accruals_table cannot be reverted.\n";

        return false;
    }
    */
}
