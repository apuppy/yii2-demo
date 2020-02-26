<?php

namespace common\logging;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Yii;
use yii\helpers\VarDumper;
use yii\log\Logger;
use yii\log\Target;

class RabbitmqTarget extends Target
{
    // rabbitmq消息类型
    const TYPE_TOPIC = 'topic';
    const TYPE_DIRECT = 'direct';
    const TYPE_HEADERS = 'headers';
    const TYPE_FANOUT = 'fanout';

    /**
     * @var \PhpAmqpLib\Connection\AMQPStreamConnection
     */
    public $rabbitmq;

    /**
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    public $channel;

    // queue name | routing key
    public $queue = 'yii-log-queue';

    // exchange name
    public $exchange = 'yii-log-exchange';

    // logstash解析时区分，多配置文件场景，如果未带标识则不记录
    public $log_from = 'php-amqp';

    private $rabbit_host = '127.0.0.1';

    private $rabbit_port = 5672;

    private $rabbit_user = 'demo';

    private $rabbit_password = 'demo123';

    private $rabbit_vhost = '/';

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub

        if (isset(Yii::$app->params['amqp']) && is_array(Yii::$app->params['amqp'])) {
            $amqp = Yii::$app->params['amqp'];
        } else {
            $amqp = [];
        }
        if (isset($amqp['exchange']) && !empty($amqp['exchange'])) {
            $this->exchange = $amqp['exchange'];
        }
        if (isset($amqp['queue']) && !empty($amqp['queue'])) {
            $this->queue = $amqp['queue'];
        }
        if (isset($amqp['host'])) {
            $this->rabbit_host = $amqp['host'];
        }
        if (isset($amqp['port'])) {
            $this->rabbit_port = $amqp['port'];
        }
        if (isset($amqp['user'])) {
            $this->rabbit_user = $amqp['user'];
        }
        if (isset($amqp['password'])) {
            $this->rabbit_password = $amqp['password'];
        }
        if (isset($amqp['vhost'])) {
            $this->rabbit_vhost = $amqp['vhost'];
        }
        if (isset($amqp['log_from'])) {
            $this->log_from = $amqp['log_from'];
        }

        $this->rabbitmq = new AMQPStreamConnection($this->rabbit_host, $this->rabbit_port, $this->rabbit_user,
            $this->rabbit_password, $this->rabbit_vhost);
        $this->channel = $this->rabbitmq->channel();
    }

    /**
     * Exports log [[messages]] to a specific destination.
     * Child classes must implement this method.
     */
    public function export()
    {
        $this->send_json();
        // $this->send_plain_text();
    }


    /**
     * send plain text message
     */
    public function send_plain_text()
    {
        $message_text = implode("\n", array_map([$this, 'formatMessage'], $this->messages)) . "\n";
        $this->send($message_text);
    }

    /**
     * send json format message
     */
    public function send_json()
    {
        foreach ($this->messages as $message) {
            list($text, $level, $category, $timestamp) = $message;
            if (!is_string($text)) {
                // exceptions may not be serializable if in the call stack somewhere is a Closure
                if ($text instanceof \Throwable || $text instanceof \Exception) {
                    $text = (string)$text;
                } else {
                    $text = VarDumper::export($text);
                }
            }
            $request_id = isset($_SERVER['HTTP_X_REQUEST_ID']) ? $_SERVER['HTTP_X_REQUEST_ID'] : '';
            $server_addr = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
            $remote_addr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';

            $row_message = [
                'env' => YII_ENV,
                'request_id' => $request_id,
                'log_level' => $level,
                'log_level_text' => Logger::getLevelName($level),
                'machine_ip' => $server_addr,
                'client_ip' => $remote_addr,
                'category' => $category,
                'log_time' => $timestamp,
                'message' => $text,
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'request_raw' => json_encode($_REQUEST),
                'time' => time(),
                'datetime' => date('Y-m-d H:i:s'),
                'prefix' => $this->getMessagePrefix($message),
                'log-from' => $this->log_from // for logstash rabbit configuration
            ];
            // 如果需要动态加参数，加到这里
            if (isset(Yii::$app->params['amqp']['log_extra']) && count(Yii::$app->params['amqp']['log_extra']) > 0) {
                $row_message = array_merge($row_message, Yii::$app->params['amqp']['log_extra']);
            }
            $json_message = json_encode($row_message);
            $this->send($json_message);
        }
    }


    /**
     * send message to rabbitmq-server
     * @param $message_text
     */
    public function send($message_text)
    {
        $this->channel->exchange_declare($this->exchange, self::TYPE_FANOUT, false, true, false);
        $this->channel->queue_declare($this->queue, false, true, false, false);
        $amqp_message = new AMQPMessage($message_text);
        $this->channel->basic_publish($amqp_message, $this->exchange, $this->queue);
    }

}