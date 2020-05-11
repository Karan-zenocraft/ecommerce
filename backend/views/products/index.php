<?php

use common\components\Common;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index email-format-index">
     <div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Search Here</div>
    </div>
        <div class="block-content collapse in">
        <div class="users-form span12">

     <?=Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'), "javascript:void(0);", ['class' => 'btn btn-primary open_search']);?>
     <?php if (!empty($_REQUEST['ProductsSearch']) || (!empty($_GET['temp']) && $_GET['temp'] == "clear")) {?>
        <div class="productss-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel, 'amSubCategories' => $amSubCategories]); ?>
        </div>
<?php } else {?>
    <div class="products-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel, 'amSubCategories' => $amSubCategories]); ?>
        </div>
    <?php }?>
</div>
</div>
</div>
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
        <div class="pull-right">
            <?php //Html::a(Yii::t('app', '<i class="icon-plus"></i> Add Product'), ['create'], ['class' => 'btn btn-success'])?>
            <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['products/index']), ['class' => 'btn btn-primary'])?>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
 <div class="block-content">
        <div class="goodtable">
    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'category_id',
            'value' => function ($data) {
                return !empty($data->category_id) ? $data->category->title : '-';
            },
        ],
        [
            'attribute' => 'subcategory_id',
            'value' => function ($data) {
                return !empty($data->subcategory_id) ? $data->subcategory->title : '-';
            },
        ],
        [
            'attribute' => 'seller_id',
            'value' => function ($data) {
                return !empty($data->seller_id) ? $data->seller->first_name . " " . $data->seller->last_name : '-';
            },
        ],
        'title',
        'description:ntext',
        //'lat',
        //'longg',
        'price',
        [
            'attribute' => 'is_rent',
            'value' => function ($data) {
                return Yii::$app->params['user_status'][$data->is_rent];
            },
        ],
        'rent_price',
        'rent_price_duration',
        'quantity',
        'quantity_in_stock',
        'discount',
        [
            'attribute' => 'is_approve',
            'filter' => Yii::$app->params['is_approve'],
            'format' => 'raw',
            'filterOptions' => ["style" => "width:13%;"],
            'headerOptions' => ["style" => "width:13%;"],
            'contentOptions' => ["style" => "width:13%;"],
            'value' => function ($data) {
                return !empty($data->is_approve) ? Yii::$app->params['is_approve'][$data->is_approve] : "Waiting";
            },
        ],
        [
            'attribute' => 'status',
            'value' => function ($data) {
                return Yii::$app->params['user_status'][$data->status];
            },
        ],
        //'created_at',
        //'updated_at',

        [
            'header' => 'Actions',
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ["style" => "width:40%;"],
            'contentOptions' => ["style" => "width:40%;"],
            'template' => '{approve_product}{product_photos}',
            'buttons' => [

                'approve_product' => function ($url, $model) {
                    $title = "Approve Product";
                    $flag = 1;
                    $url = Yii::$app->urlManager->createUrl(['products/approve-product', 'product_id' => $model->id]);
                    return Common::template_update_permission_button($url, $model, $title, $flag);

                },
                 'product_photos' => function ($url, $model) {
                    $title = "Product Photos";
                    $flag = 3;
                    $url = Yii::$app->urlManager->createUrl(['product-photos/index','pid'=>$model->id]);
                    return Common::template_view_gallery_button($url, $model, $title, $flag);

                },

            ],
        ],
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