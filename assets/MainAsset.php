<?php
namespace app\assets;

use yii\web\AssetBundle;
use Yii;

class MainAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        
    ];

    public $css = [
        'index-main/css/style.css'
    ];

    public $cssOptions = [
        'type' => 'text/css',
    ];
}
