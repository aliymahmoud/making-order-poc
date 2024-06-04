<?php
namespace App\Domains\Order\Transformer;

use App\Domains\Order\Entity\CreateOrderEntity;

class CreateOrderTransformer
{
    public function transform(CreateOrderEntity $createOrderEntity)
    {
        return [
            'order_number' => $createOrderEntity->getOrderNumber(),
            'user_id' => $createOrderEntity->getUserId(),
            'status' => $createOrderEntity->getStatus(),
            'note' => $createOrderEntity->getNote(),
            'final_price' => $createOrderEntity->getFinalPrice()
        ];
    }
}