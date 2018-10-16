<?php

namespace App\Http\Requests\Admin\AdminUser;

use App\Http\Requests\Admin\Request;

class UpdateRequest extends Request
{

    public function rules()
    {
        return [

            'name' => 'required|max:20|alpha_dash',
            'email' => 'email|',
            'password' => 'min:6|max:20',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '用户姓名必须',
            'name.max' => '用户姓名最多20个字符',
            'name.alpha_dash' => '用户仅允许字母、数字、破折号（-）以及底线（_）',
            'email.email' => '邮箱非法',
            'tel.required' => '请输入手机号码',
            'password.min' => '密码最少6个字符',
            'password.max' => '密码最多20个字符'
        ];
    }
}
