<?php

namespace App\Domain\User;

class Customer extends UserDomain
{
    const INITIAL_BALANCE = 1000.00;

    public function getInitialBalance(): float
    {
        return self::INITIAL_BALANCE;
    }
}
