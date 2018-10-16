<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class UserDepart extends Authenticatable
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

    protected $hidden = [ 'password', 'remember_token', ];

    protected $fillable = [ 'name','username', 'active', 'is_super', 'user_id' ];

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function croles()
    {
        return $this->belongsToMany(Config::get('entrust.role'), Config::get('entrust.role_user_depart_table'), Config::get('entrust.user_depart_foreign_key'), Config::get('entrust.role_foreign_key'));
    }

    /**
     * Boot the user model
     * Attach event listener to remove the many-to-many records when trying to delete
     * Will NOT delete any records if the user model uses soft deletes.
     *
     * @return void|bool
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function($user)
        {
            if( !method_exists(Config::get('auth.model'), 'bootSoftDeletes') )
            {
                $user->croles()->sync([]);
            }

            return true;
        });
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $role
     */
    public function attachRole($role)
    {

        if( is_object($role) )
        {
            $role = $role->getKey();
        }

        if( is_array($role) )
        {
            $role = $role[ 'id' ];
        }

        $this->croles()->attach($role);
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $role
     */
    public function detachRole($role)
    {
        if( is_object($role) )
        {
            $role = $role->getKey();
        }

        if( is_array($role) )
        {
            $role = $role[ 'id' ];
        }

        $this->croles()->detach($role);
    }

    /**
     * Detach multiple roles from a user
     *
     * @param mixed $roles
     */
    public function detachRoles($roles = null)
    {
        if( !$roles )
            $roles = $this->croles()->get();

        foreach( $roles as $role )
        {
            $this->detachRole($role);
        }
    }

    /**
     * Attach multiple roles to a user
     *
     * @param mixed $roles
     */
    public function attachRoles($roles)
    {

        foreach( $roles as $role )
        {
            $this->attachRole($role);
        }
    }


}
