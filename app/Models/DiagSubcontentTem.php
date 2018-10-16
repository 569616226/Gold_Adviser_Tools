<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiagSubcontentTem extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [ 'content', 'diag_mod_id', 'describle', 'suggest', 'law_id', ];

    /*诊断结果具体分析*/
    public function diag_submod_tems()
    {
        return $this->belongsTo('App\Models\DiagSubmodTem', 'diag_submod_tem_id', 'id');
    }

    /*法律法规*/
    public function laws(){
        return $this->belongsToMany('App\Models\Law','diag_subcontent_tem_laws');
    }
}
