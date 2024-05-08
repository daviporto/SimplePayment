<?php

declare(strict_types=1);

namespace App\Controller;

use App\Middleware\AuthenticationMiddleware;
use App\Request\CreateTransactionRequest;
use App\Service\TransactionServiceInterface;
use Hyperf\Context\Context;
use Psr\Http\Message\ResponseInterface;
use Swoole\Http\Status;
use function Hyperf\Support\make;

class TransactionController extends AbstractController
{
    public function create(CreateTransactionRequest $request): ResponseInterface
    {
        make(TransactionServiceInterface::class)
            ->create($request->validated(), Context::get(AuthenticationMiddleware::CONTEXT_USER_ID_KEY));

        return $this->response->withStatus(Status::CREATED);
    }
}
