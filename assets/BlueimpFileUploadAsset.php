<?php
namespace app\assets;

use yii\web\AssetBundle;
use Yii;

class BlueimpFileUploadAsset extends AssetBundle
{
    public $sourcePath = '@bower';

    public $css = [
        'blueimp-file-upload/css/jquery.fileupload.css',
        'blueimp-file-upload/css/jquery.fileupload-ui.css'
    ];

    public $cssOptions = [
        'type' => 'text/css',
    ];

    public $js = [
        'blueimp-file-upload/js/vendor/jquery.ui.widget.js',
        'blueimp-load-image/js/load-image.all.min.js',
        'blueimp-canvas-to-blob/js/canvas-to-blob.min.js',

        'blueimp-file-upload/js/jquery.iframe-transport.js',
        'blueimp-file-upload/js/jquery.fileupload.js',

        'blueimp-file-upload/js/jquery.fileupload-process.js',
        'blueimp-file-upload/js/jquery.fileupload-image.js',
        'blueimp-file-upload/js/jquery.fileupload-validate.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
