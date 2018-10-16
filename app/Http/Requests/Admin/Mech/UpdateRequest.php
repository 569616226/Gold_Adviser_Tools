<?php

namespace App\Http\Requests\Admin\Mech;

use App\Http\Requests\Admin\Request;

class UpdateRequest extends Request
{

    public function rules()
    {
        return [

            'address' =>'required|max:255|alpha_dash',
            'zip_code' =>'string|size:6',
            'super'=>'required|max:20|alpha_dash',
//            'super_tel'=>'required|string|size:11',
            'verify_team' => 'required|max:20|alpha_dash',
            'email' => 'required|email',
            'master'=>'required|max:20|alpha_dash',
//            'master_tel' => 'required|string|size:11',
        ];
    }

    public function messages()
    {
        return [
            'super_tel.required' => '请输入法规条序号',
            'super_tel.numeric' => '序号必须是数字',
            'master_tel.required' => '请输入法规条序号',
            'master_tel.numeric' => '序号必须是数字',
            'verify_team.required' => '请输入机构名称',
            'verify_team.max' => '机构名称最多20个字符',
            'verify_team.alpha_dash' => '机构名称仅允许字母、数字、破折号（-）以及底线（_）',
            'master.required' => '请输入负责人名称',
            'master.max' => '负责人名称最多20个字符',
            'master.alpha_dash' => '负责人名称仅允许字母、数字、破折号（-）以及底线（_）',
            'super.required' => '请输入项目督导名称',
            'super.max' => '项目督导名称最多20个字符',
            'super.alpha_dash' => '项目督导名称仅允许字母、数字、破折号（-）以及底线（_）',
            'address.required' => '请输入地址',
            'address.max' => '地址最多20个字符',
            'address.alpha_dash' => '地址仅允许字母、数字、破折号（-）以及底线（_）',
            'eamil.required' => '请输入eamil',
            'eamil.eamil' => '请输入正确的eamil格式',
    ];
    }
}
