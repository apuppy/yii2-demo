<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    // log target(\common\logging\RabbitmqTarget)用到的配置参数
    'amqp' => [
        'host' => '127.0.0.1',
        'port' => 5672,
        'user' => 'demo',
        'password' => 'demo123',
        'vhost' => '/',
        'exchange' => 'yii-log-exchange',
        'queue' => 'yii-log-queue',
        'log_from' => 'php-amqp', // 标记字段
        'log_extra' => [ // 附加日志字段,可配多个键值对
            //'key_name' => 'key_value',
        ]
    ]
];
