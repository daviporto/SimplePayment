<?php

namespace App\Exception\Wallet;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class InsufficientBalanceException extends AbstractSimplePaymentException
{
    public function __construct(float $availableBalance)
    {
        parent::__construct(
            InternalExceptionMessagesEnum::InsufficientBalance->value,
            InternalExceptionCodesEnum::InsufficientBalance->value
        );

        $this->additionalInfo = [
            'available_balance' => $availableBalance
        ];
    }
}
