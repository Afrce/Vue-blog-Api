<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/3 0003
 * Time: 11:05
 */

namespace App\Controllers\Api;


use App\Controllers\Controller;
use App\Models\Api\Article;
use App\Models\Api\Key;
use App\Models\Api\Type;

class IndexController extends Controller
{
    public function index()
    {
        $type = Type::all()->toArray();
        $article = Article::query()->orderBy("created_at","DESC")->paginate(15);
        $data['type'] = $type;
        $data['art'] = $article;
        echo "<pre>";
        dd($data);
        echo self::responseJson($data,1,"");
    }

    public function getAllType()
    {
        $type =  Type::all()->toArray();
        echo self::responseJson($type,1,"");
    }

    public function getAllKey()
    {
        $key = Key::all()->toArray();
        echo self::responseJson($key ,1 ,"");
    }

    public function getIndex()
    {
        $type = $_REQUEST['type'];
        $art = Article::query();
        if($type){
            $art = $art->where('type', $type);
        }
        $art = $art->orderBy('created_at','DESC')->paginate(15);
        echo self::responseJson($art, 1, "");
    }

    public function search()
    {
        $keyWord = $_REQUEST['keyWord'];
        $art = Article::query()
            ->where('title','like','%'.$keyWord.'%')
            ->orderBy('created_at',"DESC")
            ->paginate(15);
        echo self::responseJson($art, 1, "");
    }
    public function getArticle()
    {
        $id = $_REQUEST['id'];
        $art = Article::query()->where('id',$id)->get();
        echo self::responseJson($art, 1, "");
    }
}
