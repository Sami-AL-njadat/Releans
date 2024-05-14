<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password'),
                'phone' => '0789456123',
                'image' => 'frontend/userImage/errorimage.gif',
                'role' => 'admin',
                'remember_token' => null,
                'created_at' => '2024-04-23 19:03:01',
                'updated_at' => '2024-04-23 19:03:01',
            ],
            [
                'name' => 'manager',
                'email' => 'manager@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password'),
                'phone' => '0789456789',
                'image' => 'frontend/userImage/avatar-5.png',
                'role' => 'manager',
                'remember_token' => null,
                'created_at' => '2024-04-23 19:03:01',
                'updated_at' => '2024-04-23 19:03:01',
            ],
            [
                'name' => 'normal',
                'email' => 'user@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password'),
                'phone' => '0231465789',
                'image' => 'frontend/userImage/avatar-1.png',
                'role' => 'user',
                'remember_token' => null,
                'created_at' => '2024-04-23 19:03:01',
                'updated_at' => '2024-04-23 19:03:01',
            ],
        ]);
    }
}
