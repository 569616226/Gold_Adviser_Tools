<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialContentTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_content_temps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content')->comment('内容');
            $table->string('name')->comment('名称');
            $table->integer('material_template_id')->unsigned()->comment('审核对象');
            $table->foreign('material_template_id')->references('id')->on('material_templates')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('material_content_temps');
    }
}
