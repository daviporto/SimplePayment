<?php

namespace Test\Cases\Api;

use App\Domain\User\UserTypeEnum;
use App\Model\Transaction;
use App\Model\User;
use Hyperf\Testing\TestCase;
use Swoole\Http\Status;
use Test\TestUtils;

class ShowTransactionsTest extends TestCase
{
    const ROUTE = 'api/transfer';

    public function testLogin()
    {
        /** @var User $user */
        $user = TestUtils::factory(User::class)->create([
            'type' => UserTypeEnum::Customer->value
        ]);

        $transactionThatUserIsPayer = TestUtils::factory(Transaction::class)
            ->times(5)
            ->create([
                'payer_id' => $user->id
            ])
            ->pluck('payer_id');

        $transactionThatUserIsPayee = TestUtils::factory(Transaction::class)
            ->times(5)
            ->create([
                'payee_id' => $user->id
            ])
            ->pluck('payee_id');


        $response = $this->get(
            self::ROUTE,
            headers: ['Authorization' => TestUtils::getToken($user->id)]
        )
            ->assertStatus(Status::OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'payerId',
                        'payeeId',
                        'value',
                        'createdAt'
                    ]
                ]
            ]);

        $payerIds = $response->json('data.*.payerId');
        $payeeIds = $response->json('data.*.payeeId');

        $this->assertEmpty($transactionThatUserIsPayer->diff($payerIds));
        $this->assertEmpty($transactionThatUserIsPayee->diff($payeeIds));
    }
}
