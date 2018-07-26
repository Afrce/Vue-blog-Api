<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/26 0026
 * Time: 16:25
 */
use Illuminate\Database\Capsule\Manager as Capsule;

require_once '../vendor/autoload.php';
// 捕获异常并处理 注意这里必须写在最上面以免异常未能捕获而中断


set_exception_handler(function ( $exception){
    setLog($exception,'error');
    echo responseJson([],false,$exception->getMessage());
    die();
});


date_default_timezone_set("PRC");

$capsule = new Capsule;

$capsule->addConnection(require '../config/database.php');
// 启动Eloquent
$capsule->bootEloquent();
// 引入env 文件
$dotenv = new Dotenv\Dotenv(__DIR__ .'/../');
$dotenv->load();

require_once '../config/routes.php';
