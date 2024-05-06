<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exception\Auth\EmptyAuthenticationHeaderException;
use App\Exception\Auth\InvalidTokenException;
use App\Exception\Auth\MissingAuthenticationHeaderException;
use App\Service\TokenServiceInterface;
use Exception;
use Hyperf\Context\Context;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use function Hyperf\Support\make;

class AuthenticationMiddleware implements MiddlewareInterface
{
    const CONTEXT_USER_ID_KEY = 'user_id';

    public function __construct(protected ContainerInterface $container)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$request->hasHeader('Authorization')) {
            throw new MissingAuthenticationHeaderException();
        }

        $authorizationHeader = $request->getHeader('Authorization');
        $token = reset($authorizationHeader);

        if (empty($token)) {
            throw new EmptyAuthenticationHeaderException();
        }
        $token = str_replace('Bearer ', '', $token);

        try {
            Context::set(self::CONTEXT_USER_ID_KEY, make(TokenServiceInterface::class)->getUserId($token));
        } catch (Exception $e) {
            make(LoggerInterface::class)->error(
                json_encode([
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ])
            );

            throw new InvalidTokenException($token);
        }

        return $handler->handle($request);
    }
}
