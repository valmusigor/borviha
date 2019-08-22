<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%owners}}`.
 */
class m190804_051241_create_agents_table extends Migration
{
    const FORMAT = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%agents}}', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->unique()->notNull(),
            'post_address'=>$this->string(100),
            'email' => $this->string(),
            'type'=> $this->tinyInteger()->notNull(),
            'person_org'=>$this->tinyInteger()->notNull(),
        ],self::FORMAT);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%agents}}');
    }
}
