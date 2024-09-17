<?php

namespace app\controllers;

use app\models\Usuario;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\rest\Controller;

class BaseController extends Controller {
    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            'except' => [
                'login',
                'refresh-token',
                'options',
            ],
            'auth' => function ($token) {

                $jwt = Yii::$app->jwt;
                $token = $jwt->getParser()->parse((string) $token);
                $signer = new \Lcobucci\JWT\Signer\Hmac\Sha256();

                if ($token->verify($signer, Yii::$app->jwt->key)) {
                    return Usuario::findOne(['id' => $token->getClaim('uid')]);
                }

                return null;
            },
        ];

        $behaviors[] = [
            'class' => TimestampBehavior::class,
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
            'value' => time(),
        ];

        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::class,
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }
}