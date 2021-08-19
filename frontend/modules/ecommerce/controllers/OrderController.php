<?php

namespace frontend\modules\ecommerce\controllers;

use Yii;
use frontend\modules\ecommerce\models\Order;
use frontend\modules\ecommerce\models\search\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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


    public function actionChangeStatus()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $order_id = Yii::$app->request->post('order_id');
        $status_id = Yii::$app->request->post('status');

        $order = $this->findModel($order_id);
        $order->status = $status_id;
        if ($order->save()) {

            telegram_core([
                'token' => Yii::$app->controller->module->bot->token,
            ])->sendMessage([
                'chat_id' => $order->user->user_id,
                'text' => t('Your {number} status is', [
                        'number' => $order->id
                    ]) . $order->getOrderStatus()
            ]);

            return [
                'success' => true
            ];
        } else {
            return [
                'success' => true
            ];
        }


    }

    public function actionChangePaymentStatus()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $order_id = Yii::$app->request->post('order_id');
        $status_id = Yii::$app->request->post('status');

        $order = $this->findModel($order_id);
        $order->payment_status = $status_id;
        if ($order->save()) {

            telegram_core([
                'token' => Yii::$app->controller->module->bot->token,
            ])->sendMessage([
                'chat_id' => $order->user->user_id,
                'text' => t('Your {number} payment status is', [
                        'number' => $order->id
                    ]) . $order->getOrderPaymentStatus()
            ]);

            return [
                'success' => true
            ];
        } else {
            return [
                'success' => false
            ];
        }


    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
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
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'bot_id' => Yii::$app->controller->module->bot->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'bot_id' => Yii::$app->controller->module->bot->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'bot_id' => Yii::$app->controller->module->bot->id]);

    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
