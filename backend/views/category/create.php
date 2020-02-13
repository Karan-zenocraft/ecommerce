<?php

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
