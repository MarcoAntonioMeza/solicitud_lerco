<?php
namespace app\assets;

use yii\web\AssetBundle;
use Yii;

class SummernoteAsset extends AssetBundle
{
    public $baseUrl = '@web';

    public $js = [
        'js/summernote/summernote.min.js',
    ];

    public $css = [
        'css/summernote/summernote.min.css',
    ];

}