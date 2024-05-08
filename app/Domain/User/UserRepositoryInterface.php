<?php

namespace App\Domain\User;

interface UserRepositoryInterface
{
    function save(array $data): void;

    function emailExists(string $email): bool;

    function findByEmail(string $email): array;

    function idExists(int $id): bool;

    function findById(int $id): array;

    function cpfExists(string $cpf): bool;
}
