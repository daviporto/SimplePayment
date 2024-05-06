<?php

namespace App\Domain\Wallet;

enum WalletStatusEnum: string
{
    case ACTIVE = 'active';
    case BLOCKED = 'blocked';
    case PENDING = 'pending';
}
