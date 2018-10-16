<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImproveCon extends Model
{

    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'content', 'improve_list_id' ];

    /**
     *
     * Get all of the video's comments.
     */
    public function tasks()
    {
        return $this->morphMany('App\Models\Task', 'tasktable');
    }

    /*项目*/
    public function improve_lists()
    {
        return $this->belongsTo('App\Models\ImproveListTem', 'improve_list_id', 'id');
    }
}
