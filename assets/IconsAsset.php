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
class IconsAsset extends AssetBundle
{
    //public $sourcePath = '@app/node_modules';
    public $css = [
        //['bootstrap-icons/font/bootstrap-icons.css','position' => \yii\web\View::POS_HEAD],
        ['https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css','position' => \yii\web\View::POS_HEAD],
    ];
    public $js = [
    ];
    public $depends = [
    ];
    /*
    public $publishOptions = [
        'only' => [
            'bootstrap-icons/font/bootstrap-icons.css',
            'bootstrap-icons/font/bootstrap-icons.json',
            'bootstrap-icons/font/fonts/*',
            'bootstrap-icons/icons/*',
            'bootstrap-icons/icons/bootstrap-icons.svg',
        ]
    ];
     * 
     */    
        
}
