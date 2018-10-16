<?php
/*
 * 任务
 * */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('task_no')->comment('编号');
            $table->string('title')->comment('标题');
            $table->integer('status')->comment('状态');
            $table->timestamp('start_date')->comment('开始时间');
            $table->timestamp('end_date')->comment('结束时间');
            $table->timestamp('daly_date')->comment('延期时间');
            $table->integer('level')->comment('优先级');
            $table->integer('user_id')->unsigned()->comment('客户');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('admin_user_id')->unsigned()->comment('指派人');
            $table->foreign('admin_user_id')->references('id')->on('admin_users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('tasktable_id')->unsigned()->comment('任务内容表ID');
            $table->string('tasktable_type')->comment('任务内容表名称');
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
        Schema::dropIfExists('tasks');
    }
}
