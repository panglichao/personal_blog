<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//前台路由组
Route::group(['namespace' => 'Home'], function(){
    // 控制器在 "App\Http\Controllers\Home" 命名空间下
    //别名register记得要加上不然报错
    Route::get('/', 'HomeController@index')->name('register');
    Route::get('/home', 'HomeController@index')->name('index');
});

//后台路由组
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function(){
    // 控制器在 "App\Http\Controllers\Admin" 命名空间下
    Route::group(['middleware' => 'auth'], function(){
        //主页
        Route::get('/', 'AdminController@index')->name('index');
        //基本资料
        Route::get('/user/index', 'UserController@index')->name('userIndex');
        //设置密码
        Route::get('/user/password', 'UserController@password')->name('userPassword');
        Route::post('/user/password', 'UserController@password')->name('userPassword');
        //栏目操作
        Route::get('/category/index', 'CategoryController@index')->name('categoryIndex');
        Route::get('/category/add', 'CategoryController@add')->name('categoryAdd');
        Route::post('/category/add', 'CategoryController@add')->name('categorySave');
        Route::get('/category/edit', 'CategoryController@edit')->name('categoryEdit');
        Route::post('/category/edit', 'CategoryController@edit')->name('categoryStore');
        Route::get('/category/del', 'CategoryController@del')->name('categoryDel');
        Route::post('/category/sort', 'CategoryController@sort')->name('categorySort');
        Route::post('/category/switch', 'CategoryController@switch')->name('categorySwitch');
        //文章操作
        Route::get('/article/index', 'ArticleController@index')->name('articleIndex');
        Route::get('/article/add', 'ArticleController@add')->name('articleAdd');
        Route::post('/article/add', 'ArticleController@add')->name('articleSave');
        Route::get('/article/edit', 'ArticleController@edit')->name('articleEdit');
        Route::post('/article/edit', 'ArticleController@edit')->name('articleStore');
        Route::get('/article/del', 'ArticleController@del')->name('articleDel');
        Route::post('/article/batchDel', 'ArticleController@batchDel')->name('articleBatchDel');
        Route::post('/article/switch', 'ArticleController@switch')->name('articleSwitch');
        Route::post('/article/batchSwitch', 'ArticleController@batchSwitch')->name('articleBatchSwitch');
        //标签操作
        Route::get('/tag/index', 'TagController@index')->name('tagIndex');
        Route::get('/tag/add', 'TagController@add')->name('tagAdd');
        Route::post('/tag/add', 'TagController@add')->name('tagSave');
        Route::get('/tag/edit', 'TagController@edit')->name('tagEdit');
        Route::post('/tag/edit', 'TagController@edit')->name('tagStore');
        Route::get('/tag/del', 'TagController@del')->name('tagDel');
        //友链操作
        Route::get('/link/index', 'LinkController@index')->name('linkIndex');
        Route::get('/link/add', 'LinkController@add')->name('linkAdd');
        Route::post('/link/add', 'LinkController@add')->name('linkSave');
        Route::get('/link/edit', 'LinkController@edit')->name('linkEdit');
        Route::post('/link/edit', 'LinkController@edit')->name('linkStore');
        Route::get('/link/del', 'LinkController@del')->name('linkDel');
        Route::post('/link/switch', 'LinkController@switch')->name('linkSwitch');
        //访客日志
        Route::get('/visit/index', 'VisitController@index')->name('visitIndex');
        Route::get('/visit/switch', 'VisitController@switch')->name('visitSwitch');
        //黑名单
        Route::get('/blackip/index', 'BlackIpController@index')->name('blackipIndex');
        Route::get('/blackip/add', 'BlackIpController@add')->name('blackipAdd');
        Route::get('/blackip/del', 'BlackIpController@del')->name('blackipDel');
        Route::post('/blackip/import', 'BlackIpController@import')->name('blackipImport');
    });
    Route::get('/login', 'LoginController@login')->name('login');
    Route::post('/login', 'LoginController@store')->name('login');
    Route::get('/logout', 'LoginController@destroy')->name('logout');
});