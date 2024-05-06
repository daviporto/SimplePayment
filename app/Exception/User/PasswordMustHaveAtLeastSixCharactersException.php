<?php

namespace App\Exception\User;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class PasswordMustHaveAtLeastSixCharactersException extends AbstractSimplePaymentException
{
    public function __construct(string $password)
    {
        parent::__construct(
            InternalExceptionMessagesEnum::PassWordMustHaveAtLeastSixCharacters->value,
            InternalExceptionCodesEnum::PassWordMustHaveAtLeastSixCharacters->value
        );

        $this->additionalInfo = [
            'password' => $password,
        ];
    }
}
