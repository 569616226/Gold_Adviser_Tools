<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiagSubmod extends Model
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
    public function diag_mods()
    {
        return $this->belongsTo('App\Models\DiagMod', 'diag_mod_id', 'id');
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
    public function diag_subcontents()
    {
        return $this->hasMany('App\Models\DiagSubcontent', 'diag_submod_id', 'id');
    }
}
