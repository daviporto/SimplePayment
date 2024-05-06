<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use App\Exception\AbstractSimplePaymentException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class SimplePaymentExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        /** @var AbstractSimplePaymentException $throwable */

        $data = [
            'code' => $throwable->getCode(),
            'message' => $throwable->getMessage(),
            'internalCode' => $throwable->getInternalCode()
        ];

        if ($throwable->getAdditionalInfo()) {
            $data['additionalInfo'] = $throwable->getAdditionalInfo();
        }

        $this->stopPropagation();

        return $response
            ->withStatus($throwable->getCode())
            ->withBody(new SwooleStream(json_encode($data)))
            ->withHeader('Content-Type', 'application/json');
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof AbstractSimplePaymentException;
    }
}
