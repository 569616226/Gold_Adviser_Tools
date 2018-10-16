<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMechesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('机构名称');
            $table->string('address')->comment('通讯地址');
            $table->string('email')->comment('email');
            $table->string('zip_code')->comment('邮政编码');
            $table->string('master_tel')->comment('联系电话');
            $table->string('verify_team')->comment('审核团队');
            $table->string('master_fax')->unique()->comment('传真');
            $table->string('master')->comment('负责人');
            $table->string('super_tel')->comment('联系电话');
            $table->string('super_fax')->unique()->comment('传真');
            $table->string('super')->comment('负责人');
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
        Schema::dropIfExists('meches');
    }
}
