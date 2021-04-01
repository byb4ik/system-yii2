<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DrinkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Напитки на главной странице';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="drink-index">

<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->

    <p>
        <?= Html::a('Добавить напиток', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'drink',
            'group',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
