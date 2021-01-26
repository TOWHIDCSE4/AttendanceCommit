<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AuthoritySeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(HolidaySeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(UserSeeder::class);
    }
}
