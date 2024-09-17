<?php
namespace app\helpers;

use Exception;

class Validate {

    public static function validateCpf($cpf) {

        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    public static function validatePostalCode($postal_code) {

        $url = "https://viacep.com.br/ws/{$postal_code}/json/";

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if (isset($data['erro'])) {
            throw new Exception('CEP não encontrado.');
        }

        return $data;
    }

    public static function validateIsbn($isbn) {

        $url = "https://brasilapi.com.br/api/isbn/v1/{$isbn}";

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if (isset($data['erro'])) {
            throw new Exception('ISBN não encontrado');
        }

        return $data;
    }

}