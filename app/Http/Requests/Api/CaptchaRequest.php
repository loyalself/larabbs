<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CaptchaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
           'phone' => 'required|regex:/^[1][3,4,5,7,8][0-9]{9}$/'
        ];
    }
}
