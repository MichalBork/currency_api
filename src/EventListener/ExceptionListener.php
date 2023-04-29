<?php

namespace App\EventListener;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{

    public function __invoke(ExceptionEvent $event): JsonResponse
    {
        $exception = $event->getThrowable();

        return new JsonResponse([
            'error' => $exception->getMessage(),


        ], $exception->getCode() ?? 500);
    }

}