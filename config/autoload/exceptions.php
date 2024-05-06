<?php

declare(strict_types=1);

use App\Exception\Handler\SimplePaymentExceptionHandler;
use App\Exception\Handler\ValidationExceptionHandler;

return [
    'handler' => [
        'http' => [
            ValidationExceptionHandler::class,
            SimplePaymentExceptionHandler::class,
            Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler::class,
            App\Exception\Handler\AppExceptionHandler::class,
        ],
    ],
];
