<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use frontend\assets\EcommerceAsset;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
EcommerceAsset::register($this);
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
    <title>STABLE</title>
    <meta charset="UTF-8">
    <meta name="description" content="STABLE">
    <meta name="author" content="STABLE" />
    <meta name="generator" content="STABLE" />
    <meta name="theme-color" content="linear-gradient(120deg, #000 0%, #000 100%);" />
    <meta charset="<?=Yii::$app->charset?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo Yii::getAlias('@web') . "/themes/ecommerce_theme/image/fav-icon.png" ?>" type="image/png" sizes="64x64">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php $this->registerCsrfMetaTags()?>
    <title><?=Html::encode($this->title)?></title>
    <?php $this->head()?>
</head>
<body class="example-1  scrollbar-dusty-grass square thin">
<?php $this->beginBody()?>

<a href="#" id="scroll" style="display: none;z-index: 99999;">
        <span></span></a>



    <div id="Load" class="load">
        <div class="load__container text-center">
            <img src="<?php echo Yii::getAlias('@web') . "/themes/ecommerce_theme/image/logo.png" ?>" alt="" class="img-fluid" alt="Loader" style="max-width:100%;">
            

            <div class="load__mask"></div>

        </div>
    </div>

    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="Logo">
                        <a href="<?php echo Url::base(''); ?>">
                        <img src="<?php echo Yii::getAlias('@web') . "/themes/ecommerce_theme/image/logo.png" ?>" alt="" class="img-fluid">
                            </a>
                    </div>

                </div>

            </div>

        </div>
    </header>
        <?=Alert::widget()?>
        <?=$content?>
   
<footer>
        <div class="container">
            <div class="row">
                
                <div class="col-md-4">
                    <h5>About us</h5>

                    <p>Stable Corporation was thoughtfully planned to honour its storied history and the natural beauty of the land, offering a community where residents and guests become part of its rich ethos. where residents and guests become part of its</p>
                    
                </div>
                
                <div class="col-md-4">
                    <h5>Contact us</h5>


                    <ul class="ContactUs">
                        <li title="Address"><i class="fa fa-location-arrow"></i><a href="#Map" class="scroll">3084 State Route 27, Suite 12, Kendall Park, New Jersey 08824, USA</a></li>
                        <li title="Phone"><i class="fa fa-phone"></i><a href="tel:+1 888-406-2862"> +1 888-406-2862 / +91 79-35905939</a></li>
                        <li title="Email"><i class="fa fa-envelope"></i><a href="mailto:ajraghuvanshi99@gmail.com"> info@zenocraft.com</a></li>

                    </ul>
                </div>

                <div class="col-md-4">
                    <h5>Don’t forget to follow us on:</h5>
                    <ul class="Social">
                        <li class="facebook" title="Facebook"><a href="" ><i class="fa fa-facebook"></i></a></li>
                        <li class="instagram" title="Instagram"><a href="" ><i class="fa fa-instagram"></i></a></li>
                        <li class="linkedin" title="Linkedin"><a href="" ><i class="fa fa-linkedin"></i></a></li>
                        <li class="youtube" title="Youtube"><a href="" ><i class="fa fa-youtube"></i></a></li>
                        <li class="twitter" title="Twitter"><a href="" ><i class="fa fa-twitter"></i></a></li>
                    </ul>
                </div>

            </div>
            
            <div class="row Customerow">
            <div class="col-md-12 Copyright">
                
           <p class="text-muted mt-0 mb-0">Copyright <a href="www.Stablecorp.co.in">www.Stablecorp.co.in </a> 2019©.
        Made with <i style="color: red;" class="fa fa-heart"></i> by  <a class="link-inherit" href="http://www.zenocraft.com/" target="_blank"><b>Zenocraft</b> </a>. </p>
            </div>
            
            </div>

        </div>

    </footer>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.8.1/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/7.8.1/firebase-analytics.js"></script>

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyCaVpkmy1qvaaCrLhiQJlzQd77AT-K1OY8",
    authDomain: "ecommerce-acd47.firebaseapp.com",
    databaseURL: "https://ecommerce-acd47.firebaseio.com",
    projectId: "ecommerce-acd47",
    storageBucket: "ecommerce-acd47.appspot.com",
    messagingSenderId: "681968475052",
    appId: "1:681968475052:web:03c42f8711b5f9e8b27809",
    measurementId: "G-0KWQNS565B"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
</script>
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>
