<?php
/**
 * Created by PhpStorm.
 * User: charly
 * Date: 1/07/19
 * Time: 0:02
 */

namespace App\Tests\App\OrderProcessor;


use App\Entity\Coffee;
use App\Entity\Order;
use App\Entity\User;
use App\Inventory\InventoryOperator;
use App\OrderProcessor\OrderProcessor;
use PHPUnit\Framework\TestCase;

class OrderProcessorTest extends TestCase
{
    /** @var OrderProcessor */
    private $processor;

    protected function setUp()
    {
        $this->processor = new OrderProcessor(new InventoryOperator());
    }

    public function testProcess()
    {
        $user = $this->getUser();
        $coffee = (new Coffee())
            ->setName('ristretto')
            ->setTextPrice(3)
            ->setIntensity(10)
            ->setStock(20);

        $order = $this->processor->process($user, $coffee, 3);

        $this->assertInstanceOf(Order::class, $order);

        $this->assertEquals(3, $order->getQuantity());
        $this->assertEquals(900, $order->getAmount());
        $this->assertSame($user, $order->getUser());
        $this->assertSame($coffee, $order->getCoffee());

    }

    public function testCalculateAmount()
    {
        $this->assertEquals(300, $this->processor->calculateAmount(100, 3));
    }

    private function getUser()
    {
        return new User();
    }
}