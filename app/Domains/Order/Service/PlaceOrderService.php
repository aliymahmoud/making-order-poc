<?php
namespace App\Domains\Order\Service;

use App\Domains\Order\Entity\CreateOrderEntity;
use App\Domains\Order\Repository\ItemOrderRepository;
use App\Domains\Order\Repository\OrderRepository;
use App\Domains\Order\Transformer\CreateOrderTransformer;
use App\Domains\Product\Repository\ProductRepository;
use App\Events\OrderCreated;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class PlaceOrderService
{
    public function __construct(
        private OrderRepository $orderRepository,
        private ItemOrderRepository $itemOrderRepository,
        private CreateOrderTransformer $createOrderTransformer,
        private ProductRepository $productRepository
    ) {}

    public function placeOrder(CreateOrderEntity $createOrderEntity): Order
    {
        $order = DB::transaction(function() use ($createOrderEntity){

            $order = $this->orderRepository->create($this->createOrderTransformer->transform($createOrderEntity));

            $this->itemOrderRepository->create($order, $createOrderEntity->getItems());

            $orderIngredients = $this->productRepository->getOrderIngredients($order);

            OrderCreated::dispatch($orderIngredients);
    
            return $order;
        }, 5);

        return $order;
    }

}
