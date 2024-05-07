<?php

namespace App\Exception\Enum;

enum InternalExceptionMessagesEnum: string
{
    case UserTyneNotAvailable = 'user type not available';
    case PassWordMustHaveAtLeastSixCharacters = 'password must have at least six characters';
    case WrongPassword = 'wrong password';
    case EmailAlreadyExists = 'email already exists';
    case CpfAlreadyExists = 'cpf already exists';
    case EmailNotFound = 'email not found';
    case UserNotLoadedException = 'user not loaded';

    case MissingAuthenticationHeader = 'missing authentication header';
    case EmptyAuthenticationHeader = 'empty authentication header';
    case InvalidToken = 'invalid token';
    case TokenExpired = 'token expired';

    case InvalidWalletStatus = 'invalid wallet status';
}
