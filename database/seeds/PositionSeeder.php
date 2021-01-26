<?php

use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Position::create([
            'position_name'=>'admin'
        ]);
        \App\Position::create([
            'position_name'=>'manager'
        ]);
        \App\Position::create([
            'position_name'=>'employee'
        ]);
    }
}
