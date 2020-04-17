<style type="text/css">
    .from_date{
    width: 235px !important;
    height: 32px !important;
}
</style>
<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrdersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]);?>
<div class="row">
    <div class="span3 style_input_width">
    <?=$form->field($model, 'buyer_id')?>
</div>
<div class="span3 style_input_width">

    <?=$form->field($model, 'payment_type')->dropdownList(array("" => "") + Yii::$app->params['payment_type_value'])?>
</div>
</div>
<div class="row">

</div>
<div class="row">
    <div class="span3 style_input_width">
    <?=$form->field($model, 'total_amount_paid')?>
</div>
<div class="span3 style_input_width">
  <?=$form->field($model, 'created_at')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'from_date']/*, 'clientOptions' => ['minDate'=>'0']*/])->label('Date')?>
</div>
</div>

    <?php // echo $form->field($model, 'status') ?>
<div class="row">
  <div class="span3 style_input_width">
    <?=$form->field($model, 'status')->dropDownList(Yii::$app->params['order_status_value']);?>
</div>
</div>
    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?=Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
         <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['orders/index', "temp" => "clear"]), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
