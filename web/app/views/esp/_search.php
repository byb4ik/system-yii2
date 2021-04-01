<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EspSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="esp-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'valve_1') ?>

    <?= $form->field($model, 'valve_2') ?>

    <?= $form->field($model, 'liter_base') ?>

    <?php // echo $form->field($model, 'liter_balance') ?>

    <?php // echo $form->field($model, 'liter_all_time') ?>

    <?php // echo $form->field($model, 'liter_from_esp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
