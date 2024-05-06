<?php

namespace App\Exception\Auth;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class TokenExpiredException extends AbstractSimplePaymentException
{
    public function __construct()
    {
        parent::__construct(
            InternalExceptionMessagesEnum::TokenExpired->value,
            InternalExceptionCodesEnum::TokenExpired->value
        );
    }
}
