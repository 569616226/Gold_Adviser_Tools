<?php
/*
 *
 * 服务反馈
 * */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuggestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suggests', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('remark')->comment('服务内容备注');
            $table->longText('content')->comment('客户评价内容');
            $table->string('service_remark')->comment('服务反馈表备注');
            $table->integer('score')->comment('客户评分0:不满意，1：满意，2：非常满意，');
            $table->integer('active')->comment('交付');
            $table->integer('user_id')->unsigned()->comment('评价客户');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('task_id')->unsigned()->comment('清单审核资料');
            $table->foreign('task_id')->references('id')->on('tasks')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('suggests');
    }
}
