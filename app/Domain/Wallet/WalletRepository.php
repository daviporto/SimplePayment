<?php

namespace App\Domain\Wallet;

use App\Model\Wallet;

class WalletRepository implements WalletRepositoryInterface
{
    public function save(array $data): void
    {
        Wallet::create($data);
    }
}
