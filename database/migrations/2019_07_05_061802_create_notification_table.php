<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->string('notification_id');
            $table->string('subject');
            $table->string('content');
            $table->string('user_id_sender');
            $table->integer('position_id');
            $table->date('date_sending');
            $table->date('date_creation');
            $table->string('notification_type');
            $table->string('receiver_id');
            $table->integer('holiday_information_id');
            $table->string('status',15);

//            $table->foreign('status_id')->references('status_id')->on('status');
//            $table->foreign('holiday_information_id')->references('holiday_information_id')->on('user_holiday_information');
//            $table->foreign('user_id_sender')->references('user_id')->on('user');
//            $table->foreign('receiver')->references('user_id')->on('user');

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
        Schema::dropIfExists('notification');
    }
}
