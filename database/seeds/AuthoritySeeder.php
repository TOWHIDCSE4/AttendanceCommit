<?php

use Illuminate\Database\Seeder;

class AuthoritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Authority::create([
            'authority_name'=>'System admin',
        ]);
        \App\Authority::create([
            'authority_name'=>'manager',
        ]);
        \App\Authority::create([
            'authority_name'=>'member',
        ]);
    }
}
