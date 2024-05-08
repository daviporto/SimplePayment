<?php

namespace App\Exception\Wallet;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class OnlyActiveWalletCanDepositException extends AbstractSimplePaymentException
{
    public function __construct()
    {
        parent::__construct(
            InternalExceptionMessagesEnum::OnlyActiveWalletCanDeposit->value,
            InternalExceptionCodesEnum::OnlyActiveWalletCanDeposit->value
        );
    }
}
