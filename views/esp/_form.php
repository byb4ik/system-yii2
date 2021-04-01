<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Esp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="esp-form">

    <?php $form = ActiveForm::begin(); ?>
<?php
    if (Yii::$app->user->identity != null) {
    if (Yii::$app->user->id != 1) {
?>

    <?= $form->field($model, 'user_id')->dropDownList($model->getAllUsers(), ['disabled' => true]) ?>

    <?= $form->field($model, 'valve')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'liter_base')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'liter_balance')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'liter_all_time')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'liter_from_esp')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'customer')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'customer_name')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['readonly' => true]) ?>
    
	<?= $form->field($model, 'drink_name')->textInput(['readonly' => true]) ?>

	<? //= $form->field($model, 'esp_date_import')->textInput() ?>

	<? //= $form->field($model, 'esp_last_date')->textInput() ?>

	<?= $form->field($model, 'price_buy')->textInput() ?>

	<?= $form->field($model, 'price_sale')->textInput() ?>

	<?= $form->field($model, 'mail_percent')->textInput() ?>

	<?= $form->field($model, 'avrg_day')->textInput() ?>

	<?= $form->field($model, 'hour_to_exp')->textInput() ?>
<?php
    } else {

?>
     <?= $form->field($model, 'user_id')->dropDownList($model->getAllUsers()) ?>

     <?= $form->field($model, 'market_point')->dropDownList($model->getAllPoints()) ?>

    <?= $form->field($model, 'valve')->textInput() ?>

    <?= $form->field($model, 'liter_base')->textInput() ?>

    <?= $form->field($model, 'liter_balance')->textInput() ?>

    <?= $form->field($model, 'liter_all_time')->textInput() ?>

    <?= $form->field($model, 'liter_from_esp')->textInput() ?>

    <?= $form->field($model, 'customer')->textInput() ?>

    <?= $form->field($model, 'customer_name')->textInput() ?>

    <?= $form->field($model, 'address')->textInput() ?>

    <?= $form->field($model, 'drink_name')->textInput() ?>

    <?//= $form->field($model, 'esp_date_import')->textInput() ?>

    <?//= $form->field($model, 'esp_last_date')->textInput() ?>

    <?= $form->field($model, 'price_buy')->textInput() ?>

    <?= $form->field($model, 'price_sale')->textInput() ?>

    <?= $form->field($model, 'mail_percent')->textInput() ?>

    <?= $form->field($model, 'avrg_day')->textInput() ?>

    <?= $form->field($model, 'hour_to_exp')->textInput() ?>
    <?php
    }
    }
?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
