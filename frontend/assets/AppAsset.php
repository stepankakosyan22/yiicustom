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
        'css/site.css',
        'css/main.css',
        'css/font-awesome-4.7.0/css/font-awesome.min.css',
        'js/jquery-ui-1.12.1/jquery-ui.css',
    ];
    public $js = [
        'js/main.js',
        'js/jquery-ui-1.12.1/jquery-ui.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
