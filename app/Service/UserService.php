<?php

namespace App\Service;

use App\Domain\User\UserDomain;
use App\Domain\User\UserDomainInterface;
use App\Domain\User\UserRepository;
use App\Domain\Wallet\WalletDomain;
use App\Domain\Wallet\WalletRepository;
use App\Domain\Wallet\WalletRepositoryInterface;
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
        $transactionService = make(DataTransactionServiceInterface::class);
        $transactionService->begin();

        try {
            make(UserDomain::class, [$repository])
                ->fromArray($data)
                ->hashPassword()
                ->register();

            $user = make(UserDomain::class, [$repository])
                ->loadByEmail($data['email']);

            $this->createWallet($user);

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
        $transactionService = make(DataTransactionServiceInterface::class);

        try {
            $user = make(UserDomain::class, [$repository])
                ->loadByEmail($data['email'])
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

    private function createWallet(UserDomainInterface $user): void
    {
        make(WalletDomain::class, [make(WalletRepository::class)])
            ->createWallet($user->getId(), $user->getInitialBalance());
    }
}
