<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SubCategoriesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sub-categories-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index', 'cid' => $_GET['cid']],
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

    <?php // echo $form->field($model, 'updated_at') ?>

   <div class="form-group">
        <?=Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
         <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['sub-categories/index', 'cid' => $_GET['cid'], "temp" => "clear"]), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
