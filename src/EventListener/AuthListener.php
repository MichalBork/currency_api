<?php

namespace App\EventListener;

use App\Command\CheckRoleValidityCommand;
use App\Command\CheckTokenValidityCommand;
use App\Event\CurrencyRequestEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsEventListener(
    event: CurrencyRequestEvent::class,
    method: 'onCurrencyRequest'
)]
class AuthListener
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus
    ) {
    }


    public function onCurrencyRequest(CurrencyRequestEvent $event): void
    {
        $token = $this->handle(new CheckTokenValidityCommand($event->getApiKey()));

       $this->messageBus->dispatch(new CheckRoleValidityCommand($token->getUser(), $event->getMethod()));
    }


}