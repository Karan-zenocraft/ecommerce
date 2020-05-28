<?php

/* @var $this yii\web\View */
/* @var $model common\models\Advertise */

$this->title = 'Update Advertise';
$this->params['breadcrumbs'][] = ['label' => 'Manage Advertisement', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="advertise-update email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
