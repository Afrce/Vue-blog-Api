<?php
use NoahBuscher\Macaw\Macaw;
use App\Controllers\UserController;
Macaw::get('/test',function (){
    echo phpinfo();
});

Macaw::get('/',"App\Controllers\Api\IndexController@index");
Macaw::post('/getAllType',"App\Controllers\Api\IndexController@getAllType");

Macaw::post('/getAllKey',"App\Controllers\Api\IndexController@getAllKey");

Macaw::post('/getIndex',"App\Controllers\Api\IndexController@getIndex");
Macaw::post('/search',"App\Controllers\Api\IndexController@search");
Macaw::post('/getArticle',"App\Controllers\Api\IndexController@getArticle");

// admin API
Macaw::post('/admin/login',"App\Controllers\Api\AdminController@login");
Macaw::post('/admin/getTypes',"App\Controllers\Api\AdminController@getTypes");
Macaw::post('/admin/addType',"App\Controllers\Api\TypeController@addType");
Macaw::post('/admin/delType',"App\Controllers\Api\TypeController@delType");
Macaw::post('/admin/updateType',"App\Controllers\Api\TypeController@updateType");
Macaw::post('/admin/getLogs',"App\Controllers\Api\AdminController@getLogs");

Macaw::post('/admin/getKeys','App\Controllers\Api\KeyController@getKeys');
Macaw::post('/admin/delKey','App\Controllers\Api\KeyController@delKey');
Macaw::post('/admin/updateKey','App\Controllers\Api\KeyController@updateKey');
Macaw::post('/admin/addKey','App\Controllers\Api\KeyController@addKey');


Macaw::post('/admin/uploadImg','App\Controllers\Api\UploadController@uploadImg');
Macaw::post('/admin/uploadMd','App\Controllers\Api\UploadController@uploadMd');

Macaw::post('/admin/getArticles','App\Controllers\Api\ArticleController@getArticles');
Macaw::post('/admin/delArticle','App\Controllers\Api\ArticleController@delArticle');
Macaw::post('/admin/getArtInfo','App\Controllers\Api\ArticleController@getArtInfo');
Macaw::post('/admin/updateArt','App\Controllers\Api\ArticleController@updateArt');
Macaw::post('/admin/getList','App\Controllers\Api\ArticleController@getList');

Macaw::dispatch();
?>
