<?php

namespace App\Exception\Auth;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class InvalidTokenException extends AbstractSimplePaymentException
{
    public function __construct(?string $token)
    {
        parent::__construct(
            InternalExceptionMessagesEnum::InvalidToken->value,
            InternalExceptionCodesEnum::InvalidToken->value
        );

        $this->additionalInfo = [
            'token' => $token,
        ];
    }
}
