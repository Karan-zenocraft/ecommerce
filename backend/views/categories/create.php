<?php

/* @var $this yii\web\View */
/* @var $model common\models\Categories */

$this->title = 'Create Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-create email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
