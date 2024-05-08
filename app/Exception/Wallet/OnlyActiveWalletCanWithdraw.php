<?php

namespace App\Exception\Wallet;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class OnlyActiveWalletCanWithdraw extends AbstractSimplePaymentException
{
    public function __construct()
    {
        parent::__construct(
            InternalExceptionMessagesEnum::OnlyActiveWalletCanWithdraw->value,
            InternalExceptionCodesEnum::OnlyActiveWalletCanWithdraw->value
        );
    }
}
