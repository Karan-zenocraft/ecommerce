<style type="text/css">
    .from_date{
    width: 235px !important;
    height: 32px !important;
}
</style><?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\InventoryProductsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-products-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index',"uid"=>$_GET['uid']],
        'method' => 'get',
    ]); ?>
<div class="row">
    <div class="span3 style_input_width">
    <?= $form->field($model, 'product_name') ?>
</div>
 <div class="span3 style_input_width">
    <?= $form->field($model, 'category_id')->dropDownList(array(""=>"")+Category::AllCategoryDropdown()); ?>
</div>
<div class="span3 style_input_width">
    <?= $form->field($model, 'serial_no') ?>
</div>
</div>
<div class="row">
    <div class="span3 style_input_width">
    <?php  echo $form->field($model, 'note') ?>
</div>
 <div class="span3 style_input_width">
    <?=$form->field($model, 'purchase_date')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'from_date']/*, 'clientOptions' => ['minDate'=>'0']*/])?>
</div>
 <div class="span3 style_input_width">
    <?php  echo $form->field($model, 'current_value') ?>
</div>
</div>
<div class="row">
    <div class="span3 style_input_width">
    <?php  echo $form->field($model, 'replacement_value') ?>
</div>
  <div class="span3 style_input_width">
    <?php  echo $form->field($model, 'purchased_from') ?>
</div>
 <div class="span3 style_input_width">
    <?php  echo $form->field($model, 'is_warranty')->dropDownList(array(""=>"")+Yii::$app->params['is_warranty']) ?>
</div>
</div>
<div class="row">
    <div class="span3 style_input_width">
 <?=$form->field($model, 'warranty_start_date')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'from_date']/*, 'clientOptions' => ['minDate'=>'0']*/])?>
</div>
 <div class="span3 style_input_width">
 <?=$form->field($model, 'warranty_end_date')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'from_date']/*, 'clientOptions' => ['minDate'=>'0']*/])?>
</div>
</div>

    <div class="form-group">
        <?=Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
         <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['inventory-products/index',"uid"=>$_GET['uid'], "temp" => "clear"]), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
