<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Mark Worthmann
 * @since 2.0
 */
class LayoutAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/icon?family=Material+Icons',
        ['libraries/bootstrap/css/bootstrap.min.css','position' => \yii\web\View::POS_HEAD],
        'css/layout.scss',
        'css/menu.scss',
    ];
    public $js = [
        ['libraries/bootstrap/js/bootstrap.bundle.min.js','position' => \yii\web\View::POS_END],
        
    ];
    public $depends = [
        'app\assets\JqueryAsset',
    ];
    
        
}
