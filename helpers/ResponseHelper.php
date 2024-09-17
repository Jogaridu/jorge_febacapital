<?php

namespace app\helpers;

use Yii;

class ResponseHelper {
    public static function success($data, $message = 'Dados recuperados com sucesso', $statusCode = 200) {

        Yii::$app->response->statusCode = $statusCode;

        return [
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ];
    }

    public static function error($message, $statusCode = 404) {

        Yii::$app->response->statusCode = $statusCode;

        return [
            'status' => 'error',
            'message' => $message,
        ];
    }
}
