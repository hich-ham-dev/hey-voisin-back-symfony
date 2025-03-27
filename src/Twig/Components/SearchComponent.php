<?php

namespace App\Twig\Components;

use App\Repository\PostRepository;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;

#[AsLiveComponent]
final class SearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $searchInput = '';

    public function __construct(private PostRepository $postRepository)
    {
    }

    #[LiveAction]
    public function getPosts(): array
    {
        // example method that returns an array of Posts
        return $this->postRepository->searchByQuery($this->searchInput);
    }
}