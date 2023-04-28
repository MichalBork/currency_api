<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class Role
{

    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    private int $id;

    #[Column(type: 'string')]
    private string $name;

    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ManyToOne(targetEntity: User::class, inversedBy: 'roles')]
    private User $user;


    public function __construct(string $name, User $user)
    {
        $this->name = $name;
        $this->user = $user;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromUser(User $user, string $role): self
    {
        return new self($role, $user);
    }

}