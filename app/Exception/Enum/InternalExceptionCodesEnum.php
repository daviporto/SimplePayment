<?php

namespace App\Exception\Enum;

enum InternalExceptionCodesEnum: int
{
    case UserTyneNotAvailable = 1000;
    case PassWordMustHaveAtLeastSixCharacters = 1001;
    case WrongPassword = 1002;
    case EmailAlreadyExists = 1003;
    case CpfAlreadyExists = 1004;
    case EmailNotFound = 1005;

    case MissingAuthenticationHeader = 2003;
    case EmptyAuthenticationHeader = 2004;
    case InvalidToken = 2005;
    case TokenExpired = 2006;
}
