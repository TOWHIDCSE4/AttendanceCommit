<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_attendance', function (Blueprint $table) {
            $table->string('daily_attendance_id');
            $table->string('user_id');
            $table->date('date');
            $table->timestamp('checkin');
            $table->dateTime('checkout');
            $table->double('break_time_hour');
            $table->double('total_working_hour');
            $table->string('overtime_id');
            $table->string('status',15);

//            $table->foreign('user_id')->references('user_id')->on('user');
//            $table->foreign('status')->references('status_id')->on('status');
//            $table->foreign('overtime_id')->references('overtime_id')->on('overtime');

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
        Schema::dropIfExists('daily_attendance');
    }
}
