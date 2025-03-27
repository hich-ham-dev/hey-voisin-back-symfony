<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        // Get data from event
        $data = $event->getData();
        /** @var User $user */
        $user = $event->getUser();

        // Verify if user is instance of UserInterface
        if (!$user instanceof UserInterface) {
            return;
        }

        // Add data to event
        $data['user'] = array(
            'username' => $user->getUserIdentifier(),
            'id' => $user->getId(),
        );

        $event->setData($data);
    }
}