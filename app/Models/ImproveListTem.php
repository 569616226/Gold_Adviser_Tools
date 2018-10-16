<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImproveListTem extends Model
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'name','target', 'perform_type', 'remark', 'improve_list_tem_id', ];

    /*项目*/
    public function improve_title_tems()
    {
        return $this->belongsTo('App\Models\ImproveTitleTem', 'improve_title_tem_id', 'id');
    }

    /*实施计划*/
    public function improve_con_tems()
    {
        return $this->hasMany('App\Models\ImproveConTem', 'improve_list_tem_id', 'id');
    }
}
