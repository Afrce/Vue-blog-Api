<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/3 0003
 * Time: 10:51
 */

namespace App\Models\Api;


use App\Models\Model;

class Key extends Model
{
    protected $table = "key";
    public $timestamps = false;
    protected $fillable = ['name','id'];
}
