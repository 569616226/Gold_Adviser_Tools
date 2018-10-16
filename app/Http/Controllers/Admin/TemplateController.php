<?php

namespace App\Http\Controllers\Admin;

use App\Models\MaterialTemplateName;
use App\Http\Controllers\Controller as temController;

class TemplateController extends temController
{
    public function index()
    {
        $maters = MaterialTemplateName::with('material_templates.material_content_templates')->get();

        return view('admin.template.index',compact('maters'));
    }

}
