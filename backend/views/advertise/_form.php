<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Advertise */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
    </div>
    <div class="block-content collapse in">
<div class="advertise-form span12 common_search">

    <?php $form = ActiveForm::begin();?>
<div class="row">
                <div class="span3 style_input_width">
    <?=$form->field($model, 'url')->textInput(['maxlength' => true])?>
</div>
</div>
<div class="row">
                <div class="span3 style_input_width">

      <?=$form->field($model, 'image')->fileInput(['id' => 'photo', 'value' => $model->image, 'required' => "required"]);?>
</div>
</div>
    <div class="row">
<div class="span3">
    <img id="image" width="100px" hieght="100px" src="<?php echo Yii::getAlias('@web') . "/../uploads/advertise/" . $model->image ?>" alt="" />
    </div>
</div>

    <div class="form-group">
        <?=Html::submitButton('Save', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end();?>
</div>
</div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">
 $( document ).ready(function(){
        $("#photo").change(function() {
        readURL(this);
        });
    });
    function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#image').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}
</script>
