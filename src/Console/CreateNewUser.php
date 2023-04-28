<?php

namespace App\Console;

use App\Command\CreateNewUserCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand('app:create-new-user')]
class CreateNewUser extends Command
{

    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {
        parent::__construct();
    }


    protected function configure(): void
    {
        $this->setDescription('Create a new user');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->messageBus->dispatch(new CreateNewUserCommand('John Doe'));

        return 0;
    }


}