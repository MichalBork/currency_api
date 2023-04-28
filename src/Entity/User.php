<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;

#[Entity(repositoryClass: 'App\Repository\UserRepository')]
class User
{

    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    private int $id;

    #[Column(type: 'string')]
    private string $username;

    #[Column(name: 'created_at', type: 'datetime')]
    private \DateTime $createdAt;

    #[OneToOne(mappedBy: 'user', targetEntity: ApiKey::class, cascade: ['persist', 'remove'])]
    private ApiKey $apiKeys;

    #[OneToMany(mappedBy: 'user', targetEntity: Role::class, cascade: ['persist'])]
    private Collection $roles;

    public function __construct(string $username)
    {
        $this->username = $username;
        $this->createdAt = new \DateTime();
        $this->apiKeys = $this->createSessionToken();
        $this->roles = new ArrayCollection();
        $this->roles->add(Role::fromUser($this, 'ROLE_USER'));
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getApiKey(): ApiKey
    {
        return $this->apiKeys;
    }

    public function createSessionToken(): ApiKey
    {
        $this->apiKeys = new ApiKey($this);
        return $this->apiKeys;
    }

    public function getRoles(): Collection
    {
        return $this->roles;
    }


}