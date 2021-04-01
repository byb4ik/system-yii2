<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Esp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="esp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'valve_1')->textInput() ?>

    <?= $form->field($model, 'valve_2')->textInput() ?>

    <?= $form->field($model, 'liter_base')->textInput() ?>

    <?= $form->field($model, 'liter_balance')->textInput() ?>

    <?= $form->field($model, 'liter_all_time')->textInput() ?>

    <?= $form->field($model, 'liter_from_esp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
