<?php

/* @var $this yii\web\View */
/* @var $model common\models\Categories */

$this->title = 'Update Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="categories-update email-format-create">
    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
