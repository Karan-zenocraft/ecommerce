<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Common;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InventoryProductsReceiptImagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventory Products Receipt Images';
$this->params['breadcrumbs'][] = ['label' => 'Manage User Inventory', 'url' => ['users-inventory/index']];
$this->params['breadcrumbs'][] = ['label' => 'Inventory Products', 'url' => ['inventory-products/index', 'uid' => $_GET['uid']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    
.nav-list li:nth-child(7), .nav-list li:nth-child(7) a:hover{background: #006dcc;}
.nav-list li:nth-child(7) span, .nav-list li:nth-child(7) span:hover{color: #fff!important;}

</style>
<div class="inventory-products-receipt-images-index email-format-index">
   <div class="email-format-index">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Search Here</div>
        </div>
</div>
   <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">
            <?php echo Html::encode($this->title) . ' - ' .Common::get_name_by_id($_GET['pid'],"InventoryProductsReceiptImages"); ?>
        </div>
    </div>
    <div class="block-content">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           // 'inventory_product_id',
               [
            'attribute' => 'image_name',
            'filter' => false,
            'format' => 'html',
            'value' => function ($data) {
                return Html::img(Yii::getAlias('@web') . "/../uploads/receipt_images/" . $data['image_name'], ['width' => '70px']);
            },
        ],
            //'created_at',
            //'updated_at',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

  </div>
</div>

