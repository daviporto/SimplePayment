<?php

namespace App\Domain\User;

use App\Exception\User\Customer\OnlyOwnUserCanExecutePaymentException;

class Customer extends UserDomain
{
    const INITIAL_BALANCE = 1000.00;

    public function getInitialBalance(): float
    {
        return self::INITIAL_BALANCE;
    }

    public function canExecutePayment(int $requesterId): self
    {
        if ($this->getId() !== $requesterId) {
            throw new OnlyOwnUserCanExecutePaymentException();
        }

        return $this;
    }
}
