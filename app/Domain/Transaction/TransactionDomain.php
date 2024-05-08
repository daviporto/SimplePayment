<?php

namespace App\Domain\Transaction;

class TransactionDomain
{
    private int $payerId;
    private int $payeeId;
    private float $value;

    public function __construct(private TransactionRepositoryInterface $repository)
    {
    }

    public function create(array $data): self
    {
        $this->repository->save($this->fromArray($data)->toArray());

        return $this;
    }

    private function toArray(): array
    {
        return [
            'payer_id' => $this->getPayerId(),
            'payee_id' => $this->getPayeeId(),
            'value' => $this->getValue()
        ];
    }

    private function fromArray(array $data): self
    {
        return $this->setPayerId($data['payer_id'])
            ->setPayeeId($data['payee_id'])
            ->setValue($data['value']);
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
        $this->value = $value;

        return $this;
    }
}
