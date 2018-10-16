<?php
/*
 *
 * 诊断报告
 * */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('诊断问题标题');
            $table->longText('content')->comment('诊断问题内容');
            $table->integer('admin_user_id')->unsigned()->comment('审核对象');
            $table->foreign('admin_user_id')->references('id')->on('admin_users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('diags');
    }
}
