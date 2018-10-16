<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserContacter extends Model
{

    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'contacter', 'business', 'wechat', 'phone', 'email', 'depart', 'hand_id' ];

    public function hands()
    {
        return $this->belongsTo('App\Hand', 'hand_id', 'id');
    }
}
