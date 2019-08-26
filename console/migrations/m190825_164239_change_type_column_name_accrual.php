<?php

use yii\db\Migration;

/**
 * Class m190825_164239_change_type_column_name_accrual
 */
class m190825_164239_change_type_column_name_accrual extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('accruals', 'name_accrual', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->alterColumn('accruals', 'name_accrual', $this->string(100)->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190825_164239_change_type_column_name_accrual cannot be reverted.\n";

        return false;
    }
    */
}
