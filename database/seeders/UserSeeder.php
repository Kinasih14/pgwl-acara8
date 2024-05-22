<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'phone' => '087812632995',
                'email' => "admin@gmail.com",
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'User',
                'phone' => '087812354678',
                'email' => "user@gmail.com",
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'kinasihsayekti',
                'phone' => '083856050371',
                'email' => "kinasihsayekti@mail.ugm.ac.id",
                'password' => bcrypt('123456'),
            ],
        ];
        DB::table('users')->insert($users);
    }
}