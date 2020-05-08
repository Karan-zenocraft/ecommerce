<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InventoryProducts */

$this->title = 'Create Inventory Products';
$this->params['breadcrumbs'][] = ['label' => 'Inventory Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
