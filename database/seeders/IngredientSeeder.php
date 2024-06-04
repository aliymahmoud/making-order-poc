<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ingredients')->insert([
            [
                'name' => 'Beef',
                'maximum_stock' => 20000,
                'stock' => 20000,
                'unit' => 'g'
            ],
            [
                'name' => 'Cheese',
                'maximum_stock' => 5000,
                'stock' => 5000,
                'unit' => 'g'
            ],
            [
                'name' => 'Onion',
                'maximum_stock' => 1000,
                'stock' => 1000,
                'unit' => 'g'
            ],
        ]);
    }
}
