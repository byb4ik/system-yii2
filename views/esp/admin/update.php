<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Esp */

$this->title = 'Редактировать: ' . $model->address;
$this->params['breadcrumbs'][] = ['label' => 'Esps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="esp-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
