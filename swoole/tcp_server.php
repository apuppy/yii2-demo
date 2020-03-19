<?php
//多进程管理模块
$pool = new Swoole\Process\Pool(2);
//让每个OnWorkerStart回调都自动创建一个协程
$pool->set(['enable_coroutine' => true]);
$pool->on("workerStart", function ($pool, $id) {
    //每个进程都监听9501端口
    $server = new Swoole\Coroutine\Server('0.0.0.0', '9501', false, true);
    //收到15信号关闭服务
    Swoole\Process::signal(SIGTERM, function () use ($server) {
        $server->shutdown();
    });
    //接收到新的连接请求
    $server->handle(function (Swoole\Coroutine\Server\Connection $conn) {
//        //接收数据
//        $data = $conn->recv();
//        if (empty($data)) {
//            //关闭连接
//            $conn->close();
//        }
//        //发送数据
//        $conn->send("hello");
        while ($data = $conn->recv()) {
            $conn->send($data);
            write_to_file($data);
        }
    });
    //开始监听端口
    $server->start();
});
$pool->start();

/**
 * 记录tcp请求到文件
 * @param $data
 */
function write_to_file($data)
{
    file_put_contents('./tcp_server.log', $data, FILE_APPEND);
}

// curl 请求tcp，测试请求连通性
# curl -F 'img=@puppy.png' 192.168.33.22:9501