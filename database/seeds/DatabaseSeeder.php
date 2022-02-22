<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->call([
            CitiesTableSeeder::class,
            UsersTableSeeder::class,
            // VisitsTableSeeder::class,
            // ComentsTableSeeder::class,
        ]);

        Model::reguard();

    }
}
