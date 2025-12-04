<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

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
            'name' => 'Donor2',
            'email' => 'donor2@example.com',
            'password' => Hash::make('1111111'),
            'role' => 'donor',
            'phone' => '578234234',
            'address' => 'Jambi',
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

        DB::table('users')->insert([
            'name' => 'Receiver2',
            'email' => 'receiver2@example.com',
            'password' => Hash::make('22222222'),
            'role' => 'receiver',
            'phone' => '78923545123',
            'address' => 'Bogor',
            'email_verified_at' => now(),
        ]);
        
        $faker = Faker::create();

        // ---- Random Donors ----
        for ($i = 1; $i <= 3; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role' => 'donor',
                'phone' => $faker->phoneNumber(),
                'address' => $faker->city(),
                'email_verified_at' => now(),
            ]);
        }

        // ---- Random Receivers ----
        for ($i = 1; $i <= 3; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role' => 'receiver',
                'phone' => $faker->phoneNumber(),
                'address' => $faker->city(),
                'email_verified_at' => now(),
            ]);
        }
    }
}
