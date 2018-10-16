<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialTemplateName extends Model
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];
    protected $fillable = [ 'material_template_name','describle' ];

    /*项目*/
    public function items()
    {
        return $this->hasMany('App\Models\Item','material_template_name_id', 'id');
    }

    /*材料清单部门*/
    public function material_templates()
    {
        return $this->hasMany('App\Models\MaterialTemplate','material_template_name_id', 'id');
    }

}
