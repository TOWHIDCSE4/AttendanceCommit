<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->string('user_id');
            $table->string('user_name');
            $table->string('password');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('image_path');
            $table->integer('authority_id');
            $table->integer('position_id');
            $table->integer('department_id');
            $table->string('manager_id');
            $table->string('retirement');
            $table->string('status',15);

//            $table->foreign('authority_id')->references('authority_id')->on('authority');
//            $table->foreign('position_id')->references('position_id')->on('position');
//            $table->foreign('manager_id')->references('manager_id')->on('manager');
//            $table->foreign('department_id')->references('department_id')->on('department');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
