<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/25 0025
 * Time: 16:25
 */
require_once '../vendor/autoload.php';

date_default_timezone_set("PRC");
use App\Controllers\weChat\weChatController;
use App\Exception\InLineException;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Exception\TokenException;


// 引入env 文件
$dotenv = new Dotenv\Dotenv(__DIR__ .'/../');
$dotenv->load();
$capsule = new Capsule;

$capsule->addConnection(require '../config/database.php');
// 启动Eloquent
$capsule->bootEloquent();
$server = new swoole_websocket_server("0.0.0.0", 9001);
$controller = new weChatController();
$server->on('open', function($server, $req)use($controller) {
    try{
        $token = $req->get['token'];
        $pid = $req->fd;
        $uid = $controller->getUser($token);
        $controller->userAdd($token,$pid);
        $controller->sendToAllUser($server,1,$pid,$uid);
    }catch (Exception $exception){
        if($exception instanceof InLineException){
            $data = [
                "code" => INLINE_ERROR,
                "msg"  => INLINE_MSG
            ];
            $server->push($pid,json_encode($data));
        }
        if($exception instanceof TokenException){
            $data = [
                "code" => TOKEN_ERROR,
                "msg"  => $exception->getMessage(),
            ];
            $server->push($pid,json_encode($data));
        }
        echo $exception->getMessage();
    }
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
