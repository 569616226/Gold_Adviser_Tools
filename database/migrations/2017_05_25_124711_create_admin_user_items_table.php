<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for associating admin-users to items (Many-to-Many)
        /*
         *
         * */
        
        Schema::create('admin_user_items', function (Blueprint $table) {
            $table->integer('admin_user_id')->unsigned();
            $table->foreign('admin_user_id')->references('id')->on('admin_users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['admin_user_id', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_user_items');
    }
}
