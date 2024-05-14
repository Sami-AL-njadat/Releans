<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Espresso',
                'image' => 'imagesProduct/Espresso.jpeg',
                'quantity' => 500,
                'minimum_level' => 20,
                'status' => 'in stock',
                'price' => 2.50,
                'description' => 'Espresso: Strong coffee with a rich flavor, brewed by forcing hot water through grounds.',
                'created_at' => '2024-04-23 19:04:48',
                'updated_at' => '2024-04-23 19:04:48',
            ],
            [
                'name' => 'Cappuccino',
                'image' => 'imagesProduct/Cappuccino.jpeg',
                'quantity' => 200,
                'minimum_level' => 22,
                'status' => 'in stock',
                'price' => 7.00,
                'description' => 'Cappuccino: Equal parts espresso, steamed milk, and foam, topped with cocoa or cinnamon.',
                'created_at' => '2024-04-23 19:46:17',
                'updated_at' => '2024-04-23 19:53:23',
            ],
            [
                'name' => 'Latte',
                'image' => 'imagesProduct/Latte.jpeg',
                'quantity' => 21,
                'minimum_level' => 22,
                'status' => 'in stock',
                'price' => 3.50,
                'description' => 'Latte: Smooth coffee with espresso and steamed milk, often customized with flavorings',
                'created_at' => '2024-04-23 19:46:17',
                'updated_at' => '2024-04-23 19:53:23',
            ],   [
                'name' => 'Mocha',
                'image' => 'imagesProduct/Mocha.jpeg',
                'quantity' => 200,
                'minimum_level' => 22,
                'status' => 'in stock',
                'price' => 3.00,
                'description' => 'Mocha:  milk, and chocolate syrup, topped with whipped cream for indulgent sweetness.',
                'created_at' => '2024-04-23 19:46:17',
                'updated_at' => '2024-04-23 19:53:23',
            ],
        ]);
    }
}
