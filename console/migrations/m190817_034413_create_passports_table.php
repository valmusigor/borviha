<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%passports}}`.
 */
class m190817_034413_create_passports_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%passports}}', [
            'id' => $this->primaryKey(),
            'serial_number_passport'=>$this->string(10)->notNull(),
            'issued_by'=>$this->string(30)->notNull(),
            'date_issue'=>$this->integer()->notNull(),
            'personal_number'=>$this->string(14)->defaultValue(null),
            'agent_id'=>$this->integer()->notNull(),
        ]);
        $this->createIndex(
            'idx-passports-agent_id',
            'passports',
            'agent_id'
        );
         $this->addForeignKey(
            'fk-passports-agent_id',
            'passports',
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
           'fk-passports-agent_id',
            'passports'
        );
          $this->dropIndex(
           'idx-passports-agent_id',
            'passports'
        );
        $this->dropTable('{{%passports}}');
    }
}
