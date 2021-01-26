<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvertimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtime', function (Blueprint $table) {
            $table->bigIncrements('overtime_id');
            $table->string('user_id',15);
            $table->date('date');
            $table->double('duration');
            $table->string('reason',50);
            $table->string('status',15);

//            $table->foreign('user_id')->references('user_id')->on('user');
//            $table->foreign('status_id')->references('status_id')->on('status');

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
        Schema::dropIfExists('overtime');
    }
}
