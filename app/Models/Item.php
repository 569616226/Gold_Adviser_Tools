<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ,'material_active_time','diag_active_time','improve_active_time','improve_startDate','improve_endDate'];

    protected $fillable = [ 'status', 'hand_id', 'create_id', 'material_active','material_active_time','diag_active'
        ,'diag_active_time','improve_active','improve_active_time','fid' ,'improve_startDate','improve_endDate'];

    /*交接单*/
    public function hands()
    {
        return $this->belongsTo('App\Models\Hand', 'hand_id', 'id');
    }

    /*员工*/
    public function admin_users()
    {
        return $this->belongsToMany('App\Models\AdminUser', 'admin_user_items', 'item_id', 'admin_user_id');
    }

    /*材料清单模板*/
    public function material_template_names()
    {
        return $this->belongsTo('App\Models\MaterialTemplateName', 'material_template_name_id', 'id');
    }

    /*材料清单*/
    public function maters()
    {
        return $this->hasMany('App\Models\Material', 'item_id', 'id');
    }

    /*项目图片*/
    public function images()
    {
        return $this->hasOne('App\Models\Image', 'item_id', 'id');
    }

    /*项目审核资料*/
    public function item_datas()
    {
        return $this->hasOne('App\Models\ItemData', 'item_id', 'id');
    }

    /*诊断结果概述*/
    public function diags()
    {
        return $this->hasMany('App\Models\Diag', 'item_id', 'id');
    }

    /*诊断结果具体分析*/
    public function diag_mods()
    {
        return $this->hasMany('App\Models\DiagMod', 'item_id', 'id');
    }

    /*实施计划*/
    public function improve_titles()
    {
        return $this->hasMany('App\Models\ImproveTitle', 'item_id', 'id');
    }

    /*实施计划*/
    public function improve_title_tems()
    {
        return $this->hasMany('App\Models\ImproveTitleTem', 'item_id', 'id');
    }

    /*项目任务*/
    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'item_id', 'id');
    }
}
