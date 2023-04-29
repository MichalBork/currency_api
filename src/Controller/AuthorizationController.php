<?php

namespace App\Controller;

use App\Command\CheckTokenValidityCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class AuthorizationController extends AbstractController
{

    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {
    }


    #[Route('/check-token-validity', name: 'check_token_validity', methods: ['POST'])]
    public function checkTokenValidity(Request $request): Response
    {
        $this->messageBus->dispatch(new CheckTokenValidityCommand(json_encode($request->request->all())['token']));

        return new Response('', Response::HTTP_OK);
    }

}