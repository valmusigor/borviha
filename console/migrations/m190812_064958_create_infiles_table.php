<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%infiles}}`.
 */
class m190812_064958_create_infiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%infiles}}', [
            'id' => $this->primaryKey(),
            'file_name'=> $this->string(50)->unique(),
            'upload_name'=> $this->string(30),
            'date_uploads'=>$this->integer()->notNull(),
            'user_id'=>$this->integer()->notNull(),
        ]);
         $this->createIndex(
            'idx-infiles-user_id',
            'infiles',
            'user_id'
        );
          $this->addForeignKey(
            'fk-infiles-user_id',
            'infiles',
            'user_id',
            'user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->dropForeignKey(
          'fk-infiles-user_id',
            'infiles'
        );
          $this->dropIndex(
            'idx-infiles-user_id',
            'infiles'
        );
        $this->dropTable('{{%infiles}}');
    }
}
