<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Manager */

$this->title = 'Добавить торгового представителя';
$this->params['breadcrumbs'][] = ['label' => 'Торговый представитель', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manager-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
