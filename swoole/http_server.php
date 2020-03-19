<?php

Co\run(function () {
    $server = new Co\Http\Server("0.0.0.0", 9502, false);
    $server->handle('/', function ($request, $response) {
        $response->end("<h1>Index</h1>");
    });
    $server->handle('/test', function ($request, $response) {
        $response->end("<h1>Test</h1>");
    });
    $server->handle('/stop', function ($request, $response) use ($server) {
        $response->end("<h1>Stop</h1>");
        $server->shutdown();
    });

    $server->handle('/upload', function ($request, $response) use ($server) {
        $str_response_var = var_export($response, true);
        $str_request_var = var_export($request, true);
        $debug_var = "REQUEST:\n" . $str_request_var . "\n\nRESPONSE:\n" . $str_response_var . "\n END\n";
        $response->end($debug_var);
        $upload_file = $request->files['img']; // 文件名['img']
        $tmp_name = $upload_file['tmp_name'];
        $new_filename = 'image-upload-' . uniqid() . ".png";
        move_uploaded_file($tmp_name, "./{$new_filename}"); // 保存文件到本地
    });

    $server->start();

});

// curl 请求http，测试请求连通性
# curl -F 'img=@puppy.png' 192.168.33.22:9502/upload