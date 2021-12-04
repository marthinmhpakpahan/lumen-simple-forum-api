<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/user/register', 'UserController@register');
$router->post('/user/login', 'UserController@login');
$router->get('/user/show/{id}', 'UserController@show');
$router->post('/user/update/', 'UserController@update');
$router->post('/topic/create', 'TopicController@create');
$router->post('/topic/update', 'TopicController@update');
$router->get('/topic/', 'TopicController@index');
$router->get('/topic/show/{id}', 'TopicController@show');
$router->delete('/topic/delete/{id}', 'TopicController@delete');
$router->put('/topic/activate/{id}', 'TopicController@activate');
$router->post('/comment/create', 'CommentController@create');
$router->get('/comment/{id}', 'CommentController@index');
$router->delete('/comment/delete/{id}', 'CommentController@delete');