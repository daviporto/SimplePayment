<?php

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class LoginUserRequest extends FormRequest
{
    protected function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ];
    }
}
