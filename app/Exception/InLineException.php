<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/27 0027
 * Time: 14:16
 */

namespace App\Exception;


class InLineException extends \Exception
{
    public function __construct($message = "")
    {
        parent::__construct($message);
    }
}
