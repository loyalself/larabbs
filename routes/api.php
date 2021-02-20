<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

/**
 * 我们增加了一个参数 namespace ，使 v1 版本的路由都会指向 App\Http\Controllers\Api
 */
$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api'
], function($api) {
    // 短信验证码
    $api->post('verificationCodes', 'VerificationCodesController@store')
        ->name('api.verificationCodes.store');

});
