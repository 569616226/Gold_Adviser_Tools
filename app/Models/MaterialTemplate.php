<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialTemplate extends Model
{

    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];
    protected $fillable = [ 'department','template_no','material_template_name_id' ];

    /*诊断结果具体分析*/
    public function material_content_templates()
    {
        return $this->hasMany('App\Models\MaterialContentTemplate','material_template_id', 'id');
    }

    /*材料清单模板*/
    public function material_template_names()
    {
        return $this->belongsTo('App\Models\MaterialTemplateName', 'material_template_name_id', 'id');
    }

    /*材料清单内容*/
    public function material_contents()
    {
        return $this->hasMany('App\Models\MaterialContent', 'material_template_id', 'id');
    }

}