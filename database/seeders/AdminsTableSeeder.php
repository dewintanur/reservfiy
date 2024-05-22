<?php

namespace Database\Seeders;
// database/seeders/AdminsTableSeeder.php
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'username' => 'admin',
            'password' => bcrypt('password123'), // Ganti dengan password yang aman
            'role'=> 'admin'
        ]);
    }
}
