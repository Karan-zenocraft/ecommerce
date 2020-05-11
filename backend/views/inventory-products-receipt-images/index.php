<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Common;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InventoryProductsReceiptImagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventory Products Receipt Images';
$this->params['breadcrumbs'][] = ['label' => 'Manage User Inventory', 'url' => ['users-inventory/index']];
$this->params['breadcrumbs'][] = ['label' => 'Inventory Products', 'url' => ['inventory-products/index', 'uid' => $_GET['uid']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .goodtable .table thead tr th a, .table-striped tbody>tr:nth-child(odd)>td, .table-striped tbody>tr:nth-child(odd)>th{width: 40;}
.nav-list li:nth-child(7), .nav-list li:nth-child(7) a:hover{background: #006dcc;}
.nav-list li:nth-child(7) span, .nav-list li:nth-child(7) span:hover{color: #fff!important;}
.Model-Center img{padding: 15px;margin: auto;text-align: center;display: block;}
#caption{font-size: 14px;letter-spacing: 1px;color: #000;font-family: sans-serif;text-align: center;}
.close:focus{text-decoration: none;outline: none;}
.modal {
margin-left: 0px!important;
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 99999; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

  .modal-body {
    position:relative; /* This avoids whatever it's absolute inside of it to go off the container */
    height: 250px; /* let's imagine that your login box height is 250px . This height needs to be added, otherwise .img-responsive will be like "Oh no, I need to be vertically aligned?! but from which value I need to be aligned??" */
}
.img-responsive {
   
    left:50%;
    top:50%;
    margin-top:-25px; /* This needs to be half of the height */
    margin-left:-25px; /* This needs to be half of the width */
}
</style>
<div class="inventory-products-receipt-images-index email-format-index">
   <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">
            <?php echo Html::encode($this->title) . ' - ' .Common::get_name_by_id($_GET['pid'],"InventoryProducts"); ?>
        </div>
    </div>
    <div class="block-content">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           // 'inventory_product_id',
               [
            'attribute' => 'image_name',
            'filter' => false,
            'format' => 'html',
            'value' => function ($data) {
                return Html::img(Yii::getAlias('@web') . "/../uploads/receipt_images/" . $data['image_name'], ['alt'=>'No Image','width'=>'70','height'=>'70','class'=>"myImg"]);
            },
        ],
            //'created_at',
            //'updated_at',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>




  </div>
</div>


<div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="Model-Center">
          <img class="img-fluid" id="img01">

        </div>
        
        <!-- Modal footer -->
        
      </div>
    </div>
  </div>

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">



$( document ).ready(function() {
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
$(".myImg").on('click', function(event){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
});

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}

    });
</script>


