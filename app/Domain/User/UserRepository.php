<?php

namespace App\Domain\User;

use App\Model\User;

class UserRepository implements UserRepositoryInterface
{
    public function save(array $data): void
    {
        User::create($data);
    }

    public function findByEmail(string $email): array
    {
        return User::where('email', $email)->first()->toArray();
    }

    public function emailExists(string $email): bool
    {
        return User::where('email', $email)->exists();
    }

    public function cpfExists(string $cpf): bool
    {
        return User::where('cpf', $cpf)->exists();
    }
}
