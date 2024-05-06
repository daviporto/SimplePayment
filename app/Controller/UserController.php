<?php

declare(strict_types=1);

namespace App\Controller;

use App\Middleware\AuthenticationMiddleware;
use App\Request\LoginUserRequest;
use App\Request\RegisterUserRequest;
use App\Resource\LoginUserResource;
use App\Service\UserService;
use Hyperf\Context\Context;
use Psr\Http\Message\ResponseInterface;
use Swoole\Http\Status;
use function Hyperf\Support\make;

class UserController extends AbstractController
{
    public function register(RegisterUserRequest $request): ResponseInterface
    {
        make(UserService::class)->register($request->validated());

        return $this->response->withStatus(Status::NO_CONTENT);
    }

    public function login(LoginUserRequest $request): ResponseInterface
    {
        $data = make(UserService::class)->login($request->validated());

        return LoginUserResource::make($data)->toResponse();
    }

    public function testAuthenticated(): ResponseInterface
    {
        return $this->response->json(['user_id' => Context::get(AuthenticationMiddleware::CONTEXT_USER_ID_KEY)]);
    }
}
