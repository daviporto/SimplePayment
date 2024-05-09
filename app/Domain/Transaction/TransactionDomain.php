<?php

namespace App\Domain\Transaction;

use App\Exception\Transaction\MinAllowedTransactionValueException;
use Carbon\Carbon;

class TransactionDomain
{
    const MIN_TRANSACTION_VALUE = 0.01;
    private int $payerId;
    private int $payeeId;
    private float $value;
    private ?Carbon $createdAt;
    private ?int $id;

    public function __construct(private readonly TransactionRepositoryInterface $repository)
    {
    }

    public function create(array $data): self
    {
        $this->repository->save($this->fromArray($data)->toArray());

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'value' => $this->getValue(),
            'payer_id' => $this->getPayerId(),
            'payee_id' => $this->getPayeeId(),
            'created_at' => $this->getCreatedAt()?->toDateTimeString(),
        ];
    }

    public function fromArray(array $data): self
    {
        return $this->setPayerId($data['payer_id'])
            ->setPayeeId($data['payee_id'])
            ->setValue($data['value'])
            ->setId($data['id'] ?? null)
            ->setCreatedAt($data['created_at'] ?? null);
    }

    /** @return array<integer,TransactionDomain> */
    public function getTransactions(int $solicitorId): array
    {
        $transactions = $this->repository->getTransactions($solicitorId);

        return array_map(function (array $transactionData) {
            return (new TransactionDomain($this->repository))
                ->fromArray($transactionData);
        }, $transactions);
    }

    public function getPayerId(): int
    {
        return $this->payerId;
    }

    public function setPayerId(int $payerId): TransactionDomain
    {
        $this->payerId = $payerId;

        return $this;
    }

    public function getPayeeId(): int
    {
        return $this->payeeId;
    }

    public function setPayeeId(int $payeeId): TransactionDomain
    {
        $this->payeeId = $payeeId;

        return $this;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): TransactionDomain
    {
        if ($value < self::MIN_TRANSACTION_VALUE) {
            throw new MinAllowedTransactionValueException();
        }

        $this->value = $value;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): TransactionDomain
    {
        $this->id = $id;

        return $this;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    public function setCreatedAt(Carbon|string|null $createdAt): TransactionDomain
    {
        if (!$createdAt) {
            $this->createdAt = null;
        } elseif ($createdAt instanceof Carbon) {
            $this->createdAt = $createdAt;
        } else {
            $this->createdAt = Carbon::parse($createdAt);
        }

        return $this;
    }
}
