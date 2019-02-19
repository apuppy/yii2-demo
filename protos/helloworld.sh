#!/bin/bash

protoc --proto_path=./   --php_out=./../grpc   --grpc_out=./../grpc   --plugin=protoc-gen-grpc=/opt/tools/grpc_php_plugin   ./helloworld.proto