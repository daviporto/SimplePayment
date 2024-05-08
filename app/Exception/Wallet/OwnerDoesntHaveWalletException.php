<?php

namespace App\Exception\Wallet;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class OwnerDoesntHaveWalletException extends AbstractSimplePaymentException
{
    public function __construct(?int $ownerId)
    {
        parent::__construct(
            InternalExceptionMessagesEnum::OwnerDoesntHaveWallet->value,
            InternalExceptionCodesEnum::OwnerDoesntHaveWallet->value
        );

        $this->additionalInfo = [
            'ownerId' => $ownerId
        ];
    }
}
