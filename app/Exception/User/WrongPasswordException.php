<?php

namespace App\Exception\User;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class WrongPasswordException extends AbstractSimplePaymentException
{
    public function __construct()
    {
        parent::__construct(
            InternalExceptionMessagesEnum::WrongPassword->value,
            InternalExceptionCodesEnum::WrongPassword->value
        );
    }
}
