<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inventories')->insert([
            [
                'product_id' => 1,
                'status' => 'good',
                'read' => 1,
                'read_at' => '2024-04-23 21:29:49',
                'created_at' => '2024-04-23 19:04:48',
                'updated_at' => '2024-04-23 21:29:49',
            ],
            [
                'product_id' => 2,
                'status' => 'good',
                'read' => 1,
                'read_at' => '2024-04-23 21:29:49',
                'created_at' => '2024-04-23 19:46:17',
                'updated_at' => '2024-04-23 21:30:49',
            ],      [
                'product_id' => 3,
                'status' => 'low',
                'read' => 1,
                'read_at' => '2024-04-23 21:29:49',
                'created_at' => '2024-04-23 19:04:48',
                'updated_at' => '2024-04-23 21:35:49',
            ],
            [
                'product_id' => 4,
                'status' => 'good',
                'read' => 1,
                'read_at' => '2024-04-23 21:29:49',
                'created_at' => '2024-04-23 19:46:17',
                'updated_at' => '2024-04-23 21:32:49',
            ],
        ]);
    }
}