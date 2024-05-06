<?php

namespace App\Request;

use App\Domain\User\UserTypeEnum;
use Hyperf\Validation\Request\FormRequest;

class RegisterUserRequest extends FormRequest
{
    protected function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|same:password',
            'cpf' => 'required|string|between:10,11',
            'type' => 'required|string|in:' . UserTypeEnum::getTypesAsString()
        ];
    }
}
