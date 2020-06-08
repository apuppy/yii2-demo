<?php
return [
    // 'bootstrap' => ['log'],// TODO 测试日志RabbitmqTarget时打开
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [
        'queue', // The component registers own console commands
    ],
    'components' => [
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
            'as log' => \yii\queue\LogBehavior::class,//错误日志 默认为 console/runtime/logs/app.log
            'redis' => 'redis', // 连接组件或它的配置
            'channel' => 'yii2-queue-demo', // Queue channel key
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'helper' => [
            'class' => 'common\components\Helper'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        // 测试log target为rabbitmq-server的场景
        /*'log' => [
            'targets' => [
                [
                    'class' => '\common\logging\RabbitmqTarget',
                    'levels' => ['error', 'warning','info'],
                ]
            ],
        ]*/
    ],
];
