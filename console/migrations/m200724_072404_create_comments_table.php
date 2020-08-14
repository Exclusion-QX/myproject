<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m200724_072404_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('comments', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'post_id' => $this->integer(),
            'comment' => $this->text(),
            'author_comment' => $this->string(),
            'author_picture' => $this->string(),
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('comments');
    }
}
