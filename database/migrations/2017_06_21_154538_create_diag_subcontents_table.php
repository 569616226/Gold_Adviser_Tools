<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagSubcontentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diag_subcontents', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('content')->comment('审核内容');
            $table->longText('describle')->comment('问题及风险描述');
            $table->longText('suggest')->comment('建议及改善方案');
            $table->integer('law_id')->unsigned()->comment('法律法规');
            $table->foreign('law_id')->references('id')->on('laws')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('diag_submod_id')->unsigned()->comment('诊断结果模块');
            $table->foreign('diag_submod_id')->references('id')->on('diag_submods')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('diag_subcontents');
    }
}
