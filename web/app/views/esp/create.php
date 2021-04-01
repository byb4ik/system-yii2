<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Esp */

$this->title = 'Create Esp';
$this->params['breadcrumbs'][] = ['label' => 'Esps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="esp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
