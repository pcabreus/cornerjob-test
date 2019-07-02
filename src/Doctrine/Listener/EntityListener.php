<?php

namespace App\Doctrine\Listener;


use App\Entity\User;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EntityListener implements EntityListenerInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function preFlush(User $user, PreFlushEventArgs $event)
    {
        if (!empty($user->getPlainPassword())) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
        }
    }

    public function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
    }

}