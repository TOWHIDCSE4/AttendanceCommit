<?php

use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\HolidayType::create([
            'holiday_name'=>'New year',
            'holiday_group'=>'0'
        ]);
        \App\HolidayType::create([
            'holiday_name'=>'Christmas',
            'holiday_group'=>'1'
        ]);
    }
}
