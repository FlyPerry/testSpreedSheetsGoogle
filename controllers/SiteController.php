<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
     * @return string
     */
    public function actionIndex()
    {
        $tokenPath = Yii::getAlias('@app/token.json');
        $auth = !file_exists($tokenPath);
        return $this->render('index',['auth'=>$auth]);
    }

    public function actionAuthGoogle(): Response
    {
        // Получаем экземпляр компонента GoogleSheets
        $googleSheets = Yii::$app->googleSheets;

        // Генерируем URL для авторизации
        $authUrl = $googleSheets->getAuthUrl();

        // Перенаправляем пользователя на страницу авторизации Google
        return $this->redirect($authUrl);
    }

    // Действие для обработки callback от Google
    public function actionCallbackGoogle()
    {

        // Получаем код авторизации из GET параметров
        $authCode = Yii::$app->request->get('code');

        return $this->render('confirmAuth',['authCode'=>$authCode]);

    }
    public function actionAuth($authCode): string
    {
        $googleSheets = Yii::$app->googleSheets;
        $googleSheets->authenticateWithCode($authCode);
        return $this->render('callback-success');
    }

}
