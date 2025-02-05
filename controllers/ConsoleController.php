<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;

class ConsoleController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionExecute()
    {
        $command = Yii::$app->request->post('command');
        if ($command) {
            // Здесь мы выполняем команду, которую ввел пользователь
            $output = shell_exec($command);
            return $this->render('index', [
                'output' => Html::encode($output),
                'command' => $command,
            ]);
        }
        return $this->render('index');
    }
}
