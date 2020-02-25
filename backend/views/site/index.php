<?php
use common\models\Brands;
use common\models\Category;
use common\models\Products;
use common\models\Users;
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Statistics';
$this->params['breadcrumbs'][] = $this->title;
//$this->params['page']['title'] = "Dashboard";
?>
<div class="site-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
    </div>
    <div class="block-content collapse in">
        <div class="span3">
            <div class="chart" data-percent="<?=Users::find()->where(['role_id' => Yii::$app->params['userroles']['user']])->count();?>"><?=Users::find()->where(['role_id' => Yii::$app->params['userroles']['user']])->count() . "%";?></div>
            <div class="chart-bottom-heading">
                <span class="label label-info">Users</span>
            </div>
        </div>
        <div class="span3">
            <div class="chart" data-percent="<?=Category::find()->count();?>"><?=Category::find()->count() . "%";?></div>
            <div class="chart-bottom-heading">
                <span class="label label-info">Categories</span>
            </div>
        </div>
        <div class="span3">
            <div class="chart" data-percent="<?=Brands::find()->count();?>"><?=Brands::find()->count() . "%";?></div>
            <div class="chart-bottom-heading">
                <span class="label label-info">Brands</span>
            </div>
        </div>
        <div class="span3">
            <div class="chart" data-percent="<?=Products::find()->count();?>"><?=Products::find()->count() . "%";?></div>
            <div class="chart-bottom-heading">
                <span class="label label-info">Products</span>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">
$(function() {
    // Easy pie charts
    $('.chart').easyPieChart({animate: 1000});
});
</script>