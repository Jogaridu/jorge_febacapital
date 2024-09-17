<?php
namespace app\commands;

use app\models\Usuario;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class UserController extends Controller {

    public function actionCreate($login, $password, $name) {
        $user = new Usuario();
        $user->login = $login;
        $user->password = Yii::$app->security->generatePasswordHash($password);
        $user->name = $name;

        if (!$user->save()) {
            echo "Falha ao criar o usuário.\n";
            return ExitCode::IOERR;
        }

        echo "Usuário criado com sucesso.\n";
        return ExitCode::OK;

    }
}