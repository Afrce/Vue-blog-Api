<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/18 0018
 * Time: 15:06
 */

namespace App\Controllers\Api;


use App\Controllers\Controller;
use Couchbase\Exception;

class UploadController extends Controller
{
    /**
     * uploadImg 上传图片
     * 2018/7/18 0018
     * @author CL
     */
    public function uploadImg(){
        $allowUploadArr = ['gif','jepg','img','png','jpg'];
        $temp = $_FILES['file']['name'];
        $exInfo = end(explode('.',$temp));
        if(!in_array($exInfo,$allowUploadArr)) {
            throw  new \Exception("抱歉！上传的文件不是图片！");
        }
        if(file_exists(__DIR__."/../../../upload/image/" . $temp)){
            throw new \Exception('抱歉！相同名称的图片已存在！');
        }
        $url = "/upload/image/" . $temp;
        $data['imgUrl'] = $url;
        try{
            move_uploaded_file($_FILES["file"]["tmp_name"], __DIR__."/../../../upload/image/" . $temp);
            echo self::responseJson($data,1,'');
        }catch (\Exception $exception){
            echo self::responseJson([],0,$exception->getMessage());
        }
    }

    public function uploadMd(){
        $temp = $_FILES['file']['name'];
        $exInfo = end(explode('.',$temp));
        if($exInfo != 'md') {
            throw  new \Exception("抱歉！上传的文件不是md文件！");
        }
//        if(file_exists(__DIR__."/../../../upload/md/" . $temp)){
//            throw new \Exception('抱歉！相同名称的md文件已存在！');
//        }
        $url = "/upload/md/" . $temp;
        $data['mdUrl'] = $url;
        $data['content'] = file_get_contents($_FILES['file']['tmp_name']);
        try{
            move_uploaded_file($_FILES["file"]["tmp_name"], __DIR__."/../../../upload/md/" . $temp);
            echo self::responseJson($data,1,'');
        }catch (\Exception $exception){
            echo self::responseJson([],0,$exception->getMessage());
        }
    }

}
