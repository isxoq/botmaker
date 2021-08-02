<?php

namespace frontend\controllers;

use Yii;
use frontend\models\TelegramBot;
use frontend\models\search\TelegramBotSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TelegramBotController implements the CRUD actions for TelegramBot model.
 */
class TelegramBotController extends Controller
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
     * Lists all TelegramBot models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TelegramBotSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TelegramBot model.
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
     * Creates a new TelegramBot model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TelegramBot(['scenario' => TelegramBot::SCENARIO_CREATE]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {


            $bot = telegram_core([
                'token' => $model->token,
            ])->getMe();

            $model->name = $bot->result->first_name;
            $model->bot_username = $bot->result->username;
            $model->user_id = user()->id;
            $model->bot_id = strval($bot->result->id);
            $model->webhook = Url::to(['ecommerce-api/hook', 'bot_id' => $model->bot_id], true);
            if (!$model->save()) {
                dd($model->errors);
            }
            //+===================================
            $webhook = telegram_core([
                'token' => $model->token,
                'data' => [
                    'url' => $model->webhook
                ]
            ])->setWebhook();
            //+++++++++++++++++++++++++++++++++++++++++++


            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TelegramBot model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = TelegramBot::SCENARIO_UPDATE;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $bot = telegram_core([
                'token' => $model->token,
                'url' => $model->webhook
            ])->getMe();

            $model->name = $bot->result->first_name;
            $model->bot_username = $bot->result->username;
            $model->bot_id = strval($bot->result->id);
            $model->webhook = Url::to(['ecommerce-api/hook', 'bot_id' => $model->bot_id], true);

            if (!$model->save()) {
                dd($model->errors);
            }


            telegram_core([
                'token' => $model->token,
                'data' => [
                    'url' => $model->webhook
                ]
            ])->setWebhook();

            return $this->redirect(['index']);

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TelegramBot model.
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

    /**
     * Webhook sozlash
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSetWebhook($id)
    {
        $model = $this->findModel($id);
        $model->scenario = TelegramBot::SCENARIO_SETWEBHOOK;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $webhook = telegram_core([
                'token' => $model->token,
                'data' => [
                    'url' => $model->webhook
                ]
            ])->setWebhook();

            if (!$webhook->ok) {
                $model->addError('webhook', $webhook->description);
                return $this->render('_setWebhook', [
                    'model' => $model,
                ]);
            } else {
                $model->save();
                dd($webhook);
//                return $this->redirect(['index']);

            }

        }

        return $this->render('_setWebhook', [
            'model' => $model
        ]);
    }


    /**
     * Finds the TelegramBot model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TelegramBot the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TelegramBot::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionGetMe()
    {
        $this->enableCsrfValidation = false;
        $token = Yii::$app->request->post('token');
        Yii::$app->response->format = Response::FORMAT_JSON;

        return telegram_core([
            'token' => $token,
        ])->getMe();

    }
}
