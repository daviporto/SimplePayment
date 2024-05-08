<?php

namespace App\Exception\User;

use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class UserIdNotFoundException extends AbstractSimplePaymentException
{
    public function __construct(?int $id)
    {
        parent::__construct(
            InternalExceptionMessagesEnum::UserIdNotFound->value,
            InternalExceptionCodesEnum::UserIdNotFound->value
        );

        $this->additionalInfo = [
            'user_id' => $id,
        ];
    }
}
