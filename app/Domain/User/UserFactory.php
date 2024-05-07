<?php

namespace App\Domain\User;

use App\Exception\User\UserTypeNowAllowedException;
use function Hyperf\Support\make;

class UserFactory
{
    public static function createUser(string $type, UserRepositoryInterface $repository): UserDomainInterface
    {
        return match ($type) {
            UserTypeEnum::Customer->value => make(Customer::class, ['repository' => $repository]),
            UserTypeEnum::Retailer->value => make(Retailer::class, ['repository' => $repository]),
            default => throw new UserTypeNowAllowedException($type),
        };
    }
}
