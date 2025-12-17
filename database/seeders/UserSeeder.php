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
            'name' => 'Restoran Sederhana Gambir',
            'email' => 'sederhana.gambir@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'donor',
            'phone' => '0213456789',
            'address' => 'RW 02, Gambir, Central Jakarta, Special Capital Region of Jakarta',
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Bakery Petojo Sejahtera',
            'email' => 'bakery.petojo@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'donor',
            'phone' => '0213812345',
            'address' => 'Jalan Petojo Sabangan X, RW 04, Petojo Selatan, Gambir, Central Jakarta',
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Hotel Cibodas Karawaci',
            'email' => 'hotel.cibodas@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'donor',
            'phone' => '0215578123',
            'address' => 'Jalan Cibodas Raya, Karawaci Baru, Karawaci, Tangerang, Banten',
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Panti Asuhan Harapan Bangsa',
            'email' => 'harapan.bangsa@gmail.com',
            'password' => Hash::make('87654321'),
            'role' => 'receiver',
            'phone' => '0214219988',
            'address' => 'Jalan Serdang Baru, RW 04, Serdang, Kemayoran, Central Jakarta',
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Yayasan Kasih Ibu Bekasi',
            'email' => 'kasih.ibu@gmail.com',
            'password' => Hash::make('87654321'),
            'role' => 'receiver',
            'phone' => '0218890123',
            'address' => 'Graha Indah 2, Villa Taman Kartini, Bekasi, West Java',
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Rumah Singgah Peduli Anak',
            'email' => 'peduli.anak@gmail.com',
            'password' => Hash::make('87654321'),
            'role' => 'receiver',
            'phone' => '0227209988',
            'address' => 'Jalan Diponegoro, Coblong, Bandung, West Java',
            'email_verified_at' => now(),
        ]);
        
        $faker = Faker::create();

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
