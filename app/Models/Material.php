<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'department', 'content', 'item_id' ];


    public function items()
    {
        return $this->belongsTo('App\Models\Item', 'item_id', 'id');
    }

    /*材料清单内容*/
    public function material_contents()
    {
        return $this->hasMany('App\Models\MaterialContent', 'material_id', 'id');
    }

}
