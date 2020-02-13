<?php

/* @var $this yii\web\View */
/* @var $model common\models\Brands */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Manage Brands', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brands-create email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
    'parentCategories' => $parentCategories,
    'subCategories' => $subCategories,
])?>

</div>
