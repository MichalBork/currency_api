<?php

namespace App\Auth;

use App\Exception\InvalidPermissionException;

class GetAuthStrategy implements AuthStrategyInterface
{
    const ROLE_WITH_PERMISSION = ['ROLE_READ','ROLE_USER'];

    /**
     * @throws InvalidPermissionException
     */
    public function checkRole(array $roles): void
    {
        foreach ($roles as $role) {
            $authorized = in_array($role, self::ROLE_WITH_PERMISSION);
            if ($authorized) {
                return;
            }
        }

        throw new InvalidPermissionException('You are not allowed to perform this action');

    }
}

{
}