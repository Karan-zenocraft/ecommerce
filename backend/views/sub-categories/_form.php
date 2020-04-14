<?php

use common\models\Categories;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SubCategories */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
    </div>
    <div class="block-content collapse in">
<div class="sub-categories-form span12 common_search">

    <?php $form = ActiveForm::begin();?>
<div class="row">
                <div class="span3 style_input_width">
    <?=$form->field($model, 'category_id')->dropDownList(Categories::CategoriesDropDown(), ["disabled" => "true", 'value' => $_GET['cid']])?>
</div>
</div>
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

    <div class="form-group">
        <?=Html::submitButton('Save', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
