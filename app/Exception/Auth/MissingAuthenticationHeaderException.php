<?php

namespace App\Exception\Auth;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class MissingAuthenticationHeaderException extends AbstractSimplePaymentException
{
    public function __construct()
    {
        parent::__construct(
            InternalExceptionMessagesEnum::MissingAuthenticationHeader->value,
            InternalExceptionCodesEnum::MissingAuthenticationHeader->value
        );
    }
}
