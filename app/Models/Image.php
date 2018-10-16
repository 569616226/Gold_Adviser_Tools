<?php

/*
 * 项目图片
 *
 * */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];

    protected $fillable = [ 'name', 'url', 'item_id' ];

    public function items()
    {
        return $this->belongsTo('App\Models\Item', 'item_id', 'id');
    }

    public static $rules = [ 'img' => 'required|mimes:png,gif,jpeg,jpg,bmp' ];
    public static $messages = [ 'img.mimes' => '图片必须为png,gif,jpeg,jpg,bmp格式', 'img.required' => '请选择图片' ];

}
