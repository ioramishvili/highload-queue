<?php

namespace components\rabbitmq;

use mikemadisonweb\rabbitmq\components\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Throwable;
use Yii;
use yii\base\Component;

abstract class Consumer extends Component implements ConsumerInterface
{
    public function execute(AMQPMessage $msg)
    {
        try {
            return $this->run($msg);
        } catch (Throwable $e) {
            Yii::error($e);
            return static::MSG_REJECT;
        }
    }

    abstract public function run(AMQPMessage $msg);
}