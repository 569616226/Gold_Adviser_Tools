<?php
/*
 * 项目
 * */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->comment('项目状态');
            $table->integer('create_id')->comment('项目创建人');
            $table->integer('material_active')->comment('材料清单交付判断');
            $table->integer('diag_active')->comment('诊断报告交付判断');
            $table->integer('improve_active')->comment('实施计划交付判断');
            $table->timestamp('material_active_time')->comment('材料清单交付判断时间');
            $table->timestamp('diag_active_time')->comment('诊断报告交付判断时间');
            $table->timestamp('improve_active_time')->comment('实施计划交付判断时间');
            $table->integer('create_id')->comment('项目创建人');
            $table->integer('fid')->unsigned()->comment('项目负责人');
            $table->integer('hand_id')->unsigned()->comment('交接单');
            $table->foreign('hand_id')->references('id')->on('hands')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
