<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DefaultController.php',
        ]);
    }

    /**
     * @Route("/get_token/{username}", name="get_token")
     */
    public function getToken(EntityManagerInterface $entityManager, JWTTokenManagerInterface $JWTTokenManager, $username)
    {
        if (null === $user = $entityManager->getRepository(User::class)->findOneBy(['username' => $username])) {
            throw new \InvalidArgumentException(sprintf("The provided user `%s` is not valid or is not registered", $username));
        }

        return new JsonResponse(['token' => $JWTTokenManager->create($user)]);
    }
}
