<?php
/*
 *
 * 改善实施计划
 * */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImprovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('improves', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->comment('改善实施计划分类');
            $table->string('improve')->comment('项目');
            $table->longText('content')->comment('服务内容');
            $table->longText('target')->comment('服务目标');
            $table->string('perform_type')->comment('执行类型');
            $table->timestamp('start_date')->comment('开始时间');
            $table->timestamp('end_date')->comment('结束时间');
            $table->longText('remark')->comment('备注');
            $table->integer('item_id')->unsigned()->comment('审核对象');
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
        Schema::dropIfExists('improves');
    }
}
