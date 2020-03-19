<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserAddresses */

$this->title = 'Create User Addresses';
$this->params['breadcrumbs'][] = ['label' => 'User Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    
.nav-list li:nth-child(2), .nav-list li:nth-child(2) a:hover{background: #006dcc;}
.nav-list li:nth-child(2) span, .nav-list li:nth-child(2) span:hover{color: #fff!important;}

</style>
<div class="user-addresses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
