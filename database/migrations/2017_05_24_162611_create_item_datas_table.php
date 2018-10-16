<?php
/*
* 项目附件审核资料
* */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content')->comment('内容');
            $table->integer('item_id')->unsigned()->comment('清单审核资料');
            $table->foreign('item_id')->references('id')->on('items')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('admin_user_id')->unsigned()->comment('项目审核资料负责人');
            $table->foreign('admin_user_id')->unsigned()->references('id')->on('admin_users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('item_datas');
    }
}
