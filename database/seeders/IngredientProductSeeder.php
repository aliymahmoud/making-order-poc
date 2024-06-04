<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itemsIDs = DB::table('ingredients')
            ->select('id', 'name')
            ->whereIn('name', ['Beef', 'Cheese', 'Onion'])
            ->union(
                DB::table('products')
                    ->select('id', 'name')
                    ->where('name', 'Burger')
            )
            ->get()
            ->pluck('id', 'name')
        ->toArray();

        DB::table('ingredient_product')
            ->insert([
                [
                    'product_id' => $itemsIDs['Burger'],
                    'ingredient_id' => $itemsIDs['Beef'],
                    'quantity' => 150,
                ],
                [
                    'product_id' => $itemsIDs['Burger'],
                    'ingredient_id' => $itemsIDs['Cheese'],
                    'quantity' => 30,
                ],
                [
                    'product_id' => $itemsIDs['Burger'],
                    'ingredient_id' => $itemsIDs['Onion'],
                    'quantity' => 20,
                ],
            ]);
    }
}
