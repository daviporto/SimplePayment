<?php

namespace App\Service;

use App\Domain\Abstract\AbstractRepository;
use App\Domain\User\UserDomain;
use App\Domain\User\UserRepository;
use Exception;
use Hyperf\Contract\StdoutLoggerInterface;
use function Hyperf\Support\make;

class UserService implements UserServiceInterface
{
    /**
     * @throws Exception
     */
    public function register(array $data): void
    {
        $repository = make(UserRepository::class);
        AbstractRepository::beginTransaction();

        try {
            make(UserDomain::class, [$repository])
                ->fromArray($data)
                ->hashPassword()
                ->register();

            AbstractRepository::commitTransaction();
        } catch (Exception $e) {
            make(StdoutLoggerInterface::class)->error($e->getMessage());

            AbstractRepository::rollbackTransaction();

            throw $e;
        }
    }

    public function login(array $data): array
    {
        $repository = make(UserRepository::class);
        AbstractRepository::beginTransaction();

        try {
          $user = make(UserDomain::class, [$repository])
                ->load($data['email'])
                ->validatePassword($data['password']);


            $tokenService = make(TokenServiceInterface::class);

            $token = $tokenService->generateToken($user->getId());

            return['token' => $token];

            AbstractRepository::commitTransaction();
        } catch (Exception $e) {
            make(StdoutLoggerInterface::class)->error($e->getMessage());

            AbstractRepository::rollbackTransaction();

            throw $e;
        }
    }
}
