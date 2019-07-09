<?php
/**
 * Created by PhpStorm.
 * User: charly
 * Date: 8/07/19
 * Time: 13:28
 */

namespace App\Tests\App\Factory;


use App\Entity\Coffee;
use App\Entity\Order;
use App\Entity\User;
use App\Factory\OrderFactory;
use PHPUnit\Framework\TestCase;

class OrderFactoryTest extends TestCase
{
    public function testCreate()
    {
        $orderFactory = new OrderFactory();

        $coffee = new Coffee();
        $user = new User();
        $units = 12;
        $amount = 100;
        $order = $orderFactory->create($coffee, $user, $units, $amount);

        $this->assertInstanceOf(Order::class, $order);

        $this->assertEquals($coffee, $order->getCoffee());
        $this->assertEquals($user, $order->getUser());
        $this->assertEquals($units, $order->getQuantity());
        $this->assertEquals($amount, $order->getAmount());
    }
}