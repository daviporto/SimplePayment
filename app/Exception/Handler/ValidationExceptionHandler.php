<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationException;
use Hyperf\Validation\ValidationExceptionHandler as HyperfValidationExceptionHandler;
use Swow\Psr7\Message\ResponsePlusInterface;
use Throwable;

class ValidationExceptionHandler extends HyperfValidationExceptionHandler
{
    public function handle(Throwable $throwable, ResponsePlusInterface $response)
    {
        $this->stopPropagation();
        /** @var ValidationException $throwable */
        $body = $throwable->validator->errors()->all();

        if (!$response->hasHeader('content-type')) {
            $response = $response->addHeader('content-type', 'text/plain; charset=utf-8');
        }

        return $response
            ->setStatus($throwable->status)
            ->setBody(new SwooleStream(json_encode($body)));
    }
}
