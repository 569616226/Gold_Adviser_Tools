<?php
/*
 * 交接单
 * */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hand extends Model
{

    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at', 'end_time' ];

    protected $fillable = [ 'handover_no', 'name', 'description', 'end_time', 'suggest', 'meche_id', 'user_id', ];

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function meches()
    {
        return $this->belongsTo('App\Models\Mech', 'meche_id', 'id');
    }

    public function items()
    {
        return $this->hasOne('App\Models\Item', 'hand_id', 'id');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\UserContacter', 'hand_id', 'id');
    }
}
