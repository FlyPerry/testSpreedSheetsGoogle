<?php

/* @var $output string */
/* @var $this \yii\web\View */
/* @var $command array|mixed|object */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Эмулятор консоли';
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Форма для ввода команды -->
<?php $form = ActiveForm::begin([
    'action' => ['console/execute'],
    'method' => 'post',
]); ?>

<?= Html::input('text', 'command', '', ['class' => 'form-control', 'placeholder' => 'Введите команду']) ?>

    <div class="form-group">
        <?= Html::submitButton('Выполнить команду', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

<?php if (isset($output)): ?>
    <h3>Результат выполнения команды:</h3>
    <pre><?= $output ?></pre>
<?php endif; ?>