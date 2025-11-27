<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Donor1',
            'email' => 'donor@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'donor',
            'phone' => '08123456789',
            'address' => 'Jakarta',
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Receiver1',
            'email' => 'receiver@example.com',
            'password' => Hash::make('87654321'),
            'role' => 'receiver',
            'phone' => '08987654321',
            'address' => 'Bandung',
            'email_verified_at' => now(),
        ]);
    }
}
