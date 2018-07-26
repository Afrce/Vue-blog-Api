<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/10 0010
 * Time: 16:43
 */

namespace App\Controllers\Api;


use App\Controllers\Controller;
use App\Models\Api\Article;
use App\Models\Api\Key;
use App\Models\Api\Type;

class ArticleController extends Controller
{
    public function getArticles(){
        parseToken();
        $data = Article::query()->orderBy('id',"DESC")->paginate('15', ['*'],'page',$_REQUEST['page']);
        echo self::responseJson($data,1,"");
    }

    public function delArticle(){
        parseToken();
        $id = $_REQUEST['id'];
        $art = Article::query()->find($id);
        $title = $art->first()->title;
        $res = $art->delete();
        $ip = getUserIp();
        if($res){
            setApiLog($ip,"删除文章 title: ".$title,'删除成功！');
            echo self::responseJson([],1,"删除成功！");
        }else{
            setApiLog($ip,"删除文章",'删除失败！');
            echo self::responseJson([],0,"删除失败！");
        }
    }


    public function getArtInfo(){
        parseToken();
        $id = $_REQUEST['id'];
        $res1= Article::query()->where('id',$id)->first();
        $res = $res1->toArray();
        $res['key'] = ($res1->getOriginal('key')) * 1;
        $res['type'] = ($res1->getOriginal('type')) * 1;
        echo self::responseJson($res,1,"");
    }

    public function getList(){
        parseToken();
        $type = Type::query()->get(['id','name']);
        $key = Key::query()->get(['id','name']);
        $data = [
            'type' => $type->toArray(),
            'key'  => $key->toArray()
        ];
        echo self::responseJson($data,1,"");
    }

    public function updateArt(){
        parseToken();
        $id = $_REQUEST['id'];
        $data = [
            'title' => $_REQUEST['title'],
            "type"  => $_REQUEST['type'],
            "key"   => $_REQUEST['key'],
            "content" => $_REQUEST['content'],
            "mdContent" => $_REQUEST['mdContent'],
            'img'  => $_REQUEST['img']
        ];
        $ip = getUserIp();
        if($id == 0){
            $Art = new Article();
            $Art->title =  $_REQUEST['title'];
            $Art->type = $_REQUEST['type'];
            $Art->key = $_REQUEST['key'];
            $Art->content = $_REQUEST['content'];
            $Art->mdContent = $_REQUEST['mdContent'];
            $Art->img = $_REQUEST['img'];
            $res = $Art->save();
            if($res){
                setApiLog($ip,"新增文章 title: ". $_REQUEST['title'],'新增文章成功！');
                echo self::responseJson([],1,"新增文章成功！");
            }else{
                setApiLog($ip,"新增文章",'新增文章失败！');
                echo self::responseJson([],0,"新增文章失败！");
            }
        }else{
            $res = Article::query()->find($id)->update($data);
            if($res){
                setApiLog($ip,"更新文章 title: ". $_REQUEST['title'],'更新成功！');
                echo self::responseJson([],1,"删除成功！");
            }else{
                setApiLog($ip,"更新文章",'更新失败！');
                echo self::responseJson([],0,"更新失败！");
            }
        }
    }
}
