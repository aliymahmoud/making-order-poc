<?php

namespace Tests\Unit\Http\Controllers\Order;

use Tests\TestCase;
use App\Http\Controllers\Order\StoreOrderController;
use App\Http\Requests\StoreOrderRequest;
use App\Domains\Order\Handler\CreateOrderHandler;
use Illuminate\Http\Response;
use Mockery;

class StoreOrderControllerTest extends TestCase
{
    public function test_store_order(): void
    {
        $request = Mockery::mock(StoreOrderRequest::class);
        $handler = Mockery::mock(CreateOrderHandler::class);
        $response = Mockery::mock(Response::class);

        $request->shouldReceive('validated')->once()->andReturn([]);
        $request->shouldReceive('user')->once()->andReturn($user = new \stdClass());
        $handler->shouldReceive('handle')->once()->with([
            'products' => [
                'product_id' => 1,
                'quantity' => 2,
            ],
            'note' => null,
        ], $user)->andReturn($response);

        $controller = new StoreOrderController();
        $result = $controller->__invoke($request, $handler);

        $this->assertSame($response, $result);
    }
}