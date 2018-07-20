<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/27 0027
 * Time: 16:31
 */

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Models\User;
use Zend\Http\Request;

class UserController extends Controller
{
    private $userRepository = null;

    function __construct()
    {
        $this->userRepository = UserRepository::class;
    }

    public function show()
    {
        $request = new Request();
        $page = $request;
        dd($page);
    }
}
