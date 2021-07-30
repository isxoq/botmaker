<?php

namespace frontend\modules\ecommerce\controllers;

use frontend\modules\ecommerce\models\Product;
use Yii;
use frontend\modules\ecommerce\models\ProductVariant;
use frontend\modules\ecommerce\models\search\ProductVariantSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductVariantController implements the CRUD actions for ProductVariant model.
 */
class ProductVariantController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProductVariant models.
     * @return mixed
     */
    public function actionIndex($product_id)
    {
        $searchModel = new ProductVariantSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductVariant model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductVariant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($product_id)
    {
        $model = new ProductVariant();

        $product = Product::findOne(Yii::$app->request->get('product_id'));
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->product_id = $product->id;
            if (!$model->save()) {
                dd($model->errors);
            }

            return $this->redirect(['index', 'bot_id' => Yii::$app->controller->module->bot->id, 'product_id' => Yii::$app->request->get('product_id')]);

        }

        return $this->render('create', [
            'model' => $model,
            'product' => $product
        ]);
    }

    /**
     * Updates an existing ProductVariant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($product_id, $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'bot_id' => Yii::$app->controller->module->bot->id, 'product_id' => Yii::$app->request->get('product_id')]);

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductVariant model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'bot_id' => Yii::$app->controller->module->bot->id, 'product_id' => Yii::$app->request->get('product_id')]);
    }

    /**
     * Finds the ProductVariant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductVariant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductVariant::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
