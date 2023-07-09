<?php

namespace App\EntityListener;

use App\Entity\User;
use Doctrine\ORM\Events;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(event: Events::prePersist, entity: User::class)]
class UserEntityListener
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
        
    }

    public function prePersist(User $user, LifecycleEventArgs $event): void
    {
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $user->getPlainPassword()));
        $user->setRoles(["ROLE_USER"]);
    }
    
}