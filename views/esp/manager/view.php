<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Esp */

$this->title = $model->address;
$this->params['breadcrumbs'][] = ['label' => 'Esps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="esp-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?php
        if (Yii::$app->user->identity != null) {
            if (Yii::$app->user->id == 1) {

                echo Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]);
            }
        }
        ?>

    </p>
    <div class="table-responsive">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                ['attribute' => 'roleName', 'label' => 'Продавец', 'value' => $model->user->name_surname],
                ['attribute' => 'roleName', 'label' => 'Торговая точка', 'value' => $model->market->name_surname],
                ['attribute' => 'roleName', 'label' => 'Торговый представитель', 'value' => $model->manager->name_surname],
                'valve',
                'liter_base',
                'liter_balance',
                'liter_all_time',
                'liter_from_esp',
                'customer',
                'customer_name',
                'address',
                'drink_name',
                'esp_date_import',
                'esp_last_date',
                'mail_percent',
                'price_buy',
                'price_sale',
                'avrg_day',
                'data_set_storage',
                'data_exp_storage',
                'hour_to_exp',
                'avrg_value',
            ],
        ]) ?>
    </div>

    <?= Html::a('Установить время', ['settimeexp', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
<br><br>
    <?php
    if (isset($model->price_buy) && isset($model->price_sale)) {
        echo 'Доход торговой точки: <b>' . ($model->price_sale - $model->price_buy) * $model->liter_all_time . '</b><br><br>';
    }
    ?>

    <?php
    if (isset($model->summ_7days) && !empty($model->summ_7days)) {
        $arr = json_decode($model->summ_7days, true);
        $arr = array_slice($arr, '-' . $model->avrg_day, $model->avrg_day);
        echo(round(array_sum($arr) / $model->avrg_day, 2) . ' округлил до 0.00 <br>');
        foreach ($arr as $key => $value) {
            echo '<b>' . $key . ' : ' . $value . '</b><br>';
        }
    }
    ?>



</div>
