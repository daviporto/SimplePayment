<?php

namespace App\Exception\User;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class CpfAlreadyExistsException extends AbstractSimplePaymentException
{
    public function __construct(?string $cpf)
    {
        parent::__construct(
            InternalExceptionMessagesEnum::CpfAlreadyExists->value,
            InternalExceptionCodesEnum::CpfAlreadyExists->value
        );

        $this->additionalInfo = [
            'cpf' => $cpf,
        ];
    }
}
