<?php

namespace frontend\controllers;

use common\models\TempNumber;
use common\models\User;
use frontend\models\api\TelegramBot;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\ForbiddenHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'index'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'error'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/landing']);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     * @throws \Exception
     */
    public function actionLogin()
    {

        $this->layout = "login";
        $model = new TempNumber(['scenario' => TempNumber::SCENARIO_PHONE]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $phone = clearPhone($model->phone);
            TempNumber::deleteAll(['phone' => $model->phone]);
            $model->generateCode();
            $model->save();
            return $this->redirect(['site/verify-code', 'phone' => $model->phone]);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    /**
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionVerifyCode($phone)
    {
        $this->layout = "login";
        $verifyModel = TempNumber::findOne(['phone' => $phone]);

        if (!$verifyModel) {
            notFound();
        }

        $verifyModel->scenario = TempNumber::SCENARIO_VERIFY_CODE;

        if ($verifyModel->load(Yii::$app->request->post()) && $verifyModel->validate()) {

            $clearedPhone = clearPhone($verifyModel->phone);

            if (!$verifyModel->verifyCode()) {
                $verifyModel->addError('code', t('Code error'));
                return $this->render('verifycode', [
                    'model' => $verifyModel
                ]);
            }

            if ($verifyModel->isExpired()) {
                $verifyModel->addError('code', t('Code expired'));
                return $this->render('verifycode', [
                    'model' => $verifyModel
                ]);
            }

            if ($verifyModel->verifyCode()) {
                $user = User::findOne(['type' => User::TYPE_USER, 'username' => $clearedPhone]);
                if (!$user) {
                    $user = new User();
                    $user->username = $clearedPhone;
                    $user->email = $clearedPhone;
                    $user->setPassword(Yii::$app->security->generateRandomString(8));
                    $user->generateAuthKey();
                    $user->status = User::STATUS_ACTIVE;
                    $user->type = User::TYPE_USER;
//                    $user->generateEmailVerificationToken();
                    $user->save();
                    Yii::$app->user->login($user);
                }
                Yii::$app->user->login($user);
                $verifyModel->delete();
                return $this->redirect(['site/index']);
            }

            return $this->render('verifycode', [
                'model' => $verifyModel
            ]);
        }

        return $this->render('verifycode', [
            'model' => $verifyModel
        ]);

    }

    public function actionLanding()
    {
        $this->layout = 'blog';
        return $this->render('landing');
    }

    public function actionLoginViaSeller($password, $bot_id)
    {

        $encryption = $password;
        // Non-NULL Initialization Vector for decryption
        $decryption_iv = '1234567891011121';
        $ciphering = "AES-128-CTR";
        $options = 0;
        $decryption_key = "botyasa";

        $decryption = openssl_decrypt($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

        if ($decryption == "Isxoqjon Axmedov") {
            $user = User::findOne(TelegramBot::findOne($bot_id)->user_id);
            Yii::$app->user->login($user, 3600);
            $this->redirect(['site/index']);
        } else {
            throw new ForbiddenHttpException(t('You Cannot to do this!'));
        }
    }
}
