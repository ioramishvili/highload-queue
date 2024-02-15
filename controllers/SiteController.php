<?php

namespace app\controllers;

use components\rabbitmq\QueueManager;
use jobs\AccountsJob;
use Random\RandomException;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    private const MAX_USERS = 5;
    private const MAX_JOBS = 100;
    private const RANDOM_STRING_LENGTH = 5;
    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     * @throws RandomException
     */
    public function actionIndex(): string
    {
        for ($i = 0; $i < self::MAX_JOBS; $i++) {
            $userId = random_int(1, self::MAX_USERS);
            $message = random_bytes(self::RANDOM_STRING_LENGTH);

            $routingKey = Yii::$app->cache->getOrSet($userId, function () {
                return AccountsJob::KEYS[random_int(0,count(AccountsJob::KEYS) - 1)];
            });

            QueueManager::publish([
                'userId' => $userId,
                'message' => $message
            ], AccountsJob::FUNCTION_NAME, $routingKey);
        }
        return $this->render('index');
    }
}
