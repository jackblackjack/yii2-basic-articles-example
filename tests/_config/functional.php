<?php
return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../config/web.php'),
    require(__DIR__ . '/../../config/test.php'),
    [
        'components' => [
            'request' => [
                'scriptFile' => dirname(dirname(__DIR__)) . '/web/index-test.php',
            ],
        ],
    ]
);