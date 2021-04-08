<?php

use app\models\Users;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

//use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

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

        echo Html::a('Добавить Esp', ['create'], ['class' => 'btn btn-success']);

        $gridColumns = [
            [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width:1%'],
            ],
            ['attribute' => 'roleName', 'label' => 'Продавец', 'value' => 'user.name_surname'],
            ['attribute' => 'roleName', 'label' => 'Торговая точка', 'value' => 'market.name_surname'],
            [
                'attribute' => 'valve',
                'headerOptions' => ['style' => 'width:2%'],
            ],
            'liter_base',
            [
                'label' => 'Заявка',
                'filter' => Html::activeDropDownList($model, 'day_from_table', $model->getFilterValue(), ['class' => 'form-control', 'prompt' => 'Фильтр']),
                'value' => function ($model) {
                    if (!empty(Yii::$app->request->queryParams['Esp']['day_from_table'])) {

                        return $model->getAvrgValue() * Yii::$app->request->queryParams['Esp']['day_from_table'];
                    } else {

                        return null;
                    }
                },
                'format' => 'raw',
            ],

            'liter_balance',
            //'liter_all_time',
            [
                'attribute' => 'liter_from_esp',
                'headerOptions' => ['style' => 'width:2%'],
            ],
            [
                'attribute' => 'esp_last_date',
                'headerOptions' => ['style' => 'width:2%'],
            ],
            'customer',
            [
                'attribute' => 'customer_name',
                'filter' => Html::activeDropDownList($searchModel, 'customer_name', $model->getUniqCustomerName(), ['class' => 'form-control', 'prompt' => 'Фильтр']),
            ],
            [
                'attribute' => 'address',
                'filter' => Html::activeDropDownList($searchModel, 'address', $model->getUniqAddress(), ['class' => 'form-control', 'prompt' => 'Фильтр']),
            ],
            [
                'attribute' => 'drink_name',
                'filter' => Html::activeDropDownList($searchModel, 'drink_name', $model->getUniqDrink(), ['class' => 'form-control', 'prompt' => 'Фильтр']),
            ],
            [
                'attribute' => 'price_buy',
                'label' => 'Покупка',
            ],
            [
                'attribute' => 'price_sale',
                'label' => 'Продажа',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ];
        echo ExportMenu::widget(
            [
                'dataProvider' => $dataProvider,
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
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'pjax' => true,
            'pjaxSettings' => [
                'neverTimeout' => true,
                'clientOptions' => ['method' => 'POST']
            ]
        ]);
        ?>
    </div>

</div>
