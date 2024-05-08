<?php

declare(strict_types=1);


use App\Domain\Wallet\WalletStatusEnum;
use App\Model\User;
use App\Model\Wallet;
use Hyperf\Testing\ModelFactory;
use Test\TestUtils;

/* @var ModelFactory $factory */
$factory->define(Wallet::class, function (Faker\Generator $faker) {
    return [
        'owner_id' => fn() => TestUtils::factory(User::class)->create()->id,
        'balance' => $faker->randomFloat(2, 500, 1000),
        'status' => $faker->randomElement(WalletStatusEnum::getValues()),
    ];
});
