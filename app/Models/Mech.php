<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mech extends Model
{

    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'name', 'address', 'zip_code', 'super', 'super_tel', 'verify_team', 'email', 'super_fax', 'master', 'mawter_fax', 'master_tel' ];

    public function hands()
    {
        return $this->hasOne('App\Models\Hand', 'user_id', 'id');
    }
}
