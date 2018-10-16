<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advise extends Model
{

    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at','plan_date' ];

    protected $fillable = ['titel','content','plan_date','suggest_id'];

    /*服务反馈表*/
    public function suggests()
    {
        return $this->belongsTo('App\Models\Suggest','suggest_id','id');
    }

}
