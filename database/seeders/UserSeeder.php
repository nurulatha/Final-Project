<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole('superAdmin');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole('admin');

        $pembeli = User::create([
            'name' => 'Pembeli',
            'email' => 'pembeli@gmail.com',
            'password' => bcrypt('11111111'),
        ]);
        $pembeli->assignRole('pembeli');
    }
}
