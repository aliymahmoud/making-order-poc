<?php
namespace App\Domains\Product\Repository;

use App\Models\Ingredient;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Models\Order;

class ProductRepository
{
    public function __construct(
        private Product $product,
    ) {}

    public function find(int $id): Product
    {
        return $this->product->find($id);
    }

    public function hasAvailableStock(Product $product, int $quantity): bool
    {
        return $product->ingredients()->lockForUpdate()->get()->every(function ($ingredient) use ($quantity) {
            return $ingredient->stock >= $ingredient->pivot->quantity * $quantity;
        });
    }

    public function decreaseStock(Product $product, int $quantity): void
    {
        $product->ingredients()->get()->each(function ($ingredient) use ($quantity) {
            $ingredient->stock -= $ingredient->pivot->quantity * $quantity;
            $ingredient->save();
        });
    }

    public function getOrderIngredients(Order $order): Collection
    {
        return Ingredient::query()
            ->join('ingredient_product', 'ingredients.id', '=', 'ingredient_product.ingredient_id')
            ->join('orderables', 'ingredient_product.product_id', '=', 'orderables.orderable_id')
            ->select('ingredients.*')
            ->distinct()
            ->where('orderables.order_id', $order->id)->get();
    }
}