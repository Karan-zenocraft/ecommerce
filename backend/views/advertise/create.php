<?php

/* @var $this yii\web\View */
/* @var $model common\models\Advertise */

$this->title = 'Create Advertise';
$this->params['breadcrumbs'][] = ['label' => 'Manage Advertisement', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertise-create email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
