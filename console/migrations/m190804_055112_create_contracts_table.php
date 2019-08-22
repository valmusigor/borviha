<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contracts}}`.
 */
class m190804_055112_create_contracts_table extends Migration
{
    const FORMAT = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contracts}}', [
            'id' => $this->primaryKey(),
            'number_contract'=>$this->string(20)->notNull(),
            'date_contract'=>$this->integer()->notNull(),
            'agent_area'=>$this->double()->notNull(),
            'common_area'=>$this->double()->notNull(),
            'agent_id'=>$this->integer()->notNull(),
            'connection_id'=>$this->integer(),
        ],self::FORMAT);
        
        
         $this->createIndex(
            'idx-contracts-agent_id',
            'contracts',
            'agent_id'
        );
         $this->addForeignKey(
            'fk-contracts-agent_id',
            'contracts',
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
           'fk-contracts-agent_id',
            'contracts'
        );
          $this->dropIndex(
           'idx-contracts-agent_id',
            'contracts'
        );
        $this->dropTable('{{%contracts}}');
    }
}
