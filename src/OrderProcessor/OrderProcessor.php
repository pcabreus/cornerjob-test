<?php

namespace App\OrderProcessor;

use App\Entity\Coffee;
use App\Entity\Order;
use App\Entity\User;
use App\Factory\OrderFactory;
use App\Inventory\InventoryOperator;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class OrderProcessor
 * @package App\OrderProcessor
 */
class OrderProcessor
{
    private $inventorOperator;
    private $orderFactory;
    private $entityManager;

    public function __construct(OrderFactory $orderFactory, InventoryOperator $inventorOperator, EntityManagerInterface $entityManager)
    {
        $this->orderFactory = $orderFactory;
        $this->inventorOperator = $inventorOperator;
        $this->entityManager = $entityManager;
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

        $order = $this->orderFactory->create($coffee, $user, $units, $amount);

        $this->entityManager->persist($order);
        $this->entityManager->persist($coffee);
        $this->entityManager->flush();

        return $order;
    }

    public function calculateAmount(int $price, int $units): int
    {
        return intval($price * $units);
    }
}