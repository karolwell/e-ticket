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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/vendor.min.css',
        'css/styles.min.css',
        'css/card.min.css',
        'css/font-awesome.css',
        'customizer/customizer.min.css',
        //'//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css',
    ];
    public $js = [
       //'//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js',
       //'//pagead2.googlesyndication.com/pagead/show_ads.js',
       // 'js/jquery-barcode.js',
        '//code.jquery.com/jquery-1.11.1.min.js',
        'customizer/customizer.min.js',
        'js/JsBarcode.all.js',
        'js/jquery-2.2.3.min',
        'js/modernizr.min.js',
        'js/vendor.min.js',
        'js/scripts.min.js',
       'js/card.min.js',
       'js/jquery-barcode',
       'js/jquery-qrcode'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
