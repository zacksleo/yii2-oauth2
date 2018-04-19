<?php

use yii\db\Schema;

class m160501_075311_add_oauth2_server extends \yii\db\Migration
{
    public function mysql($yes, $no = '')
    {
        return $this->db->driverName === 'mysql' ? $yes : $no;
    }

    public function primaryKey($columns = '')
    {
        return 'PRIMARY KEY (' . $this->db->getQueryBuilder()->buildColumns($columns) . ')';
    }

    public function foreignKey($columns, $refTable, $refColumns, $onDelete = null, $onUpdate = null)
    {
        $builder = $this->db->getQueryBuilder();
        $sql = ' FOREIGN KEY (' . $builder->buildColumns($columns) . ')'
            . ' REFERENCES ' . $this->db->quoteTableName($refTable)
            . ' (' . $builder->buildColumns($refColumns) . ')';
        if ($onDelete !== null) {
            $sql .= ' ON DELETE ' . $onDelete;
        }
        if ($onUpdate !== null) {
            $sql .= ' ON UPDATE ' . $onUpdate;
        }
        return $sql;
    }

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $now = $this->mysql('CURRENT_TIMESTAMP', "'now'");
        $on_update_now = $this->mysql("ON UPDATE $now");

        $transaction = $this->db->beginTransaction();
        try {
            $this->createTable('{{%oauth_clients}}', [
                'client_name' => Schema::TYPE_STRING . '(36) NOT NULL COMMENT "客户端名称"',
                'client_icon' => $this->string()->comment('图标'),
                'client_id' => Schema::TYPE_STRING . '(36) NOT NULL COMMENT "客户端ID"',
                'client_secret' => Schema::TYPE_STRING . '(32) DEFAULT NULL COMMENT "客户端密钥"',
                'redirect_uri' => Schema::TYPE_STRING . '(1000) NOT NULL DEFAULT "" COMMENT "回跳地址"',
                'grant_types' => Schema::TYPE_STRING . '(100) NOT NULL COMMENT "授权类型"',
                'scope' => Schema::TYPE_STRING . '(2000) DEFAULT NULL COMMENT "权限范围"',
                'user_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL COMMENT "用户"',
                $this->primaryKey('client_id'),
            ], $tableOptions);

            $this->createTable('{{%oauth_access_tokens}}', [
                'access_token' => Schema::TYPE_STRING . '(40) NOT NULL COMMENT "访问令牌"',
                'client_id' => Schema::TYPE_STRING . '(36) NOT NULL COMMENT "客户端ID"',
                'user_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL COMMENT "用户"',
                'expires' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT $now $on_update_now COMMENT '期限'",
                'scope' => Schema::TYPE_STRING . '(2000) DEFAULT NULL COMMENT "权限范围"',
                $this->primaryKey('access_token'),
                $this->foreignKey('client_id', '{{%oauth_clients}}', 'client_id', 'CASCADE', 'CASCADE'),
            ], $tableOptions);

            $this->createTable('{{%oauth_refresh_tokens}}', [
                'refresh_token' => Schema::TYPE_STRING . '(40) NOT NULL COMMENT "刷新令牌"',
                'client_id' => Schema::TYPE_STRING . '(36) NOT NULL COMMENT "客户端ID"',
                'user_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL COMMENT "用户"',
                'expires' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT $now $on_update_now COMMENT '期限'",
                'scope' => Schema::TYPE_STRING . '(2000) DEFAULT NULL COMMENT "权限范围"',
                $this->primaryKey('refresh_token'),
                $this->foreignKey('client_id', '{{%oauth_clients}}', 'client_id', 'CASCADE', 'CASCADE'),
            ], $tableOptions);

            $this->createTable('{{%oauth_authorization_codes}}', [
                'authorization_code' => Schema::TYPE_STRING . '(40) NOT NULL COMMENT "授权码"',
                'client_id' => Schema::TYPE_STRING . '(36) NOT NULL COMMENT "客户端ID"',
                'user_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL COMMENT "用户"',
                'redirect_uri' => Schema::TYPE_STRING . '(1000) NOT NULL COMMENT "回跳地址"',
                'expires' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT $now $on_update_now COMMENT '期限'",
                'scope' => Schema::TYPE_STRING . '(2000) DEFAULT NULL COMMENT "权限范围"',
                $this->primaryKey('authorization_code'),
                $this->foreignKey('client_id', '{{%oauth_clients}}', 'client_id', 'CASCADE', 'CASCADE'),
            ], $tableOptions);

            $this->createTable('{{%oauth_scopes}}', [
                'scope' => Schema::TYPE_STRING . '(2000) NOT NULL COMMENT "权限范围"',
                'is_default' => Schema::TYPE_BOOLEAN . ' NOT NULL COMMENT "默认"',
            ], $tableOptions);

            $this->createTable('{{%oauth_jwt}}', [
                'client_id' => Schema::TYPE_STRING . '(36) NOT NULL COMMENT "客户端ID"',
                'subject' => Schema::TYPE_STRING . '(80) DEFAULT NULL COMMENT "接收者"',
                'public_key' => Schema::TYPE_STRING . '(2000) DEFAULT NULL COMMENT "公钥"',
                $this->primaryKey('client_id'),
            ], $tableOptions);

            $this->createTable('{{%oauth_public_keys}}', [
                'client_id' => Schema::TYPE_STRING . '(255) NOT NULL COMMENT "客户端ID"',
                'public_key' => Schema::TYPE_STRING . '(2000) DEFAULT NULL COMMENT "公钥"',
                'private_key' => Schema::TYPE_STRING . '(2000) DEFAULT NULL COMMENT "私钥"',
                'encryption_algorithm' => Schema::TYPE_STRING . '(100) DEFAULT \'RS256\' COMMENT "加密算法"',
            ], $tableOptions);

            $transaction->commit();
        } catch (Exception $e) {
            echo 'Exception: ' . $e->getMessage() . '\n';
            $transaction->rollback();

            return false;
        }

        return true;
    }

    public function down()
    {
        $transaction = $this->db->beginTransaction();
        try {
            $this->dropTable('{{%oauth_jwt}}');
            $this->dropTable('{{%oauth_scopes}}');
            $this->dropTable('{{%oauth_authorization_codes}}');
            $this->dropTable('{{%oauth_refresh_tokens}}');
            $this->dropTable('{{%oauth_access_tokens}}');
            $this->dropTable('{{%oauth_public_keys}}');
            $this->dropTable('{{%oauth_clients}}');

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            echo $e->getMessage();
            echo "\n";
            echo get_called_class() . ' cannot be reverted.';
            echo "\n";

            return false;
        }

        return true;
    }
}
