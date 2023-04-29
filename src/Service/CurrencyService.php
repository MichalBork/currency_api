<?php

namespace App\Service;

use App\Entity\Currency;
use App\Exception\CurrencyValidationException;
use App\Repository\CurrencyRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\DateImmutableType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CurrencyService
{

    public function __construct(
        private readonly CurrencyRepository $currencyRepository,
        private readonly ValidatorInterface $validator

    ) {
    }


    public function isCurrencyExists(string $name): bool
    {
        return $this->currencyRepository->findOneBy(
                ['name' => $name, 'createdAt' => (new DateTimeImmutable('midnight'))->getTimestamp()]
            ) !== null;
    }


    private function getCurrency(string $name): Currency
    {
        return $this->currencyRepository->findOneBy(['name' => $name]);
    }


    /**
     * @throws \Exception
     */
    public function updateCurrency(string $name, int $amount): void
    {
        $currency = $this->getCurrencyByNameAndDate($name, (new DateTimeImmutable('midnight'))->getTimestamp());
        $currency->setAmount($amount);
        $currency->setCreatedAt((new \DateTimeImmutable('midnight'))->getTimestamp());

        $this->currencyValidate($currency);

        $this->currencyRepository->save($currency);
    }

    /**
     * @throws \Exception
     */
    public function insertCurrency(string $name, int $amount): void
    {
        $currency = new Currency(
            $name,
            $amount,
        );

        $this->currencyValidate($currency);
        $this->currencyRepository->save($currency);
    }

    /**
     * @param Currency $currency
     * @return void
     * @throws \Exception
     */
    public function currencyValidate(Currency $currency): void
    {
        $errors = $this->validator->validate($currency);
        if (count($errors) > 0) {
            throw new CurrencyValidationException((string)$errors);
        }
    }


    public function getCurrencyByDate(int $date): array
    {
        return $this->currencyRepository->findBy(['createdAt' => $date]);
    }

    public function getCurrencyByNameAndDate(string $name, int $date): ?Currency
    {
        return $this->currencyRepository->findOneBy(['name' => $name, 'createdAt' => $date]);
    }

}