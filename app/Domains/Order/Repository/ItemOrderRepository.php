<?php
namespace App\Domains\Order\Repository;

use App\Domains\Product\Repository\ProductRepository;
use App\Models\Order;

class ItemOrderRepository
{
    public function __construct(
        private Order $order,
        private ProductRepository $productRepository
    ) {}

    public function create(Order &$order, array $items): void
    {
        $orderItems = [];

        foreach ($items as $item) {
            $product = $this->productRepository->find($item['product_id']);
            $hasAvailableStock = $this->productRepository->hasAvailableStock($product, $item['quantity']);
            if (!$hasAvailableStock) {
                throw new \Exception('Product out of stock');
            }
            $this->productRepository->decreaseStock($product, $item['quantity']);
            
            $orderItems[] = [
                'order_id' => $order->id,
                'orderable_id' => $product->id,
                'orderable_type' => get_class($product),
                'quantity' => $item['quantity'],
            ];
        }

        $order->items()->attach($orderItems);
    }
}