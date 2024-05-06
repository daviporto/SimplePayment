<?php

namespace App\Exception\User;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class EmailNotFoundException extends AbstractSimplePaymentException
{
    public function __construct(?string $email)
    {
        parent::__construct(
            InternalExceptionMessagesEnum::EmailNotFound->value,
            InternalExceptionCodesEnum::EmailNotFound->value
        );

        $this->additionalInfo = [
            'email' => $email,
        ];
    }
}
