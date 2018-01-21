<?php

use yii\db\Migration;

/**
 * 用户与App注册关联表
 * Handles the creation of table `user_oauth_clients`.
 */
class m171124_062746_create_oauth_clients_signup_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%oauth_clients_signup_user}}', [
            'user_id' => $this->primaryKey(),
            'client_id' => $this->string(36)->comment('客户端'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%oauth_clients_signup_user}}');
    }
}
