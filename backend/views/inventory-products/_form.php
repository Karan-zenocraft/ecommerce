<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\InventoryProducts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'serial_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'purchase_date')->textInput() ?>

    <?= $form->field($model, 'current_value')->textInput() ?>

    <?= $form->field($model, 'replacement_value')->textInput() ?>

    <?= $form->field($model, 'purchased_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_warranty')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'warranty_start_date')->textInput() ?>

    <?= $form->field($model, 'warranty_end_date')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 1 => '1', 0 => '0', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
