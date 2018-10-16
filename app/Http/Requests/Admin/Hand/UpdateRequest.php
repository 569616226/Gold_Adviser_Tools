<?php

namespace App\Http\Requests\Admin\Hand;

use App\Http\Requests\Admin\Request;

class UpdateRequest extends Request
{

    public function rules()
    {
        return [

            'handover_no'=>'required|max:20|alpha_dash',
            'end_time'=> 'required',
            'description'=> 'required',
            'mech_id'=> 'required',

        ];
    }

    public function messages()
    {
        return [
            'handover_no.required' => '请输入合同编号',
            'handover_no.max' => '合同编号最多20个字符',
            'handover_no.alpha_dash' => '合同编号仅允许字母、数字、破折号（-）以及底线（_）',
            'end_time.required' => '请输入项目有效期',
            'description.required' => '请输入项目描述',
            'mech_id.required' => '请选择审核机构',
        ];
    }
}
