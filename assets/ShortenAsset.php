<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ShortenAsset extends AssetBundle
{
    public $sourcePath = '@app/assets';
    
    public $js = [
		'shorten/shorten.js',
    ];
    
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}
