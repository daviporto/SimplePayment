<?php

namespace App\Exception\User;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class EmailAlreadyExistsException extends AbstractSimplePaymentException
{
    public function __construct(?string $email)
    {
        parent::__construct(
            InternalExceptionMessagesEnum::EmailAlreadyExists->value,
            InternalExceptionCodesEnum::EmailAlreadyExists->value
        );

        $this->additionalInfo = [
            'email' => $email,
        ];
    }
}
