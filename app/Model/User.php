<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model as BaseModel;


/**
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $type
 * @property string $cpf
 * */
class User extends BaseModel
{
    protected ?string $table = 'users';

    protected array $fillable = [
        'name',
        'email',
        'password',
        'type',
        'cpf',
    ];
}
