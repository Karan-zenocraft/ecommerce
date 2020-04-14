<?php

/* @var $this yii\web\View */
/* @var $model common\models\SubCategories */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Manage Categories', 'url' => ['categories/index']];
$this->params['breadcrumbs'][] = ['label' => 'Sub Categories', 'url' => ['index', 'cid' => $_GET['cid']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-categories-create email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
