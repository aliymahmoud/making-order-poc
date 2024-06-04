<?php
namespace App\Domains\Order\Transformer;

class ViewOrderTransformer
{
    public static function transform($order): array
    {
        return [
            'id' => $order->id,
            'total' => $order->total,
            'order_number' => $order->order_number,
            'user' => ($order->user) ? [
                'id' => $order->user->id,
                'name' => $order->user->name,
                'email' => $order->user->email,
            ] : "Guest",
            'status' => $order->status,
            'note' => $order->note,
            'total' => $order->final_price,
            'items' => $order->items->map(function($item){
                return [
                    'name' => $item->name,
                    'quantity' => $item->pivot->quantity,
                ];
            }),
        ];
    }
}