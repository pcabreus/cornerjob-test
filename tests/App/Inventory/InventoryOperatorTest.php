<?php
/**
 * Created by PhpStorm.
 * User: charly
 * Date: 30/06/19
 * Time: 23:16
 */

namespace App\Tests\App\Inventory;


use App\Entity\Coffee;
use App\Inventory\InventoryOperator;
use PHPUnit\Framework\TestCase;

class InventoryOperatorTest extends TestCase
{
    public function testProcess()
    {
        $processor =  new InventoryOperator();

        $coffee = (new Coffee())
            ->setName('ristretto')
            ->setTextPrice(3)
            ->setIntensity(10)
            ->setStock(20);

        $this->assertTrue($processor->hasInStock($coffee, 3));
        $processor->modifyStock($coffee, 3);

        $this->assertEquals(17, $coffee->getStock());

        $this->assertTrue($processor->hasInStock($coffee, 10));
        $processor->modifyStock($coffee, 10);

        $this->assertEquals(7, $coffee->getStock());

        $this->assertFalse($processor->hasInStock($coffee, 10));
    }
}