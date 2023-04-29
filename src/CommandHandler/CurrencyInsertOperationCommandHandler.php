<?php

namespace App\CommandHandler;

use App\Command\NewCurrencyCommand;
use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use App\Service\CurrencyService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CurrencyInsertOperationCommandHandler
{

    public function __construct(
        private readonly CurrencyService $currencyService,

    ) {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(NewCurrencyCommand $newCurrencyCommand): void
    {
        if ($this->currencyService->isCurrencyExists($newCurrencyCommand->getName())) {
            $this->currencyService->updateCurrency(
                $newCurrencyCommand->getName(),
                $newCurrencyCommand->getAmount() * 100
            );
        } else {
            $this->currencyService->insertCurrency(
                $newCurrencyCommand->getName(),
                $newCurrencyCommand->getAmount() * 100
            );
        }
    }

}