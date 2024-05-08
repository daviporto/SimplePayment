<?php

namespace App\Domain\User;

use App\Exception\User\Retailer\RetailerCantExecutePaymentException;

class Retailer extends UserDomain
{
    const INITIAL_BALANCE = 0.00;

    public function getInitialBalance(): float
    {
        return self::INITIAL_BALANCE;
    }

    public function canExecutePayment(int $requesterId): UserDomain
    {
        throw new RetailerCantExecutePaymentException();
    }
}
