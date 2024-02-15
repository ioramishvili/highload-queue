<?php

namespace components\rabbitmq;

use Yii;

class QueueManager
{
    public static function publish(
        $msgBody,
        string $exchangeName,
        string $routingKey = '',
        array $additionalProperties = [],
        array $headers = null
    ): void
    {
        Yii::$app->rabbitmq
            ->getDefaultProducer()
            ->publish($msgBody, $exchangeName, $routingKey, $additionalProperties, $headers);
    }
}