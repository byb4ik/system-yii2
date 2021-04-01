
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\Login */
$this->title = 'Регистрация нового пользователя';

?>
<div class="container">

    <?php
    $form = ActiveForm::begin(['class' => 'form-horizontal']);
    ?>
    <h1>Авторизация</h1>
    <?php echo $form->field($login_model, 'mail')->textInput()->label('Ваш email/телефон'); ?>

    <?php echo $form->field($login_model, 'password')->passwordInput()->label('Пароль'); ?>

    <div>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </div>

    <?php
    ActiveForm::end();
    ?>
asd2
</div>