<?php
/*交接单*/
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('handover_no')->comment('合同编号');
            $table->string('name')->comment('项目名称');
            $table->longText('description')->comment('项目描述');
            $table->timestamp('end_time')->comment('项目有效期');
            $table->longText('suggest')->comment('营销中心建议');
            $table->integer('meche_id')->unsigned()->comment('项目服务部门（审核机构）');
            $table->foreign('meche_id')->references('id')->on('meches')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->comment('客户');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('hands');
    }
}
