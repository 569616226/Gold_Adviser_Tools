<?php

namespace App\Http\Requests\Admin\Law;

use App\Http\Requests\Admin\Request;

class UpdateRequest extends Request
{

    public function rules()
    {
        return [

            'name' => 'required|max:255|',
            'title_no'=>'required',
            'content'=> 'required',
        ];
    }

    public function messages()
    {
        return [

            'name.required' => '请输入法规条例名称',
            'name.max' => '法规条例名称最多255个字符',
//            'name.alpha_dash' => '法规条例名称仅允许字母、数字、破折号（-）以及底线（_）',
            'content.required' => '请输入法规条例内容',
            'title_no.required' => '请输入法规条例条号',
//            'title_no.numeric' => '法规条例条号必须是数字',
];
    }
}
