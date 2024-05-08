<?php

namespace App\Domain\Wallet;

interface WalletRepositoryInterface
{
    function save(array $toArray): void;

    function loadFromOwnerId(int $ownerId): array;

    function updateBalance(int $id, float $balance): void;

    public function ownerHasWallet(int $ownerId): bool;
}
