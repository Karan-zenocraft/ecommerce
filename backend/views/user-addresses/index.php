<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserAddressesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Addresses';
$this->params['breadcrumbs'][] = ['label' => 'Manage Users', 'url' => ['users/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">

.nav-list li:nth-child(2), .nav-list li:nth-child(2) a:hover{background: #006dcc;}
.nav-list li:nth-child(2) span, .nav-list li:nth-child(2) span:hover{color: #fff!important;}

</style>
<div class="user-addresses-index email-format-index">
        <div class="email-format-index">

</div>
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
    <div class="block-content">
        <div class="goodtable">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'id',
        [
            'attribute' => 'user_id',
            'value' => function ($data) {
                return !empty($data->user_id) ? $data->user->user_name : "-";
            },
        ],
        'address:ntext',
        'pincode',
        [
            'attribute' => 'is_default',
            'value' => function ($data) {
                return ($data->is_default == "1") ? "Yes" : "No";
            },
        ],
        //'created_at',
        //'updated_at',

        // ['class' => 'yii\grid\ActionColumn'],
    ],
]);?>
   </div>
    </div>
</div>
