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
class JqueryAsset extends AssetBundle
{
    public $sourcePath = '@app/node_modules';
    public $css = [
    ];
    public $js = [
        ['jquery/dist/jquery.min.js','position' => \yii\web\View::POS_HEAD],
        
    ];
    public $depends = [
    ];
    public $publishOptions = [
        'only' => [
            'jquery/dist/jquery.min.js',
        ]
    ];    
        
}
