<?php

namespace components\rabbitmq;

use mikemadisonweb\rabbitmq\components\Producer;
use Yii;

class Configuration extends \mikemadisonweb\rabbitmq\Configuration
{
    public const DEFAULT_PRODUCER = 'common';

    public function getDefaultProducer(): Producer
    {
        return Yii::$app->rabbitmq->getProducer(self::DEFAULT_PRODUCER);
    }
}