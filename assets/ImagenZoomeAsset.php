<?php
namespace app\assets;

use yii\web\AssetBundle;
use Yii;

class ImagenZoomeAsset extends AssetBundle
{
    public $baseUrl = '@web';

    public $js = [
        'js/jquery.zoom.min.js',
    ];

}