<?php

namespace App\Exception\Transaction;

use App\Domain\Transaction\TransactionDomain;
use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class MinAllowedTransactionValueException extends AbstractSimplePaymentException
{
    public function __construct()
    {
        parent::__construct(
            InternalExceptionMessagesEnum::MinAllowedTransactionValue->value,
            InternalExceptionCodesEnum::MinAllowedTransactionValue->value
        );

        $this->additionalInfo = [
            'minAValueAllowed' => TransactionDomain::MIN_TRANSACTION_VALUE
        ];
    }
}
