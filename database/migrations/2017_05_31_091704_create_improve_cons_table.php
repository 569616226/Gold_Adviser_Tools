<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImproveConsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('improve_cons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content')->comment('服务内容');
            $table->string('type')->comment('执行类型');
            $table->string('remark')->comment('备注');
            $table->integer('improve_list_id')->unsigned()->comment('审核对象');
            $table->foreign('improve_list_id')->references('id')->on('improve_lists')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('improve_cons');
    }
}
