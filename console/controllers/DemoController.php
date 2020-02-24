<?php

namespace console\controllers;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class DemoController extends Controller
{
    /****** options 方法限定参数 ******/
    public $user_name;
    public $operate_action;
    public $uid;

    public function options($actionID)
    {
        return ['user_name', 'operate_action', 'uid'];
    }

    public function actionIndex()
    {
        $this->stdout("demo console \n");
    }

    /**
     * options 方法限定参数
     */
    public function actionShowOptions()
    {
        var_dump($this->user_name);
        var_dump($this->operate_action);
        var_dump($this->uid);
    }

    /**
     * 用户自定义变量
     * mixed params
     * @param $name
     * @param $value
     * @param array $extra_params
     */
    public function actionShowCustomParams($name, $value, array $extra_params)
    {
        var_dump($name);
        var_dump($value);
        var_dump($extra_params);
    }

    /**
     * 字体、颜色、格式
     * @return int
     */
    public function actionTricks()
    {
        // strong the output
        $this->stdout("Hello \n");
        $this->stdout("more strong \n", Console::BOLD);

        $name = $this->ansiFormat('Alex', Console::FG_RED);
        $this->stdout("Hello, my name is $name. \n");

        // return status code ExitCode::OK && ExitCode::UNSPECIFIED_ERROR
        return ExitCode::UNSPECIFIED_ERROR;
    }

    /**
     * 命令行交互
     * interactive command line
     * @return int
     */
    public function actionInteractiveOperate()
    {
        // confirm
        if ($this->confirm("Are you sure?")) {
            echo "user typed yes\n";
        } else {
            echo "user typed no\n";
        }
        // standard and error output
        $this->stdout("black hole \n");

        $this->stderr("no completed \n");
        return ExitCode::UNSPECIFIED_ERROR;
    }

    public function actionQueueSend()
    {
        $connection = new AMQPStreamConnection('192.168.33.22', 5672, 'demo', 'demo123');
        $channel = $connection->channel();
        $channel->queue_declare('hello', false, false, false, false);
        $msg = new AMQPMessage('Hello World!');
        $channel->basic_publish($msg, '', 'hello');
        echo " [x] Sent 'Hello World!'\n";
        $channel->close();
        $connection->close();
        //var_dump($channel);
        exit;
    }

    public function actionQueueReceive()
    {
        $connection = new AMQPStreamConnection('192.168.33.22', 5672, 'demo', 'demo123');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $channel->basic_consume('hello', '', false, true, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }

    }

}