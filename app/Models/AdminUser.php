<?php

namespace App\Models;

use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    use EntrustUserTrait
    {
        restore as private restoreA;
    }
    use SoftDeletes
    {
        restore as private restoreB;
    }

    /**
     * 解决 EntrustUserTrait 和 SoftDeletes 冲突
     */
    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }


    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'active', 'email', 'password', 'is_super', 'username', 'tel' ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 'password', 'remember_token', ];

    public function items()
    {
        return $this->belongsToMany('App\Models\Item', 'admin_user_items', 'item_id', 'admin_user_id');
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'admin_user_id', 'id');
    }

}
