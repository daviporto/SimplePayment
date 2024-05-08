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
    case UserNotLoadedException = 1006;
    case OnlyOwnUserCanExecutePayment = 1007;
    case RetailerCantExecutePayment = 1008;
    case UserIdNotFound = 1009;

    case MissingAuthenticationHeader = 2003;
    case EmptyAuthenticationHeader = 2004;
    case InvalidToken = 2005;
    case TokenExpired = 2006;

    case InvalidWalletStatus = 3000;
    case InsufficientBalance = 3001;
    case UnauthorizedTransaction = 3002;
    case OnlyActiveWalletCanWithdraw = 3003;
    case OnlyActiveWalletCanDeposit = 3004;
    case OwnerDoesntHaveWallet = 3005;

    case MinAllowedTransactionValue = 4000;
}
