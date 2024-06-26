<?php

namespace Test\Cases\Unit\User;

use App\Domain\User\UserDomain;
use App\Domain\User\UserDomainInterface;
use App\Domain\User\UserTypeEnum;
use App\Exception\User\CpfAlreadyExistsException;
use App\Exception\User\EmailAlreadyExistsException;
use App\Exception\User\EmailNotFoundException;
use App\Exception\User\PasswordMustHaveAtLeastSixCharactersException;
use App\Exception\User\UserIdNotFoundException;
use App\Exception\User\UserNotLoadedException;
use App\Exception\User\UserTypeNowAllowedException;
use App\Exception\User\WrongPasswordException;
use Faker\Factory;
use Faker\Generator;
use Hyperf\Stringable\Str;
use PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound;
use PHPUnit\Framework\TestCase;
use function Hyperf\Support\make;

class UserDomainTest extends TestCase
{
    const DEFAULT_PASSWORD = '123456';
    private UserDomainInterface $domain;
    private Generator $faker;

    public function getDefaultData(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'password' => self::DEFAULT_PASSWORD,
            'cpf' => 1 . $this->faker->unique()->numerify('##########'),
            'type' => $this->faker->randomElement(UserTypeEnum::getTypes())
        ];
    }

    protected function setUp(): void
    {
        $this->faker = make(Factory::class)->create();
        $this->domain = make(UserDomain::class, [make(UserTestRepository::class)]);
    }

    public function testFromArray()
    {
        $data = $this->getDefaultData();

        $this->domain->fromArray($data);

        $this->assertSame($data['name'], $this->domain->getFullName());
        $this->assertSame($data['email'], $this->domain->getEmail());
        $this->assertSame($data['cpf'], $this->domain->getCpf());
        $this->assertSame($data['type'], $this->domain->getType()->value);
    }

    public function testToArray()
    {
        $data = $this->getDefaultData();

        $this->domain->fromArray($data);

        $this->assertEmpty(array_diff($data, $this->domain->toArray()));
    }

    public function testSetInvalidPassword()
    {
        $this->expectException(PasswordMustHaveAtLeastSixCharactersException::class);

        $this->domain->setPassword(Str::random(5));
    }

    public function testSetInvalidType()
    {
        $this->expectException(UserTypeNowAllowedException::class);

        $this->domain->setType(UserTypeEnum::Customer->value . Str::random());
    }

    public function testValidatePasswordSuccess()
    {
        $this
            ->domain
            ->setPassword(self::DEFAULT_PASSWORD)
            ->hashPassword();

        $this->domain->validatePassword(self::DEFAULT_PASSWORD);

        $this->assertNotEmpty($this->domain->getPassword());
    }

    public function testValidatePasswordInvalid()
    {
        $this
            ->domain
            ->setPassword(self::DEFAULT_PASSWORD)
            ->hashPassword();

        $this->expectException(WrongPasswordException::class);

        $this->domain->validatePassword('123');
    }

    public function testRegisterEmailAlreadyExistsException()
    {
        $this->domain->setEmail('exists@gmail.com');

        $this->expectException(EmailAlreadyExistsException::class);

        $this->domain->register();
    }

    public function testRegisterCpfAlreadyExistsException()
    {
        $this->domain->setEmail($this->faker->unique()->email());
        $this->domain->setCpf('2');

        $this->expectException(CpfAlreadyExistsException::class);

        $this->domain->register();
    }

    public function testRegisterSuccess()
    {
        $this->domain->fromArray($this->getDefaultData());
        $this->domain->register();

        $this->assertNotEmpty($this->domain->getEmail());
    }

    public function testLoadByEmailNonExistentEmail()
    {
        $this->expectException(EmailNotFoundException::class);

        $this->domain->loadByEmail('nonExistentEmail@gmail.com');
    }

    public function testLoadByEmailSuccess()
    {
        $email = 'exists';
        $loadedUser = $this->domain->loadByEmail($email);

        $this->assertSame($email, $loadedUser->getEmail());
        $this->assertNotEmpty($loadedUser->getId());
    }

    public function testLoadByIdNonExistentId()
    {
        $this->expectException(UserIdNotFoundException::class);

        $this->domain->loadById(1);
    }

    public function testLoadByIdSuccess()
    {
        $id = 2;
        $loadedUser = $this->domain->loadById($id);

        $this->assertSame($id, $loadedUser->getid());
        $this->assertNotEmpty($loadedUser->getId());
    }

    public function testGetDefaultBalanceOnUnloadedUser()
    {
        $this->expectException(UserNotLoadedException::class);

        $this->domain->getInitialBalance();
    }

    public function testCanExecutePayment()
    {
        $this->expectException(UserNotLoadedException::class);

        $this->domain->canExecutePayment(1);
    }

    public function testGetUsers()
    {
        $users = $this->domain->getUsers();

        $this->assertNotEmpty($users);

        foreach ($users as $user) {
            $this->assertInstanceOf(UserDomainInterface::class, $user);
        }
    }
}
