<?php

namespace App\Http\Requests\Admin\Material;

use App\Http\Requests\Admin\Request;

class UpdateRequest extends Request
{

    public function rules()
    {
        return [
            'department' => 'required|max:20|alpha_dash',
        ];
    }

    public function messages()
    {
        return [
            'department.required' => '请输入清单部门名称',
            'department.max' => '清单部门最多20个字符',
            'department.alpha_dash' => '清单部门仅允许字母、数字、破折号（-）以及底线（_）',
        ];
    }
}
