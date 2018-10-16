<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission implements Transformable
{
    use TransformableTrait, SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'fid', 'icon', 'name', 'display_name', 'description', 'is_menu', 'sort' ];

    protected $appends = [ 'icon_html', 'sub_permission' ];

    public function getIconHtmlAttribute()
    {
        return $this->attributes[ 'icon' ] ? '<i class="fa fa-'.$this->attributes[ 'icon' ].'"></i>' : '';
    }

    public function getNameAttribute($value)
    {
        if( starts_with($value, '#') )
        {
            return head(explode('-', $value));
        }

        return $value;
    }

    public function setNameAttribute($value)
    {
        $this->attributes[ 'name' ] = ( $value == '#' ) ? '#-'.time() : $value;
    }

    public function getSubPermissionAttribute()
    {
//        return ( $this->attributes[ 'fid' ] !== 0 ) ? $this->where('fid', $this->attributes[ 'id' ])->orderBy('sort', 'asc')->get() : null;
        return $this->where('fid', $this->attributes[ 'id' ])->orderBy('sort', 'asc')->get();
    }
}
