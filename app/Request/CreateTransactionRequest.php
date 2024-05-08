<?php

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class CreateTransactionRequest extends FormRequest
{
    protected function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payer' => 'required|integer',
            'payee' => 'required|integer',
            'value' => 'required|numeric|min:0.01'
        ];
    }
}
