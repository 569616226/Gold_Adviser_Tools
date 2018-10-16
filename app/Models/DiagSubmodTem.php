<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiagSubmodTem extends Model
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'name', 'content', 'diag_mod_id', 'discrible', 'suggest', 'law_id', ];

    /*诊断结果具体分析*/
    public function diag_mod_tems()
    {
        return $this->belongsTo('App\Models\DiagModTem', 'diag_mod_tem_id', 'id');
    }

    /**
     *任务
     * Get all of the video's comments.
     */
    public function tasks()
    {
        return $this->morphMany('App\Models\Task', 'tasktable');
    }

    /*诊断结果具体分析内容*/
    public function diag_subcontent_tems()
    {
        return $this->hasMany('App\Models\DiagSubcontentTem', 'diag_submod_tem_id', 'id');
    }
}
