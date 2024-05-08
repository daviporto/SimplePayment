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
    case OnlyOwnUserCanExecutePayment = 'only own user can execute payment';
    case RetailerCantExecutePayment = 'retailer cant execute payment';
    case UserIdNotFound = 'user id not found';

    case MissingAuthenticationHeader = 'missing authentication header';
    case EmptyAuthenticationHeader = 'empty authentication header';
    case InvalidToken = 'invalid token';
    case TokenExpired = 'token expired';

    case InvalidWalletStatus = 'invalid wallet status';
    case InsufficientBalance = 'insufficient balance';
    case UnauthorizedTransaction = 'unauthorized transaction';
    case OnlyActiveWalletCanWithdraw = 'only active wallet can withdraw';
    case OnlyActiveWalletCanDeposit = 'only active wallet can deposit';
}
