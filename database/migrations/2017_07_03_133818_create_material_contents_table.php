<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content')->comment('内容');
            $table->string('name')->comment('名称');
            $table->integer('material_id')->unsigned()->comment('审核对象');
            $table->foreign('material_id')->references('id')->on('materials')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('material_contents');
    }
}
