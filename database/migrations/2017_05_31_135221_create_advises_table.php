<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('建议问题');
            $table->longText('content')->comment('建议内容');
            $table->timestamp('plan_date')->comment('计划完成');
            $table->integer('suggest_id')->unsigned()->comment('服务反馈表');
            $table->foreign('suggest_id')->references('id')->on('suggests')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('advises');
    }
}
