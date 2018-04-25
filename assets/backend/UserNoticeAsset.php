<?php

namespace app\assets\backend;

use yii\web\AssetBundle;

class UserNoticeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
        
    public $js = [
        'js/user-notice/togglers.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
