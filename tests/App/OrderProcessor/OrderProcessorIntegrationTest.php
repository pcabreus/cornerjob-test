<?php
/**
 * Created by PhpStorm.
 * User: charly
 * Date: 8/07/19
 * Time: 18:39
 */

namespace App\Tests\App\OrderProcessor;


use App\Entity\Coffee;
use App\Entity\Order;
use App\Entity\User;
use App\OrderProcessor\OrderProcessor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderProcessorIntegrationTest extends KernelTestCase
{
    public function setUp()
    {
        self::bootKernel();
        $this->truncateEntities();
    }

    public function testProcess()
    {
        $orderProcessor = self::$kernel->getContainer()->get('test.' . OrderProcessor::class);

        $em = $this->getEntityManager();

        //@todo not needed for now
    }

    private function getEntityManager()
    {
        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    private function truncateEntities()
    {
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
    }
}