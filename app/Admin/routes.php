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

    $router->resource('category', 'CategoryController');
    $router->resource('knowledge', 'KnowledgeController');
    $router->resource('question', 'QuestionController');
});
