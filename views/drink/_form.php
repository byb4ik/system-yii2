<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Drink */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="drink-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'drink')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'group')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
