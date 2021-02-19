<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', 'PagesController@root')->name('root');  //2.6-首页
/**
 * 3.1 运行 php artisan make:auth后会生成
 * Auth::routes() 和 Route::get('/home', 'HomeController@index')->name('home') 两个路由;
 * + Auth::routes() 是 Laravel 的用户认证路由，可以在 vendor/laravel/framework/src/Illuminate/Routing/Router.php 中搜索关
   键词 LoginController 即可找到定义的地方.
   + 由于我们已经定义了主页路由,就将 Route::get('/home', 'HomeController@index')->name('home') 删掉
 */
Auth::routes();
//Auth::routes()相当于一下 1234 4个部分的路由
// 1.用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// 2.用户注册相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//3.密码重置相关路由...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update'); //更改密码

// 4.Email 认证相关路由
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
//上面代码等同于以下三条:
Route::get('/users/{user}', 'UsersController@show')->name('users.show');      //显示用户个人信息页面
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit'); //显示编辑个人资料页面
Route::patch('/users/{user}', 'UsersController@update')->name('users.update'); //处理 edit 页面提交的更改

Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');
/**
 * URI 最后一个参数表达式 {slug?} , ? 意味着参数可选，这是为了兼容我们数据库中 Slug 为空的话题数据。
 * 这种写法可以同时兼容以下两种链接：
 * 1. http://larabbs.test/topics/115
 * 2. http://larabbs.test/topics/115/slug-translation-test
 */
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');

//Route::resource('replies', 'RepliesController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('replies', 'RepliesController', ['only' => [ 'store', 'destroy']]);

Route::resource('notifications', 'NotificationsController', ['only' => ['index']]); //消息通知列表

Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');
