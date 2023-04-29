<?php

namespace App\Repository;

use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CurrencyRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Currency::class);
    }

    public function save(Currency $currency): void
    {
        $entity = $this->getEntityManager();
        $entity->persist($currency);
        $entity->flush();
    }

    public function findOneByNameAndDate(string $name, \DateTimeImmutable $date): ?Currency
    {
        return $this->findOneBy([
            'name' => $name,
            'createdAt' => $date
        ]);
    }

}