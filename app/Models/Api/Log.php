<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/9 0009
 * Time: 17:03
 */

namespace App\Models\Api;


use App\Models\Model;

class Log extends Model
{
    protected $table = "logs";
    protected $fillable = ['id','ip','doWhat','result','created_at',"updated_at"];
}
