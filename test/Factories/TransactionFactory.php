<?php

declare(strict_types=1);


use App\Domain\Wallet\WalletStatusEnum;
use App\Model\Transaction;
use App\Model\User;
use Hyperf\Testing\ModelFactory;
use Test\TestUtils;

/* @var ModelFactory $factory */
$factory->define(Transaction::class, function (Faker\Generator $faker) {
    return [
        'payer_id' => fn() => TestUtils::factory(User::class)->create()->id,
        'payee_id' => fn() => TestUtils::factory(User::class)->create()->id,
        'value' => $faker->randomFloat(2, 1, 50),
    ];
});
