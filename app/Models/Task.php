<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at','start_date','end_date','daly_date'];


    protected $fillable = [ 'title', 'status', 'start_date', 'end_date', 'level', 'daly_date', 'admin_user_id', 'tasktable_id', 'tasktable_type' ,'task_no'];

    /**
     * 任务
     * Get all of the owning commentable models.
     */
    public function taskable()
    {
        return $this->morphTo();
    }

    /*任务负责人*/
    public function admin_users()
    {
        return $this->belongsTo('App\Models\AdminUser', 'admin_user_id', 'id');
    }

    /*服务评价*/
    public function suggests()
    {
        return $this->hasOne('App\Models\Suggest', 'task_id', 'id');
    }

    /*客户*/
    public function items()
    {
        return $this->belongsTo('App\Models\Item', 'item_id', 'id');
    }
}
