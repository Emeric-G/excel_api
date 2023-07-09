<?php

namespace App\EventListener;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener{


    public function __construct(private UserRepository $userRepository)
    {
        
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();
    
        if (!$user instanceof UserInterface) {
            return;
        }

        // $this->userRepository->loadUserByIdentifier($user->getUserIdentifier())->getId();
    
        $data['user'] = array(
            'id' => $this->userRepository->loadUserByIdentifier($user->getUserIdentifier())->getId(),
        );
    
        $event->setData($data);
    }

}