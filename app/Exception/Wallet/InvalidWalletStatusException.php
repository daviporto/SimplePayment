<?php

namespace App\Exception\Wallet;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class InvalidWalletStatusException extends AbstractSimplePaymentException
{
    public function __construct(?string $status)
    {
        parent::__construct(
            InternalExceptionMessagesEnum::InvalidWalletStatus->value,
            InternalExceptionCodesEnum::InvalidWalletStatus->value
        );

        $this->additionalInfo = [
            'status' => $status,
        ];
    }
}
