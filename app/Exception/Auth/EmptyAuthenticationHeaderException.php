<?php

namespace App\Exception\Auth;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class EmptyAuthenticationHeaderException extends AbstractSimplePaymentException
{
    public function __construct()
    {
        parent::__construct(
            InternalExceptionMessagesEnum::EmptyAuthenticationHeader->value,
            InternalExceptionCodesEnum::EmptyAuthenticationHeader->value
        );
    }
}
