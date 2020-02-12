<?php

/* @var $this yii\web\View */
/* @var $model common\models\SubCategories */

$this->title = 'Update : ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Manage Categories', 'url' => ['categories/index']];
$this->params['breadcrumbs'][] = ['label' => 'Sub Categories', 'url' => ['index', 'cid' => $model->category_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-categories-update email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
