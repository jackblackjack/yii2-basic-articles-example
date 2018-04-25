<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article_search}}`.
 */
class m180420_145830_create_article_search_table extends Migration
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

        $this->createTable('{{%article_search}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'preview_data' => $this->string(),
            'full_data' => $this->string()->notNull(),
            'is_active' => $this->integer(6)->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article_search}}');
    }
}
