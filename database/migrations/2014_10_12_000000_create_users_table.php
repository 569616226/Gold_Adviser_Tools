<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('企业名称');
            $table->string('address')->comment('地址');
            $table->integer('fax')->comment('传真');
            $table->string('code')->comment('海关识别码');
            $table->string('tel')->comment('企业手机');
            $table->string('email')->comment('企业邮箱');
            $table->string('trade')->comment('贸易方式');
            $table->timestamp('end_date')->comment('营业期限');
            $table->string('aeo')->comment('AEO认证');
            $table->string('trade_manual')->comment('加工贸易手册管理方式');
            $table->longText('main_trade')->comment('主要进出口贸易方式');
            $table->longText('pro_item_type')->comment('生产项目类别');
            $table->string('capital')->comment('注册资本');
            $table->longText('remark')->comment('备注');
            $table->timestamp('create_date')->comment('成立日期');
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
        Schema::drop('users');
    }
}
