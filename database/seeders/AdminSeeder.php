<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'inan@gmail.com',
        ], [
            'name' => 'inan Tamvan',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'phone' => '085959880656',
        ]);

        User::updateOrCreate([
            'email' => 'admin2@example.com',
        ], [
            'name' => 'Admin Kedua',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        User::updateOrCreate([
            'email' => 'kasir1@example.com',
        ], [
            'name' => 'Kasir Satu',
            'password' => Hash::make('kasir1234'),
            'role' => 'kasir',
            'phone' => '081111111111',
        ]);

        User::updateOrCreate([
            'email' => 'kasir2@example.com',
        ], [
            'name' => 'Kasir Dua',
            'password' => Hash::make('kasir1234'),
            'role' => 'kasir',
            'phone' => '082222222222',
        ]);

        User::updateOrCreate([
            'email' => 'kasir3@example.com',
        ], [
            'name' => 'Kasir Tiga',
            'password' => Hash::make('kasir1234'),
            'role' => 'kasir',
            'phone' => '083333333333',
        ]);
    }
}
