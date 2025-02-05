<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $auth bool */

$this->title = 'Google API Authentication';
?>

<div class="site-index">
    <h1>Google SpreedSheets Parse Welcome!</h1>

    <p>
        <?= $auth
            ? Html::a('Login with Google', ['site/auth-google'], ['class' => 'btn btn-primary'])
            :  Html::a('Перейти к эмулятору консоли',Url::to('console'),['class'=>'btn btn-success'])
        ?>
    </p>
</div>
