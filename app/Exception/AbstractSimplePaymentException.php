<?php

namespace App\Exception;

use GuzzleHttp\Exception\ServerException;
use Swoole\Http\Status;

class AbstractSimplePaymentException extends ServerException
{
    protected array $additionalInfo = [];
    protected int $internalCode;

    public function __construct(string $message, int $internalCode, int $code = Status::UNPROCESSABLE_ENTITY)
    {
        $this->message = $message;
        $this->code = $code;
        $this->internalCode = $internalCode;
    }

    public function getAdditionalInfo(): array
    {
        return $this->additionalInfo;
    }

    public function getInternalCode(): int
    {
        return $this->internalCode;
    }
}
