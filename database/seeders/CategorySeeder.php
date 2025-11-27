<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Bakery',
                'description' => 'Bread, pastries, cakes, and baked goods.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rice',
                'description' => 'Cooked rice meals or nasi kotak.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Meat',
                'description' => 'Chicken, beef, fish, and other protein meals.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fruits',
                'description' => 'Fresh or packed fruits near expiration.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vegetables',
                'description' => 'Fresh vegetables and produce.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dairy',
                'description' => 'Milk, yogurt, cheese, and dairy products.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Snacks',
                'description' => 'Light snacks like biscuits, chips, or cookies.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Drinks',
                'description' => 'Beverages such as juice, mineral water, soda, etc.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Baby Food',
                'description' => 'Food and formula for babies.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Packaged Food',
                'description' => 'Items like canned food, instant noodles, snacks.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Others',
                'description' => 'Miscellaneous food categories.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
