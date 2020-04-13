<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-products-index email-format-index">
<div class="email-format-index">

</div>
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
 <div class="block-content">
        <div class="goodtable">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        //'id',
        //    'order_id',
        // 'product_id',
        [
            'attribute' => 'product_id',
            'value' => function ($data) {
                return $data->product->title;
            },
        ],
        'actual_price',
        //  'price_with_quantity',
        'quantity',
        'discount',
        'tax',
        //'discounted_price',
        //'total_price_with_tax_discount',
        [
            'attribute' => 'seller_id',
            'value' => function ($data) {
                return $data->seller->user_name;
            },
        ],
        //'seller_amount',
        //'created_at',
        //'updated_at',

        //['class' => 'yii\grid\ActionColumn'],
    ],
]);?>
    </div>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
    $('.products-serach').hide();
        $('.open_search').click(function(){
            $('.products-serach').toggle();
        });
    });

</script>

