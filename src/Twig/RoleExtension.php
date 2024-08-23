<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class RoleExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('role_format', [$this, 'formatRole']),
        ];
    }

    public function formatRole(string $role): string
    {
        // Convert the role to a more readable format
        switch ($role) {
            case 'ROLE_ADMIN':
                return 'Admin';
            case 'ROLE_MODERATOR':
                return 'Moderator';
            case 'ROLE_USER':
                return 'User';
            default:
                return ucfirst(strtolower(str_replace('ROLE_', '', $role)));
        }
    }
}
