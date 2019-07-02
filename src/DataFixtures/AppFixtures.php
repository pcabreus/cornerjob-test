<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Coffee;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

    	$admin = (new User('admin'))
    				->setPlainPassword('123')
    				->addRole(User::ROLE_ADMIN);
//        $tokenAdmin = $JWTTokenManager->create($admin);

    	$customer = (new User('customer'))
    				->setPlainPassword('123')
    				->addRole(User::ROLE_CUSTOMER);
//        $tokenCustomer = $JWTTokenManager->create($customer);

    	$manager->persist($admin);
    	$manager->persist($customer);

        $coffeesData = [
            ['name' => 'ristretto', 'intensity' => 10, 'price' => 3, 'stock' => 20],
            ['name' => 'cubita', 'intensity' => 6, 'price' => 2, 'stock' => 50],
            ['name' => 'bustelo', 'intensity' => 9, 'price' => 6, 'stock' => 5],
            ['name' => 'serrano', 'intensity' => 10, 'price' => 3, 'stock' => 10]
        ];

        foreach ($coffeesData as $key => $value) {
            $coffee = (new Coffee())
                            ->setName($value['name'])
                            ->setIntensity($value['intensity'])
                            ->setTextPrice($value['price'])
                            ->setStock($value['stock']);
            $manager->persist($coffee);
        }

        $manager->flush();
    }
}
