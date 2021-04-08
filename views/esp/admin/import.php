<?php

use app\models\Esp;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EspSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Esp';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <?php
    if (isset($messages) && !empty($messages)) {
        echo('импортированио ' . count($messages) . ' записей <br><br>');
        foreach ($messages as $value) {
            foreach ($value as $key => $val) {
                echo $key . ' <b>' . $val . '</b><br>';
            }
        }
    }
    ?>
</div>
