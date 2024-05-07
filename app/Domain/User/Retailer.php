<?php

namespace App\Domain\User;

class Retailer extends UserDomain
{
    const INITIAL_BALANCE = 0.00;

    public function getInitialBalance(): float
    {
        return self::INITIAL_BALANCE;
    }
}
