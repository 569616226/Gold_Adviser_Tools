<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\Admin\Request;

class CreateRequest extends Request
{

    public function rules()
    {
        return [
            'name'=>'required|max:20|alpha_dash',
            'address'=> 'required|max:255',
//            'code'=> 'required|size:10',
            'trade'=> 'required',
            'aeo'=> 'required',
            'trade_manual'=> 'required',
            'capital'=> 'required',
            'email'=> 'email',
            'create_date'=> 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '注册名称必须',
            'name.max' => '注册名称最多20个字符',
            'name.alpha_dash' => '用户仅允许字母、数字、破折号（-）以及底线（_）',
            'email.email' => '邮箱非法',
            'password.max' => '密码最多20个字符',
            'address.required' => '请输入地址',
            'address.max' => '地址最多255个字符',
            'code.required' => '请输入海关编码',
//            'code.size' => '海关编码最多10个字符',
//            'code.alpha_num' => '海关编码仅允许大写字母、数字',
            'trade.required' => '请选择贸易方式',
            'end_date.required' => '请选择成立日期',
            'aeo.required' => '请选择AEO认证',
            'trade_manual.required' => '请输入加工贸易手册',
            'capital.required' => '请输入注册资本',
            'create_date.required' => '请选择成立时期',
            'create_date.date' => '请输入正确的日期格式',

        ];
    }
}
