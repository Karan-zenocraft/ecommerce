<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Common;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductPhotosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Photos';
$this->params['breadcrumbs'][] = ['label' => 'Manage Products', 'url' => ['products/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">

.nav-list li:nth-child(5), .nav-list li:nth-child(5) a:hover{background: #006dcc;}
.nav-list li:nth-child(5) span, .nav-list li:nth-child(5) span:hover{color: #fff!important;}

</style>
<div class="product-photos-index email-format-index">

    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title).": ".Common::get_name_by_id($_GET['pid'],"Products"); ?></div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
    <div class="block-content">
        <div class="goodtable">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
          'filterModel' => null,
        'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

         //   'id',
           // 'product_id',
                 [
            'attribute' => 'image_name',
            'filter' => false,
            'format' => 'html',
            'value' => function ($data) {
                return Html::img(Yii::getAlias('@web') . "/../uploads/products/" . $data['image_name'], ['width' => '70px']);
            },
        ],
            //'image_path:ntext',
           // 'created_at',
            //'updated_at',

         //   ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
  </div>
    </div>
</div>
