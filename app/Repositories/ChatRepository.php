<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/27 0027
 * Time: 14:33
 */

namespace App\Repositories;

use App\Models\weChat\ChatUser;
class ChatRepository
{
    public function getData($type,$uid,$msg=""){
        $data = [];
        echo "uid: ".$type;
        if($uid){
            $user = ChatUser::query()->where('id',$uid)->first()->name;
        }
        switch ($type){
            case 1:// 加入
                $data = [
                    'code' => ADD_CODE,
                    "msg"  => sprintf(ADD_MSG,$user)
                ];
                break;
            case 2:// 退出
                $data = [
                    "code" => EXIT_CODE,
                    "msg"  => sprintf(EXIT_MSG,$user)
                ];
                break;
            default: // 广播
                $data = [
                    "code" => ALL_CODE,
                    "msg"  => $msg
                ];
                break;
        }
        var_dump($data);
        return $data;
    }
}
