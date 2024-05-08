<?php

declare(strict_types=1);

use Hyperf\Contract\StdoutLoggerInterface;
use Psr\Log\LogLevel;
use function Hyperf\Support\env;

return [
    'app_name' => env('APP_NAME', 'skeleton'),
    'app_env' => env('APP_ENV', 'dev'),
    'scan_cacheable' => env('SCAN_CACHEABLE', false),
    'token_expiration_time' => env('TOKEN_EXPIRATION_TIME', 3600),
    'jwt_secret_key' => env('JWT_SECRET_KEY', '0ec685c6aa9b6fb1a035d16f72ffafbc1f39a7610b9c15d6f99daf3de6c7023f'),
    'max_email_retries' => env('MAX_EMAIL_RETRIES', 3),
    StdoutLoggerInterface::class => [
        'log_level' => [
            LogLevel::ALERT,
            LogLevel::CRITICAL,
//            LogLevel::DEBUG,
            LogLevel::EMERGENCY,
            LogLevel::ERROR,
            LogLevel::INFO,
            LogLevel::NOTICE,
            LogLevel::WARNING,
        ],
    ],
];
