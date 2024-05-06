<?php

namespace App\Exception\User;

use App\Domain\User\UserTypeEnum;
use App\Exception\AbstractSimplePaymentException;
use App\Exception\Enum\InternalExceptionCodesEnum;
use App\Exception\Enum\InternalExceptionMessagesEnum;

class UserTypeNowAllowedException extends AbstractSimplePaymentException
{
    public function __construct(?string $type)
    {
        parent::__construct(
            InternalExceptionMessagesEnum::UserTyneNotAvailable->value,
            InternalExceptionCodesEnum::UserTyneNotAvailable->value
        );

        $this->additionalInfo = [
            'type' => $type,
            'availableTypes' => UserTypeEnum::getTypesAsString()
        ];
    }
}
