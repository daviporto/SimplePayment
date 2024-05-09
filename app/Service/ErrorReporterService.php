<?php

namespace App\Service;

use App\Exception\AbstractSimplePaymentException;
use Exception;
use Hyperf\Contract\StdoutLoggerInterface;
use PHPUnit\Event\Code\Throwable;
use function Hyperf\Support\make;

class ErrorReporterService implements ErrorReporterServiceInterface
{
    private StdoutLoggerInterface $logger;

    public function __construct()
    {
        $this->logger = make(StdoutLoggerInterface::class);
    }

    public function handle(Exception $exception): void
    {
        if (!$exception instanceof AbstractSimplePaymentException) {
            $this->logger->error(
                json_encode([
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'trace' => $exception->getTraceAsString(),
                ])
            );
        }
    }
}
