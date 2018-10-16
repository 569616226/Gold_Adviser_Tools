<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Law extends Model
{

    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'content', 'title', 'name', 'title_no' ];

    /*诊断子模块内容*/
    public function diag_subcontents()
    {
        return $this->belongsToMany('App\Models\DiagSubcontent', 'diag_subcontent_laws');
    }

    /*诊断子模块内容*/
    public function diag_subcontent_tems()
    {
        return $this->belongsToMany('App\Models\DiagSubcontentTem', 'diag_subcontent_tem_laws');
    }



}
