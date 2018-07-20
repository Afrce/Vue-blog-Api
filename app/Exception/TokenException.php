<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/10 0010
 * Time: 11:21
 */

namespace App\Exception;


use Throwable;

class TokenException extends \Exception
{
    public function __construct($message = "")
    {
        parent::__construct($message);
    }
}
