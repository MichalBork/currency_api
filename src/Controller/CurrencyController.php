<?php

namespace App\Controller;

use App\Command\NewCurrencyCommand;
use App\Event\CurrencyRequestEvent;
use App\EventListener\AuthListener;
use App\Service\CurrencyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class CurrencyController extends AbstractController
{


    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly RequestStack $requestStack,
        private readonly CurrencyService $currencyService,

    ) {
        $request = $this->requestStack->getCurrentRequest();
        $apiKey = $request->headers->get('X-API-KEY');
        $method = $request->getMethod();

        $this->eventDispatcher->dispatch(
            new CurrencyRequestEvent($apiKey, $method),
        );
    }

    #[Route('/add-currency', name: 'add_currency', methods: ['POST'])]
    public function addCurrency(Request $request): JsonResponse
    {
        $currencyJson = json_decode($request->getContent(), true) ?? [];


        foreach ($currencyJson as $value) {
            if (!isset($value['currency']) || !isset($value['amount'])) {
                return $this->json([
                    'message' => 'Name and amount are required'
                ], 400);
            }

            $this->messageBus->dispatch(
                new NewCurrencyCommand(
                    $value['currency'],
                    $value['amount']
                )
            );
        }

        return $this->json([
            'message' => 'Currency added'
        ]);
    }


    #[Route('/get-currency/{date}', name: 'get_currency', methods: ['GET'])]
    public function getCurrency(string $date): JsonResponse
    {
        $date = new \DateTimeImmutable($date);
        $currencyObjectList = $this->currencyService->getCurrencyByDate($date->getTimestamp());

        if (empty($currencyObjectList)) {
            return $this->json([
                'message' => 'Currency not found'
            ], 404);
        }


        foreach ($currencyObjectList as $currencyObject) {
            $currencyList[] = [
                'currency' => $currencyObject->getName(),
                'amount' => $currencyObject->getAmount(),
                'date' => date('Y-m-d', $currencyObject->getCreatedAt())
            ];
        }

        return $this->json($currencyList);
    }


    #[Route('/get-currency/{date}/{name}', name: 'get_currency_by_name_and_date', methods: ['GET'])]
    public function getCurrencyByNameAndDate(string $date, string $name): JsonResponse
    {
        $date = new \DateTimeImmutable($date);
        $currencyObject = $this->currencyService->getCurrencyByNameAndDate($name, $date->getTimestamp());

        if (empty($currencyObject)) {
            return $this->json([
                'message' => 'Currency not found'
            ], 404);
        }

        $currencyList = [
            'currency' => $currencyObject->getName(),
            'amount' => $currencyObject->getAmount(),
            'date' => date('Y-m-d', $currencyObject->getCreatedAt())
        ];

        return $this->json($currencyList);
    }


}