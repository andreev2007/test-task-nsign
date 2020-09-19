<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <?php /** @var \common\models\Food $searchModel */
    echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= /** @var \common\models\FoodSearch $dataProvider */
    ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('food', ['model' => $model]);
        },
    ]) ?>
</div>
