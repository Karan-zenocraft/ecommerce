<?php

use common\components\Common;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BrandsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Brands';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brands-index email-format-index">
    <div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Search Here</div>
    </div>
        <div class="block-content collapse in">
        <div class="users-form span12">

     <?=Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'), "javascript:void(0);", ['class' => 'btn btn-primary open_search']);?>
     <?php if (!empty($_REQUEST['BrandsSearch']) || (!empty($_GET['temp']) && $_GET['temp'] == "clear")) {?>
        <div class="brands-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel, 'amSubCategories' => $amSubCategories]); ?>
        </div>
<?php } else {?>
    <div class="brand-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel, 'amSubCategories' => $amSubCategories]); ?>
        </div>
    <?php }?>
</div>
</div>
</div>
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
        <div class="pull-right">
            <?=Html::a(Yii::t('app', '<i class="icon-plus"></i> Add Brand'), ['create'], ['class' => 'btn btn-success'])?>
            <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['categories/index']), ['class' => 'btn btn-primary'])?>
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

        // 'id',
        'title',
        'description:ntext',
        [
            'attribute' => 'parent_category_id',
            'value' => function ($data) {
                return !empty($data->parent_category_id) ? $data->parentCategory->title : '-';
            },
        ],
        [
            'attribute' => 'sub_category_id',
            'value' => function ($data) {
                return !empty($data->sub_category_id) ? $data->subCategory->title : '-';
            },
        ],
        //'created_at',
        //'update_at',

        [
            'header' => 'Actions',
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ["style" => "width:40%;"],
            'contentOptions' => ["style" => "width:40%;"],
            'template' => '{update}{delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    $flag = 1;
                    return Common::template_update_button($url, $model, $flag);
                },
                'delete' => function ($url, $model) {
                    $flag = 1;
                    $confirmmessage = "Are you sure you want to delete this Category?";
                    return Common::template_delete_button($url, $model, $confirmmessage, $flag);
                },

            ],
        ],
    ],
]);?>
      </div>
    </div>
</div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
    $('.brand-serach').hide();
        $('.open_search').click(function(){
            $('.brand-serach').toggle();
        });
    });

</script>