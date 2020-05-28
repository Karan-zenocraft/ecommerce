<?php

use common\components\Common;
use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AdvertiseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Advertisement';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertise-index email-format-index">
   <div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Search Here</div>
    </div>
        <div class="block-content collapse in">
        <div class="users-form span12">

     <?=Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'), "javascript:void(0);", ['class' => 'btn btn-primary open_search']);?>
     <?php if (!empty($_REQUEST['AdvertiseSearch']) || (!empty($_GET['temp']) && $_GET['temp'] == "clear")) {?>
        <div class="advertises-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
<?php } else {?>
    <div class="advertise-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    <?php }?>
</div>
</div>
</div>
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
        <div class="pull-right">
            <?=Html::a(Yii::t('app', '<i class="icon-plus"></i> Add Advertise'), ['create'], ['class' => 'btn btn-success'])?>
            <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['advertise/index']), ['class' => 'btn btn-primary'])?>
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
        [
            'attribute' => 'image',
            'format' => 'image',
            'value' => function ($data) {
                return !empty($data->image) && file_exists(Yii::getAlias('@root') . '/uploads/advertise/' . $data->image) ? Yii::getAlias('@web') . "/../uploads/advertise/" . $data->image : Yii::$app->params['root_url'] . '/' . "uploads/dp/no_image.png";
            },
        ],
        'url:url',
        //'created_at',
        // 'updated_at',

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
                    $confirmmessage = "Are you sure you want to delete this advertise?";
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
    $('.advertise-serach').hide();
        $('.open_search').click(function(){
            $('.advertise-serach').toggle();
        });
    });

</script>
