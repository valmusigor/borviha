<?php

use yii\db\Migration;

/**
 * Class m190822_083454_add_indexes_in_agents_legals_passports_table
 */
class m190822_083454_add_indexes_in_agents_legals_passports_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-legals-unp',
            'legals',
            'unp'
        );
        $this->createIndex(
            'idx-passports-serial_number_passport',
            'passports',
            'serial_number_passport'
        );
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->dropIndex(
           'idx-legals-unp',
            'legals'
        );
          $this->dropIndex(
           'idx-passports-serial_number_passport',
            'passports'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190822_083454_add_indexes_in_agents_legals_passports_table cannot be reverted.\n";

        return false;
    }
    */
}
