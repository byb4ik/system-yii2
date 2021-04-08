<?php

use yii\helpers\Html;
use app\models\Esp;
use yii\widgets\Pjax;
use kartik\editable\Editable;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EspSearch */
/* @var $model app\models\Esp */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Esp';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="esp-index">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="table-responsive">
        <?php
        // Pjax::begin();
        $gridColumns = [
            'id',
            ['attribute' => 'roleName', 'label' => 'Торговая точка', 'value' => 'market.name_surname'],
            ['attribute' => 'roleName', 'label' => 'Торг. пр-ль', 'value' => 'manager.name_surname'],
            ['attribute' => 'roleName', 'label' => 'Клиент', 'value' => 'user.name_surname'],
            [
                'attribute' => 'address',
                'filter' => Html::activeDropDownList($searchModel, 'address', $model->getUniqAddress(Yii::$app->user->id), ['class' => 'form-control', 'prompt' => 'Фильтр']),
            ],
            [
                'attribute' => 'drink_name',
                'filter' => Html::activeDropDownList($searchModel, 'drink_name', $model->getUniqDrink(Yii::$app->user->id), ['class' => 'form-control', 'prompt' => 'Фильтр']),
            ],
            'liter_base',
            //'esp_date_import',
            'liter_balance',
            //'liter_all_time',
            'liter_from_esp',
            'avrg_value',
            [
                'class' => '\kartik\grid\EditableColumn',
                'attribute' => 'request_value',
                'editableOptions' => [
                    'header' => 'Объем кеги',
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => ['30' => '30л', '60' => '60л', '90' => '90л'],
                    'options' => ['class' => 'form-control', 'prompt' => 'Выбрать ....'],
                    'editableValueOptions' => ['class' => 'text-primary']
                ],
                'hAlign' => 'middle',
                'vAlign' => 'left',
                'width' => '5%',
                'pageSummary' => true
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'request_count',
                'editableOptions' => [
                    'header' => 'Кол-во',
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => ['1' => '1шт', '2' => '2шт', '3' => '3шт', '4' => '4шт', '5' => '5шт', '6' => '6шт', '7' => '7шт'],
                    'options' => ['class' => 'form-control', 'prompt' => 'Выбрать ....'],
                    'editableValueOptions' => ['class' => 'text-primary']
                ],
                'hAlign' => 'middle',
                'vAlign' => 'left',
                'width' => '6%',
                'pageSummary' => true
            ],
            'request_sum',
            ['class' => 'yii\grid\ActionColumn'],
        ];

        echo ExportMenu::widget(
            [
                'dataProvider' => $data,
                'columns' => $gridColumns,
            ]
        );

        echo GridView::widget([
            'rowOptions' => function ($model) {
                if ($model->colorValve()) {
                    return ['style' => 'background-color:#3ad43c;'];
                } else {
                    return ['style' => 'background-color:#e22020;'];
                }
            },
            'dataProvider' => $data,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'pjax' => true,
            'pjaxSettings' => [
                'neverTimeout' => true,
                'clientOptions' => ['method' => 'GET']
            ]
        ]);
        // Pjax::end();
        ?>


    </div>

</div>
