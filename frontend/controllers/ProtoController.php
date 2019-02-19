<?php

namespace frontend\controllers;

use yii\web\Controller;
use Helloworld\GreeterClient;
use Helloworld\HiRequest;
use Grpc\ChannelCredentials;

class ProtoController extends Controller
{
    public function actionIndex()
    {
        $client = new GreeterClient('127.0.0.1:50051', [
            'credentials' => ChannelCredentials::createInsecure(),
        ]);
        $name = 'PHP client : timestamp now : '.time().', date now : '.date('Y-m-d H:i:s');
        $request = new HiRequest();
        $request->setName($name);
        list($reply, $status) = $client->SayHi($request)->wait();
        $message = $reply->getMessage();

        return $message;
    }

    public function actionHello()
    {
        $client = new \Helloworld\GreeterClient('127.0.0.1:50051', [
            'credentials' => \Grpc\ChannelCredentials::createInsecure(),
        ]);
        $name = 'PHP client : timestamp now : '.time().', date now : '.date('Y-m-d H:i:s');
        $request = new \Helloworld\HelloRequest();
        $request->setName($name);
        list($reply, $status) = $client->SayHello($request)->wait();
        $message = $reply->getMessage();

        return $message;
    }

}