<?php

/* @var $this yii\web\View */
/* @var $model common\models\Advertise */

$this->title = 'Update Advertise: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Advertises', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="advertise-update email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
