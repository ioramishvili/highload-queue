<?php

use Dotenv\Dotenv;

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$dotenv->required([
    'RABBITMQ_DEFAULT_USER',
    'RABBITMQ_DEFAULT_PASS',
    'RABBITMQ_HOST',
    'RABBITMQ_PORT'
]);

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();