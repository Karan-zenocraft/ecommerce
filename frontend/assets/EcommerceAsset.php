<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class EcommerceAsset extends AssetBundle
{
    public $basePath = '@webroot/themes/ecommerce_theme/';
    public $baseUrl = '@web/themes/ecommerce_theme/';
    public $sourcePath = '@webroot/themes/ecommerce_theme/';
    public $css = [
        'css/style.css',
        'css/responsive.css',
        'css/bootstrap.min.css',
        'font/font.css'
        
    ];
    public $js = [
        'js/jquery-2.2.0.min.js',
        'js/script.js'
         ];

    
    public $depends = [
        

         ];
}
