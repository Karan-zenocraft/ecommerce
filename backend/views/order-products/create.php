<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OrderProducts */

$this->title = 'Create Order Products';
$this->params['breadcrumbs'][] = ['label' => 'Order Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
