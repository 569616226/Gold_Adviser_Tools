<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiagSubcontent extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [ 'content', 'diag_mod_id', 'describle', 'suggest', 'law_id', ];

    /*诊断结果具体分析*/
    public function diag_submods()
    {
        return $this->belongsTo('App\Models\DiagSubmod', 'diag_submod_id', 'id');
    }

    /*法律法规*/
    public function laws(){
        return $this->belongsToMany('App\Models\Law','diag_subcontent_laws');
    }

}
