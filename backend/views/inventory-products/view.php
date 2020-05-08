<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\InventoryProducts */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inventory Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="inventory-products-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'product_name',
            'category_id',
            'serial_no',
            'note',
            'purchase_date',
            'current_value',
            'replacement_value',
            'purchased_from',
            'is_warranty',
            'warranty_start_date',
            'warranty_end_date',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
