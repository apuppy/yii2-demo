<?php
return [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        /*
        'log' => [
            'targets' => [
                [
                    'class' => 'common\components\SqlLogTarget',
                    'levels' => ['info'],
                    'categories' => [
                        'yii\db\Command::query',
                        'yii\db\Command::execute',
                    ],
                ],
            ],
        ],
        */
    ],
];
