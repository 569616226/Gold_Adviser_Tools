<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiagModTem extends Model
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
        return $this->belongsToMany('App\Models\Item', 'diag_mod_tem_item');
    }

    /*诊断结果具体分析内容*/
    public function diag_submod_tems()
    {
        return $this->hasMany('App\Models\DiagSubmodTem', 'diag_mod_tem_id', 'id');
    }
}
