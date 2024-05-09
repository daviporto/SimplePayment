<?php

namespace Test\Cases\Unit\Transaction;

use App\Domain\Transaction\TransactionDomain;
use App\Exception\Transaction\MinAllowedTransactionValueException;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use function Hyperf\Support\make;

class TransactionDomainTest extends TestCase
{
    private TransactionDomain $domain;
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = make(Factory::class)->create();
        $this->domain = make(TransactionDomain::class, [make(TransactionTestRepository::class)]);
    }

    public function testFromArray()
    {
        $this->domain->fromArray([
            'id' => $id = $this->faker->unique()->randomNumber(),
            'value' => $value = $this->faker->randomFloat(2, 0, 1000),
            'payer_id' => $payerId = $this->faker->unique()->randomNumber(),
            'payee_id' => $payeeId = $this->faker->unique()->randomNumber(),
        ]);

        $this->assertSame($id, $this->domain->getId());
        $this->assertSame($value, $this->domain->getValue());
        $this->assertSame($payerId, $this->domain->getPayerId());
        $this->assertSame($payeeId, $this->domain->getPayeeId());
    }

    public function testToArray()
    {
        $this->domain
            ->setId($id = $this->faker->unique()->randomNumber())
            ->setValue($value = $this->faker->randomFloat(2, 0, 1000))
            ->setPayerId($payerId = $this->faker->unique()->randomNumber())
            ->setPayeeId($payeeId = $this->faker->unique()->randomNumber());

        $this->assertSame([
            'id' => $id,
            'value' => $value,
            'payer_id' => $payerId,
            'payee_id' => $payeeId,
        ], $this->domain->toArray());
    }

    public function testSetValueWithNegativeOne()
    {
        $this->expectException(MinAllowedTransactionValueException::class);

        $this->domain->setValue(-1);
    }

    public function testSetValueWithNeutralOne()
    {
        $this->expectException(MinAllowedTransactionValueException::class);

        $this->domain->setValue(0);
    }

    public function testGetTransaction()
    {
        $transactions = $this->domain->getTransactions(1);

        $this->assertNotEmpty($transactions);

        foreach ($transactions as $transaction) {
            $this->assertInstanceOf(TransactionDomain::class, $transaction);
        }
    }
}
