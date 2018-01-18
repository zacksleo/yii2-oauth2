<?php

use yii\db\Migration;

/**
 * Handles adding one_token_per_user to table `oauth_clients`.
 */
class m170615_020437_add_one_token_per_user_column_to_oauth_clients_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%oauth_clients}}', 'one_token_per_user', $this->boolean()->notNull()->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%oauth_clients}}', 'one_token_per_user');
    }
}
