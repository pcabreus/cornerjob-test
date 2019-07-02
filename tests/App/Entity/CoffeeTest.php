<?php
/**
 * Created by PhpStorm.
 * User: charly
 * Date: 30/06/19
 * Time: 23:09
 */

namespace App\Tests\App\Entity;

use App\Entity\Coffee;
use PHPUnit\Framework\TestCase;

class CoffeeTest extends TestCase
{
    public function testSetTextPrice()
    {
        $coffee = new Coffee();

        $coffee->setTextPrice("2.58");

        $this->assertEquals(258, $coffee->getPrice());
        $this->assertEquals(2.58, $coffee->getTextPrice());
    }

    public function testSetPrice()
    {
        $coffee = new Coffee();

        $coffee->setPrice(258);

        $this->assertEquals(258, $coffee->getPrice());
        $this->assertEquals(2.58, $coffee->getTextPrice());
    }

    public function testGetUnitsAndClean()
    {
        $coffee =  new Coffee();

        $coffee->setUnits(10);

        $this->assertEquals(10, $coffee->getUnits());
        $this->assertEquals(10, $coffee->getUnitsAndClean());
        $this->assertEquals(0, $coffee->getUnits());
    }
}
