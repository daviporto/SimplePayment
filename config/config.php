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
    'jwt_secret_key' => env(
        'JWT_SECRET_KEY',
        '0ec685c6aa9b6fb1a035d16f72ffafbc1f39a7610b9c15d6f99daf3de6c7023f'
    ),
    'max_email_retries' => env('MAX_EMAIL_RETRIES', 3),
    'email_retry_interval' => env('EMAIL_RETRY_INTERVAL', 5),
    'email_provider_url' => env(
        'EMAIL_PROVIDER_URL',
        'https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6'
    ),
    'external_authorizer_provider_url' => env(
        'EXTERNAL_AUTHORIZER_PROVIDER_URL',
        'https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc'
    ),
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
