<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Domains\Order\Handler\CreateOrderHandler;

class StoreOrderController extends Controller
{
    public function __invoke(StoreOrderRequest $request, CreateOrderHandler $createOrderHandler)
    {        
        $user = $request->user();
        $response = $createOrderHandler->handle($request->validated(), $user);
        
        return $response;
    }
}
