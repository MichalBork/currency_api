<?php

namespace App\CommandHandler;

use App\Command\CreateNewUserCommand;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;


#[AsMessageHandler]
class CreateNewUserCommandHandler
{

    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }


    public function __invoke(CreateNewUserCommand $command): void
    {
        $user = new User($command->getUsername());
        $this->userRepository->save($user);
    }
}