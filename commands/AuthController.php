<?php
namespace app\commands;

use app\models\Usuario;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class AuthController extends Controller {
    public function actionLogin($login, $password) {

        $user = Usuario::findOne(['login' => $login]);

        if (!($user && Yii::$app->security->validatePassword($password, $user->password))) {
            echo "Usuário ou senha incorreto.\n";
            return ExitCode::IOERR;
        }

        $token = $this->generateJwt($user);
        $refreshToken = Yii::$app->security->generateRandomString();

        $user->refresh_token = $refreshToken;
        $user->save();

        echo "\nToken: \n\n{$token}\n\n Refresh token: \n\n{$refreshToken}\n\n";
        return ExitCode::OK;
    }

    public function actionRefresh($refreshToken) {

        $user = Usuario::findOne(['refresh_token' => $refreshToken]);

        if (!$user) {
            echo "Refresh token inválido.\n";
            return ExitCode::IOERR;
        }

        $token = $this->generateJwt($user);
        $newRefreshToken = Yii::$app->security->generateRandomString();

        $user->refresh_token = $newRefreshToken;
        $user->save();

        echo "\nToken RENOVADO: \n\n{$token}\n\n Refresh token: \n\n{$newRefreshToken}\n\n";
        return ExitCode::OK;
    }

    private function generateJwt(\app\models\Usuario $user) {

        $jwt = Yii::$app->jwt;
        $signer = new $jwt->supportedAlgs['HS256']();
        $key = $jwt->key;

        $time = time();

        $jwtParams = Yii::$app->params['jwt'];

        return $jwt->getBuilder()
            ->setIssuedAt($time)
            ->setExpiration($time + $jwtParams['expire'])
            ->set('uid', (string) $user->id)
            ->sign($signer, $key)
            ->getToken();

    }
}