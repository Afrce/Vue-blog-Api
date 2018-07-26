<?php
return [

    'driver'    => 'mysql',

    'host'      => env('DB_IP'),

    'database'  => env("DB_DATABASE"),

    'username'  => env("DB_USERNAME"),

    'password'  => env("DB_PWD"),

    'port'     => env("DB_PORT"),

    'charset'   => 'utf8mb4',

    'collation' => 'utf8mb4_general_ci',

    'prefix'    => ''

];


?>
