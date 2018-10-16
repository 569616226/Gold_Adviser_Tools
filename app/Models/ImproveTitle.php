<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImproveTitle extends Model
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' , 'start_date', 'end_date'];

    protected $fillable = [ 'name','item_id', 'start_date', 'end_date' ];

    /*项目*/
    public function items()
    {
        return $this->belongsTo('App\Models\Item', 'item_id', 'id');
    }

    /*实施计划*/
    public function improve_cons()
    {
        return $this->hasMany('App\Models\ImproveConTem', 'improve_list_tem_id', 'id');
    }
}
