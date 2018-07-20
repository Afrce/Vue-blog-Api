<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/10 0010
 * Time: 16:43
 */

namespace App\Controllers\Api;


use App\Controllers\Controller;
use App\Models\Api\Type;

class TypeController extends Controller
{
    /**
     * addType
     * 2018/7/10 0010
     * @author CL
     */
   public function addType()
   {
       parseToken();
       $data = [
           'parent_id' => 0,
           "name"      => $_REQUEST['name']
       ];
       $res = Type::query()->create($data);
       $ip = getUserIp();
       if($res){
           setApiLog($ip,"新增Type name: ".$_REQUEST['name'],'成功！');
           echo self::responseJson($res->toArray(),1,"添加成功！");
       }else{
           setApiLog($ip,"新增Type",'添加失败！');
           echo self::responseJson([],0,"添加失败！");
       }
   }

   public function delType()
   {
       parseToken();
       $id = $_REQUEST['id'];
       $res = Type::query()->find($id)->delete();
       $ip = getUserIp();
       if($res){
           setApiLog($ip,"删除Type name: ".$_REQUEST['name'],'删除成功！');
           echo self::responseJson([],1,"删除成功！");
       }else{
           setApiLog($ip,"删除Type",'删除失败！');
           echo self::responseJson([],0,"删除失败！");
       }
   }

    public function updateType()
    {
        parseToken();
        $id = $_REQUEST['id'];
        $Type = Type::query()->find($id);
        $Type -> name = $_REQUEST['name'];
        $res = $Type -> save();
        $ip = getUserIp();
        if($res){
            setApiLog($ip,"更新Type,id:".$id."name:".$_REQUEST['name'],'更新成功！');
            echo self::responseJson([],1,"更新成功！");
        }else{
            setApiLog($ip,"更新Type id:".$id."name:".$_REQUEST['name'],'更新失败！');
            echo self::responseJson([],0,"更新失败！");
        }
    }
}
