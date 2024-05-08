<?php

namespace App\Domain\Wallet;

enum WalletStatusEnum: string
{
    case ACTIVE = 'active';
    case BLOCKED = 'blocked';
    case PENDING = 'pending';

    public static function getValues(): array
    {
        return [
            self::ACTIVE->value,
            self::BLOCKED->value,
            self::PENDING->value,
        ];
    }
}
