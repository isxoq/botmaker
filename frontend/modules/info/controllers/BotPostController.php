<?php

namespace frontend\modules\info\controllers;

use frontend\modules\info\models\BotUser;
use Yii;
use frontend\modules\info\models\BotPost;
use frontend\modules\info\models\BotPostSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BotPostController implements the CRUD actions for BotPost model.
 */
class BotPostController extends Controller
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
     * Lists all BotPost models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BotPostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BotPost model.
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
     * Creates a new BotPost model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BotPost();

        if ($model->load(Yii::$app->request->post())) {
            $model->bot_id = Yii::$app->controller->module->bot->id;
            if ($model->save()) {
                return $this->redirect(['index', 'bot_id' => Yii::$app->controller->module->bot->id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BotPost model.
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
     * Deletes an existing BotPost model.
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
     * Finds the BotPost model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BotPost the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BotPost::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionSendPost($id)
    {
        $post = BotPost::findOne($id);
        $users = BotUser::find()->all();
//        dd($users);

        if ($post->image) {
            foreach ($users as $user) {
                Yii::$app->async->run(function () use ($user, $post) {
                    telegram_core(['token' => Yii::$app->controller->module->bot->token])->sendPhoto([
                        'chat_id' => $user->user_id,
                        'caption' => $post->caption,
                        'photo' => Url::to([$post->image], true),
                        'parse_mode' => "html"
                    ]);
                });
            }
            return 1;
        }
        foreach ($users as $user) {
            Yii::$app->async->run(function () use ($user, $post) {
                telegram_core(['token' => Yii::$app->controller->module->bot->token])->sendMessage([
                    'chat_id' => $user->user_id,
                    'parse_mode' => "html",
                    'text' => $post->caption
                ]);
            });
        }
    }
}
