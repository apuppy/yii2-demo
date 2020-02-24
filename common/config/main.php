<?php
return [
    'bootstrap' => ['log'],// TODO 测试日志RabbitmqTarget时打开
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'helper' => [
            'class' => 'common\components\Helper'
        ],
        // 测试log target为rabbitmq-server的场景
        'log' => [
            'targets' => [
                [
                    'class' => '\common\logging\RabbitmqTarget',
                    'levels' => ['error', 'warning','info'],
                ]
            ],
        ]
    ],
];
