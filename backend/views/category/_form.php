<?php

use common\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
    </div>
    <div class="block-content collapse in">
<div class="category-form span12 common_search">

    <?php $form = ActiveForm::begin();?>
<div class="row">
                <div class="span3 style_input_width">
    <?=$form->field($model, 'title')->textInput()?>
</div>
</div>
<div class="row">
                <div class="span3 style_input_width">
    <?=$form->field($model, 'description')->textInput()?>
</div>
</div>
<div class="row">
                <div class="span3 style_input_width">
                    <?php if ($model->isNewrecord) {?>
    <?=$form->field($model, 'parent_id')->dropDownList(array("" => "") + Category::CategoryDropdown())?>
<?php } else {
    $parent_id = $model->parent_id;
    $disabled = !empty($parent_id) ? "false" : "true";
    ?>
      <?=$form->field($model, 'parent_id')->dropDownList(array("" => "") + Category::CategoryDropdown($model->id), ["disabled" => ($disabled == "true") ? true : false])?>
<?php }?>

</div>
</div>
<div class="row">
<div class="span3 style_input_width">
      <?=$form->field($model, 'photo')->fileInput(['id' => 'photo', 'value' => $model->photo]);?>
</div>
</div>
      <div class="row">
<div class="span3">
    <img id="image" width="100px" hieght="100px" src="<?php echo $model->photo; ?>" alt="" />
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
