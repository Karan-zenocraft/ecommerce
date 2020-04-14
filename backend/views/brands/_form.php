<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Brands */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
    </div>
    <div class="block-content collapse in">
<div class="brands-form span12 common_search">

    <?php $form = ActiveForm::begin();?>
<div class="row">
                <div class="span3 style_input_width">
    <?=$form->field($model, 'title')->textInput(['maxlength' => true])?>
</div>
</div>
<div class="row">
                <div class="span3 style_input_width">
    <?=$form->field($model, 'description')->textarea(['rows' => 6])?>
</div>
</div>
<div class="row">
                <div class="span3 style_input_width">
    <?=$form->field($model, 'parent_category_id')->dropDownList($parentCategories, [
    'prompt' => Yii::t('app', '-Choose Parent Category-'),
    'onchange' => '
                $.post( "' . Yii::$app->urlManager->createUrl('category/get-subcategory?id=') . '"+$(this).val(), function( data ) {
                  $( "select#brands-sub_category_id" ).html( data );
                });',
]);
?>
</div>
</div>
<div class="row">
                <div class="span3 style_input_width">
 <?=$form->field($model, 'sub_category_id')->dropDownList($subCategories)?>
</div>
</div>
    <div class="form-group">
        <?=Html::submitButton('Save', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end();?>
</div>
</div>
</div>

