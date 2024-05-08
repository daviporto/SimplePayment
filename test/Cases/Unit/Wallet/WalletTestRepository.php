<?php

namespace Test\Cases\Unit\Wallet;

use App\Domain\Wallet\WalletRepositoryInterface;
use App\Domain\Wallet\WalletStatusEnum;
use Faker\Factory;
use function Hyperf\Support\make;

class WalletTestRepository implements WalletRepositoryInterface
{

    public function save(array $toArray): void
    {
        // test method
    }

    public function loadFromOwnerId(int $ownerId): array
    {
        $faker = make(Factory::class)->create();

        return [
            'id' => $faker->unique()->randomNumber(),
            'owner_id' => $ownerId,
            'balance' => 0.00,
            'status' =>  WalletStatusEnum::ACTIVE->value
        ];
    }

    public function updateBalance(int $id, float $balance): void
    {
        // test method
    }

    public function ownerHasWallet(int $ownerId): bool
    {
        return $ownerId % 2 == 0;
    }
}
