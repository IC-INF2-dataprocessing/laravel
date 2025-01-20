<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            [
                'name' => 'Dave',
                'user_id' => 1,
                'profile_picture' => null,
                'date_of_birth' => '2000-01-01',
            ],
            [
                'name' => 'Lucas W',
                'user_id' => 1,
                'profile_picture' => 1,
                'date_of_birth' => '2000-01-01',
            ],
            [
                'name' => 'Lucas L',
                'user_id' => 1,
                'profile_picture' => 8,
                'date_of_birth' => '2000-01-01',
            ],
            [
                'name' => 'Aaron',
                'user_id' => 1,
                'profile_picture' => 20,
                'date_of_birth' => '2000-01-01',
            ],
        ]);
    }
}
