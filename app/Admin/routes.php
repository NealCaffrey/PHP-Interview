<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('/api/category_list', 'CategoryController@categoryList');
    $router->get('/api/type_list', 'QuestionTypeController@typeList');
    //面试库
    $router->resource('category', 'CategoryController');
    $router->resource('knowledge', 'KnowledgeController');
    $router->resource('question', 'QuestionController');
    //会员管理
    $router->resource('user', 'UserController');
    $router->resource('browse', 'BrowseController');
    $router->resource('collection', 'CollectionController');
    $router->resource('points', 'PointsController');
    $router->resource('sign', 'SignController');
    //小程序
    $router->resource('version', 'VersionController');
    $router->resource('help', 'HelpController');
});
