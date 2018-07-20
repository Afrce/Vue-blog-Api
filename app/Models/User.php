<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/26 0026
 * Time: 16:36
 */

namespace App\Models;
use App\Models\Model;

class User extends Model
{
    protected $table = "users";
    public $timestamps = false;
}
