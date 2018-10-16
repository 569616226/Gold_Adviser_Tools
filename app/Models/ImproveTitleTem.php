<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImproveTitleTem extends Model
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at', 'start_date', 'end_date' ];

    protected $fillable = [ 'name','item_id', 'start_date', 'end_date'];

    /*项目*/
    public function items()
    {
        return $this->belongsTo('App\Models\Item', 'item_id', 'id');
    }

    /*实施计划*/
    public function improve_list_tems()
    {
        return $this->hasMany('App\Models\ImproveListTem', 'improve_title_tem_id', 'id');
    }

}
