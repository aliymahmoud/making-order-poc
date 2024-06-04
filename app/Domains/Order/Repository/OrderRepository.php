<?php
namespace App\Domains\Order\Repository;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function __construct(private Order $order){}

    public function create(array $data): Order
    {   
        // should be wrapped with strategy pattern based on the orderable type
        return $this->order->create($data);
    }
}