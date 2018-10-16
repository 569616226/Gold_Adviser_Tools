<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserContactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_contacters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('depart')->comment('部门');
            $table->string('contacter')->comment('负责人');
            $table->string('business')->comment('职位');
            $table->string('wechat')->comment('微信');
            $table->string('phone')->comment('电话');
            $table->string('email')->comment('邮箱');
            $table->integer('hand_id')->unsigned()->comment('所属客户');
            $table->foreign('hand_id')->references('id')->on('hands')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('user_contacters');
    }
}
