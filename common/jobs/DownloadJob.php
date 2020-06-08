<?php

namespace common\jobs;

use yii\base\BaseObject;
use yii\queue\JobInterface;

class DownloadJob extends BaseObject implements JobInterface
{

    public $url;
    public $file;

    public function execute($queue)
    {
        file_put_contents($this->file, file_get_contents($this->url));
    }

}