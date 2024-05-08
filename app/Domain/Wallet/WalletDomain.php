<?php

namespace App\Domain\Wallet;

use App\Exception\Wallet\InsufficientBalanceException;
use App\Exception\Wallet\InvalidWalletStatusException;
use App\Exception\Wallet\OnlyActiveWalletCanDepositException;
use App\Exception\Wallet\OnlyActiveWalletCanWithdrawException;
use App\Exception\Wallet\OwnerDoesntHaveWalletException;

class WalletDomain
{
    private ?int $id;
    private int $ownerId;
    private float $balance;
    private WalletStatusEnum $status;

    public function __construct(private readonly WalletRepositoryInterface $repository)
    {
    }

    public function createWallet(int $userId, float $initialBalance): WalletDomain
    {
        $this->ownerId = $userId;
        $this->balance = $initialBalance;
        $this->status = WalletStatusEnum::ACTIVE;

        $this->repository->save($this->toArray());

        return $this;
    }

    public function loadByOwnerId(int $ownerId): self
    {
        if (!$this->repository->ownerHasWallet($ownerId)) {
            throw new OwnerDoesntHaveWalletException($ownerId);
        }

        $data = $this->repository->loadFromOwnerId($ownerId);

        return $this->fromArray($data);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'owner_id' => $this->ownerId,
            'status' => $this->status->value,
            'balance' => $this->balance,
        ];
    }

    public function fromArray($data): self
    {
        $this->setId($data['id']);
        $this->setOwnerId($data['owner_id']);
        $this->setBalance($data['balance']);
        $this->setStatus($data['status']);

        return $this;
    }


    public function canTransfer(float $value): self
    {
        if ($this->balance < $value) {
            throw new InsufficientBalanceException($this->balance);
        }

        return $this;
    }

    public function withdraw(float $value): self
    {
        if ($this->status !== WalletStatusEnum::ACTIVE) {
            throw new OnlyActiveWalletCanWithdrawException();
        }

        $this->setBalance($this->getBalance() - $value);

        $this->repository->updateBalance($this->getId(), $this->getBalance());

        return $this;
    }

    public function deposit(float $value): self
    {
        if ($this->status !== WalletStatusEnum::ACTIVE) {
            throw new OnlyActiveWalletCanDepositException();
        }

        $this->setBalance($this->getBalance() + $value);

        $this->repository->updateBalance($this->getId(), $this->getBalance());

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): WalletDomain
    {
        $this->id = $id;

        return $this;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function setOwnerId(int $ownerId): WalletDomain
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): WalletDomain
    {
        $this->balance = $balance;

        return $this;
    }

    public function getStatus(): WalletStatusEnum
    {
        return $this->status;
    }

    public function setStatus(WalletStatusEnum|string $status): WalletDomain
    {
        if ($status instanceof WalletStatusEnum) {
            $this->status = $status;
        }

        if ($status = WalletStatusEnum::tryFrom($status)) {
            $this->status = $status;
        } else {
            throw new InvalidWalletStatusException($status);
        }

        return $this;
    }
}
