<?php
use Illuminate\Support\Facades\Route;


Route::get('/', 'PagesController@root')->name('root');  //2.6-首页
