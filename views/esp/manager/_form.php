<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Esp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="esp-form">

    <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'user_id')->dropDownList($model->getAllUsers()) ?>

            <?= $form->field($model, 'market_point')->dropDownList($model->getAllPoints()) ?>

            <?= $form->field($model, 'manager_id')->dropDownList($model->getAllManagers()) ?>

            <?= $form->field($model, 'valve')->textInput() ?>

            <?= $form->field($model, 'liter_base')->textInput() ?>

            <?= $form->field($model, 'liter_balance')->textInput() ?>

            <?= $form->field($model, 'liter_all_time')->textInput() ?>

            <?= $form->field($model, 'liter_from_esp')->textInput() ?>

            <?= $form->field($model, 'customer')->textInput() ?>

            <?= $form->field($model, 'customer_name')->textInput() ?>

            <?= $form->field($model, 'address')->textInput() ?>

            <?= $form->field($model, 'drink_name')->textInput() ?>

            <?= $form->field($model, 'price_buy')->textInput() ?>

            <?= $form->field($model, 'price_sale')->textInput() ?>

            <?= $form->field($model, 'mail_percent')->textInput() ?>

            <?= $form->field($model, 'avrg_day')->textInput() ?>

            <?= $form->field($model, 'hour_to_exp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
