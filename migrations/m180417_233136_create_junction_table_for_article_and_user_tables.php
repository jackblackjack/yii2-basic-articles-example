<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_user`.
 * Has foreign keys to the tables:
 *
 * - `article`
 * - `user`
 */
class m180417_233136_create_junction_table_for_article_and_user_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article_user', [
            'article_id' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'PRIMARY KEY(article_id, user_id)',
        ]);

        // creates index for column `article_id`
        $this->createIndex(
            'idx-article_user-article_id',
            'article_user',
            'article_id'
        );

        // add foreign key for table `article`
        $this->addForeignKey(
            'fk-article_user-article_id',
            'article_user',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-article_user-user_id',
            'article_user',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-article_user-user_id',
            'article_user',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `article`
        $this->dropForeignKey(
            'fk-article_user-article_id',
            'article_user'
        );

        // drops index for column `article_id`
        $this->dropIndex(
            'idx-article_user-article_id',
            'article_user'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-article_user-user_id',
            'article_user'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-article_user-user_id',
            'article_user'
        );

        $this->dropTable('article_user');
    }
}
