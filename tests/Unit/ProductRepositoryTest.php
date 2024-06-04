<?php

namespace Tests\Unit\Domains\Product\Repository;

use App\Domains\Product\Repository\ProductRepository;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ProductRepository $productRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productRepository = new ProductRepository(new Product());
    }

    public function test_find_returns_product(): void
    {
        $product = Product::factory()->create();

        $foundProduct = $this->productRepository->find($product->id);

        $this->assertEquals($product->id, $foundProduct->id);
    }

    public function test_hasAvailableStock_returns_true_when_stock_is_available(): void
    {
        $product = Product::factory()->create();
        $ingredient = Ingredient::factory()->create();
        $product->ingredients()->attach($ingredient, ['quantity' => 1]);
        $ingredient->stock = 10;
        $ingredient->save();

        $hasAvailableStock = $this->productRepository->hasAvailableStock($product, 1);

        $this->assertTrue($hasAvailableStock);
    }

    public function test_hasAvailableStock_returns_false_when_stock_is_not_available(): void
    {
        $product = Product::factory()->create();
        $ingredient = Ingredient::factory()->create();
        $product->ingredients()->attach($ingredient, ['quantity' => 1]);
        $ingredient->stock = 0;
        $ingredient->save();

        $hasAvailableStock = $this->productRepository->hasAvailableStock($product, 1);

        $this->assertFalse($hasAvailableStock);
    }

    public function test_decreaseStock_decreases_stock_of_product_ingredients(): void
    {
        $product = Product::factory()->create();
        $ingredient = Ingredient::factory()->create();
        $product->ingredients()->attach($ingredient, ['quantity' => 2]);
        $ingredient->stock = 10;
        $ingredient->save();

        $this->productRepository->decreaseStock($product, 1);

        $ingredient->refresh();
        $this->assertEquals(8, $ingredient->stock);
    }

    public function test_getOrderIngredients_returns_collection_of_order_ingredients(): void
    {
        $order = Order::factory()->create();
        $ingredient1 = Ingredient::factory()->create();
        $ingredient2 = Ingredient::factory()->create();
        $order->ingredients()->attach($ingredient1);
        $order->ingredients()->attach($ingredient2);

        $orderIngredients = $this->productRepository->getOrderIngredients($order);

        $this->assertCount(2, $orderIngredients);
        $this->assertTrue($orderIngredients->contains($ingredient1));
        $this->assertTrue($orderIngredients->contains($ingredient2));
    }
}