<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%legals}}`.
 */
class m190817_035858_create_legals_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%legals}}', [
            'id' => $this->primaryKey(),
            'unp'=>$this->string(9)->notNull(),
            'legal_address'=>$this->string(100)->notNull(),
            'pc'=>$this->string(28)->unique()->notNull(),
            'bic'=>$this->string(20),
            'bank_data'=>$this->string(100),
            'agent_id'=>$this->integer()->notNull(),
        ]);
         $this->createIndex(
            'idx-legals-agent_id',
            'legals',
            'agent_id'
        );
         $this->addForeignKey(
            'fk-legals-agent_id',
            'legals',
            'agent_id',
            'agents',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->dropForeignKey(
           'fk-legals-agent_id',
            'legals'
        );
          $this->dropIndex(
           'idx-legals-agent_id',
            'legals'
        );
        $this->dropTable('{{%legals}}');
    }
}
