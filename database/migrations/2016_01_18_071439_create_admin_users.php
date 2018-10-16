<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('email');
            $table->integer('active')->comment('1:解冻，0：冻结');
            $table->string('password', 60);
            $table->string('name')->comment('姓名');
            $table->string('tel')->comment('手机');
            $table->tinyInteger('is_super')->default(0)->comment('是否超级管理员,0:管理员；1：超级管理员；2：普通用户');
            $table->softDeletes();
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
        Schema::drop('admin_users');
    }
}
