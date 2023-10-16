<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserAppVoter extends Voter
{
    public const VIEW = 'USER_VIEW';
    public const DELETE = 'USER_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // Verify that the attribute is one we support
        if (in_array($attribute, [self::VIEW, self::DELETE])===false) {
            return false;
            }
        
        // Only vote on `Post` objects
        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        if (in_array('ROLE_MODERATOR', $user->getRoles())) {
            switch ($attribute) {
                case 'USER_VIEW':
                    return true;
                    break;

                    case 'USER_DELETE':
                    return true;
                    break;
            }

            return false;
        }
    }   
}

