<?php

declare(strict_types=1);

namespace jobs;

use components\rabbitmq\Consumer;
use Exception;
use PhpAmqpLib\Message\AMQPMessage;

class AccountsJob extends Consumer
{
    public const FUNCTION_NAME = 'ACCOUNTS_JOB';
    public const KEYS = [
        'task_one',
        'task_two'
    ];

    /**
     * @param AMQPMessage $msg
     * @return int
     * @throws Exception
     */
    public function run(AMQPMessage $msg): int
    {
        $data = $msg->getBody();

        if (empty($data)) {
            return self::MSG_REJECT;
        }

        $userId = $data['userId'] ?? null;
        $message = $data['message'] ?? null;

        if ($userId === null || $message === null) {
            return self::MSG_REJECT;
        }

        return $this->doSomething((int)$userId, $message);
    }

    private function doSomething(int $userId, string $message): int
    {
        sleep(1);
        return self::MSG_ACK;
    }
}