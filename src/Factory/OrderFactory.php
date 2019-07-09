<?php

namespace App\Factory;


use App\Entity\Coffee;
use App\Entity\Order;
use App\Entity\User;

class OrderFactory
{
    public function create(Coffee $coffee, User $user, int $units, int $amount): Order
    {
        return (new Order())
            ->setCoffee($coffee)
            ->setUser($user)
            ->setQuantity($units)
            ->setAmount($amount);
    }

    public static function getClass() { return Order::class;}
}