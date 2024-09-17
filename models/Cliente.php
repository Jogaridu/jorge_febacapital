<?php

namespace app\models;

use Exception;

/**
 * This is the model class for table "cliente".
 *
 * @property int $id
 * @property string $name
 * @property string $cpf
 * @property string $postal_cep
 * @property string $address
 * @property string $number
 * @property string $city
 * @property string $state
 * @property string|null $complement
 * @property string $gender
 */
class Cliente extends \yii\db\ActiveRecord
{

    public static function tableName() {
        return 'client';
    }

    public function rules() {
        return [
            [['name', 'cpf', 'postal_code', 'number', 'gender'], 'required'],
            [['name', 'address', 'complement'], 'string', 'max' => 255],
            [['cpf', 'postal_code'], 'filter', 'filter' => function ($value) {
                return preg_replace('/[^0-9]/', '', $value);
            }],
            ['cpf', 'match', 'pattern' => '/^\d{11}$/', 'message' => 'CPF deve conter exatamente 11 dígitos.'],
            [['cpf'], 'unique'],
            [['cpf'], 'validateCpf'],
            ['postal_code', 'match', 'pattern' => '/^\d{8}$/', 'message' => 'CEP deve conter exatamente 8 dígitos.'],
            [['number'], 'string', 'max' => 10],
            [['city'], 'string', 'max' => 100],
            [['state'], 'string', 'max' => 2],
            ['gender', 'in', 'range' => ['M', 'F'], 'message' => 'Gênero deve ser "M" ou "F".'],
            [['gender'], 'string'],
            [['postal_code'], 'validatePostalCode'],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Nome',
            'cpf' => 'Cpf',
            'postal_code' => 'Cep',
            'address' => 'Logradouro',
            'number' => 'Numero',
            'city' => 'Cidade',
            'state' => 'Estado',
            'complement' => 'Complemento',
            'gender' => 'Sexo',
        ];
    }

    public function validateCpf($attribute) {
        if (!$this->hasErrors()) {
            if (!\app\helpers\Validate::validateCpf($this->$attribute)) {
                $this->addError($attribute, 'O CPF é inválido.');
            }
        }
    }

    public function validatePostalCode($attribute) {
        if (!$this->hasErrors()) {
            try {
                $address = \app\helpers\Validate::validatePostalCode($this->$attribute);

                if (empty($this->address)) {
                    $this->address = $address['logradouro'];
                }

                if (empty($this->city)) {
                    $this->city = $address['localidade'];
                }

                if (empty($this->state)) {
                    $this->state = $address['uf'];
                }

            } catch (Exception $e) {
                $this->addError($attribute, 'Erro ao buscar o endereço: ' . $e->getMessage());
            }
        }
    }

    public function uploadFile() {

    }

}