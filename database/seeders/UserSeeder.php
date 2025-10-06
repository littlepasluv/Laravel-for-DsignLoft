<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Client User',
            'email' => 'client@dsignloft.com',
            'password' => bcrypt('password'),
            'role' => 'client',
        ]);

        \App\Models\User::create([
            'name' => 'Designer User',
            'email' => 'designer@dsignloft.com',
            'password' => bcrypt('password'),
            'role' => 'designer',
        ]);

        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@dsignloft.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }
}
