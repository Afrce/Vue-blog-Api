<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/26 0026
 * Time: 16:09
 */

namespace App\Controllers\weChat;

use Predis\Client;
use App\Exception\InLineException;
use App\Repositories\ChatRepository;
use Firebase\JWT\JWT;
use App\Exception\TokenException;
class weChatController
{
    private $client = null;
    private $chat = null;

    public function __construct()
    {
        $this->client =new Client(config("redis"));
        $this->chat = new ChatRepository();
    }

    public function userAdd($uid,$pid){
        $InLine = false;
        $pidInline = $this->client->hmget('userInlineList',$uid);
        if($pidInline[0] != null){
            $InLine = true;
        }
        $this->client->hmset('userInlineList', array(
            $uid => $pid
        ));
        if($InLine){
            throw  new InLineException("占线！");
        }
    }

    /**
     * userExit 用户退出
     * 2018/7/27 0027
     * @author CL
     * @param $uid
     * @param $pid
     */
    public function userExit($uid,$pid){
        $this->client->hdel("userInlineList",$uid);
    }

    /**
     * userList
     * 2018/7/27 0027
     * @author CL
     * @return array
     */
    public function userList(){
        $userList = $this->client->hgetall("userInlineList");
        return $userList;
    }

    /**
     * sendToAllUser
     * 2018/7/27 0027
     * @author CL
     * @param \swoole_http_server $server
     * @param $type
     * @param null $pid
     * @param null $uid
     */
    public function sendToAllUser($server,$type,$pid = null,$uid = null){
        // 获取 对应type 的data
        $data = $this->chat->getData($type,$uid);
        $data = json_encode($data);
        foreach($server->connections as $fd)
        {
            if($pid != $fd){
                $server->push($fd, $data);
            }
        }
    }

    public function getUser($token){
        echo "token=".$token;
        $jwt = $this->getUserByToken($token);
        $user = $jwt['data']['id'];
        return $user;
    }


    public function getUserByToken($token){
        echo $token;
        if($token == ""){
            throw new TokenException("抱歉，您还未登录！");
        }else{
            try{
                JWT::$leeway = 60;
                $token = JWT::decode($token,TOKEN,['HS256']);
                $arr = (array)$token;
                if ($arr['exp'] < time()) {
                    throw new TokenException('抱歉！您的Token已经失效！请重新登录');
                } else {
                    return $arr;
                }
            }catch (\Exception $e){
                throw new TokenException($e->getMessage());
            }
        }
    }
}
