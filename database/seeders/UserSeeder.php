<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'), //Khusus bagian password harus dilindungi (jangan langsung dimasukkan) tapi pakai bcrypt
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'password' => bcrypt('customer123'), //Khusus bagian password harus dilindungi (jangan langsung dimasukkan) tapi pakai bcrypt
            'role' => 'customer'
        ]);


    }
}
