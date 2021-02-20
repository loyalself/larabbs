<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class VerificationCodeRequest extends FormRequest
{
    public function authorize()
    {
        //return false; //default value
        return true;
    }


    public function rules()
    {
       /* return [
            'phone' => [
                'required',
                'regex:/^[1][3,4,5,7,8][0-9]{9}$/',
                'unique:users'
            ]
        ];*/
        return [
            'captcha_key' => 'required|string',
            'captcha_code' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'captcha_key' => '图片验证码 key',
            'captcha_code' => '图片验证码',
        ];
    }
}
