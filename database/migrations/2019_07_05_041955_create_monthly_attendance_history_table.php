<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthlyAttendanceHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_attendance_history', function (Blueprint $table) {
            $table->string('history_id');
            $table->string('monthly_attendance_id');
            $table->timestamp('operated_at');
            $table->string('status',15);

//            $table->foreign('status_id')->references('status_id')->on('status');
//            $table->foreign('monthly_attendance_id')->references('monthly_attendance_id')->on('monthly_attendance');

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
        Schema::dropIfExists('monthly_attendance_history');
    }
}
