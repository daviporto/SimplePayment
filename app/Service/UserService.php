<?php

namespace App\Service;

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
        $transactionService = make(TransactionServiceInterface::class);
        $transactionService->begin();

        try {
            make(UserDomain::class, [$repository])
                ->fromArray($data)
                ->hashPassword()
                ->register();

            $transactionService->commit();
        } catch (Exception $e) {
            make(StdoutLoggerInterface::class)->error($e->getMessage());

            $transactionService->rollback();
            throw $e;
        }
    }

    /**
     * @throws Exception
     */
    public function login(array $data): array
    {
        $repository = make(UserRepository::class);
        $transactionService = make(TransactionServiceInterface::class);

        try {
            $user = make(UserDomain::class, [$repository])
                ->load($data['email'])
                ->validatePassword($data['password']);


            $tokenService = make(TokenServiceInterface::class);

            $token = $tokenService->generateToken($user->getId());

            $transactionService->commit();

            return ['token' => $token];
        } catch (Exception $e) {
            make(StdoutLoggerInterface::class)->error($e->getMessage());

            $transactionService->rollback();

            throw $e;
        }
    }
}
