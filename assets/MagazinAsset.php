<?php
/**
 * Created by PhpStorm.
 * User: 555
 * Date: 29.04.2018
 * Time: 18:10
 */

namespace app\assets;

use yii\web\AssetBundle;
class MagazinAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/magazin-index.css',
    ];
    public $js = [
        'js/jquery.cookie.js',
        'js/jquery.accordion.js',
        'js/magazin-main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}