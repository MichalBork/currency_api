<?php

namespace App\Controller;

use App\Command\CheckTokenValidityCommand;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class AuthorizationController extends AbstractController
{

    const TOKEN_VALIDITY_CHECKED = 'Your token is valid';

    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {
    }


    #[Route('/check-token-validity', name: 'check_token_validity', methods: ['POST'])]
    public function checkTokenValidity(Request $request): JsonResponse
    {
        $this->messageBus->dispatch(new CheckTokenValidityCommand($request->request->get('token')));

        return $this->json([
            'message' => self::TOKEN_VALIDITY_CHECKED
        ]);
    }

}