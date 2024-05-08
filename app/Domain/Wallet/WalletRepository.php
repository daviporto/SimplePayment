<?php

namespace App\Domain\Wallet;

use App\Model\Wallet;

class WalletRepository implements WalletRepositoryInterface
{
    public function save(array $data): void
    {
        Wallet::create($data);
    }

    public function loadFromOwnerId(int $ownerId): array
    {
        return Wallet::where('owner_id', $ownerId)->first()->toArray();
    }

    public function updateBalance(int $id, float $balance): void
    {
        Wallet::where('id', $id)->update(['balance' => $balance]);
    }

    public function ownerHasWallet(int $ownerId): bool
    {
        return Wallet::where('owner_id', $ownerId)->exists();
    }
}
