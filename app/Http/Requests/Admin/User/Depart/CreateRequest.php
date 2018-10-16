<?php

namespace App\Http\Requests\Admin\User\Depart;

use App\Http\Requests\Admin\Request;

class CreateRequest extends Request
{

    public function rules()
    {
        return [
            'username' => 'required|max:20|alpha_dash|unique:user_departs,username',
            'name' => 'required|max:20|alpha_dash',
            'password' => 'required|min:6|max:20',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '用户姓名必须',
            'name.max' => '用户姓名最多20个字符',
            'name.alpha_dash' => '用户仅允许字母、数字、破折号（-）以及底线（_）',
            'username.alpha_dash' => '用户仅允许字母、数字、破折号（-）以及底线（_）',
            'username.max' => '用户名称最多20个字符',
            'username.unique' => '该用户名称已存在',
            'username.required' => '用户名称必须',
            'pasword.required' => '密码必须',
            'password.min' => '密码最少6个字符',
            'password.max' => '密码最多20个字符'
        ];
    }
}