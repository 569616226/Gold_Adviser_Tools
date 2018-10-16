<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagSubcontentLawTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diag_subcontent_laws', function (Blueprint $table) {
            $table->integer('diag_subcontent_id')->unsigned();
            $table->foreign('diag_subcontent_id')->references('id')->on('diag_subcontents')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('law_id')->unsigned();
            $table->foreign('law_id')->references('id')->on('laws')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['diag_subcontent_id', 'law_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diag_subcontent_laws');
    }
}
