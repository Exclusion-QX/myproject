<?php

use yii\db\Migration;

/**
 * Class m200828_094622_alter_table_user_drop_index_unique_on_username
 */
class m200828_094622_alter_table_user_drop_index_unique_on_username extends Migration
{

    public function safeUp()
    {
        $this->dropIndex('Username', 'user');
    }

    public function safeDown()
    {
        $this->createIndex('username', 'user', 'username', $unique = true);
    }

}
