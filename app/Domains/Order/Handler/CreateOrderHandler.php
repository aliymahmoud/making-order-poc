<?php
namespace App\Domains\Order\Handler;

use App\Domains\Order\Service\PlaceOrderService;
use App\Models\User;
use App\Support\Handler\BaseHandler;
use Illuminate\Http\JsonResponse;
use App\Domains\Order\Entity\CreateOrderEntity;
use App\Domains\Order\Transformer\ViewOrderTransformer;
use App\Models\Order;

class CreateOrderHandler extends BaseHandler
{
    public function __construct(
        private PlaceOrderService $placeOrderService,
        private CreateOrderEntity $createOrderEntity
    ) {}

    public function handle($data, User $user = null): JsonResponse
    {
        $this->createOrderEntity
            ->setUser($user)
            ->setStatus(Order::STATUS_PENDING)
            ->setItems($data['products']) // should be transformed using proper transformer class
            ->setFinalPrice($data['products'])
            ->setNote(isset($data['note']) ? $data['note'] : '');

        try {
            $order = $this->placeOrderService->placeOrder($this->createOrderEntity);
            return $this->success(ViewOrderTransformer::transform($order), 'Order created successfully');

        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}