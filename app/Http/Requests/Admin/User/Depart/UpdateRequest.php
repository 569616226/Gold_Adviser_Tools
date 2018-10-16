<?php

namespace App\Http\Requests\Admin\User\Depart;

use App\Http\Requests\Admin\Request;

class UpdateRequest extends Request
{

    public function rules()
    {
        return [

            'password' => 'min:6|max:20',
        ];
    }

    public function messages()
    {
        return [
            'password.min' => '密码最少6个字符',
            'password.max' => '密码最多20个字符'
        ];
    }
}
