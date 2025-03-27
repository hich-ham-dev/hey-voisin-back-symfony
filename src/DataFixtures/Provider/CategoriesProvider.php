<?php

namespace App\DataFixtures\Provider;

class CategoriesProvider
{
    // Predifined post categories
    private array $postCategories = [
        'Soutien scolaire',
        'Covoiturage',
        'Bricolage',
        'Jardinage',
        'Aide à domicile',
        
    ];

    /**
     * Randomly return a post category
     * @return string
     */
    public function postCategories(): string
    {
        return $this->postCategories[array_rand($this->postCategories)];
    }
}