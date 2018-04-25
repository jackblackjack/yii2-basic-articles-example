<?php

namespace app\assets\backend;

use yii\web\AssetBundle;

class ArticleAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
        
    public $js = [
        'js/article/togglers.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
