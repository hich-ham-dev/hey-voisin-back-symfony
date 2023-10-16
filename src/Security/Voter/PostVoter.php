<?php

namespace App\Security\Voter;

use App\Entity\Post;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PostVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';
    public const DELETE = 'POST_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // Verify that the attribute is one we support
        if (!in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])) {
            return false;
            }
        
        // Only vote on `Post` objects
        if (!$subject instanceof Post) {
            return false;
        }

        return true;
    }

    public function __construct(
        private Security $security,
    ) {

    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if ($this->security->isGranted('ROLE_MODERATOR')) {
            // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return true;

                break;

            case self::VIEW:
                return true;

                break;
            
            case self::DELETE:
                return true;

                break;
        }

        return false;
        }
    }
}
