<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiagMod extends Model
{

    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'name', 'item_id', 'fid' ];

    /*项目*/
    public function items()
    {
        return $this->belongsTo('App\Models\Item', 'item_id', 'id');
    }

    /*诊断结果具体分析内容*/
    public function diag_submods()
    {
        return $this->hasMany('App\Models\DiagSubmod', 'diag_mod_id', 'id');
    }
}
