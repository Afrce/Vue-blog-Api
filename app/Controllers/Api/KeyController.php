<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/10 0010
 * Time: 16:43
 */

namespace App\Controllers\Api;


use App\Controllers\Controller;
use App\Models\Api\Key;

class KeyController extends Controller
{
    public function getKeys(){
        if(parseToken()){
            $data = Key::query()->orderBy('id',"DESC")->paginate('15', ['*'],'page',$_REQUEST['page']);
            echo self::responseJson($data,1,"");
        }
    }

    public function addKey(){
        parseToken();
        $data = [
            'parent_id' => 0,
            "name"      => $_REQUEST['name']
        ];
        $res = Key::query()->create($data);
        $ip = getUserIp();
        if($res){
            setApiLog($ip,"新增Key name: ".$_REQUEST['name'],'成功！');
            echo self::responseJson($res->toArray(),1,"添加成功！");
        }else{
            setApiLog($ip,"新增Key",'添加失败！');
            echo self::responseJson([],0,"添加失败！");
        }
    }

    public function delKey(){
        parseToken();
        $id = $_REQUEST['id'];
        $res = Key::query()->find($id)->delete();
        $ip = getUserIp();
        if($res){
            setApiLog($ip,"删除Key name: ".$_REQUEST['name'],'删除成功！');
            echo self::responseJson([],1,"删除成功！");
        }else{
            setApiLog($ip,"删除Key",'删除失败！');
            echo self::responseJson([],0,"删除失败！");
        }
    }


    public function updateKey()
    {
        parseToken();
        $id = $_REQUEST['id'];
        $Type = Key::query()->find($id);
        $Type -> name = $_REQUEST['name'];
        $res = $Type -> save();
        $ip = getUserIp();
        if($res){
            setApiLog($ip,"更新Key,id:".$id."name:".$_REQUEST['name'],'更新成功！');
            echo self::responseJson([],1,"更新成功！");
        }else{
            setApiLog($ip,"更新Key id:".$id."name:".$_REQUEST['name'],'更新失败！');
            echo self::responseJson([],0,"更新失败！");
        }
    }

}
