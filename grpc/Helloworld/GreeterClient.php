<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Helloworld;

/**
 */
class GreeterClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * say hi
     * @param \Helloworld\HiRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SayHi(\Helloworld\HiRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/helloworld.Greeter/SayHi',
        $argument,
        ['\Helloworld\HiReply', 'decode'],
        $metadata, $options);
    }

    /**
     * say hello
     * @param \Helloworld\HelloRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SayHello(\Helloworld\HelloRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/helloworld.Greeter/SayHello',
        $argument,
        ['\Helloworld\HelloReply', 'decode'],
        $metadata, $options);
    }

}
