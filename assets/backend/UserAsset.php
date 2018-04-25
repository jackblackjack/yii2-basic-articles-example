<?php

namespace app\assets\backend;

use yii\web\AssetBundle;

class UserAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
        
    public $js = [
        'js/user/togglers.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
