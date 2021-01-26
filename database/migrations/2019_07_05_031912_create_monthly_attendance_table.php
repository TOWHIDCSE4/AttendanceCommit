<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthlyAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_attendance', function (Blueprint $table) {
            $table->string('monthly_id',15)->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('user_id',15);
            $table->string('status',15);

//            $table->foreign('user_id')->references('user_id')->on('user');
//            $table->foreign('status')->references('status_id')->on('status');

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
        Schema::dropIfExists('monthly_attendance');
    }
}
