<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/3 0003
 * Time: 10:56
 */

namespace App\Models\Api;


use App\Models\Model;
use App\Models\Api\Key;
use App\Models\Api\Type;
use Carbon\Carbon;

class Article extends Model
{
    protected $table = "article";
    protected $fillable = ['id','title','content','mdContent','content','key','type','created_at','updated_at','img'];

    public function getKeyAttribute($key)
    {
        $name = Key::query()->where('id',$key)->get()[0]->name;
        return $name;
    }

    public function getTypeAttribute($key)
    {
        $name = Type::query()->where('id',$key)->get()[0]->name;
        return $name;
    }

    public function getCreatedAtAttribute($date)
    {
        Carbon::setLocale("zh");
        if (Carbon::now() > Carbon::parse($date)->addDays(30)) {
            return Carbon::parse($date);
        }

        return Carbon::parse($date)->diffForHumans();
    }
}
