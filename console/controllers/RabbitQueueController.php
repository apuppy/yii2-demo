<?php

namespace console\controllers;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class RabbitQueueController extends Controller
{

    public $queue = 'yii2demo-queue';
    public $exchange = 'yii2demo-exchange';
    public $rabbit_conf;

    public function init()
    {
        parent::init();
        $this->rabbit_conf = Yii::$app->params['rabbitmq'];
    }

    public function actionProduce()
    {
        $config = $this->rabbit_conf;
        $connection = new AMQPStreamConnection($config['host'], $config['port'], $config['user'], $config['password'], $config['vhost']);
        $channel = $connection->channel();

        $channel->queue_declare($this->queue, false, true, false, false);
        $channel->exchange_declare($this->exchange, AMQPExchangeType::DIRECT, false, true, false);
        $channel->queue_bind($this->queue, $this->exchange);

        $messageBody = date('Y-m-d H:i:s');
        $message = new AMQPMessage($messageBody, array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        $channel->basic_publish($message, $this->exchange);
        $this->stdout('published message : '.$messageBody.' .', Console::FG_YELLOW);
    }

    public function actionConsume()
    {
        $config = $this->rabbit_conf;
        $connection = new AMQPStreamConnection($config['host'], $config['port'], $config['user'], $config['password'], $config['vhost']);
        $channel = $connection->channel();

        $channel->queue_declare($this->queue, false, true, false, false);
        $channel->exchange_declare($this->exchange, AMQPExchangeType::DIRECT, false, true, false);
        $channel->queue_bind($this->queue, $this->exchange);


        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        $channel->basic_consume($this->queue, '',
            false, false, false, false, $callback);

        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

}