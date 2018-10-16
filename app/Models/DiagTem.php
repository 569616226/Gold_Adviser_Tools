<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiagTem extends Model
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'title', 'content', 'item_id', ];

    /**
     *任务
     * Get all of the video's comments.
     */
    public function tasks()
    {
        return $this->morphMany('App\Models\Task', 'tasktable');
    }

    /*项目*/
    public function items()
    {
        return $this->belongsToMany('App\Models\Item', 'diag_tem_item');
    }

}
