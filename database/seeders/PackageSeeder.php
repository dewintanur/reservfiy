<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    \App\Models\Package::create([
        'name' => 'Basic Package',
        'price' => 99.99,
        'description' => 'This is a basic package.',
        'cafe_id' => 1 // asumsikan cafe dengan ID 1 sudah ada
    ]);
}
}
