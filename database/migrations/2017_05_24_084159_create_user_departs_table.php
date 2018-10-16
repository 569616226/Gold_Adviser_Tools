<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_departs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('name')->comment('客户名称');
            $table->string('password', 60);
	        $table->integer('active')->comment('1:解冻，0：冻结');
            $table->tinyInteger('is_super')->default(2)->comment('是否超级管理员,0:管理员；1：超级管理员；2：普通用户');
            $table->integer('user_id')->unsigned()->comment('所属客户');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('user_departs');
    }
}
