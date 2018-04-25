<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notice_type}}`.
 */
class m180420_150748_create_notice_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%notice_type}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'ident' => $this->string()->unique(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%notice_type}}');
    }
}
