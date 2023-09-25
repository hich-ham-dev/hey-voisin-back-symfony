<?php

namespace App\DataFixtures;

class CategoriesProvider
{
    private $postCategories = [
        'Soutien scolaire',
        'Covoiturage',
        'Bricolage',
        'Jardinage',
        'Aide à domicile',
        
    ];

    /**
     * Retourne une catégorie au hasard
     * @return string
     */
    public function postCategories(): string
    {
        return $this->postCategories[array_rand($this->postCategories)];
    }
}