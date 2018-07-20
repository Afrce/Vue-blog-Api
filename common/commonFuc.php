<?php
use Firebase\JWT\JWT;
use Zend\Http\Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Models\Api\Log;
use App\Exception\TokenException;

if(!function_exists('test')){
    function test(){
        echo 1;
    }
}

//返回信息

if(!function_exists('responseJson')){
    function responseJson($data,$status,$msg){
        $ret = [
            'data' => $data,
            'status' => $status,
            "msg"    => $msg,
        ];
        return json_encode($ret);
    }
}

//获取配置
if(!function_exists('config')){
    function config($data){
        $dataArr = explode('.' , $data);
        $retData = require_once ('../config/' . $dataArr[0] .".php");
        if(count($dataArr) <= 1){
            return $retData;
        }
        foreach ($dataArr as $key=>$item){
            if($key > 1){
                $retData = $retData[$item];
            }
        }
        return $retData;
    }
}

// 生成token
if(!function_exists("makeToken")){
    function makeToken($data){
        $jwt = JWT::encode($data,TOKEN,'HS256');
        return $jwt;
    }
}

if(!function_exists("setLog")){
    function setLog($data,$type)
    {
        $log = new Logger("LOG");
        $path = '../logs/'. date('Y-m-d') . $type . ".log";
        $log->pushHandler(new StreamHandler($path, Logger::WARNING));
        $log->$type($data);
    }
}

if(!function_exists("setApiLog")){
    function setApiLog($ip, $doWhat, $result){
        $data = [
            'ip' => $ip,
            'doWhat' => $doWhat,
            "result" => $result,
        ];
        Log::query()->create($data);
    }
}

if(!function_exists("getUserIp")){
    function getUserIp(){
        $ip=false;
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
            for ($i = 0; $i < count($ips); $i++) {
                if (!preg_match ("^(10|172\.16|192\.168)\.", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }
}

if(!function_exists("parseToken")){
    function parseToken()
    {
        $jwt = $_SERVER['HTTP_AUTHORIZATION'] ?? "";
        if($jwt == "null"){
            throw new TokenException("抱歉，您还未登录！");
        }else{
            try{
                JWT::$leeway = 60;
                $token = JWT::decode($jwt,TOKEN,['HS256']);
                $arr = (array)$token;
                if ($arr['exp'] < time()) {
                    throw new TokenException('抱歉！您的Token已经失效！请重新登录');
                } else {
                    return true;
                }
            }catch (\Exception $e){
                setLog($e,"error");
                throw new TokenException($e->getMessage());
            }
        }
    }
}
