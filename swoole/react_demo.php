<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$server = new Server(function (ServerRequestInterface $request) {

    if ($request->getMethod() === 'POST') {
        $uploads = $request->getUploadedFiles();
        if (isset($uploads['img']) && $uploads['img'] instanceof UploadedFileInterface) {
            /* @var $file UploadedFileInterface */
            $file = $uploads['img'];
            if ($file->getError() === UPLOAD_ERR_OK) {
                // $file->moveTo('./upload-image-react-' . uniqid() . '.png'); // can not use this method
                file_put_contents('./upload-image-react-' . uniqid() . '.png',(string)$file->getStream(),FILE_APPEND);
                // Note that moveFile() is not available due to its blocking nature.
                // You can use your favorite data store to simply dump the file
                // contents via `(string)$file->getStream()` instead.
                // Here, we simply use an inline image to send back to client:
                $img = '<img src="data:' . $file->getClientMediaType() . ';base64,' . base64_encode($file->getStream()) . '" /> (' . $file->getSize() . ' bytes)';
            } elseif ($file->getError() === UPLOAD_ERR_INI_SIZE) {
                $img = 'upload exceeds file size limit';
            } else {
                // Real applications should probably check the error number and
                // should print some human-friendly text
                $img = 'upload error ' . $file->getError();
            }
        }

    }

    $serverParams = $request->getServerParams();
    $queryParams = $request->getQueryParams();
    $files = $request->getUploadedFiles();

    $params = [
        'server' => $serverParams,
        'query' => $queryParams,
        'file' => $files
    ];
    $str_params = var_export($params, true) . "\n";

    return new Response(
        200,
        array(
            'Content-Type' => 'text/html'
        ),
        //$body
        $str_params
    );

});

$socket = new \React\Socket\Server(isset($argv[1]) ? $argv[1] : '0.0.0.0:0', $loop);
$server->listen($socket);

echo 'Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress()) . PHP_EOL;

$loop->run();
