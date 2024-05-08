<?php

namespace Test\Cases\Api;

use App\Domain\User\UserTypeEnum;
use App\Domain\Wallet\WalletStatusEnum;
use App\Model\Transaction;
use App\Model\User;
use App\Model\Wallet;
use Hyperf\Testing\TestCase;
use Swoole\Http\Status;
use Test\TestUtils;

class CreateTransactionTest extends TestCase
{
    const ROUTE = 'api/transaction';

    const DEFAULT_BALANCE = 1000.00;
    const TRANSACTION_VALUE = 100.00;

    public function testCreateTransaction()
    {
        list($payer, $payee) = $this->createScenario();

        $payload = $this->getPayload($payer, $payee);

        $this->post(
            self::ROUTE,
            $payload,
            ['Authorization' => TestUtils::getToken($payer->id)]
        )
            ->assertStatus(Status::CREATED);

        $this->assertTrue(
            Transaction::where('payer_id', $payer->id)
                ->where('payee_id', $payee->id)
                ->where('value', self::TRANSACTION_VALUE)
                ->exists()
        );

        $this->assertEquals(
            self::DEFAULT_BALANCE - self::TRANSACTION_VALUE,
            Wallet::where('owner_id', $payer->id)->first()->balance
        );

        $this->assertEquals(
            self::DEFAULT_BALANCE + self::TRANSACTION_VALUE,
            Wallet::where('owner_id', $payee->id)->first()->balance
        );
    }

    private function getPayload(User $payer, User $payee): array
    {
        return [
            'payer' => $payer->id,
            'payee' => $payee->id,
            'value' => self::TRANSACTION_VALUE
        ];
    }

    public function createScenario(): array
    {
        $payer = TestUtils::factory(User::class)
            ->create([
                'type' => UserTypeEnum::Customer->value
            ]);

        TestUtils::factory(Wallet::class)
            ->create([
                'owner_id' => $payer->id,
                'balance' => self::DEFAULT_BALANCE,
                'status' => WalletStatusEnum::ACTIVE->value
            ]);


        $payee = TestUtils::factory(User::class)->create();

        TestUtils::factory(Wallet::class)
            ->create([
                'owner_id' => $payee->id,
                'balance' => self::DEFAULT_BALANCE,
                'status' => WalletStatusEnum::ACTIVE->value
            ]);


        return array($payer, $payee);
    }
}
