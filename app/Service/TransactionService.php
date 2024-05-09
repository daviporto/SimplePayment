<?php

namespace App\Service;

use App\Domain\Transaction\TransactionDomain;
use App\Domain\Transaction\TransactionRepository;
use App\Domain\User\UserDomain;
use App\Domain\User\UserDomainInterface;
use App\Domain\User\UserRepository;
use App\Domain\Wallet\WalletDomain;
use App\Domain\Wallet\WalletRepository;
use App\Exception\Wallet\UnauthorizedTransactionException;
use Exception;
use function Hyperf\Coroutine\co;
use function Hyperf\Coroutine\defer;
use function Hyperf\Support\make;

class TransactionService implements TransactionServiceInterface
{
    /**
     * @throws Exception
     */
    public function create(array $data, int $requesterId): void
    {
        $dataTransactionService = make(DataTransactionServiceInterface::class);

        try {
            $dataTransactionService->begin();

            $payer = make(UserDomain::class, [make(UserRepository::class)])->loadById($data['payer']);
            $payee = make(UserDomain::class, [make(UserRepository::class)])->loadById($data['payee']);

            $payer->canExecutePayment($requesterId);

            /** @var float $value */
            $value = $data['value'];

            $payerWallet = make(WalletDomain::class, [make(WalletRepository::class)])
                ->loadByOwnerId($payer->getId())
                ->canTransfer($data['value']);

            $this->checkExternalAuthorization($payer, $payee, $value);

            $payeeWallet = make(WalletDomain::class, [make(WalletRepository::class)])
                ->loadByOwnerId($payee->getId());

            $this->executeTransaction($payerWallet, $payeeWallet, $value);

            defer(function () use ($payer, $payee, $value) {
                $this->sendConfirmationEmails($payer, $payee, $value);
            });

            $dataTransactionService->commit();
        } catch (Exception $e) {
            make(ErrorReporterServiceInterface::class)->handle($e);

            $dataTransactionService->rollback();

            throw $e;
        }
    }

    private function executeTransaction(WalletDomain $payerWallet, WalletDomain $payeeWallet, float $value): void
    {
        $payerWallet->withdraw($value);
        $payeeWallet->deposit($value);

        make(TransactionDomain::class, [make(TransactionRepository::class)])
            ->create([
                'payer_id' => $payerWallet->getOwnerId(),
                'payee_id' => $payeeWallet->getOwnerId(),
                'value' => $value
            ]);
    }

    private function checkExternalAuthorization(
        UserDomainInterface $payer,
        UserDomainInterface $payee,
        float               $value
    ): void
    {
        $externalService = make(ExternalAuthorizationServiceInterface::class);

        if (!$externalService->checkAuthorization($payer->getCpf(), $payee->getCpf(), $value)) {
            throw new UnauthorizedTransactionException();
        }
    }

    private function sendConfirmationEmails(UserDomainInterface $payer, UserDomainInterface $payee, float $value): void
    {
        co(fn() => $this->sendPaymentMadeEmail($payer, $value));
        co(fn() => $this->sendPaymentReceivedEmail($payee, $value));
    }

    private function sendPaymentMadeEmail(UserDomainInterface $payer, float $value): void
    {
        make(EmailServiceInterface::class)
            ->sendEmail($payer->getEmail(), 'Payment Made', "You made a payment of $value");
    }

    private function sendPaymentReceivedEmail(UserDomainInterface $payee, float $value): void
    {
        make(EmailServiceInterface::class)
            ->sendEmail($payee->getEmail(), 'Payment Received', "You received a payment of $value");
    }

    public function getTransactions(int $solicitorId): array
    {
        $transactions =  make(TransactionDomain::class, [make(TransactionRepository::class)])
            ->getTransactions($solicitorId);

        return array_map(function (TransactionDomain $transaction) {
            return $transaction->toArray();
        }, $transactions);
    }
}
