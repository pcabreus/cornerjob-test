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
use App\Factory\OrderFactory;
use App\Inventory\InventoryOperator;
use App\OrderProcessor\OrderProcessor;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class OrderProcessorTest extends TestCase
{
    /** @var OrderProcessor */
    private $processor;

    /**
     * @var InventoryOperator|\PHPUnit_Framework_MockObject_MockObject
     */
    private $inventoryOperator;

    /**
     * @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $entityManager;

    /**
     * @var OrderFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $orderFactory;

    protected function setUp()
    {
        $this->inventoryOperator = $this->createMock(InventoryOperator::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->orderFactory = new OrderFactory();
        $this->processor = new OrderProcessor($this->orderFactory, $this->inventoryOperator, $this->entityManager);
    }

    public function testProcess()
    {
        $user = $this->getUser();

        $coffee = (new Coffee())
            ->setName('ristretto')
            ->setTextPrice(3)
            ->setIntensity(10)
            ->setStock(20);

        $this->inventoryOperator
            ->expects($this->once())
            ->method('hasInStock')
            ->with($coffee, 3)
            ->willReturn(true);

        $this->entityManager
            ->expects($this->exactly(2))
            ->method('persist');

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