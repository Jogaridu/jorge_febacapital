<?php

namespace app\models;

use Exception;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $isbn
 * @property string $title
 * @property string $author
 * @property float $price
 * @property int $quantity
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['isbn', 'price', 'quantity'], 'required'],
            ['price', 'number', 'min' => 0],
            ['quantity', 'integer', 'min' => 0],
            [['isbn'], 'string', 'max' => 100],
            [['title', 'author'], 'string', 'max' => 150],
            [['isbn'], 'unique'],
            [['isbn'], 'validateIsbn'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'isbn' => 'ISBN',
            'title' => 'Título',
            'author' => 'Autor',
            'price' => 'Preço',
            'quantity' => 'Quantidade',
        ];
    }

    public function validateIsbn($attribute) {
        if (!$this->hasErrors()) {
            try {
                $book = \app\helpers\Validate::validateIsbn($this->$attribute);

                if (empty($this->title)) {
                    $this->title = $book['title'];
                }

                if (empty($this->author)) {
                    $this->author = implode(' - ', $book['authors']);
                }

            } catch (Exception $e) {
                $this->addError($attribute, 'Falha ao buscar livro.');
            }
        }
    }
}
