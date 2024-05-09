<?php

namespace Test\Cases\Unit\Transaction;

use App\Domain\Transaction\TransactionRepositoryInterface;
use Faker\Factory;

class TransactionTestRepository implements TransactionRepositoryInterface
{
    function save(array $data): void
    {
        // test method
    }

    function getTransactions(int $solicitorId): array
    {
        $faker = Factory::create();
        $transaction = [
            'id' => $faker->unique()->randomNumber(),
            'value' => $faker->randomFloat(2, 10, 1000),
            'payer_id' => $faker->unique()->randomNumber(),
            'payee_id' => $faker->unique()->randomNumber(),
        ];

       return array_fill(0, 5, $transaction);
    }
}
