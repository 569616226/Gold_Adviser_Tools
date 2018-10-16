<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','email','tel','fax','address','code','trade',
        'aeo','trade_manual','main_trade','pro_item_type','capital', 'remark','create_date',
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at','create_date'];



    /*交接单*/
    public function hands()
    {
        return $this->hasOne('App\Models\Hand','user_id','id');
    }

    /*客户联系人*/
    public function user_departs()
    {
        return $this->hasMany('App\Models\UserDepart','user_id','id');
    }

    /**
     *任务
     * Get all of the video's comments.
     */
    public function tasks()
    {
        return $this->morphMany('App\Models\Task', 'tasktable');
    }


}
