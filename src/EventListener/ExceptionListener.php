<?php

namespace App\EventListener;


use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Log\Logger;

#[AsEventListener]
class ExceptionListener
{

    public function __invoke(ExceptionEvent $event): void
    {

        $message = sprintf(
            '[%s]My Error says: %s with code: %s',
            date('Y-m-d H:i:s'),
            $event->getThrowable()->getMessage(),
            $event->getThrowable()->getCode()
        );


        file_put_contents(
            dirname(__DIR__, 2) . '/logs/log.txt',
            $message. PHP_EOL,
            FILE_APPEND
        );



        $response = new JsonResponse(
            [
                'message' => $event->getThrowable()->getMessage(),
                'code' => $event->getThrowable()->getCode()
            ]
        );

        $event->setResponse($response);
    }

}