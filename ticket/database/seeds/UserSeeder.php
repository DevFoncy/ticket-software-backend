<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')
            ->insert([
                'name' => 'Steve Arias Arias',
                'email' => 'steve.admin@gmail.com',
                'password' => bcrypt('secret'),
                'is_admin' => 1,
            ]);

        DB::table('users')
            ->insert([
                'name' => 'Pedro Giacomme',
                'email' => 'pedro.test@gmail.com',
                'password' => bcrypt('secret'),
                'is_admin' => 0,
            ]);
    }
}
