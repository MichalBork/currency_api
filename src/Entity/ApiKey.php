<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;


#[Entity]
class ApiKey
{
    //id (int, primary key, auto increment)
    //key (varchar)
    //created_at (datetime)


    #[Id]
    #[Column(type: 'string', unique: true)]
    #[GeneratedValue(strategy: 'NONE')]
    private string $id;

    #[OneToOne(inversedBy: 'apiKeys', targetEntity: User::class)]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;


    public function __construct(User $user)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->user = $user;
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }




}