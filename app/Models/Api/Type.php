<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/3 0003
 * Time: 10:48
 */

namespace App\Models\Api;


use App\Models\Model;

class Type extends Model
{
    protected $table = "type";
    public $timestamps = false;
    protected $fillable = ['name','id','parent_id'];
}
