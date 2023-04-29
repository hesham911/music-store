<?php

namespace Database\Seeders;

use App\Enum\UserStatus;
use App\Enum\UserTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'email'     => env('ADMIN_MAIL','admin@app.com'),
            'password'  => bcrypt('admin1234'),
            'name'      => 'admin',
            'username'  => 'Admin',
            'is_admin'  => true,
            'type'      => UserTypes::Admin,
            'status'    => UserStatus::Active,
        ]);
    }
}
