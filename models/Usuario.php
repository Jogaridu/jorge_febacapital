<?php

namespace app\models;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $login
 * @property string $senha
 * @property string $nome
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['login', 'password', 'name'], 'required'],
            [['login', 'password', 'name'], 'string', 'max' => 255],
            [['login'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Senha',
            'name' => 'Nome',
        ];
    }
}
