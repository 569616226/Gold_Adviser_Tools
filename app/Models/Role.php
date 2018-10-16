<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\EntrustRole;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Role extends EntrustRole implements Transformable
{
    use TransformableTrait, SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'name', 'display_name', 'description' ];

    /**
     * belongs to many for admin_user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\AdminUser', 'admin_user_role', 'admin_user_id', 'role_id');
    }

    public function user_departs()
    {
        return $this->belongsToMany('App\Models\UserDepart', 'user_depart_role', 'user_depart_id', 'role_id');
    }


}

