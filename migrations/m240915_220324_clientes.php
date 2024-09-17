<?php

use yii\db\Migration;

/**
 * Class m240915_220324_clientes
 */
class m240915_220324_clientes extends Migration {
    public function safeUp() {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'cpf' => $this->string(11)->notNull()->unique(),
            'postal_code' => $this->string(8)->notNull(),
            'address' => $this->string(255)->notNull(),
            'number' => $this->string(10)->notNull(),
            'city' => $this->string(100)->notNull(),
            'state' => $this->string(2)->notNull(),
            'complement' => $this->string(255),
            'gender' => "ENUM('M', 'F') NOT NULL",
            'image' => $this->string(255),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-client-name',
            '{{%client}}',
            'name',
        );

        $this->createIndex(
            'idx-client-city',
            '{{%client}}',
            'city',
        );

        $this->createIndex(
            'idx-client-cpf',
            '{{%client}}',
            'cpf',
            true
        );
    }

    public function safeDown() {
        $this->dropTable('{{%client}}');
    }
}
