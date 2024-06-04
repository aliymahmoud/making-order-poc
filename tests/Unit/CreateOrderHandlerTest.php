<?php

namespace Tests\Unit\Domains\Order\Handler;

use App\Domains\Order\Entity\CreateOrderEntity;
use App\Domains\Order\Handler\CreateOrderHandler;
use App\Domains\Order\Service\PlaceOrderService;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class CreateOrderHandlerTest extends TestCase
{
    public function test_handle_method_creates_order_successfully(): void
    {
        $data = [
            'products' => [
                'product_id' => 1,
                'quantity' => 2,
            ],
            'note' => 'Test note',
        ];
        $user = new User();

        $placeOrderService = $this->createMock(PlaceOrderService::class);
        $createOrderEntity = $this->createMock(CreateOrderEntity::class);
        $order = $this->createMock(Order::class);

        $createOrderEntity->expects($this->once())
            ->method('setUser')
            ->with($user)
            ->willReturnSelf();
        $createOrderEntity->expects($this->once())
            ->method('setStatus')
            ->with(Order::STATUS_PENDING)
            ->willReturnSelf();
        $createOrderEntity->expects($this->once())
            ->method('setItems')
            ->with($data['products'])
            ->willReturnSelf();
        $createOrderEntity->expects($this->once())
            ->method('setFinalPrice')
            ->with($data['products'])
            ->willReturnSelf();
        $createOrderEntity->expects($this->once())
            ->method('setNote')
            ->with($data['note'])
            ->willReturnSelf();

        $placeOrderService->expects($this->once())
            ->method('placeOrder')
            ->with($createOrderEntity)
            ->willReturn($order);

        $handler = new CreateOrderHandler($placeOrderService, $createOrderEntity);

        $response = $handler->handle($data, $user);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}