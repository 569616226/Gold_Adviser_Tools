<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagSubmodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diag_submods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('诊断结果子模块名称');
            $table->integer('diag_mod_id')->unsigned()->comment('诊断结果模块');
            $table->foreign('diag_mod_id')->references('id')->on('diag_mods')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('diag_submods');
    }
}
