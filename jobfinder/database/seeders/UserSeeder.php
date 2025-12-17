<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Admin JobFinder',
            'email' => 'admin@jobfinder.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
    }
}
