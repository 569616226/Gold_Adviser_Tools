<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImproveListTemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('improve_list_tems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('实施计划项目名称');
            $table->string('target')->comment('服务目标');
            $table->integer('improve_title_id')->unsigned()->comment('审核对象');
            $table->foreign('improve_title_id')->references('id')->on('improve_titles')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('improve_list_tems');
    }
}
