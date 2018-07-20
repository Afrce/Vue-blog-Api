<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/10 0010
 * Time: 9:39
 */

namespace App\Controllers\Api;


use App\Controllers\Controller;
use App\Exception\TokenException;
use App\Models\Api\Log;
use App\Models\Api\Type;
use App\Models\Api\User;
use Firebase\JWT\JWT;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function login()
    {
        $name = $_REQUEST['username'];
        $user = User::query()->where('name',$name)->first();
        $pwd = $user->password;
        $relPwd = md5(md5($_REQUEST['password']) . $user->sha1);
        $ip = getUserIp();
        if($pwd == $relPwd){
            $data = [
                'id' => $user->id,
                'username' => $name
            ];
            $token = $this->makeToken($data);

            $user->login_ip = $ip;
            $user->save();
            setApiLog($ip,"登录",'登录成功！');
            echo self::responseJson($token,1,"");
        }else{
            setApiLog($ip,'登录后台',"账号密码错误！");
            echo self::responseJson([],0,"账号密码错误！");
        }
    }

    /**
     * makeToken
     * 2018/7/10 0010
     * @author CL
     * @param array $data
     * @return string
     */
    private function makeToken(array $data)
    {
        $array = [
            'iss' => 'http://api.sahulula.club', //签发者
            'aud' => 'http://www.sahulula.club', //jwt所面向的用户
            'iat' => time(), //签发时间
            'nbf' => time() + 10, //在什么时间之后该jwt才可用
            'exp' => time() + 3600,
            'data' => $data
        ];
        $token = JWT::encode($array,TOKEN);
        $res = [
            'exp' => $array['exp'],
            "token" => $token
        ];
        return $res;
    }

    public function getTypes()
    {
        if(parseToken()){
            $data = Type::query()->orderBy('id',"DESC")->paginate('20');
            echo self::responseJson($data,1,"");
        }
    }

    public function getLogs()
    {
        if(parseToken()){
            $data = Log::query()->orderBy('id',"DESC")->paginate('15', ['*'],'page',$_REQUEST['page']);
            echo self::responseJson($data,1,"");
        }
    }

}
