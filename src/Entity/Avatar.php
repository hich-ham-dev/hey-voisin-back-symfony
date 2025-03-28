<?php

namespace App\Entity;

use App\Repository\AvatarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
#[ORM\Entity(repositoryClass: AvatarRepository::class)]
class Avatar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['avatars'])]
    private ?int $id = null;

    #[ORM\Column(length: 2100)]
    #[Groups(['avatars', 'posts','categories', 'users'])]
    private string $url;

    #[ORM\Column(length: 25)]
    #[Groups(['avatars'])]
    private string $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        if(empty($url)){
            throw new \TypeError('Url cannot be empty');
        }
        $this->url = $url;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        if(empty($name)){
            throw new \TypeError('Name cannot be empty');
        }
        $this->name = $name;

        return $this;
    }
}
