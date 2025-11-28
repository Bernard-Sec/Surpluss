<?php

namespace Database\Seeders;

use App\Models\FoodItem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ClaimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $donor = User::where('role', 'donor')->first();
        // $receiver = User::where('role', 'receiver')->first();
        
        // // Ambil makanan milik donor tersebut
        // $food = FoodItem::where('user_id', $donor->id)->first();

        // if ($food && $receiver) {
        //     DB::table('claims')->insert([
        //         'food_id' => $food->id,
        //         'receiver_id' => $receiver->id,
        //         'status' => 'pending', 
        //         'message' => 'Saya butuh makanan ini untuk panti asuhan.',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }

        $faker = Faker::create();

        $receivers = User::where('role', 'receiver')->pluck('id')->toArray();

        $foodItems = FoodItem::pluck('id')->toArray();

        $statuses = ['pending', 'approved', 'rejected', 'completed'];

        foreach ($foodItems as $foodId) {

            if (rand(1, 100) > 65) {
                continue;
            }

            DB::table('claims')->insert([
                'food_id' => $foodId,
                'receiver_id' => $faker->randomElement($receivers),
                'status' => $faker->randomElement($statuses),
                'message' => $faker->boolean(60) ? $faker->sentence(6) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
