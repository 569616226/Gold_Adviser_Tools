<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\Admin\Request;

class UpdateRequest extends Request
{

    public function rules()
    {
        return [
            'address'=> 'required|max:255',
//            'code'=> 'required|size:10',
            'trade'=> 'required',
//            'end_date'=> 'required',
            'aeo'=> 'required',
            'trade_manual'=> 'required',
            'capital'=> 'required',
//            'tel'=> 'required|string|size:11',
            'email'=> 'email',
            'create_date'=> 'required|date',
        ];
    }

    public function messages()
    {
        return [

            'email.email' => '邮箱非法',
            'address.required' => '请输入地址',
            'address.max' => '地址最多255个字符',
            'code.required' => '请输入海关编码',
            'trade.required' => '请选择贸易方式',
            'end_date.required' => '请选择成立日期',
//            'code.size' => '海关编码最多10个字符',
//            'code.alpha_num' => '海关编码仅允许大写字母、数字',
            'trade_manual.required' => '请输入加工贸易手册',
            'capital.required' => '请输入注册资本',
            'company_type.required' => '请选择企业性质类型',
            'create_date.required' => '请选择成立时期',
            'create_date.date' => '请输入正确的日期格式',
        ];
    }
}
