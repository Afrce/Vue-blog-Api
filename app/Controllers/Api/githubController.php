<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/28 0028
 * Time: 13:39
 */

namespace App\Controllers\Api;


use App\Controllers\Controller;
use Predis\Client;
use GuzzleHttp\Psr7\Request;
use Overtrue\Pinyin\Pinyin;

class githubController extends Controller
{
    public function getTrending(){
        $day = $_REQUEST['day'];
        $lan = $_REQUEST['lan'];
        $lanArr = ["","PHP","Vue","JS","C++","C#","JAVA","Python"];
        $dayArr = ['daily','weekly','monthly'];
        $buck = $dayArr[$day] . $lanArr[$lan];
        $client = new Client(config('redis'));
        $data = $client->hget($buck,$buck);
        $data = json_decode($data,true);
        echo self::responseJson($data,true,"");
    }

    public function search(){
        $project = $_POST['projectName'];
        $page = $_POST['page'];
        $project = urlencode($project);
        $url = "https://api.github.com/search/repositories?q=".$project."&sort=stars&order=desc&page=".$page;
        $header = [
            "Accept" => "application/vnd.github.mercy-preview+json"
        ];
        $client = new \GuzzleHttp\Client();
        $request = new Request("GET",$url,$header);
        $response = $client->send($request,['timeout'=>30]);
        if($response->getStatusCode() == "200"){
            $data = json_decode($response->getBody()->getContents(),true);
            echo self::responseJson($data,true,"");
        }else{
            echo self::responseJson("",false,"查询失败");
        }
    }
}
