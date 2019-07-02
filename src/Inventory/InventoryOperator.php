<?php

namespace App\Inventory;

use App\Entity\Coffee;

/**
 * Class InventoryOperator
 * @package App\Inventory
 */
class InventoryOperator
{
    /**
     * @param Coffee $coffee
     * @param int $units
     */
    public function modifyStock(Coffee $coffee, int $units): void
    {
        $coffee->setStock($coffee->getStock() - $units);
    }

    /**
     * @param Coffee $coffee
     * @param int $units
     * @return bool
     */
    public function hasInStock(Coffee $coffee, int $units): bool
    {
        return 0 <= $coffee->getStock() - $units;
    }
}