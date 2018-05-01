<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notice_type_user}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%notice_type}}`
 * - `{{%user}}`
 */
class m180420_150755_create_junction_table_for_notice_type_and_user_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notice_type_user}}', [
            'notice_type_id' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'is_readed' => $this->integer(6)->notNull()->defaultValue(0),
            'PRIMARY KEY(notice_type_id, user_id)',
        ]);

        // creates index for column `notice_type_id`
        $this->createIndex(
            '{{%idx-notice_type_user-notice_type_id}}',
            '{{%notice_type_user}}',
            'notice_type_id'
        );

        // add foreign key for table `{{%notice_type}}`
        $this->addForeignKey(
            '{{%fk-notice_type_user-notice_type_id}}',
            '{{%notice_type_user}}',
            'notice_type_id',
            '{{%notice_type}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-notice_type_user-user_id}}',
            '{{%notice_type_user}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-notice_type_user-user_id}}',
            '{{%notice_type_user}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%notice_type}}`
        $this->dropForeignKey(
            '{{%fk-notice_type_user-notice_type_id}}',
            '{{%notice_type_user}}'
        );

        // drops index for column `notice_type_id`
        $this->dropIndex(
            '{{%idx-notice_type_user-notice_type_id}}',
            '{{%notice_type_user}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-notice_type_user-user_id}}',
            '{{%notice_type_user}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-notice_type_user-user_id}}',
            '{{%notice_type_user}}'
        );

        $this->dropTable('{{%notice_type_user}}');
    }
}
