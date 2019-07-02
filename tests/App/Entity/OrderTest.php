<?php
/**
 * Created by PhpStorm.
 * User: charly
 * Date: 30/06/19
 * Time: 23:59
 */

namespace App\Tests\App\Entity;


use App\Entity\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testSetAmount()
    {
        $order = new Order();

        $order->setAmount(258);

        $this->assertEquals(258, $order->getAmount());
        $this->assertEquals(2.58, $order->getTextAmount());
    }
}