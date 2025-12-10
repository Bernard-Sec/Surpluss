<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;
use Faker\Factory as Faker;

class FoodItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $users = User::where('role', 'donor')->pluck('id')->toArray();

        $categoryMap = Category::pluck('id', 'name')->toArray();

        $foodList = [
            'Bakery' => [
                'Whole Wheat Bread', 'Croissant', 'Chocolate Muffin'
            ],
            'Rice' => [
                'Nasi Goreng', 'Nasi Kuning Box', 'Chicken Teriyaki Rice'
            ],
            'Meat' => [
                'Beef Rendang', 'Grilled Chicken Breast', 'Fish Fillet Meal'
            ],
            'Fruits' => [
                'Fresh Apples Pack', 'Bananas', 'Fruit Salad Cup'
            ],
            'Vegetables' => [
                'Mixed Salad Bowl', 'Fresh Lettuce Head', 'Vegetable Stir Fry'
            ],
            'Dairy' => [
                'Yogurt Cup', 'Cheddar Cheese Slices', 'Milk Carton (1L)'
            ],
            'Snacks' => [
                'Peanut Cookies', 'Potato Chips Bag'
            ],
            'Drinks' => [
                'Orange Juice Bottle', 'Mineral Water (1.5L)'
            ],
            'Baby Food' => [
                'Baby Formula Powder', 'Mashed Banana Baby Pouch'
            ],
            'Packaged Food' => [
                'Instant Noodles 5-Pack', 'Canned Tuna'
            ],
            'Others' => [
                'Honey Jar', 'Cereal Box'
            ],
        ];

       $index = 1;

        foreach ($foodList as $category => $foods) {
            foreach ($foods as $food) {

                DB::table('food_items')->insert([
                    'user_id' => $faker->randomElement($users),
                    'category_id' => $categoryMap[$category],
                    'name' => $food,
                    'description' => $faker->sentence(10),
                    'photo' => "images/sample-$index.jpg",
                    'quantity' => rand(1, 10),
                    'pickup_location' => $faker->address(),
                    'pickup_time' => $faker->randomElement([
                        '09.00 - 12.00 WIB', 
                        '13.00 - 15.00 WIB', 
                        '16.00 - 20.00 WIB', 
                        'Bebas (Hubungi via WA)'
                    ]),
                    'expires_at' => $faker->dateTimeBetween('now', '+6 days'),
                    'status' => 'available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $index++; // naikkan setiap food diinsert
            }
        }
    }
}
