<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%locagent}}`.
 */
class m190910_092155_create_locagent_table extends Migration
{
     const FORMAT = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%locagent}}', [
            'id' => $this->primaryKey(),
            'number_office'=>$this->string(10)->notNull(),
            'number_floor'=>$this->integer()->notNull(),
            'square'=>$this->double()->notNull(),
            'contract_id'=>$this->integer()->notNull(),
        ],self::FORMAT);
        $this->createIndex(
            'idx-locagent-contract_id',
            'locagent',
            'contract_id'
        );
         $this->addForeignKey(
            'fk-locagent-contract_id',
            'locagent',
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
           'fk-locagent-contract_id',
            'locagent'
        );
          $this->dropIndex(
           'idx-locagent-contract_id',
            'locagent'
        );
        $this->dropTable('{{%locagent}}');
    }
}
