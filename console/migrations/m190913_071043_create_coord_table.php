<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%coord}}`.
 */
class m190913_071043_create_coord_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%coord}}', [
            'id' => $this->primaryKey(),
            'point'=>$this->string()->notNull(),
            'floor'=>$this->integer()->notNull(),
            'number_office'=>$this->string(10),
        ]);
//         $this->createIndex(
//            'idx-coord-locagent_id',
//            'coord',
//            'locagent_id'
//        );
//         $this->addForeignKey(
//            'fk-coord-locagent_id',
//            'coord',
//            'locagent_id',
//            'locagent',
//            'id'
//        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $this->dropForeignKey(
//           'fk-coord-locagent_id',
//            'coord'
//        );
//          $this->dropIndex(
//           'idx-coord-locagent_id',
//            'coord'
//        );
        $this->dropTable('{{%coord}}');
    }
}
