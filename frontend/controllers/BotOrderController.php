<?php

namespace frontend\controllers;

use Yii;
use frontend\models\BotOrder;
use frontend\models\BotOrderSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * BotOrderController implements the CRUD actions for BotOrder model.
 */
class BotOrderController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['view', 'index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['view', 'index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Lists all BotOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BotOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BotOrder model.
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
     * Creates a new BotOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BotOrder();

        if ($model->load(Yii::$app->request->post())) {

            $model->user_id = Yii::$app->user->id;
            $model->created_at = time();
            $model->state = BotOrder::STATE_WAITING_PAYMENT;
            $model->amount = $this->getAmount($model->bot_id, $model->month);

            if ($model->save()) {
                return $this->redirect(['index']);
            } else {
                dd($model->errors);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function getAmount($bot_id, $month)
    {
        $monthlyPrice = 1000;
        return $month * $monthlyPrice;
    }

    /**
     * Updates an existing BotOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BotOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGetAmount()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $bot_id = Yii::$app->request->post('bot_id');
        $month = Yii::$app->request->post('month');
        $monthlyPrice = 1000;

        return [
            'total' => $month * $monthlyPrice
        ];
    }

    /**
     * Finds the BotOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BotOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BotOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
