<?php

namespace App\Domain\User;

use App\Exception\User\CpfAlreadyExistsException;
use App\Exception\User\EmailAlreadyExistsException;
use App\Exception\User\EmailNotFoundException;
use App\Exception\User\PasswordMustHaveAtLeastSixCharactersException;
use App\Exception\User\UserIdNotFoundException;
use App\Exception\User\UserNotLoadedException;
use App\Exception\User\UserTypeNowAllowedException;
use App\Exception\User\WrongPasswordException;

class UserDomain implements UserDomainInterface
{
    private string $fullName;
    private string $email;
    private ?string $password;
    private UserTypeEnum $type;
    private string $cpf;
    private ?int $id;

    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function fromArray(array $data): self
    {
        $this->setFullName($data['name']);
        $this->setEmail($data['email']);
        $this->setPassword($data['password']);
        $this->setType($data['type']);
        $this->setCpf($data['cpf']);
        $this->id = $data['id'] ?? null;

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'name' => $this->getFullName(),
            'email' => $this->getEmail(),
            'type' => $this->getType()->value,
            'cpf' => $this->getCpf()
        ];

        if (isset($this->password)) {
            $data['password'] = $this->getPassword();
        }

        if (isset($this->id)) {
            $data['id'] = $this->id;
        }

        return $data;
    }

    public function loadByEmail(string $email): UserDomainInterface
    {
        if(!$this->repository->emailExists($email)){
            throw new EmailNotFoundException($email);
        }

        $data = $this->repository->findByEmail($email);

        $user = UserFactory::createUser($data['type'], $this->repository);

        return $user->fromArray($data);
    }

    public function loadById(int $id): UserDomainInterface
    {
        if(!$this->repository->idExists($id)){
            throw new UserIdNotFoundException($id);
        }

        $data = $this->repository->findById($id);

        $user = UserFactory::createUser($data['type'], $this->repository);

        return $user->fromArray($data);
    }

    public function getUsers(): array
    {
        $users =  $this->repository->findAll();

        return array_map(function(array $userData){
            return UserFactory::createUser($userData['type'], $this->repository)
                ->fromArray($userData);
        }, $users);
    }

    public function register(): void
    {
        if ($this->repository->emailExists($this->email)) {
            throw new EmailAlreadyExistsException($this->email);
        }

        if ($this->repository->cpfExists($this->cpf)) {
            throw new CpfAlreadyExistsException($this->cpf);
        }

        $this->repository->save($this->toArray());
    }

    public function getInitialBalance(): float
    {
        throw new UserNotLoadedException();
    }

    public function canExecutePayment(int $requesterId): self
    {
        throw new UserNotLoadedException();
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password ?: null;
    }

    public function setPassword(string $password): UserDomainInterface
    {
        if (strlen($password) < 6) {
            throw new PasswordMustHaveAtLeastSixCharactersException($password);
        }

        $this->password = $password;

        return $this;
    }

    public function getType(): UserTypeEnum
    {
        return $this->type;
    }

    public function setType(UserTypeEnum|string $type): UserDomainInterface
    {
        if ($type instanceof UserTypeEnum) {
            $this->type = $type;
        }

        if ($type = UserTypeEnum::tryFrom($type)) {
            $this->type = $type;
        } else {
            throw new UserTypeNowAllowedException($type);
        }

        return $this;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): UserDomainInterface
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function register(): void
    {
        if ($this->repository->emailExists($this->email)) {
            throw new EmailAlreadyExistsException($this->email);
        }

        if ($this->repository->cpfExists($this->cpf)) {
            throw new CpfAlreadyExistsException($this->cpf);
        }

        $this->repository->save($this->toArray());
    }

    public function hashPassword(): self
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        return $this;
    }

    public function validatePassword(string $password): self
    {
        if (!password_verify($password, $this->password)) {
            throw new WrongPasswordException();
        }

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): UserDomainInterface
    {
        $this->id = $id;

        return $this;
    }
}
