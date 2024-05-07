<?php

namespace App\Exception\User;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class UserNotLoadedException extends AbstractSimplePaymentException
{
    public function __construct()
    {
        parent::__construct(
            InternalExceptionMessagesEnum::WrongPassword->value,
            InternalExceptionCodesEnum::UserNotLoadedException->value
        );
    }
}
