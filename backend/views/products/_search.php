<?php

use common\models\Categories;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]);?>

<div class="row">
    <div class="span3 style_input_width">
    <?=$form->field($model, 'category_id')->dropDownList(array("" => "") + Categories::CategoryDropdown());?>
</div>
 <div class="span3 style_input_width">
    <?=$form->field($model, 'seller_id')?>
</div>
</div>
<div class="row">
    <div class="span3 style_input_width">
    <?=$form->field($model, 'title')?>
</div>
<div class="span3 style_input_width">
    <?=$form->field($model, 'description')?>
</div>
</div>
<div class="row">
<div class="span3 style_input_width">
    <?php echo $form->field($model, 'price') ?>
</div>
  <div class="span3 style_input_width">
    <?php echo $form->field($model, 'is_rent') ?>
</div>
</div>
<div class="row">

<div class="span3 style_input_width">
    <?php echo $form->field($model, 'rent_price') ?>
</div>
    <div class="span3 style_input_width">
    <?php echo $form->field($model, 'rent_price_duration') ?>
</div>
</div>
<div class="row">

<div class="span3 style_input_width">
    <?php echo $form->field($model, 'quantity') ?>
</div>
    <div class="span3 style_input_width">
    <?=$form->field($model, 'status')->dropDownList(Yii::$app->params['user_status']);?>
</div>
</div>

     <div class="form-group">
        <?=Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
         <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['products/index', "temp" => "clear"]), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
