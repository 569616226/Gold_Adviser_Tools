<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialContent extends Model
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'name','content','material_id' ];

    public function materials()
    {
        return $this->belongsTo('App\Models\Material', 'material_id', 'id');
    }

    /*材料清单模板部门*/
    public function material_templates()
    {
        return $this->belongsTo('App\Models\MaterialTemplate', 'material_template_id', 'id');
    }
}
