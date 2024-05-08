<?php

namespace App\Domain\User;

interface UserDomainInterface
{
    function fromArray(array $data): self;

    function toArray(): array;

    function loadByEmail(string $email): self;

    function loadById(int $id): self;

    function getFullName(): string;

    function setFullName(string $fullName): self;

    function getEmail(): string;

    function setEmail(string $email): void;

    function getPassword(): ?string;

    function setPassword(string $password): self;

    function getType(): UserTypeEnum;

    function setType(UserTypeEnum|string $type): UserDomainInterface;

    function getCpf(): string;

    function setCpf(string $cpf): UserDomainInterface;

    function register(): void;

    function hashPassword(): self;

    function validatePassword(string $password): self;

    function getId(): int;

    function getInitialBalance(): float;

    function canExecutePayment(int $requesterId): UserDomainInterface;

    function getUsers(): array;
}
