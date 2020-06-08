<?php

namespace common\jobs;

use common\services\ErrorLogService;
use yii\base\BaseObject;
use yii\queue\RetryableJobInterface;

class RetryDemoJob extends BaseObject implements RetryableJobInterface
{
    // retrable job
    // https://www.yiiframework.com/extension/yiisoft/yii2-queue/doc/guide/2.0/en/retryable
    // manage queue use process management tool
    // https://www.yiiframework.com/extension/yiisoft/yii2-queue/doc/guide/2.0/en/worker#supervisor

    public $url;
    public $file;

    public function execute($queue)
    {
        file_put_contents($this->file, file_get_contents($this->url));
    }

    public function getTtr()
    {
        return 15 * 60;
    }

    public function canRetry($attempt, $error)
    {
        // 记录错误日志
        ErrorLogService::record_queue_error($error);
        // 重试次数限制
        return $attempt < 5;
    }

}