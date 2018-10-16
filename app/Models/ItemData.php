<?php
/*
 * 项目附件审核资料
 * */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemData extends Model
{

    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'content', 'item_id', 'admin_user_id', ];

    /**
     *
     * Get all of the video's comments.
     */
    public function tasks()
    {
        return $this->morphMany('App\Models\Task', 'tasktable');
    }

    public function items()
    {
        return $this->belongsTo('App\Models\Item', 'item_id', 'id');
    }

}
