<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this \yii\web\View */
/* @var $message string */
$this->title = 'Ошибка авторизации';

?>

<div class="bg-gradient text-danger"> Попытка авторизации неудачна, проверьте настройки сервера и прочего (см. инструкцию)</div>
<?=Html::a('Вернутся на главную',Url::to('/'),['class'=>'btn btn-success'])?>
