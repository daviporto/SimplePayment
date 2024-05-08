<?php

namespace App\Domain\User;

use App\Model\User;

class UserRepository implements UserRepositoryInterface
{
    public function save(array $data): void
    {
        User::create($data);
    }

    public function emailExists(string $email): bool
    {
        return User::where('email', $email)->exists();
    }

    public function findByEmail(string $email): array
    {
        return User::where('email', $email)->first()->toArray();
    }

    public function idExists(int $id): bool
    {
        return User::where('id', $id)->exists();
    }

    public function findById(int $id): array
    {
        return User::where('id', $id)->first()->toArray();
    }

    public function cpfExists(string $cpf): bool
    {
        return User::where('cpf', $cpf)->exists();
    }
}
