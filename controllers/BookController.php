<?php

namespace app\controllers;

use app\helpers\ResponseHelper;
use app\models\Book;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * BookController implements the CRUD actions for book model.
 */
class BookController extends BaseController {

    public $modelClass = 'app\models\Cliente';

    /**
     * Lists all book models.
     *
     * @return string
     */
    public function actionIndex() {

        $query = Book::find();

        $isbn = Yii::$app->request->get('isbn');
        $title = Yii::$app->request->get('title');
        $author = Yii::$app->request->get('author');

        if ($isbn) {
            $query->andWhere(['like', 'isbn', $isbn]);
        }

        if ($title) {
            $query->andWhere(['like', 'title', $title]);
        }

        if ($author) {
            $query->andWhere(['like', 'author', $author]);
        }

        $sort = Yii::$app->request->get('sort', 'id');
        $order = Yii::$app->request->get('order', 'desc');

        $sortPermitted = ['title', 'price'];
        if (!in_array($sort, $sortPermitted)) {
            return ResponseHelper::error('Só é permitido ordernar por: Título ou Preço');
        }

        $query->orderBy([$sort => ($order === 'asc' ? SORT_ASC : SORT_DESC)]);

        $limit = Yii::$app->request->get('limit', 10);
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
     * Creates a new book model.
     * @return string|\yii\web\Response
     */
    public function actionCreate() {

        $model = new Book();

        if (!$this->request->isPost) {
            return ResponseHelper::error('Método inválido');
        }

        $body = $this->request->post();

        $model->isbn = $body['isbn'] ?? '';
        // $model->image = UploadedFile::getInstance($model, 'image');
        $model->title = $body['title'] ?? '';
        $model->author = $body['author'] ?? '';
        $model->price = $body['price'] ?? '';
        $model->quantity = $body['quantity'] ?? '';

        if (!$model->validate() || !$model->save()) {
            return ResponseHelper::error($model->getErrors(), 400);
        }

        return ResponseHelper::success($model, 'Livro cadastrado com sucesso', 201);
    }

}
