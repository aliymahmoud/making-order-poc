<?php
namespace App\Domains\Order\Entity;

use App\Models\User;

class CreateOrderEntity // should extends BaseEntity or BaseOrderEntity to have common methods like setAttributes, getAttributes, etc
{   
    private ?User $user;
    private string $status;
    private string $note;
    private float $finalPrice;
    private array $items;

    public function getOrderNumber(): string
    {
        // very simple implementation to generate order number
        // should be replaced with more business representative logic
        return 'ORD-#' . time();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getUserId(): ?int
    {
        return ($this->user->id) ?? null;
    }

    public function getItems(): array
    {
        return $this->items;
    }
    
    public function getStatus(): string
    {
        return $this->status;
    }

    public function getNote(): string
    {
        return $this->note;
    }

    public function getFinalPrice(): float
    {
        return $this->finalPrice;
    }

    public function setUser(User $user = null): CreateOrderEntity
    {
        $this->user = $user;
        return $this;
    }

    public function setItems(array $items): CreateOrderEntity
    {
        $this->items = $items;
        return $this;
    }

    public function setNote(string $note): CreateOrderEntity
    {
        $this->note = $note;
        return $this;
    }

    public function setStatus(string $status): CreateOrderEntity
    {
        $this->status = $status;
        return $this;
    }

    public function setFinalPrice(array $items): CreateOrderEntity
    {
        $this->finalPrice = rand(100, 1000) * count($items);
        return $this;
    }

}