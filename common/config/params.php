<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    // log target(\common\logging\RabbitmqTarget)用到的配置参数
    'amqp' => [
        'host' => '192.168.33.22',
        'port' => 5672,
        'user' => 'demo',
        'password' => 'demo123',
        'vhost' => '/',
        'exchange' => 'yii-log-exchange',
        'queue' => 'yii-log-exchange',
        'log_extra' => [ // 附加日志字段,可配多个键值对
            //'key_name' => 'key_value',
        ]
    ]
];
