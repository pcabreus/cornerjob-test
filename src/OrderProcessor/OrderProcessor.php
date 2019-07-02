<?php

namespace App\OrderProcessor;

use App\Entity\Coffee;
use App\Entity\Order;
use App\Entity\User;
use App\Inventory\InventoryOperator;

/**
 * Class OrderProcessor
 * @package App\OrderProcessor
 */
class OrderProcessor
{
    private $inventorOperator;

    public function __construct(InventoryOperator $inventorOperator)
    {
        $this->inventorOperator = $inventorOperator;
    }

    /**
     * @param User $user
     * @param Coffee $coffee
     * @param int $units
     * @return Order
     */
    public function process(User $user, Coffee $coffee, int $units): Order
    {
        // Double check if the stock is available
        if (!$this->inventorOperator->hasInStock($coffee, $units)) {
            throw new \InvalidArgumentException("out of stock");
        }

        // Modifiy the stock of the coffee
        $this->inventorOperator->modifyStock($coffee, $units);

        // Calculate the amount for the current coffee
        $amount = $this->calculateAmount($coffee->getPrice(), $units);

        $order = (new Order())
            ->setCoffee($coffee)
            ->setUser($user)
            ->setQuantity($units)
            ->setAmount($amount);

        return $order;
    }

    public function calculateAmount(int $price, int $units): int
    {
        return intval($price * $units);
    }
}