<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserHolidayInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_holiday_information', function (Blueprint $table) {
            $table->bigIncrements('holiday_information_id');
            $table->string('user_id');
            $table->string('holiday_id');
            $table->string('apply_date');
            $table->string('start_date');
            $table->string('end_date');
            $table->double('total_duration');
            $table->string('status',15);

//            $table->foreign('user_id')->references('user_id')->on('user');
//            $table->foreign('status_id')->references('status_id')->on('status');
//            $table->foreign('holiday_id')->references('holiday_id')->on('holiday_type');

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
        Schema::dropIfExists('user_holiday_information');
    }
}
