<?php

use yii\db\Migration;

/**
 * Class m240916_004356_usuarios
 */
class m240916_004356_usuarios extends Migration {
    public function safeUp() {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'login' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'refresh_token' => $this->string(255),
        ]);
    }

    public function safeDown() {
        $this->dropTable('{{%user}}');
    }
}
