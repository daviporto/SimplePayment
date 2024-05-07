<?php

namespace App\Domain\Wallet;

interface WalletRepositoryInterface
{
    public function save(array $toArray): void;
}
