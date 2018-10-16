<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suggest extends Model
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'remark','task_id', 'service_remark', 'content', 'score', 'user_id' ,'active'];

    /*任务*/
    public function tasks()
    {
        return $this->belongsTo('App\Models\Task', 'task_id', 'id');
    }


    /*服务反馈表*/
    public function advises()
    {
        return $this->hasMany('App\Models\Advise','suggest_id','id');
    }

}
