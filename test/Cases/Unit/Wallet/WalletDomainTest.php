<?php

namespace Test\Cases\Unit\Wallet;

use App\Domain\Wallet\WalletDomain;
use App\Domain\Wallet\WalletStatusEnum;
use App\Exception\Wallet\InsufficientBalanceException;
use App\Exception\Wallet\OnlyActiveWalletCanDepositException;
use App\Exception\Wallet\OnlyActiveWalletCanWithdrawException;
use App\Exception\Wallet\OwnerDoesntHaveWalletException;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use function Hyperf\Support\make;

class WalletDomainTest extends TestCase
{
    private WalletDomain $domain;
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = make(Factory::class)->create();
        $this->domain = make(WalletDomain::class, [make(WalletTestRepository::class)]);
    }

    public function testFromArray()
    {
        $data = [
            'id' => $this->faker->unique()->randomNumber(),
            'owner_id' => $this->faker->unique()->randomNumber(),
            'balance' => $this->faker->randomFloat(2, 0, 1000),
            'status' => $this->faker->randomElement(WalletStatusEnum::getValues())
        ];

        $this->domain->fromArray($data);

        $this->assertSame($data['id'], $this->domain->getId());
        $this->assertSame($data['owner_id'], $this->domain->getOwnerId());
        $this->assertSame($data['balance'], $this->domain->getBalance());
    }

    public function testToArray()
    {
        $this->domain->setId($id = $this->faker->unique()->randomNumber());
        $this->domain->setOwnerId($ownerId = $this->faker->unique()->randomNumber());
        $this->domain->setBalance($balance = $this->faker->randomFloat(2, 0, 1000));
        $this->domain->setStatus($status = $this->faker->randomElement(WalletStatusEnum::getValues()));

        $this->assertSame([
            'id' => $id,
            'owner_id' => $ownerId,
            'status' => $status,
            'balance' => $balance,
        ], $this->domain->toArray());
    }

    public function testLoadByOwnerIdWhenNotFound()
    {
        $this->expectException(OwnerDoesntHaveWalletException::class);
        $this->domain->loadByOwnerId(1);
    }

    public function testLoadByOwnerId()
    {
        $this->domain->setOwnerId($id = 2);

        $this->domain->loadByOwnerId($id);

        $this->assertSame($id, $this->domain->getOwnerId());
    }

    public function canTransferWithInvalidBalanceTest()
    {
        $this->domain->setBalance(0);

        $this->expectException(InsufficientBalanceException::class);
        $this->domain->canTransfer(1.0);
    }

    public function canTransferValidBaance()
    {
        $this->domain->setBalance(2);

        $this->expectException(InsufficientBalanceException::class);
        $this->assertSame($this->domain, $this->domain->canTransfer(1.0));
    }

    public function testWithdrawWithInvalidStatus()
    {
        $this->domain->setStatus(WalletStatusEnum::BLOCKED->value);

        $this->expectException(OnlyActiveWalletCanWithdrawException::class);
        $this->domain->withdraw(1.0);
    }

    public function testWithdraw()
    {
        $this->domain->setStatus(WalletStatusEnum::ACTIVE->value);

        $withdrawValue = $this->faker->randomFloat(2, 0, 1000);
        $balance = $this->faker->randomFloat(2, 1000, 2000);

        $this->domain
            ->setBalance($balance)
            ->setId(1)
            ->withdraw($withdrawValue);

        $this->assertSame($balance - $withdrawValue, $this->domain->getBalance());
    }

    public function testDepositWithInvalidStatus()
    {
        $this->domain->setStatus(WalletStatusEnum::BLOCKED->value);

        $this->expectException(OnlyActiveWalletCanDepositException::class);
        $this->domain->deposit(1.0);
    }

    public function testDeposit()
    {
        $this->domain->setStatus(WalletStatusEnum::ACTIVE->value);

        $withdrawValue = $this->faker->randomFloat(2, 0, 1000);
        $balance = $this->faker->randomFloat(2, 0, 2000);

        $this->domain->setBalance($balance)
            ->setId(1)
            ->deposit($withdrawValue);

        $this->assertSame($balance + $withdrawValue, $this->domain->getBalance());
    }
}
