<?php

namespace App\Domain\User;

interface UserRepositoryInterface
{
    public function save(array $data): void;

    public function findByEmail(string $email): array;

    public function emailExists(string $email): bool;

    public function cpfExists(string $cpf): bool;
}
