<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $code array|mixed */
/* @var $authCode array|mixed */
?>

<?= Html::a('Войти в ВЭБ версии', ['site/auth', 'authCode' => $authCode], [
    'class' => 'btn btn-primary',
    'role' => 'button'
]) ?>
<?= Html::button('Копировать код авторизации', [
    'class' => 'btn btn-info',
    'id' => 'copyTextButton',
    'data-clipboard-text' => $authCode
]) ?>

<!-- Подключаем библиотеку Clipboard.js для копирования в буфер -->
<?php
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJs(new \yii\web\JsExpression("
    var clipboard = new ClipboardJS('#copyTextButton');
    clipboard.on('success', function(e) {
        alert('Код авторизации скопирован в буфер обмена!');
    });
"));
?>
