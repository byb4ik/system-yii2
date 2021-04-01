<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php
echo('<h2>' . $model->getAttributes()['res'] . '</h2>');
?>
<div class="container">
    <div class="row">
        <div class="col">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

            <?= $form->field($model, 'file')->fileInput() ?>

            <button>Загрузить</button>

            <?php ActiveForm::end() ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col">
            <?php echo Html::a('Импорт', ['esp/import'], ['class' => 'btn btn-success']); ?>
        </div>
    </div>
</div>


