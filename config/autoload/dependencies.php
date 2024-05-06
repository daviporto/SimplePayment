<?php

declare(strict_types=1);

use App\Service\TokenService;
use App\Service\TokenServiceInterface;
use App\Service\UserService;
use App\Service\UserServiceInterface;
use Hyperf\Database\Model\Factory;

return [
    Factory::class => HyperfTest\FactoryWithFaker::class,
    UserServiceInterface::class => UserService::class,
    TokenServiceInterface::class => TokenService::class
];
