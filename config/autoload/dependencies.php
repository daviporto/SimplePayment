<?php

declare(strict_types=1);

use App\Service\TokenService;
use App\Service\TokenServiceInterface;
use App\Service\TransactionService;
use App\Service\TransactionServiceInterface;
use App\Service\UserService;
use App\Service\UserServiceInterface;
use Hyperf\Database\Model\Factory;
use Test\FactoryWithFaker;

return [
    Factory::class => FactoryWithFaker::class,
    UserServiceInterface::class => UserService::class,
    TokenServiceInterface::class => TokenService::class,
    TransactionServiceInterface::class => TransactionService::class
];
