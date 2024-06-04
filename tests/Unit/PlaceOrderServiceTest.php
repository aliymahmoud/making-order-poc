<?php

namespace Tests\Unit\Domains\Order\Service;

use App\Domains\Order\Entity\CreateOrderEntity;
use App\Domains\Order\Repository\ItemOrderRepository;
use App\Domains\Order\Repository\OrderRepository;
use App\Domains\Order\Transformer\CreateOrderTransformer;
use App\Domains\Product\Repository\ProductRepository;
use App\Events\OrderCreated;
use App\Models\Order;
use App\Domains\Order\Service\PlaceOrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PlaceOrderServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_place_order(): void
    {
        // Arrange
        $createOrderEntity = new CreateOrderEntity();
        $orderRepository = $this->app->make(OrderRepository::class);
        $itemOrderRepository = $this->app->make(ItemOrderRepository::class);
        $createOrderTransformer = $this->app->make(CreateOrderTransformer::class);
        $productRepository = $this->app->make(ProductRepository::class);
        $placeOrderService = new PlaceOrderService(
            $orderRepository,
            $itemOrderRepository,
            $createOrderTransformer,
            $productRepository
        );

        // Act
        $order = $placeOrderService->placeOrder($createOrderEntity);

        // Assert
        $this->assertInstanceOf(Order::class, $order);
        // Add more assertions as needed
    }
}