<?php

use yii\db\Migration;

/**
 * Class m240917_033751_livros
 */
class m240917_033751_livros extends Migration {
    public function safeUp() {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'isbn' => $this->string(100)->notNull()->unique(),
            'title' => $this->string(150)->notNull(),
            'author' => $this->string(150)->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            'quantity' => $this->smallInteger()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-book-title',
            '{{%book}}',
            'title'
        );

        $this->createIndex(
            'idx-book-author',
            '{{%book}}',
            'author'
        );

        $this->createIndex(
            'idx-book-isbn',
            '{{%book}}',
            'isbn',
            true
        );
    }

    public function safeDown() {
        $this->dropTable('{{%book}}');
    }
}
