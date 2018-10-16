<?php

namespace App\Http\Requests\Admin\Law;

use App\Http\Requests\Admin\Request;

class CreateRequest extends Request
{

    public function rules()
    {
        return [

            'name' => 'required|max:255',
            'title'=> 'required|max:255',

            'content'=> 'required',
        ];
    }

    public function messages()
    {
        return [

            'name.required' => '请输入法规条例名称',
            'name.max' => '法规条例名称最多255个字符',

            'title.required' => '请输入法规条例文号',
            'title.max' => '法规条例文号最多255个字符',

            'content.required' => '请输入法规条例内容',
            'title_no.required' => '请输入法规条例条号',
        ];
    }
}
