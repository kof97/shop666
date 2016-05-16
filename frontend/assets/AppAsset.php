<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.css',
        'css/style.css',
        'css/megamenu.css',
        'css/etalage.css',
    ];
    public $js = [
        'js/jquery-1.11.1.min.js',
        'js/megamenu.js',
        'js/menu_jquery.js',
        'js/simpleCart.min.js',
        'js/jquery-ui.min.js',
        'js/jquery.etalage.min.js',
        'js/jquery.jscrollpane.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
