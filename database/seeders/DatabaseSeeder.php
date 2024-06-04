<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\IngredientSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\IngredientProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            IngredientSeeder::class,
            ProductSeeder::class,
            IngredientProductSeeder::class,
        ]);
    }
}