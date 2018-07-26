<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/25 0025
 * Time: 16:25
 */

$server = new swoole_websocket_server("0.0.0.0", 9001);

$server->on('open', function($server, $req) {
    echo "connection open: {$req->fd}\n";
});

$server->on('message', function($server, $frame) {
    echo "received message: {$frame->data}\n";
    $server->push($frame->fd, json_encode(["hello", "world"]));
});

$server->on('close', function($server, $fd) {
    echo "connection close: {$fd}\n";
});

$server->start();
