<?php


namespace common\services;


use yii\base\InvalidArgumentException;
use yii\helpers\Json;

class WsService
{

    /**
     * parse message from client and deal with them
     * @param $message
     * @return string
     */
    public static function deal_with_client_message($message)
    {
        try {
            $data = Json::decode($message);
            if (isset($data['timestamp'])) {
                $data['datetime'] = date('Y-m-d H:i:s', $data['timestamp'] / 1000);
            }
        } catch (InvalidArgumentException $ie) {
            $error_message = $ie->getMessage();
            $data = ['error_message' => $error_message, 'origin_message' => $message];
        }
        $reply_message = Json::encode($data);
        return $reply_message;
    }

}