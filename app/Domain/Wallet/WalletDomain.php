<?php

namespace App\Domain\Wallet;

use App\Exception\Wallet\InvalidWalletStatusException;

class WalletDomain
{
    private ?int $Id;
    private int $userId;
    private float $balance;
    private WalletStatusEnum $status;

    public function __construct(private readonly WalletRepositoryInterface $repository)
    {
    }

    public function createWallet(int $userId, float $initialBalance): WalletDomain
    {
        $this->userId = $userId;
        $this->balance = $initialBalance;
        $this->status = WalletStatusEnum::ACTIVE;

        $this->repository->save($this->toArray());

        return $this;
    }

    private function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'status' => $this->status->value,
            'balance' => $this->balance,
        ];
    }

    public function getId(): ?int
    {
        return $this->Id;
    }

    public function setId(?int $Id): WalletDomain
    {
        $this->Id = $Id;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): WalletDomain
    {
        $this->userId = $userId;

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
