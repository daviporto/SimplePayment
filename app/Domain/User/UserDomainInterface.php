<?php

namespace App\Domain\User;

interface UserDomainInterface
{
    function fromArray(array $data): self;

    function toArray(): array;

    function load(string $email): self;

    function getFullName(): string;

    function setFullName(string $fullName): self;

    function getEmail(): string;

    function setEmail(string $email): void;

    function getPassword(): ?string;

    function setPassword(string $password): self;

    function getType(): UserTypeEnum;

    function setType(UserTypeEnum|string $type): void;

    function getCpf(): string;

    function setCpf(string $cpf): void;

    function register(): void;

    function hashPassword(): self;

    function validatePassword(string $password): self;

    function getId(): int;

    function getInitialBalance(): float;
}
