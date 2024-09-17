<?php

namespace app\controllers;

use app\helpers\ResponseHelper;
use app\models\Cliente;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

/**
 * ClienteController implements the CRUD actions for cliente model.
 */
class ClienteController extends BaseController {

    public $modelClass = 'app\models\Cliente';

    /**
     * Lists all cliente models.
     *
     * @return string
     */
    public function actionIndex() {

        $query = Cliente::find();

        $name = Yii::$app->request->get('name');
        $cpf = Yii::$app->request->get('cpf');

        if ($name) {
            $query->andWhere(['like', 'name', $name]);
        }

        if ($cpf) {
            $query->andWhere(['like', 'cpf', $cpf]);
        }

        $sort = Yii::$app->request->get('sort', 'name');
        $order = Yii::$app->request->get('order', 'asc');

        $sortPermitted = ['name', 'cpf', 'city'];
        if (!in_array($sort, $sortPermitted)) {
            return ResponseHelper::error('Só é permitido ordernar por: Nome, CPF ou Cidade');
        }

        $query->orderBy([$sort => ($order === 'asc' ? SORT_ASC : SORT_DESC)]);

        $limit = Yii::$app->request->get('limit', 2);
        $offset = Yii::$app->request->get('offset', 0);

        $query->limit($limit)->offset($offset);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);

        return ResponseHelper::success($dataProvider->getModels());
    }

    /**
     * Creates a new cliente model.
     * @return string|\yii\web\Response
     */
    public function actionCreate() {

        $model = new Cliente();

        if (!$this->request->isPost) {
            return ResponseHelper::error('Método inválido');
        }

        $body = $this->request->post();

        $model->name = $body['name'] ?? '';
        $model->image = UploadedFile::getInstance($model, 'image');
        $model->cpf = $body['cpf'] ?? '';
        $model->postal_code = $body['postal_code'] ?? '';
        $model->address = $body['address'] ?? '';
        $model->number = $body['number'] ?? '';
        $model->city = $body['city'] ?? '';
        $model->state = $body['state'] ?? '';
        $model->complement = $body['complement'] ?? '';
        $model->gender = $body['gender'] ?? '';
        $model->created_at = date('Y-m-d h:i:s');
        $model->updated_at = date('Y-m-d h:i:s');

        if (!$model->validate() || !$model->save()) {
            return ResponseHelper::error($model->getErrors(), 400);
        }

        return ResponseHelper::success($model, 'Cliente cadastrado com sucesso', 201);
    }

}
