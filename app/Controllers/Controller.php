<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/26 0026
 * Time: 16:38
 */

namespace App\Controllers;


class Controller
{
    /**
     * 接口返回数据格式
     * responseJson
     * 2018/6/26 0026
     * @author CL
     * @param $data
     * @param $status
     * @param $msg
     * @return string
     */
    static public function responseJson($data,$status,$msg)
    {
        $ret = [
            'data' => $data,
            'status' => $status,
            "msg"    => $msg,
        ];
        return json_encode($ret);
    }
}
