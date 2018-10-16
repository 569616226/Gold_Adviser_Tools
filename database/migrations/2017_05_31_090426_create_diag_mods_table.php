<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagModsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diag_mods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('诊断结果模块名称');
            $table->integer('fid')->unsigned()->comment('指派模块负责人');
            $table->integer('item_id')->unsigned()->comment('清单审核资料');
            $table->foreign('item_id')->references('id')->on('items')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('diag_mods');
    }
}
