<?php
return [
    // 'bootstrap' => ['log'],// TODO 测试日志RabbitmqTarget时打开
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [
        'queue', // The component registers own console commands
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=yii2demo',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8mb4',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        // 使用redis作为消息队列
        /*
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
            'as log' => \yii\queue\LogBehavior::class,//错误日志 默认为 console/runtime/logs/app.log
            'redis' => 'redis', // 连接组件或它的配置
            'channel' => 'yii2-queue-demo', // Queue channel key
        ],
        */
        // 使用rabbitmq作为消息队列
        // https://php-enqueue.github.io/transport/amqp_lib/
        'queue' => [
            'class' => \yii\queue\amqp_interop\Queue::class,
            'host' => '127.0.0.1',
            'port' => 5672,
            'user' => 'guest',
            'password' => 'guest',
            'queueName' => 'yii2-queue-rabbit-demo',
            'driver' => yii\queue\amqp_interop\Queue::ENQUEUE_AMQP_LIB,
            'attempts' => 3
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
