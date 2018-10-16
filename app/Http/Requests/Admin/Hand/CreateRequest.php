<?php

namespace App\Http\Requests\Admin\Hand;

use App\Http\Requests\Admin\Request;

class CreateRequest extends Request
{

    public function rules()
    {
        return [

            'handover_no'=>'required|max:20|alpha_dash',
            'name'=>'required|max:20|alpha_dash|unique:hands,name',
            'end_time'=> 'required',
            'description'=> 'required',
            'mech_id'=> 'required',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => '请输入项目名称',
            'name.max' => '项目名称最多20个字符',
            'name.alpha_dash' => '项目名称仅允许字母、数字、破折号（-）以及底线（_）',
            'name.unique' => '项目名称已经存在',
            'handover_no.required' => '请输入合同编号',
            'handover_no.max' => '合同编号最多20个字符',
            'handover_no.alpha_dash' => '合同编号仅允许字母、数字、破折号（-）以及底线（_）',
            'end_time.required' => '请输入项目有效期',
            'description.required' => '请输入项目描述',
            'mech_id.required' => '请选择审核机构',
        ];
    }
}
