<style type="text/css">

.nav-list li:nth-child(7), .nav-list li:nth-child(7) a:hover{background: #006dcc;}
.nav-list li:nth-child(7) span, .nav-list li:nth-child(7) span:hover{color: #fff!important;}

</style><?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Common;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InventoryProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventory Products: '.Common::get_user_name($_GET['uid']);
$this->params['breadcrumbs'][] = ['label' => 'Manage User Inventory', 'url' => ['users-inventory/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-products-index email-format-index">
 <div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Search Here</div>
    </div>
        <div class="block-content collapse in">
        <div class="users-form span12">

     <?=Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'), "javascript:void(0);", ['class' => 'btn btn-primary open_search']);?>
     <?php if (!empty($_REQUEST['InventoryProductsSearch']) || (!empty($_GET['temp']) && $_GET['temp'] == "clear")) {?>
        <div class="inventory-productss-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
<?php } else {?>
    <div class="inventory-products-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    <?php }?>
</div>
</div>
</div>
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
        <div class="pull-right">
            <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['inventory-products/index', "uid" => $_GET['uid']]), ['class' => 'btn btn-primary'])?>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
    <div class="block-content">
        <div class="goodtable">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'filterModel' => null,
        'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
          //  'user_id',
            'product_name',
             [
            'attribute' => 'category_id',
            'value' => function ($data) {
                return !empty($data->category_id) ? $data->category->title : '-';
            },
        ],
            'serial_no',
            'note',
            'purchase_date',
            'current_value',
            'replacement_value',
            'purchased_from',
            [
            'attribute' => 'is_warranty',
            'value' => function ($data) {
                return Yii::$app->params['is_warranty'][$data->is_warranty];
            },
            ],
            'warranty_start_date',
            'warranty_end_date',
            //'status',
            //'created_at',
            //'updated_at',

                    [
            'header' => 'Actions',
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ["style" => "width:40%;"],
            'contentOptions' => ["style" => "width:40%;"],
            'template' => '{inventory_product_photos}{receipt_images}',
            'buttons' => [
              
                'inventory_product_photos' => function ($url, $model) {
                    $title = "Inventory Product Photos";
                    $flag = 3;
                    $url = Yii::$app->urlManager->createUrl(['inventory-products-photos/index', 'uid' => $_GET['uid'],'pid'=>$model->id]);
                    return Common::template_view_gallery_button($url, $model, $title, $flag);

                },
                'receipt_images' => function ($url, $model) {
                    $title = "Receipt Images";
                    $flag = 7;
                    $url = Yii::$app->urlManager->createUrl(['inventory-products-receipt-images/index', 'uid' => $_GET['uid'],'pid'=>$model->id]);
                    return Common::template_view_gallery_button($url, $model, $title, $flag);

                },
            ],
        ],
        ],
    ]); ?>
      </div>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
    $('.inventory-products-serach').hide();
        $('.open_search').click(function(){
            $('.inventory-products-serach').toggle();
        });
    });

</script>