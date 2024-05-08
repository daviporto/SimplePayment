<?php

namespace App\Exception\User\Retailer;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class RetailerCantExecutePaymentException extends AbstractSimplePaymentException
{
    public function __construct()
    {
        parent::__construct(
            InternalExceptionMessagesEnum::RetailerCantExecutePayment->value,
            InternalExceptionCodesEnum::RetailerCantExecutePayment->value
        );
    }
}
