<?php

namespace App\CommandHandler;

use App\Auth\GetAuthStrategy;
use App\Auth\PostAuthStrategy;
use App\Command\CheckRoleValidityCommand;
use App\Exception\InvalidPermissionException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CheckRoleValidityCommandHandler
{


    /**
     * @throws InvalidPermissionException
     */
    public function __invoke(CheckRoleValidityCommand $checkRoleValidityCommand): void
    {
        $userRole = [];
        if ($checkRoleValidityCommand->getMethod() === 'GET') {
            $guard = new GetAuthStrategy();
        } else {
            $guard = new PostAuthStrategy();
        }

        foreach ($checkRoleValidityCommand->getUser()->getRoles()->getValues() as $role) {
            $userRole[] = $role->getName();
        }

        $guard->checkRole($userRole);
    }


}