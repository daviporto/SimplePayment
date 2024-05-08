<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\LoginUserRequest;
use App\Request\RegisterUserRequest;
use App\Resource\LoginUserResource;
use App\Resource\UserResource;
use App\Service\UserServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Swoole\Http\Status;
use function Hyperf\Support\make;

class UserController extends AbstractController
{
    public function register(RegisterUserRequest $request): ResponseInterface
    {
        make(UserServiceInterface::class)->register($request->validated());

        return $this->response->withStatus(Status::NO_CONTENT);
    }

    public function login(LoginUserRequest $request): ResponseInterface
    {
        $data = make(UserServiceInterface::class)->login($request->validated());

        return LoginUserResource::make($data)->toResponse();
    }

    public function index(): ResponseInterface
    {
        $users = make(UserServiceInterface::class)->getUsers();

        return UserResource::collection($users)->toResponse();
    }
}
