<?php

namespace App\Exception\User\Customer;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class OnlyOwnUserCanExecutePaymentException extends AbstractSimplePaymentException
{
    public function __construct()
    {
        parent::__construct(
            InternalExceptionMessagesEnum::OnlyOwnUserCanExecutePayment->value,
            InternalExceptionCodesEnum::OnlyOwnUserCanExecutePayment->value
        );
    }
}
