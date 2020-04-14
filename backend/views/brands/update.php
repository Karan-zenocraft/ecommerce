<?php

/* @var $this yii\web\View */
/* @var $model common\models\Brands */

$this->title = 'Update: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Manage Brands', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="brands-update email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
    'parentCategories' => $parentCategories,
    'subCategories' => $subCategories,
])?>

</div>
