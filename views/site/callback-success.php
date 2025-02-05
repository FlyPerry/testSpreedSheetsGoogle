<?php
use yii\helpers\Url;
use \yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Google Authentication Successful';

?>

<h1>Авторизация прошла успено</h1>
<?=Html::a('Перейти к эмулятору консоли',Url::to('/console'),['class'=>'btn btn-success'])?>
