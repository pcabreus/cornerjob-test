<?php

namespace App\Controller\Action;

use App\Entity\Coffee;
use App\OrderProcessor\OrderProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;

/**
 * Class BuyCoffee
 * @package App\COntroller\Action
 */
class BuyCoffeeAction
{
    private $processor;
    private $entityManager;
    private $tokenStorage;
    private $validator;

    public function __construct(OrderProcessor $orderProcessor, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, ValidatorInterface $validator)
    {
        $this->processor = $orderProcessor;
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->validator = $validator;
    }

    /**
     * @param Coffee $data
     * @param $units
     * @return Coffee
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(Coffee $data): Coffee
    {
        $user = $this->getUser();

        $this->validator->validate($data);

        $order = $this->processor->process($user, $data, $data->getUnitsAndClean());

        $this->entityManager->persist($order);
        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }

    public function getUser()
    {
        return $this->entityManager->getRepository('App\Entity\User')->findOneBy(['username' => 'customer']);
//        $this->tokenStorage->getToken()->getUser()
    }

}