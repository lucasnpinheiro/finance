<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'account_number' => 'required',
            'transaction_type' => 'required',
            'transaction_value' => 'required',
        ];
    }

    public function accountNumber(): string
    {
        return $this->input('account_number');
    }

    public function transactionType(): string
    {
        return $this->input('transaction_type');
    }

    public function transactionValue(): float
    {
        return (float) $this->input('transaction_value');
    }
}
