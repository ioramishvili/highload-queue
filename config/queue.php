<?php

use components\rabbitmq\Configuration;
use jobs\AccountsJob;

$queues = $bindings = $consumers = [];

foreach (AccountsJob::KEYS as $key => $task) {
    $queues[] = ['name' => AccountsJob::FUNCTION_NAME . $task];
    $bindings[] = ['exchange' => AccountsJob::FUNCTION_NAME, 'queue' => AccountsJob::FUNCTION_NAME . $task, 'routing_keys' => [$task]];
    $consumers[] =
        [
            'name' => 'common' . $key,
            'qos' => [
                'prefetch_count' => 1,
            ],
            'callbacks' => [AccountsJob::FUNCTION_NAME . $task => AccountsJob::class]
        ];
}

return [
    'class' => Configuration::class,
    'connections' => [
        [
            'host' => $_ENV['RABBITMQ_HOST'],
            'port' => $_ENV['RABBITMQ_PORT'],
            'user' => $_ENV['RABBITMQ_DEFAULT_USER'],
            'password' => $_ENV['RABBITMQ_DEFAULT_PASS'],
        ]
    ],
    'exchanges' => [
        [
            'name' => AccountsJob::FUNCTION_NAME,
            'type' => 'direct'
        ],
    ],
    'queues' => $queues,
    'bindings' => $bindings,
    'producers' => [
        [
            'name' => Configuration::DEFAULT_PRODUCER,
        ],
    ],
    'consumers' => $consumers
];