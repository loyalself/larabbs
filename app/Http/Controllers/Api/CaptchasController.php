<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CaptchaRequest;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request,CaptchaBuilder $captchaBuilder){
        $key = 'captcha-'.str_random(15);
        $phone = $request->phone;
        $captcha = $captchaBuilder->build();        //创建出验证码图片
        $expiredAt = now()->addMinutes(2);    //2分钟过期
        Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt); //使用 getPhrase 方法获取验证码文本
        $result = [
            'captcha_key'           => $key,
            'expired_at'            => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()               //inline 方法获取的base64 图片验证码
        ];
        return $this->response->array($result)->setStatusCode(201);
    }
}
