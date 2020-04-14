<?php

use common\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\BrandsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brands-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]);?>
<div class="row">
    <div class="span3 style_input_width">
    <?=$form->field($model, 'title')?>
</div>
</div>
<div class="row">
    <div class="span3 style_input_width">
    <?=$form->field($model, 'description')?>
</div>
</div>
<div class="row">
    <div class="span3 style_input_width">
    <?=$form->field($model, 'parent_category_id')->dropDownList(Category::ParentCategoryDropdown(), [
    'prompt' => Yii::t('app', '-Choose Parent Category-'),
    'onchange' => '
                $.post( "' . Yii::$app->urlManager->createUrl('category/get-subcategory?id=') . '"+$(this).val(), function( data ) {
                  $( "select#brandssearch-sub_category_id" ).html( data );
                });',
]);?>
</div>
</div>
<div class="row">
    <div class="span3 style_input_width">
    <?=$form->field($model, 'sub_category_id')->dropDownList($amSubCategories, [
    'prompt' => Yii::t('app', '-Choose Sub Category-'),
]);?>
</div>
</div>
</div>

    <?php // echo $form->field($model, 'update_at') ?>

     <div class="form-group">
        <?=Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
         <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['brands/index', "temp" => "clear"]), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
