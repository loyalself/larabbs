<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    protected $content;

    public function rules()
    {
        return [
            'content' => 'required|min:2',
        ];
    }

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
