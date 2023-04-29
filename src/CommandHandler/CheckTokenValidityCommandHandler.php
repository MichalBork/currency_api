<?php

namespace App\CommandHandler;

use App\Command\CheckTokenValidityCommand;
use App\Entity\ApiKey;
use App\Exception\InvalidAuthTokenException;
use App\Repository\ApiKeyRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CheckTokenValidityCommandHandler
{

    public function __construct(
        private readonly ApiKeyRepository $apiKeyRepository
    )
    {
    }

    /**
     * @throws InvalidAuthTokenException
     */
    public function __invoke(CheckTokenValidityCommand $checkTokenValidityCommand): ApiKey
    {

        $apiKey = $this->apiKeyRepository->findOneBy([
            'id' => $checkTokenValidityCommand->getToken()
        ]);

        if ($apiKey === null) {
            throw new InvalidAuthTokenException('Invalid token');
        }

        return $apiKey;

    }
}